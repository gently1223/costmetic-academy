<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Mail;
use DB;
use \setasign\Fpdi\Fpdi;

class dashboard extends Controller
{
    public function index(Request $request)
    {
        $id=$request->session()->get('id');
        
        $logged_in=$request->session()->get('logged_in');
        $request->session()->put('logged_in', '');
        
        $date=date('Y-m-d');
        
        if($request->input('subscribe')=='1')
        {
            DB::update("UPDATE contacts SET newsletter='1' WHERE id='$id'");
            return redirect('dashboard');
        }
        /*$today_appointments=array(); $i=0;
        $row=DB::select("SELECT * FROM appointments WHERE date='$date' AND contact='$id'");
        foreach($row as $r)
        {
            $today_appointments[$i]['appointment']=$r;
            
            $row2=DB::select("SELECT id, name FROM contacts WHERE id='$r->contact' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $today_appointments[$i]['contact']=$row2;
            }
            else $today_appointments[$i]['contact']='NA';
            
            $row2=DB::select("SELECT id, name, location FROM rooms WHERE id='$r->room' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $today_appointments[$i]['room']=$row2;
                
                $row2=DB::select("SELECT id, name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                if(count($row2)==1)
                {
                    $row2=collect($row2)->first();
                    $today_appointments[$i]['room_location']=$row2;
                }
                else $today_appointments[$i]['room_location']='NA';
            }
            else { $today_appointments[$i]['room']='NA'; $today_appointments[$i]['room_location']='NA'; }
            
            $i++;
        }*/
        
        $appointments=DB::select("SELECT * FROM appointments WHERE contact='$id' AND status='1'");
        $i=0; $app='';
        foreach($appointments as $appointment)
        {
            $time=date("H:i", strtotime($appointment->time));
            $time_end=date("H:i", strtotime($appointment->time_end));
            
            $title=addslashes($appointment->title);
            $room=DB::select("SELECT name FROM rooms WHERE id='$appointment->room' LIMIT 1");
            if(count($room)==1)
            {
                $room=collect($room)->first();
                $title.=' ('.addslashes($room->name).')';
            }
            
            $color='#3788d8';
            if($appointment->category!=0)
            {
                $category=DB::select("SELECT color FROM calendar_categories WHERE id='$appointment->category' LIMIT 1");
                $category=collect($category)->first();
                $color=$category->color;
            }
            
            if($i++!=0) $app.=',';
            $app.='{
                            "id": "'.$appointment->id.'",
                            "title": "'.$title.'",
                            "start": "'.$appointment->date.'T'.$time.'",
                            "end": "'.$appointment->date.'T'.$time_end.'",
                            "backgroundColor": "'.$color.'",
                            "borderColor": "'.$color.'"
                            ';
            
            if($appointment->recurring!='0') {
            
            switch($appointment->recurring)
            {
                case 'Everyday': $days='0, 1, 2, 3, 4, 5, 6'; break;
                case 'Sunday': $days='0'; break;
                case 'Monday': $days='1'; break;
                case 'Tuesday': $days='2'; break;
                case 'Wednesday': $days='3'; break;
                case 'Thursday': $days='4'; break;
                case 'Friday': $days='5'; break;
                case 'Saturday': $days='6'; break;
                default : $days=''; break;
            }
            
            $app.=',
                            "daysOfWeek": ['.$days.'],
                            "startTime": "'.$time.'",
                            "endTime": "'.$time_end.'"
                    ';
            }
            
            $app.='}';
        }
        
        $task_contacts=DB::select("SELECT id, name FROM contacts WHERE type='Student' OR type='Coach'");
        $todos=array(); $i=0;
        $row=DB::select("SELECT * FROM todos WHERE (added_by='$id' AND type='2') OR (assign_to='$id' AND user_type='2') ORDER BY priority, due_date ASC");
        foreach($row as $r)
        {
            $todos[$i]['todo']=$r;
            
            $row2=DB::select("SELECT id, name, profile_image FROM contacts WHERE id='$r->assign_to' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $todos[$i]['contact']=$row2;
            }
            else $todos[$i]['contact']='NA';
            
            $i++;
        }
        return view('dashboard.index', ['title'=>'Dashboard', 'appointments'=>$app, 'todos'=>$todos, 'task_contacts'=>$task_contacts, 'logged_in'=>$logged_in]);
    }
    
    public function my_cvs(Request $request)
    {
        $user_id=$request->session()->get('id');
        
        if($request->input('delete')!='')
        {
            $delete=addslashes($request->input('delete'));
            DB::delete("DELETE FROM cvs WHERE id='$delete'");
            $request->session()->flash('success','CV deleted successfully.');
            return redirect('my-cvs');
        }
        
        $cvs=DB::select("SELECT * FROM cvs WHERE user_id='$user_id' ORDER BY id DESC");
        
        return view('my_cvs.index', ['title'=>trans('header.my_cvs'), 'cvs'=>$cvs]);
    }
    
    public function create_cv(Request $request, $cv=0)
    {
        $user_id=$request->session()->get('id');
        
        if($request->input('create_cv')!='')
        {
            DB::delete("DELETE FROM personal_details WHERE user_id='$user_id' AND cv='$cv'");
            DB::delete("DELETE FROM experience WHERE user_id='$user_id' AND cv='$cv'");
            DB::delete("DELETE FROM education WHERE user_id='$user_id' AND cv='$cv'");
            DB::delete("DELETE FROM languages WHERE user_id='$user_id' AND cv='$cv'");
            DB::delete("DELETE FROM skills WHERE user_id='$user_id' AND cv='$cv'");
            DB::delete("DELETE FROM hobbies WHERE user_id='$user_id' AND cv='$cv'");
            
            if($request->input('job_title')!='')
            {
                $job_title=$request->input('job_title');
                $company_name=$request->input('company_name');
                $from_month=$request->input('from_month');
                $from_year=$request->input('from_year');
                $to_month=$request->input('to_month');
                $to_year=$request->input('to_year');
                
                for($i=0; $i<count($job_title); $i++)
                {
                    if($job_title[$i]=='') continue;
                    
                    $title=addslashes($job_title[$i]);
                    $company=addslashes($company_name[$i]);
                    $from_m=$from_month[$i];
                    $from_y=$from_year[$i];
                    $to_m=$to_month[$i];
                    $to_y=$to_year[$i];
                    $present=0;
                    if($request->input('to_present'.$i)!='') $present=$request->input('to_present'.$i);
                    if($present==1) { $to_m=''; $to_y=''; }
                    
                    $responsibilities_a=array();
                    if($request->input('job_responsibilities'.$i)!='') $responsibilities_a=$request->input('job_responsibilities'.$i);
                    
                    $responsibilities=addslashes(implode(';', $responsibilities_a));
                    
                    DB::insert("INSERT INTO experience (user_id, company_name, job_title, from_month, from_year, present, to_month, to_year, responsibilities, cv) VALUES ('$user_id', '$company', '$title', '$from_m', '$from_y', '$present', '$to_m', '$to_y', '$responsibilities', '$cv')");
                }
            }
            
            if($request->input('school')!='')
            {
                $schools=$request->input('school');
                $qualifications=$request->input('qualification');
                $from_month=$request->input('edu_from_month');
                $from_year=$request->input('edu_from_year');
                $to_month=$request->input('edu_to_month');
                $to_year=$request->input('edu_to_year');
                
                for($i=0; $i<count($schools); $i++)
                {
                    if($schools[$i]=='') continue;
                    
                    $school=addslashes($schools[$i]);
                    $qualification=addslashes($qualifications[$i]);
                    $from_m=$from_month[$i];
                    $from_y=$from_year[$i];
                    $to_m=$to_month[$i];
                    $to_y=$to_year[$i];
                    $present=0;
                    if($request->input('edu_to_present'.$i)!='') $present=$request->input('edu_to_present'.$i);
                    
                    if($present==1) { $to_m=''; $to_y=''; }
                    
                    $details_a=array();
                    if($request->input('edu_details'.$i)!='') $details_a=$request->input('edu_details'.$i);
                    
                    $details=addslashes(implode(';', $details_a));
                    
                    DB::insert("INSERT INTO education (user_id, school, qualification, from_month, from_year, present, to_month, to_year, details, cv) VALUES ('$user_id', '$school', '$qualification', '$from_m', '$from_y', '$present', '$to_m', '$to_y', '$details', '$cv')");
                }
            }
            
            if($request->input('language')!='')
            {
                $languages=$request->input('language');
                $lng_fluencys=$request->input('lng_fluency');
                
                for($i=0; $i<count($languages); $i++)
                {
                    $language=addslashes($languages[$i]);
                    if($language=='') continue;
                    $fluency=addslashes($lng_fluencys[$i]);
                    
                    DB::insert("INSERT INTO languages (user_id, language, fluency, cv) VALUES ('$user_id', '$language', '$fluency', '$cv')");
                }
            }
            
            if($request->input('skill')!='')
            {
                $skills=$request->input('skill');
                $skill_fluencys=$request->input('skill_fluency');
                
                for($i=0; $i<count($skills); $i++)
                {
                    $skill=addslashes($skills[$i]);
                    if($skill=='') continue;
                    $fluency=addslashes($skill_fluencys[$i]);
                    
                    DB::insert("INSERT INTO skills (user_id, skill, fluency, cv) VALUES ('$user_id', '$skill', '$fluency', '$cv')");
                }
            }
            
            if($request->input('hobby')!='')
            {
                $hobby=addslashes($request->input('hobby'));
                
                DB::insert("INSERT INTO hobbies (user_id, hobby, cv) VALUES ('$user_id', '$hobby', '$cv')");
            }
            
            if($request->input('name')!='')
            {
                $name=addslashes($request->input('name'));
                $title=addslashes($request->input('title'));
                $dob=addslashes($request->input('dob'));
                $email=addslashes($request->input('email'));
                $phone_no=addslashes($request->input('phone_no'));
                $address=addslashes($request->input('address'));
                $profile_image=addslashes($request->input('profile_image'));
                $to_address=addslashes($request->input('to_address'));
                $content=addslashes($request->input('content'));
                $signature=addslashes($request->input('signature'));
                
                DB::insert("INSERT INTO personal_details (user_id, name, title, dob, email, phone_no, address, profile_image, cv, to_address, content, signature) VALUES ('$user_id', '$name', '$title', '$dob', '$email', '$phone_no', '$address', '$profile_image', '$cv', '$to_address', '$content', '$signature')");
            }
            
            if($cv==0)
                return redirect('cv-preview');
            else
                return redirect('cv-preview/'.$cv);
        }
        
        $personal_details=DB::select("SELECT * FROM personal_details WHERE user_id='$user_id' AND cv='$cv' LIMIT 1");
        if(count($personal_details)==1) $personal_details=collect($personal_details)->first();
        $experience=DB::select("SELECT * FROM experience WHERE user_id='$user_id' AND cv='$cv'");
        $education=DB::select("SELECT * FROM education WHERE user_id='$user_id' AND cv='$cv'");
        $languages=DB::select("SELECT * FROM languages WHERE user_id='$user_id' AND cv='$cv'");
        $skills=DB::select("SELECT * FROM skills WHERE user_id='$user_id' AND cv='$cv'");
        $hobby=DB::select("SELECT * FROM hobbies WHERE user_id='$user_id' AND cv='$cv' LIMIT 1");
        if(count($hobby)==1) $hobby=collect($hobby)->first();
        
        return view('create_cv.index', ['title'=>trans('forms.create_cv'), 'personal_details'=>$personal_details, 'experience'=>$experience, 'education'=>$education, 'languages'=>$languages, 'skills'=>$skills, 'hobby'=>$hobby]);
    }
    
    public function cv_preview(Request $request, $cv=0)
    {
        $user_id=$request->session()->get('id');
        
        if($request->input('title')!='' AND $cv==0)
        {
            $title=addslashes($request->input('title'));
            $template=addslashes($request->input('template'));
            $attachment='';
            $attachment_name='';
            
            if($request->file('attachment')!='')
            {
            $file=$request->file('attachment');
            
            //Move Uploaded File
            $destinationPath = 'company_files/attachments/';
                $img_name=$file->getClientOriginalName();
                $attachment_name=$img_name;
                $array=explode('.', $img_name);
                $img_name=$array[0];
                $ext=$array[1];
                $img_name=rand(pow(10, 4-1), pow(10, 4)-1).'.'.$ext;
                $fileName = $destinationPath . $img_name; // renameing image
                
                if($file->move($destinationPath,$img_name)) {
                    $attachment=$img_name;
                }
            }
            
            DB::insert("INSERT INTO cvs (user_id, title, pdf, template, on_date, attachment, attachment_name) VALUES ('$user_id', '$title', '', '$template', NOW(), '$attachment', '$attachment_name')");
            $id=DB::getPdo()->lastInsertId();
            
            $personal_details=DB::select("SELECT * FROM personal_details WHERE user_id='$user_id' AND cv='0' LIMIT 1");
            if(count($personal_details)==1) 
            {
                $personal_details=collect($personal_details)->first();
                DB::insert("INSERT INTO personal_details (user_id, name, title, dob, email, phone_no, address, profile_image, cv, to_address, content, signature) VALUES ('$user_id', '$personal_details->name', '$personal_details->title', '$personal_details->dob', '$personal_details->email', '$personal_details->phone_no', '$personal_details->address', '$personal_details->profile_image', '$id', '$personal_details->to_address', '$personal_details->content', '$personal_details->signature')");
            }
            
            $experience=DB::select("SELECT * FROM experience WHERE user_id='$user_id' AND cv='0'");
            foreach($experience as $exp)
            {
                DB::insert("INSERT INTO experience (user_id, company_name, job_title, from_month, from_year, present, to_month, to_year, responsibilities, cv) VALUES ('$user_id', '$exp->company_name', '$exp->job_title', '$exp->from_month', '$exp->from_year', '$exp->present', '$exp->to_month', '$exp->to_year', '$exp->responsibilities', '$id')");
            }
            
            $education=DB::select("SELECT * FROM education WHERE user_id='$user_id' AND cv='0'");
            foreach($education as $edu)
            {
                DB::insert("INSERT INTO education (user_id, school, qualification, from_month, from_year, present, to_month, to_year, details, cv) VALUES ('$user_id', '$edu->school', '$edu->qualification', '$edu->from_month', '$edu->from_year', '$edu->present', '$edu->to_month', '$edu->to_year', '$edu->details', '$id')");
            }
            
            $languages=DB::select("SELECT * FROM languages WHERE user_id='$user_id' AND cv='0'");
            foreach($languages as $lng)
            {
                DB::insert("INSERT INTO languages (user_id, language, fluency, cv) VALUES ('$user_id', '$lng->language', '$lng->fluency', '$id')");
            }
            
            $skills=DB::select("SELECT * FROM skills WHERE user_id='$user_id' AND cv='0'");
            foreach($skills as $skill)
            {
                DB::insert("INSERT INTO skills (user_id, skill, fluency, cv) VALUES ('$user_id', '$skill->skill', '$skill->fluency', '$id')");
            }
            
            $hobby=DB::select("SELECT * FROM hobbies WHERE user_id='$user_id' AND cv='0' LIMIT 1");
            if(count($hobby)==1) 
            {
                $hobby=collect($hobby)->first();
                DB::insert("INSERT INTO hobbies (user_id, hobby, cv) VALUES ('$user_id', '$hobby->hobby', '$id')");
            }
            
            $request->session()->flash('success', 'Your request has been submitted successfully.');
            return redirect('my-cvs');
        }
        
        else if($request->input('title')!='' AND $cv!=0)
        {
            $title=addslashes($request->input('title'));
            $template=addslashes($request->input('template'));
            
            DB::update("UPDATE cvs SET title='$title', template='$template', on_date=NOW(), status='0' WHERE id='$cv' AND user_id='$user_id'");
            
            $request->session()->flash('success', 'Your request has been submitted successfully.');
            return redirect('my-cvs');
        }
        
        $cv_details=DB::select("SELECT * FROM cvs WHERE id='$cv' LIMIT 1");
        if(count($cv_details)==1) $cv_details=collect($cv_details)->first();
        
        return view('cv_preview.index', ['title'=>trans('forms.cv_preview'), 'cv'=>$cv, 'cv_details'=>$cv_details]);
    }
    
    public function cover_page(Request $request)
    {
        $user_id=$request->session()->get('id');
        
        $template=$request->input('t');
        $user=$request->input('user');
        $cv_id=0;
        $attachment_name='';
        
        $cv=$request->input('cv');
        if($cv!='' AND $cv!=0)
        {
            $cv=DB::select("SELECT id, user_id, template, attachment, attachment_name FROM cvs WHERE id='$cv' LIMIT 1");
            $cv=collect($cv)->first();
            $attachment_name=$cv->attachment_name;
            
            $user=$cv->user_id;
            $cv_id=$cv->id;
            
            if($template=='' || $template=='0')
            $template=$cv->template;
        }
        
        $personal_details=array();
        $experience=array();
        $education=array();
        $user=DB::select("SELECT id, name, email FROM contacts WHERE id='$user' LIMIT 1");
        if(count($user)==1)
        {
            $user=collect($user)->first();
            
            $experience=DB::select("SELECT * FROM experience WHERE user_id='$user->id' AND cv='$cv_id'");
            $education=DB::select("SELECT * FROM education WHERE user_id='$user->id' AND cv='$cv_id'");
            $personal_details=DB::select("SELECT * FROM personal_details WHERE user_id='$user->id' AND cv='$cv_id' LIMIT 1");
            $personal_details=collect($personal_details)->first();
            $languages=DB::select("SELECT * FROM languages WHERE user_id='$user->id' AND cv='$cv_id'");
            $skills=DB::select("SELECT * FROM skills WHERE user_id='$user->id' AND cv='$cv_id'");
            $hobby=DB::select("SELECT * FROM hobbies WHERE user_id='$user->id' AND cv='$cv_id' LIMIT 1");
            $hobby=collect($hobby)->first();
        }
        
        if($template==1) $template='template1_cover_page';
        else if($template==2) $template='template2_cover_page';
        else if($template==3) $template='template3_cover_page';
        else $template='template1_cover_page';
        
        return view('cv_templates.'.$template, ['title'=>trans('forms.cv_preview'), 'attachment_name'=>$attachment_name, 'user'=>$user, 'experience'=>$experience, 'education'=>$education, 'personal_details'=>$personal_details, 'languages'=>$languages, 'skills'=>$skills, 'hobby'=>$hobby, 'preview_style'=>'max-width:100%;', 'preview_img_style'=>'left:555px;', 'preview_mrg_style'=>'margin-left:210px;']);
    }
    
    public function covering_letter(Request $request)
    {
        $user_id=$request->session()->get('id');
        
        $template=$request->input('t');
        $user=$request->input('user');
        $cv_id=0;
        
        $cv=$request->input('cv');
        if($cv!='' AND $cv!=0)
        {
            $cv=DB::select("SELECT id, user_id, template FROM cvs WHERE id='$cv' LIMIT 1");
            $cv=collect($cv)->first();
            
            $user=$cv->user_id;
            $cv_id=$cv->id;
            
            if($template=='' || $template=='0')
            $template=$cv->template;
        }
        
        $personal_details=array();
        $experience=array();
        $education=array();
        $user=DB::select("SELECT id, name, email FROM contacts WHERE id='$user' LIMIT 1");
        if(count($user)==1)
        {
            $user=collect($user)->first();
            
            $experience=DB::select("SELECT * FROM experience WHERE user_id='$user->id' AND cv='$cv_id'");
            $education=DB::select("SELECT * FROM education WHERE user_id='$user->id' AND cv='$cv_id'");
            $personal_details=DB::select("SELECT * FROM personal_details WHERE user_id='$user->id' AND cv='$cv_id' LIMIT 1");
            $personal_details=collect($personal_details)->first();
            $languages=DB::select("SELECT * FROM languages WHERE user_id='$user->id' AND cv='$cv_id'");
            $skills=DB::select("SELECT * FROM skills WHERE user_id='$user->id' AND cv='$cv_id'");
            $hobby=DB::select("SELECT * FROM hobbies WHERE user_id='$user->id' AND cv='$cv_id' LIMIT 1");
            $hobby=collect($hobby)->first();
        }
        
        if($template==1) $template='template1_covering_letter';
        else if($template==2) $template='template2_covering_letter';
        else if($template==3) $template='template3_covering_letter';
        else $template='template1_covering_letter';
        
        return view('cv_templates.'.$template, ['title'=>trans('forms.cv_preview'), 'user'=>$user, 'experience'=>$experience, 'education'=>$education, 'personal_details'=>$personal_details, 'languages'=>$languages, 'skills'=>$skills, 'hobby'=>$hobby, 'preview_style'=>'max-width:100%;', 'preview_img_style'=>'left:555px;', 'preview_mrg_style'=>'margin-left:210px;']);
    }
    
    public function template(Request $request)
    {
        $user_id=$request->session()->get('id');
        
        $template=$request->input('t');
        $user=$request->input('user');
        $cv_id=0;
        
        $cv=$request->input('cv');
        if($cv!='' AND $cv!=0)
        {
            $cv=DB::select("SELECT id, user_id, template FROM cvs WHERE id='$cv' LIMIT 1");
            $cv=collect($cv)->first();
            
            $user=$cv->user_id;
            $cv_id=$cv->id;
            
            if($template=='' || $template=='0')
            $template=$cv->template;
        }
        
        $personal_details=array();
        $experience=array();
        $education=array();
        $user=DB::select("SELECT id, name, email FROM contacts WHERE id='$user' LIMIT 1");
        if(count($user)==1)
        {
            $user=collect($user)->first();
            
            $experience=DB::select("SELECT * FROM experience WHERE user_id='$user->id' AND cv='$cv_id'");
            $education=DB::select("SELECT * FROM education WHERE user_id='$user->id' AND cv='$cv_id'");
            $personal_details=DB::select("SELECT * FROM personal_details WHERE user_id='$user->id' AND cv='$cv_id' LIMIT 1");
            $personal_details=collect($personal_details)->first();
            $languages=DB::select("SELECT * FROM languages WHERE user_id='$user->id' AND cv='$cv_id'");
            $skills=DB::select("SELECT * FROM skills WHERE user_id='$user->id' AND cv='$cv_id'");
            $hobby=DB::select("SELECT * FROM hobbies WHERE user_id='$user->id' AND cv='$cv_id' LIMIT 1");
            $hobby=collect($hobby)->first();
        }
        
        if($template==1) $template='template1';
        else if($template==2) $template='template2';
        else if($template==3) $template='template3';
        else $template='template1';
        
        return view('cv_templates.'.$template, ['title'=>trans('forms.cv_preview'), 'user'=>$user, 'experience'=>$experience, 'education'=>$education, 'personal_details'=>$personal_details, 'languages'=>$languages, 'skills'=>$skills, 'hobby'=>$hobby, 'preview_style'=>'max-width:100%;', 'preview_img_style'=>'left:555px;', 'preview_mrg_style'=>'margin-left:210px;']);
    }
    
    public function view_contract(Request $request, $id)
    {
        $user_id=$request->session()->get('id');
        $coach=0;
        $contract=DB::select("SELECT * FROM contracts WHERE id='$id' AND c_id='$user_id' AND signature='' LIMIT 1");
        if(count($contract)==0)
        {
            $row=DB::select("SELECT id FROM contact_courses WHERE coach='$user_id' AND contract_id='$id' LIMIT 1");
            if(count($row)==1)
            {
                $contract=DB::select("SELECT * FROM contracts WHERE id='$id' LIMIT 1");
                $coach=1;
            }
            else return redirect('dashboard');
        }
            
        $contract=collect($contract)->first();
        
        $t_date=date('Y-m-d');
        if($contract->status=='0')
        {
            //check for expiry
            $date=new DateTime($contract->on_date);
            $date=$date->format("Y-m-d");
            if($contract->expiry_date=='0000-00-00') 
            {
                $contract->expiry_date=$date;
                DB::update("UPDATE contracts SET expiry_date='$date' WHERE id='$contract->id'");
            }
                
                $expiry_date = new DateTime($contract->expiry_date);
                $expiry_date->modify("+2 days");
                $expiry_date=$expiry_date->format("Y-m-d");
                
                if($t_date>=$expiry_date)
                {
                    //echo 'Expired.<br>';
                    DB::update("UPDATE contracts SET status='3' WHERE id='$contract->id'");
                    return redirect('my-contracts');
                }
            }
        else return redirect('my-contracts');
        
        return view('contract.index', ['title'=>'Contract', 'contract'=>$contract, 'coach'=>$coach]);
    }
    
    public function save_signature(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        $data=array();
        
        if($request->input('id')!='')
        {
            $id=$request->input('id');
            $coach=$request->input('coach');
            $image=$request->input('image');
            
            $signature=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.png';
            
            $img = str_replace('data:image/png;base64,', '', $image);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            file_put_contents("signatures/".$signature, $fileData);
            //imagejpeg($fileData, "signatures/".$signature);
            
            if($coach==0)
            DB::update("UPDATE contracts SET signature='$signature', status='1' WHERE id='$id'");
            else
            DB::update("UPDATE contracts SET coach_signature='$signature', status='1' WHERE id='$id'");
            
            $contract=DB::select("SELECT * FROM contracts WHERE id='$id' LIMIT 1");
            $contract=collect($contract)->first();
            
            //Add signature to the Contract START
            //ini_set('memory_limit', '-1');
            //require('fpdf17/fpdf.php');
            //require('fpdi/src/autoload.php');

            $contact=DB::select("SELECT * FROM contacts WHERE id='$contract->c_id' LIMIT 1");
            $contact=collect($contact)->first();
            $type=$contract->type;
            
            //$c_id=\Contacts::instance()->coachee_contract($request, $contact, $type, $contract);
            
            $c_id=\Contacts::instance()->create_contract($request, $contract->c_id, $type, $contract, $coach);
            
            if($contract->signature!='' AND $contract->coach_signature!='')
            {
                //\Contacts::instance()->create_timetable_appointments($request, $contract->c_id, $contract->type, $contract, $contract->coach);
            }
            
            $pdf =new Fpdi();
            $pdf->AddPage();

            //Set the source PDF file
            $file=$contract->contract;
            $old_file=explode('.', $file);
            $old_file=$old_file[0].'_old.pdf';
            copy("contracts/".$file, "contracts/".$old_file);
            $pagecount = $pdf->setSourceFile("contracts/".$file);
        
            //Import the first page of the file
            $tpl = $pdf->importPage(1);


            //Use this page as template
            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($tpl, 0, 0, 210);
        
        
            //Select Arial italic 8
            $pdf->SetFont('GOTHIC','',8);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetXY(90, 220);

            $image = "signatures/".$signature;
            $pdf->Cell(200,14,$pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 120), 0, 0, 'L');
        
            $pdf->output("contracts/".$file, 'F');
            //Add signature to the Contract END
            $data['success']=1;
        }
        
        return response()->json($data);
    }
    
    public function save_signature_cv(Request $request)
    {
        $data=array();
        $data['success']=0;
        
        if($request->input('image')!='')
        {
            $image=$request->input('image');
            
            $signature=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 4).'.png';
            
            $img = str_replace('data:image/png;base64,', '', $image);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            file_put_contents("signatures/".$signature, $fileData);
            //imagejpeg($fileData, "signatures/".$signature);
            $data['signature']=$signature;
            $data['success']=1;
        }
        
        return response()->json($data);
    }
    
    public function my_profile(Request $request)
    {
        $id=$request->session()->get('id');
        $user=DB::select("SELECT * FROM contacts WHERE id='$id' LIMIT 1");
        $user=collect($user)->first();
        
        if($request->input('days')!='')
        {
            
            DB::delete("DELETE FROM users_availability WHERE c_id='$id'");
            for($i=0; $i<count($request->input('days')); $i++)
            {
                $day=addslashes($request->input('days')[$i]);
                $from_time=addslashes($request->input('from_time')[$i]);
                $to_time=addslashes($request->input('to_time')[$i]);
                
                DB::insert("INSERT INTO users_availability (c_id, day, from_time, to_time) VALUES ('$id', '$day', '$from_time', '$to_time')");
            }
            
            $request->session()->flash('success', 'Your availability has been updated successfully.');
            return redirect('my-profile');
        }
        
        if($request->file('image')!=''){
            $error='';
            $file=$request->file('image');
            $type=$request->input('type');
            
            //Move Uploaded File
            $destinationPath = 'images/profile/';
                $img_name=$file->getClientOriginalName();
                $array=explode('.', $img_name);
                $img_name=$array[0];
                $ext=$array[1];
                $img_name=rand(pow(10, 4-1), pow(10, 4)-1).'.'.$ext;
                $fileName = $destinationPath . $img_name; // renameing image
                
                if($file->move($destinationPath,$img_name)) {
                    $image=$img_name;
                    DB::update("UPDATE contacts SET profile_image='$image' WHERE id='$id'");
                }
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $email=addslashes($request->input('email'));
            $newsletter=addslashes($request->input('newsletter'));
            if($newsletter=='') $newsletter='0';
            if($email==$user->email) $email='';
            $code=substr(md5(uniqid(rand(),true)),0,20);
            
            if($email!='')
            {
                //send password reset link START
                    $from=env('MAIL_USERNAME');
                    $name=$user->name;
                    $data2=array(
                        'u_id'=>$id,
                        'code'=>$code,
                        'email'=>$email,
                        'from'=>$from,
                        'name'=>$name
                    );
                    Mail::send('emails.confirmation', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Email Confirmation');
                        //$message->attach($pathToFile);
                    });
                //send password reset link END
            }
            
            DB::update("UPDATE contacts SET name='$name', new_email='$email', code='$code', newsletter='$newsletter' WHERE id='$id'");
            $request->session()->flash('success', 'Your details has been updated successfully.');
            return redirect('my-profile');
        }
        
        if($request->input('pass1')!='')
        {
            $pass1=addslashes($request->input('pass1'));
            $pass2=addslashes($request->input('pass2'));
                if($pass1==$pass2){
                    DB::update("UPDATE contacts SET pass='$pass1' WHERE id='$id'");
                    
                    $request->session()->flash('success', 'Your password has been updated successfully!');
                }
                else $request->session()->flash('error', 'Passwords did not match.');
                return redirect('my-profile');
        }
        
        $availability=DB::SELECT("SELECT day, from_time, to_time FROM users_availability WHERE c_id='$id'");
        $user=DB::select("SELECT * FROM contacts WHERE id='$id' LIMIT 1");
        $user=collect($user)->first();
        return view('my_profile.index', ['title'=>'My Profile', 'user'=>$user, 'availability'=>$availability]);
    }
}
