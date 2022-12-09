<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use DB;
use Mail;
use PDF;
use PDFMerger;

class dashboard extends Controller
{
    public function index(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        $admin_type=$request->session()->get('admin_type');
        
        $users=DB::select("SELECT id FROM users WHERE type!='1'");
        $rooms=DB::select("SELECT id FROM rooms");
        $contacts=DB::select("SELECT id FROM contacts");
        $products=DB::select("SELECT id FROM products");
        $product_categories=DB::select("SELECT id FROM product_categories");
        $room_locations=DB::select("SELECT id FROM room_locations");
        
        $date=date('Y-m-d');
        /*$today_appointments=array(); $i=0;
        $row=DB::select("SELECT * FROM appointments WHERE date='$date'");
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
        
        $appointments=DB::select("SELECT * FROM appointments WHERE status='1'");
        $i=0; $app='';
        foreach($appointments as $appointment)
        {
            if($appointment->course_id!=0 AND $appointment->type=='1') continue;
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
            
            if($appointment->recurring!='0' AND 0) {
            
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
        
        $task_contacts=DB::select("SELECT id, name FROM contacts WHERE type!='Prospect' AND type!='Internship Company'");
        $task_users=DB::select("SELECT id, name FROM users WHERE id!='$admin_id'");
        $todos=array(); $i=0;
        $row=DB::select("SELECT * FROM todos WHERE (added_by='$admin_id' OR (user_type='1' AND assign_to='$admin_id')) AND type='1' ORDER BY priority, due_date ASC, id DESC");
        foreach($row as $r)
        {
            $todos[$i]['todo']=$r;
            
            if($r->user_type=='2')
            $row2=DB::select("SELECT id, name, profile_image FROM contacts WHERE id='$r->assign_to' LIMIT 1");
            else
            $row2=DB::select("SELECT id, name, profile_image FROM users WHERE id='$r->assign_to' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $todos[$i]['contact']=$row2;
            }
            else $todos[$i]['contact']='NA';
            
            $i++;
        }
        
        $open_courses=array();
        $row=DB::select("SELECT course_id FROM appointments WHERE status='2' AND type='2'");
        foreach($row as $r)
        {
            if(!in_array($r->course_id, $open_courses))
            $open_courses[]=$r->course_id;
        }
        
        $courses_app_report=array(); $i=0;
        foreach($open_courses as $course_id)
        {
            $row2=DB::select("SELECT title FROM courses WHERE id='$course_id'");
            $row2=collect($row2)->first();
            $courses_app_report[$i]['name']=$row2->title;
            
            $row2=DB::select("SELECT id FROM appointments WHERE course_id='$course_id' AND type='2'");
            $courses_app_report[$i]['appointments']=count($row2);
            
            $row2=DB::select("SELECT id FROM appointments WHERE course_id='$course_id' AND status='1' AND type='2'");
            $courses_app_report[$i]['accepted']=count($row2);
            
            $row2=DB::select("SELECT id FROM appointments WHERE course_id='$course_id' AND status='0' AND type='2'");
            $courses_app_report[$i]['pending']=count($row2);
            
            $i++;
        }
        
        $running_courses=array();
        $row=DB::select("SELECT course_id FROM appointments WHERE status='1' AND type='2'");
        foreach($row as $r)
        {
            $check=DB::select("SELECT id FROM appointments WHERE course_id='$r->course_id' AND status='2' LIMIT 1");
            if(count($check)==0)
            {
                if(!in_array($r->course_id, $running_courses))
                $running_courses[]=$r->course_id;
            }
        }
        
        $running_courses_app_report=array(); $i=0; $t_date=date('Y-m-d');
        foreach($running_courses as $course_id)
        {
            $row2=DB::select("SELECT title FROM courses WHERE id='$course_id'");
            $row2=collect($row2)->first();
            $running_courses_app_report[$i]['name']=$row2->title;
            
            $row2=DB::select("SELECT id FROM appointments WHERE course_id='$course_id' AND type='2'");
            $running_courses_app_report[$i]['appointments']=count($row2);
            
            $row2=DB::select("SELECT id FROM appointments WHERE course_id='$course_id' AND date>='$t_date' AND type='2'");
            $running_courses_app_report[$i]['done']=count($row2);
            
            $row2=DB::select("SELECT id FROM appointments WHERE course_id='$course_id' AND date<='$t_date' AND type='2'");
            $running_courses_app_report[$i]['pending']=count($row2);
            
            $i++;
        }
        return view('panel.dashboard.index', ['title'=>trans('header.dashboard'), 'sub_title'=>trans('header.all_stats'), 'users'=>$users, 'rooms'=>$rooms, 'contacts'=>$contacts, 'products'=>$products, 'product_categories'=>$product_categories, 'room_locations'=>$room_locations, 'appointments'=>$app, 'task_contacts'=>$task_contacts, 'task_users'=>$task_users, 'todos'=>$todos, 'courses_app_report'=>$courses_app_report, 'running_courses_app_report'=>$running_courses_app_report]);
    }
    
    public function cvs(Request $request)
    {
        $id=$request->session()->get('id');
        
        if($request->input('delete')!='')
        {
            $delete=addslashes($request->input('delete'));
            DB::delete("DELETE FROM cvs WHERE id='$delete'");
            $request->session()->flash('success','CV deleted successfully.');
            return redirect('admin/cvs');
        }
        
        if($request->input('notes_id')!='')
        {
            $id=addslashes($request->input('notes_id'));
            $notes=addslashes($request->input('notes'));
            
            DB::update("UPDATE sick_leaves SET notes='$notes' WHERE id='$id'");
            
            $request->session()->flash('success','Notes updated successfully.');
            return redirect('admin/cvs');
        }
        
        if($request->input('accept')!='')
        {
            $accept=addslashes($request->input('accept'));
            
            DB::update("UPDATE cvs SET status='1' WHERE id='$accept'");
            
            $this->generate_cv_pdf($request, $accept);
            
            $id=$accept;
            $leave=DB::select("SELECT id, title, user_id FROM cvs WHERE id='$id' LIMIT 1");
            $leave=collect($leave)->first();
            
            $contact=DB::select("SELECT name, email FROM contacts WHERE id='$leave->user_id' LIMIT 1");
            $contact=collect($contact)->first();
            $name2=$contact->name;
            $email=$contact->email;
            $from=env('MAIL_USERNAME');
            $title2='CV generated';
            $title_url='Login';
            $url=url('/');
            $text='Your CV "<b>'.$leave->title.'</b>" has been generated.<br>';
            
            $data2=array(
                    'email'=>$email,
                    'from'=>$from,
                    'name'=>$name2,
                    'title'=>$title2,
                    'title_url'=>$title_url,
                    'url'=>$url,
                    'text'=>$text
                );
                Mail::send('emails.notification', $data2, function($message) use($email, $from, $title2) {
                    $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject($title2);
                });
            
            $request->session()->flash('success','CV has been generated successfully.');
            return redirect('admin/cvs');
        }
        
        if($request->input('reject')!='')
        {
            $reject=addslashes($request->input('reject'));
            $reason=addslashes($request->input('reason'));
            
            DB::update("UPDATE cvs SET status='2', reason='$reason' WHERE id='$reject'");
            
            $id=$reject;
            $leave=DB::select("SELECT id, title, reason, user_id FROM cvs WHERE id='$id' LIMIT 1");
            $leave=collect($leave)->first();
            
            $contact=DB::select("SELECT name, email FROM contacts WHERE id='$leave->user_id' LIMIT 1");
            $contact=collect($contact)->first();
            $name2=$contact->name;
            $email=$contact->email;
            $from=env('MAIL_USERNAME');
            $title2='CV rejected';
            $title_url='Login';
            $url=url('/');
            $text='Your CV "<b>'.$leave->title.'</b>" has been rejected.<br>
            <b>Reason:</b> '.$leave->reason.'<br>';
            
            $data2=array(
                    'email'=>$email,
                    'from'=>$from,
                    'name'=>$name2,
                    'title'=>$title2,
                    'title_url'=>$title_url,
                    'url'=>$url,
                    'text'=>$text
                );
                Mail::send('emails.notification', $data2, function($message) use($email, $from, $title2) {
                    $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject($title2);
                });
            
            $request->session()->flash('success','CV has been rejected successfully.');
            return redirect('admin/cvs');
        }
        
        $cvs=array(); $i=0;
        $row=DB::select("SELECT * FROM cvs ORDER BY id DESC");
        foreach($row as $r)
        {
            $row2=DB::select("SELECT * FROM contacts WHERE id='$r->user_id'");
            if(count($row2)==0) continue;
            $row2=collect($row2)->first();
            
            $cvs[$i]['cv']=$r;
            $cvs[$i]['user']=$row2;
            
            $i++;
        }
        
        return view('panel.cvs.index', ['title'=>trans('header.cvs'), 'cvs'=>$cvs]);
    }
    
    public function generate_cv_pdf(Request $request, $cv_id)
    {
        $cvs=array(); $i=0;
        $row=DB::select("SELECT * FROM cvs WHERE id='$cv_id' LIMIT 1");
        $row=collect($row)->first();
        $user=$row->user_id;
        $template=$row->template;
        $attachment_name=$row->attachment_name;
        
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
        
        if($template==1) $template='pdf1';
        else if($template==2) $template='pdf2';
        else if($template==3) $template='pdf3';
        else $template='pdf1';
        
        //$pdf = PDF::loadHTML('cv_templates.'.$template.'cv_templates.'.$template, ['title'=> '', 'experience'=>$experience, 'education'=>$education, 'personal_details'=>$personal_details, 'languages'=>$languages, 'skills'=>$skills, 'hobby'=>$hobby]);
        
        $pdf = PDF::loadView('cv_templates.'.$template, ['title'=> '', 'attachment_name'=>$attachment_name, 'experience'=>$experience, 'education'=>$education, 'personal_details'=>$personal_details, 'languages'=>$languages, 'skills'=>$skills, 'hobby'=>$hobby]);
        $pdf->setOptions(['dpi' => 96, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'debugCss' => true]);
        $pdf_name=rand(pow(10, 4-1), pow(10, 4)-1).'.pdf';
        $pdf->save('company_files/cvs/'.$pdf_name);
        
        if($row->attachment!='')
        {
            $pdf = new PDFMerger();
            $pdf->addPDF('company_files/cvs/'.$pdf_name, 'all');
            $pdf->addPDF('company_files/attachments/'.$row->attachment, 'all');
        
            $pathForTheMergedPdf = 'company_files/cvs/'.$pdf_name;
            $pdf->merge('file', $pathForTheMergedPdf);
        }
        
        DB::update("UPDATE cvs SET pdf='$pdf_name' WHERE id='$cv_id'");
    }
    
    public function generate_pdf(Request $request)
    {
        $pdf = PDF::loadView('cv_templates.test', ['title'=> '']);
        $pdf->setOptions(['dpi' => 96, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'debugCss' => true]);
        $pdf_name=rand(pow(10, 4-1), pow(10, 4)-1).'.pdf';
        $pdf->save('company_files/cvs/'.$pdf_name);
    }
    
    public function contracts_documents(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('generate_appointments')!='')
        {
            $contract_id=$request->input('contract_id');
            
            $contract=DB::select("SELECT * FROM contracts WHERE id='$contract_id' LIMIT 1");
            $contract=collect($contract)->first();
            
            $classes=$request->input('classes');
            $froms=$request->input('froms');
            $tos=$request->input('tos');
            $notes=$request->input('notes');
            $rooms=$request->input('rooms');
            
            for($i=0; $i<count($classes); $i++)
            {
                $class=$classes[$i];
                $day='';
                if($request->input('days'.$i)!='')
                $day=implode(';', $request->input('days'.$i));
                $from=$froms[$i];
                $to=$tos[$i];
                $note=$notes[$i];
                $room=$rooms[$i];
                
                DB::insert("INSERT INTO contract_timetable (contract_id, course_id, class, days, fromm, too, notes, room, added_by, on_date) VALUES ('$contract_id', '$course_id', '$class', '$day', '$from', '$to', '$note', '$room', '$admin_id', NOW())");
            }
            
            \Contacts::instance()->create_timetable_appointments($request, $contract->c_id, $contract->type, $contract, $contract->coach);
        }
        
        if($request->input('delete')!='')
        {
            
            $delete=addslashes($request->input('delete'));
            
            //track Activity START
            //track Activity END
            
            DB::delete("DELETE FROM contracts WHERE id='$delete'");
            $request->session()->flash('success', 'Contract has been deleted successfully.');
            
            return redirect('admin/contracts-documents');
        }
        
        $t_date=date('Y-m-d');
        if($request->input('resend')!='')
        {
            
            $id=addslashes($request->input('resend'));
            
            DB::update("UPDATE contracts SET status='0', expiry_date='$t_date', reminder='0' WHERE id='$id'");
            $request->session()->flash('success', 'Contract has been sent successfully.');
            
            return redirect('admin/contracts-documents');
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $contact=addslashes($request->input('contact'));
            $document='';
            
            if($request->file('file')!='') 
            {
                $file=$request->file('file');
            
                //Move Uploaded File
                $destinationPath = 'company_files/documents';
                $file_name=$file->getClientOriginalName();
                $array=explode('.', $file_name);
                $file_name=$array[0];
                $ext=$array[1];
                $file_name=rand(pow(10, 4-1), pow(10, 4)-1).'-'.time().'.'.$ext;
            
                if($file->move($destinationPath,$file_name)) {
                    $document=$file_name;
                }
            }
            
            DB::insert("INSERT INTO contracts (type, contract, c_id, added_by, on_date, document) VALUES ('$name', '$document', '$contact', '$admin_id', NOW(), '1')");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Added document - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Successfully added.');
            return redirect('admin/contracts-documents');
        }
        
        $contracts=array(); $j=0;
        $row2=DB::select("SELECT * FROM contracts ORDER BY id DESC");
        if(count($row2)!=0)
        {
            foreach($row2 as $r2)
            {
                $contracts[$j]['contract']=$r2;
                
                $contracts[$j]['contact']='NA';
                $row3=DB::select("SELECT * FROM contacts WHERE id='$r2->c_id' LIMIT 1");
                if(count($row3)==1) {
                    $row3=collect($row3)->first();
                    $contracts[$j]['contact']=$row3;
                }
                
                if($r2->document=='0' AND $r2->status=='0')
                {
                    //check for expiry
                    $date=new DateTime($r2->on_date);
                    $date=$date->format("Y-m-d");
                    if($r2->expiry_date=='0000-00-00') 
                    {
                        $r2->expiry_date=$date;
                        DB::update("UPDATE contracts SET expiry_date='$date' WHERE id='$r2->id'");
                    }
                
                    $expiry_date = new DateTime($r2->expiry_date);
                    $expiry_date->modify("+2 days");
                    $expiry_date=$expiry_date->format("Y-m-d");
                
                    if($t_date>=$expiry_date)
                    {
                        //echo 'Expired.<br>';
                        DB::update("UPDATE contracts SET status='3' WHERE id='$r2->id'");
                        $r2->status='3';
                        $contracts[$j]['contract']=$r2;
                    }
                }
                    
                $j++;
            }
        }
        
        $document_types=DB::select("SELECT * FROM document_types");
        $contacts=DB::select("SELECT id, name FROM contacts ORDER BY name ASC");
        return view('panel.contracts_documents.index', ['title'=>trans('header.contracts_documents'), 'contracts'=>$contracts, 'document_types'=>$document_types, 'contacts'=>$contacts]);
    }
    
    public function fetch_timetable(Request $request)
    {
        $data=array();
        $data['success']=0;
        $data['timetable']='';
        
        $contract_id=$request->input('contract_id');
        
        $contract=DB::select("SELECT * FROM contracts WHERE id='$contract_id' LIMIT 1");
        $contract=collect($contract)->first();
        
        $c_id=$contract->id;
        $contact_id=$contract->c_id;
        $courses=array(); $i=0; $total_lessons=0;
        $row=DB::select("SELECT * FROM contact_courses WHERE c_id='$contact_id' AND contract_id='$c_id'");
        
        if(count($row)!=0)
        {
            foreach($row as $r)
            {
                $row2=DB::select("SELECT id, title, coach FROM courses WHERE id='$r->course_id' LIMIT 1");
                if(count($row2)==0) continue;
                $row2=collect($row2)->first();
                
                $courses[$i]['contract']=$c_id;
                $courses[$i]['course']=$row2;
                
                $c=$r->course_id;
                $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$c'");
                foreach($row1 as $r1)
                {
                    $row22=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$c'");
                    foreach($row22 as $r2)
                    {
                        $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$c'");
                        $module_items=array(); $k=0;
                        foreach($row3 as $r3)
                        {
                            $row4=DB::select("SELECT lessons FROM contract_items WHERE c_id='$contact_id' AND course_id='$c' AND contract_id='$c_id' AND i_id='$r3->id' LIMIT 1");
                            if(count($row4)==1)
                            {
                                $row4=collect($row4)->first();
                                $total_lessons+=$row4->lessons;
                            }
                        }
                    }
                }
                
                $courses[$i]['coach']='NA';
                $row1=DB::select("SELECT * FROM contacts WHERE id='$row2->coach' LIMIT 1");
                if(count($row1)==1)
                {
                    $row1=collect($row1)->first();
                    $courses[$i]['coach']=$row1;
                }
                
                $courses[$i]['contact']=$contact_id;
                
                $classes=array(); $i2=0;
                $row1=DB::SELECT("SELECT * FROM classes WHERE course_id='$row2->id'");
                foreach($row1 as $r1)
                {
                    $classes[$i2]['class']=$r1;
                
                    $i2++;
                }
                $courses[$i]['classes']=$classes;
                
                
                $i++;
            }
        }
        
        $rooms=array(); $i=0;
        $row=DB::select("SELECT id, name, location FROM rooms");
        foreach($row as $r)
        {
            $rooms[$i]['room']=$r;
            
            $rooms[$i]['location']='';
            $row2=DB::select("SELECT name FROM room_locations WHERE id='$r->location' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $rooms[$i]['location']=$row2->name;
            }
            
            $i++;
        }
        
        $i=0;
        foreach($courses as $course)
        {
            foreach($course['classes'] as $class)
            {
                $rooms2='';
                if(!empty($rooms)) {
                foreach($rooms as $room) {
                    $selected='';
                    if($class['class']->room==$room['room']->id) $selected='selected';
                    $rooms2.='<option value="'.$room['room']->id.'" '.$selected.'>'.$room['room']->name.' ('.$room['location'].')</option>';
                } }
                
                $time=date_format(new DateTime($class['class']->fromm),'H:i');
                $time_end=date_format(new DateTime($class['class']->too),'H:i');
                
                $classes=explode(';', $class['class']->day);
                
                $mon=''; $tue=''; $wed=''; $thur='';

                $data['timetable'].='
                <tr>
                <td><input type="text" name="classes[]" class="form-control" required value="'.$class['class']->name.'"></td>
                <td>
                <select type="text" name="days'.$i.'[]" class="form-control select-multiple" multiple="" required>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
                </select></td>
                <td><input type="text" name="froms[]" class="form-control" required value="'.$time.'"></td>
                <td><input type="text" name="tos[]" class="form-control" required value="'.$time_end.'"></td>
                <td><input type="text" name="notes[]" class="form-control" values="'.$class['class']->notes.'"></td>
                <td>
                <select name="rooms[]" class="form-control" required value="'.$class['class']->room.'" style="padding-left:0px;">
                '.$rooms2.'
                </select>
                </td>
                </tr>';
                
                $i++;
            }
        $data['success']=1;
        }
        
        return response()->json($data);
    }
    
    public function my_profile(Request $request)
    {
        $id=$request->session()->get('admin_id');
        $user=DB::select("SELECT * FROM users WHERE id='$id' LIMIT 1");
        $user=collect($user)->first();
        
        if($request->input('days')!='')
        {
            
            DB::delete("DELETE FROM users_availability WHERE u_id='$id'");
            for($i=0; $i<count($request->input('days')); $i++)
            {
                $day=addslashes($request->input('days')[$i]);
                $from_time=addslashes($request->input('from_time')[$i]);
                $to_time=addslashes($request->input('to_time')[$i]);
                
                DB::insert("INSERT INTO users_availability (u_id, day, from_time, to_time) VALUES ('$id', '$day', '$from_time', '$to_time')");
            }
            
            $request->session()->flash('success', 'Your availability has been updated successfully.');
            return redirect('admin/my-profile');
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
                    DB::update("UPDATE users SET profile_image='$image' WHERE id='$id'");
                }
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $email=addslashes($request->input('email'));
            
            DB::update("UPDATE users SET name='$name', email='$email' WHERE id='$id'");
            $request->session()->flash('success', 'Your details has been updated successfully.');
            return redirect('admin/my-profile');
        }
        
        if($request->input('pass1')!='')
        {
            $pass1=addslashes($request->input('pass1'));
            $pass2=addslashes($request->input('pass2'));
                if($pass1==$pass2){
                    DB::update("UPDATE users SET pass='$pass1' WHERE id='$id'");
                    
                    $request->session()->flash('success', 'Your password has been updated successfully!');
                }
                else $request->session()->flash('error', 'Passwords did not match.');
                return redirect('admin/my-profile');
        }
        
        $availability=DB::SELECT("SELECT day, from_time, to_time FROM users_availability WHERE u_id='$id'");
        $user=DB::select("SELECT * FROM users WHERE id='$id' LIMIT 1");
        $user=collect($user)->first();
        return view('panel.my_profile.index', ['title'=>'My Profile', 'user'=>$user, 'availability'=>$availability]);
    }
    public function add_signature(Request $request){
        
      $image = $request->input('image');
        if($image!='')    {    
      $admin_id=$request->session()->get('admin_id');
     
            $signature = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.png';

            $img = str_replace('data:image/png;base64,', '', $image);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            file_put_contents("admin_signatures/" . $signature, $fileData);
            // imagejpeg($fileData, "signatures/".$signature);

            DB::update("UPDATE users SET signature='$signature' WHERE id='$admin_id'");
            $data['success'] = 1;
       
        
}
    else
    {
         $data['success'] = 0;
    }
    return response()->json($data);
}
}
