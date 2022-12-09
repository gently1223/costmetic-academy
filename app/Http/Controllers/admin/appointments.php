<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use DateTime;
use App\Http\Controllers\Controller;
use DB;
use Mail;
use RRule\RRule;

class appointments extends Controller
{
    public function index(Request $request)
    {
        $room_filter=''; $contact_filter=''; $user_filter='';
        if($request->input('room')!='') {
            $room=$request->input('room');
            $room_filter=" AND room='$room' ";
        }
        if($request->input('contact')!='') {
            $contact=$request->input('contact');
            $contact_filter=" AND contact='$contact' ";
        }
        if($request->input('user')!='') {
            $user=$request->input('user');
            $user_filter=" AND added_by='$user' ";
        }
        $appointments=DB::select("SELECT * FROM appointments WHERE status='1' AND id!='0' $room_filter $contact_filter $user_filter ");
        $i=0; $app='';
        foreach($appointments as $appointment)
        {
            if($appointment->course_id!=0 AND $appointment->type=='1') continue;
            $time=date("H:i", strtotime($appointment->time));
            $time_end=date("H:i", strtotime($appointment->time_end));
            
            $title=addslashes($appointment->title);
            $row2=DB::select("SELECT name, location FROM rooms WHERE id='$appointment->room' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $row3=DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                if(count($row3)==1)
                {
                    $row3=collect($row3)->first();
                    $title.=' ('.$row2->name.' - '.$row3->name.')';
                }
                else
                $title.=' ('.addslashes($row2->name).')';
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
        
        $contacts=DB::select("SELECT id, name FROM contacts");
        $users=DB::select("SELECT id, name FROM users");
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
        
        $holidays=array();
        $row=DB::select("SELECT title, beginning, end FROM holidays");
        foreach($row as $r)
        {
            $holidays2=\CommonFunctions::instance()->getDatesFromRange($r->beginning, $r->end, 'Y-m-d');
            foreach($holidays2 as $h)
            {
                $holidays[]=$h;
            }
        }
        $calendar_categories=DB::select("SELECT id, name FROM calendar_categories ORDER BY name ASC");
        return view('panel.appointments.index', ['title'=>trans('header.appointments'), 'sub_title'=>count($appointments).' total '.trans('header.appointments'), 'appointments'=>$app, 'contacts'=>$contacts, 'users'=>$users, 'rooms'=>$rooms, 'calendar_categories'=>$calendar_categories, 'holidays'=>$holidays]);
    }
    
    public function holidays(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            $delete=addslashes($request->input('delete'));
            DB::delete("DELETE FROM holidays WHERE id='$delete'");
            $request->session()->flash('success','Holiday deleted successfully.');
            return redirect('admin/holidays');
        }
        
        if($request->input('title')!='')
        {
            $title=addslashes($request->input('title'));
            $documents='';
            $beginning=''; $end='';
            $period=addslashes($request->input('period'));
            if($period!='')
            {
                $dates=explode(' - ', $period);
                $beginning=date_format(new DateTime($dates[0]),'Y-m-d');
                $end=date_format(new DateTime($dates[1]),'Y-m-d');
            }
            
            DB::insert("INSERT INTO holidays (title, documents, beginning, end, added_by, on_date) VALUES ('$title', '$documents', '$beginning', '$end', '$admin_id', NOW())");
            
            $courses=array();
            $appointments=DB::select("SELECT id, course_id FROM appointments WHERE course_id!='0' AND ((date>='$beginning' AND date<='$end') OR (date='$beginning' OR date='$end'))");
            foreach($appointments as $appointment)
            {
                DB::update("UPDATE appointments SET status='3' WHERE id='$appointment->id'");
                if(!in_array($appointment->course_id, $courses))
                    $courses[]=$appointment->course_id;
                //echo $appointment->id;
            }
            
            foreach($courses as $course)
            {
                $course=DB::select("SELECT * FROM courses WHERE id='$course' LIMIT 1");
                if(count($course)==0) continue;
                $course=collect($course)->first();
                \Courses::instance()->create_appointments($request, $course);
            }
            
            $request->session()->flash('success','Holiday has been added successfully.');
            return redirect('admin/holidays');
        }
        
        $holidays=array(); $i=0;
        $row=DB::select("SELECT * FROM holidays ORDER BY id DESC");
        foreach($row as $r)
        {
            $holidays[$i]['holiday']=$r;
            
            $i++;
        }
        
        return view('panel.holidays.index', ['title'=>trans('header.holidays'), 'holidays'=>$holidays]);
    }
    
    public function sick_leaves(Request $request)
    {
        $id=$request->session()->get('id');
        
        if($request->input('delete')!='')
        {
            $delete=addslashes($request->input('delete'));
            DB::delete("DELETE FROM sick_leaves WHERE id='$delete'");
            $request->session()->flash('success','Sick leave deleted successfully.');
            return redirect('admin/sick-leaves');
        }
        
        if($request->input('notes_id')!='')
        {
            $id=addslashes($request->input('notes_id'));
            $notes=addslashes($request->input('notes'));
            
            DB::update("UPDATE sick_leaves SET notes='$notes' WHERE id='$id'");
            
            $request->session()->flash('success','Notes updated successfully.');
            return redirect('admin/sick-leaves');
        }
        
        if($request->input('accept')!='')
        {
            $accept=addslashes($request->input('accept'));
            $reason_type=addslashes($request->input('reason_type'));
            
            DB::update("UPDATE sick_leaves SET status='1', reason_type='$reason_type' WHERE id='$accept'");
            
            $id=$accept;
            $leave=DB::select("SELECT id, title, user_id FROM sick_leaves WHERE id='$id' LIMIT 1");
            $leave=collect($leave)->first();
            
            $contact=DB::select("SELECT name, email FROM contacts WHERE id='$leave->user_id' LIMIT 1");
            $contact=collect($contact)->first();
            $name2=$contact->name;
            $email=$contact->email;
            $from=env('MAIL_USERNAME');
            $title2='Sick leave accepted';
            $title_url='Login';
            $url=url('/');
            $text='Your sick leave "<b>'.$leave->title.'</b>" has been accepted.<br>';
            
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
            
            $request->session()->flash('success','Sick leave has been accepted successfully.');
            return redirect('admin/sick-leaves');
        }
        
        if($request->input('reject')!='')
        {
            $reject=addslashes($request->input('reject'));
            $reason=addslashes($request->input('reason'));
            
            DB::update("UPDATE sick_leaves SET status='2', reason='$reason' WHERE id='$reject'");
            
            $id=$reject;
            $leave=DB::select("SELECT id, title, reason, user_id FROM sick_leaves WHERE id='$id' LIMIT 1");
            $leave=collect($leave)->first();
            
            $contact=DB::select("SELECT name, email FROM contacts WHERE id='$leave->user_id' LIMIT 1");
            $contact=collect($contact)->first();
            $name2=$contact->name;
            $email=$contact->email;
            $from=env('MAIL_USERNAME');
            $title2='Sick leave rejected';
            $title_url='Login';
            $url=url('/');
            $text='Your sick leave "<b>'.$leave->title.'</b>" has been rejected.<br>
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
            
            $request->session()->flash('success','Sick leave has been rejected successfully.');
            return redirect('admin/sick-leaves');
        }
        
        $sick_leaves=array(); $i=0;
        $row=DB::select("SELECT * FROM sick_leaves ORDER BY id DESC");
        foreach($row as $r)
        {
            $row2=DB::select("SELECT * FROM contacts WHERE id='$r->user_id'");
            if(count($row2)==0) continue;
            $row2=collect($row2)->first();
            
            $sick_leaves[$i]['leave']=$r;
            $sick_leaves[$i]['user']=$row2;
            
            $i++;
        }
        
        return view('panel.sick_leaves.index', ['title'=>trans('header.sick_leaves'), 'sick_leaves'=>$sick_leaves]);
    }
    
    public function attendance_register(Request $request)
    {
        $course_id=0;
        $course_ids=array();
        $row=DB::select("SELECT course_id FROM course_offers ORDER BY id DESC");
        foreach($row as $r)
        {
            if(!in_array($r->course_id, $course_ids))
            $course_ids[]=$r->course_id;
        }
        
        $courses=array(); $i=0;
        foreach($course_ids as $course_id)
        {
            $row=DB::select("SELECT id, title, description, students FROM courses WHERE id='$course_id' LIMIT 1");
            if(count($row)==0) continue;
            $row=collect($row)->first();
            
            $appointments=array(); $j=0;
            $row2=DB::select("SELECT * FROM appointments WHERE course_id='$course_id' AND status='1' AND type='2'");
            if(count($row2)==0) continue;
            $courses[$i]['course']=$row;
            foreach($row2 as $r)
            {
                $appointments[$j]['appointment']=$r;
                
                $appointments[$j]['room']='';
                $appointments[$j]['room_location']='';
            
                $row2=DB::select("SELECT name, location FROM rooms WHERE id='$r->room' LIMIT 1");
                if(count($row2)==1)
                {
                    $row2=collect($row2)->first();
                    $appointments[$j]['room']=$row2->name;
                
                    $row2=DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                    if(count($row2)==1)
                    {
                        $row2=collect($row2)->first();
                        $appointments[$j]['location']=$row2->name;
                    }
                }
                
                $appointments[$j]['coach']='';
                $row2=DB::select("SELECT name, email FROM contacts WHERE id='$r->contact' LIMIT 1");
                if(count($row2)==1)
                {
                    $row2=collect($row2)->first();
                    $appointments[$j]['coach']=$row2->name.'<p style="color:#777;">'.$row2->email.'</p>';
                }
                
                $j++;
            }
            $courses[$i]['appointments']=$appointments;
            
            $date=date('Y-m-d');
            $attendance=array(); $j=0;
            $row2=DB::select("SELECT id, title, room, date, time, time_end, appointment_form FROM appointments WHERE course_id='$course_id' AND status='1' AND type='2'");
            foreach($row2 as $r)
            {
                $attendance[$j]['appointment']=$r;
                
                $attendance[$j]['room']='';
                $attendance[$j]['room_location']='';
            
                $row2=DB::select("SELECT name, location FROM rooms WHERE id='$r->room' LIMIT 1");
                if(count($row2)==1)
                {
                    $row2=collect($row2)->first();
                    $attendance[$j]['room']=$row2->name;
                
                    $row2=DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                    if(count($row2)==1)
                    {
                        $row2=collect($row2)->first();
                        $attendance[$j]['location']=$row2->name;
                    }
                }
                $courses[$i]['attendance']=$attendance;
                
                
                $j++;
            }
            
                
            $students_ids=array();
            $row3=DB::select("SELECT id, title, room, date, time, time_end, contact FROM appointments WHERE course_id='$course_id' AND status='1' AND type='1'");
            foreach($row3 as $r2)
            {
                if(in_array($r2->contact, $students_ids)) continue;
                $students_ids[]=$r2->contact;
            }
            
            $students=array(); $k=0;
            foreach($students_ids as $s)
            {
                $row4=DB::select("SELECT id, name, email FROM contacts WHERE id='$s' LIMIT 1");
                $row4=collect($row4)->first();
                $students[$k]['student']=$row4;
                
                $students[$k]['attendance']='NA'; $students[$k]['late']='';
                $check=DB::select("SELECT status, late FROM attendance WHERE course_id='$course_id' AND student_id='$s' AND date='$date' LIMIT 1");
                if(count($check)==1)
                {
                    $check=collect($check)->first();
                    $students[$k]['attendance']=$check->status;
                    $students[$k]['late']=$check->late;
                }
                
                $k++;
                
            }
            $courses[$i]['students']=$students;
            
            $notes=array(); $k=0;
            $row2=DB::select("SELECT * FROM course_notes WHERE course_id='$course_id' ORDER BY id DESC");
            foreach($row2 as $r2)
            {
                $notes[$k]['note']=$r2;
                
                $k++;
            }
            $courses[$i]['notes']=$notes;
            
            $attendance=array(); $j=0; $filters='';
            if($request->input('d')!='' AND $request->input('c')==$course_id)
            {
                $dates=explode(' - ', $request->input('d'));
                $start=date_format(new DateTime($dates[0]),'Y-m-d');
                $end=date_format(new DateTime($dates[1]),'Y-m-d');
                $filters=" AND (date>='$start' AND date<='$end') ";
                $student=$request->input('s');
                
                if($student!='') $filters.=" AND student_id='$student' ";
            }
            $check=DB::select("SELECT status, late, student_id, date, notes, pdf_url FROM attendance WHERE course_id='$course_id' $filters ORDER BY date DESC");
            foreach($check as $c)
            {
                $row4=DB::select("SELECT id, title, room, date, time, time_end, module_id FROM appointments WHERE course_id='$course_id' AND status='1' AND type='2' AND date='$c->date' LIMIT 1");
                if(count($row4)==0) continue;
                $row4=collect($row4)->first();
                $attendance[$j]['appointment']=$row4;
                
                $row4=DB::select("SELECT title FROM modules WHERE id='$row4->module_id' LIMIT 1");
                $row4=collect($row4)->first();
                $attendance[$j]['module']=$row4;
                
                $attendance[$j]['attendance']=$c;
                
                $row4=DB::select("SELECT id, name, email FROM contacts WHERE id='$c->student_id' LIMIT 1");
                $row4=collect($row4)->first();
                $attendance[$j]['student']=$row4;
                
                $attendance[$j]['sick_leave']='NA';
                $row4=DB::select("SELECT id, documents FROM sick_leaves WHERE user_id='$c->student_id' AND beginning<='$c->date' AND end>='$c->date' LIMIT 1");
                if(count($row4)==1)
                {
                    $row4=collect($row4)->first();
                    $attendance[$j]['sick_leave']=$row4;
                }
                
                $j++;
            }
            
            $courses[$i]['attendance']=$attendance;
            
            $attendance_notes=array(); $j=0;
            $row=DB::select("SELECT * FROM attendance_notes WHERE course_id='$course_id' ORDER BY id DESC");
            foreach($row as $r)
            {
                $attendance_notes[$j]['note']=$r;
            
                $j++;
            }
            
            $courses[$i]['attendance_notes']=$attendance_notes;
            
            $attendance_report=array(); $k=0;
            foreach($students_ids as $s)
            {
                $row4=DB::select("SELECT id, name, email FROM contacts WHERE id='$s' LIMIT 1");
                $row4=collect($row4)->first();
                $attendance_report[$k]['student']=$row4;
                $total_appointments=50;
                
                $attendance_report[$k]['percentage']='NA';
                $check=DB::select("SELECT id FROM attendance WHERE course_id='$course_id' AND student_id='$s'");
                if(count($check)!=0)
                {
                    $total_appointments=count($check);
                    
                    $check=DB::select("SELECT id FROM attendance WHERE course_id='$course_id' AND student_id='$s' AND status='0'");
                    $absents=count($check);
                    
                    $check=DB::select("SELECT id FROM attendance WHERE course_id='$course_id' AND student_id='$s' AND (status='1' OR status='2')");
                    $presents=count($check);
                    
                    
                    
                    if($absents==0) $attendance_report[$k]['percentage']='100%';
                    else $attendance_report[$k]['percentage']=(($presents/$total_appointments)*100).'%';
                }
                
                $k++;
                
            }
            $courses[$i]['attendance_report']=$attendance_report;
            
            $i++;
        }
        
        $date=date('Y-m-d');
        $attendance_notes=array(); $i=0;
        $row=DB::select("SELECT * FROM attendance_notes WHERE course_id='$course_id' ORDER BY id DESC");
        foreach($row as $r)
        {
            $attendance_notes[$i]['note']=$r;
            
            $i++;
        }
        
        return view('panel.attendance_register.index', ['title'=>'Attendance Register', 'courses'=>$courses, 'attendance_notes'=>$attendance_notes]);
    }
    
    public function attendance_register_date(Request $request)
    {
        $data=array();
        $data['success']=1;
        $data['students']='';
        
        $course_id=addslashes($request->input('course_id'));
        $date=addslashes($request->input('date'));
        $date=date_format(new DateTime($date),'Y-m-d');
        
        $students_ids=array();
        $row3=DB::select("SELECT id, title, room, date, time, time_end, contact FROM appointments WHERE course_id='$course_id' AND status='1' AND type='1' AND date='$date'");
        foreach($row3 as $r2)
        {
            if(in_array($r2->contact, $students_ids)) continue;
            $students_ids[]=$r2->contact;
        }
        
        $students=array(); $k=0;
        foreach($students_ids as $s)
        {
            $row4=DB::select("SELECT id, name, email FROM contacts WHERE id='$s' LIMIT 1");
            $row4=collect($row4)->first();
            $students[$k]['student']=$row4;
                
            $present=''; $absent=''; $late=''; $late_mins=''; $notes='';
            $students[$k]['attendance']='NA';
            $check=DB::select("SELECT status, late, notes FROM attendance WHERE course_id='$course_id' AND student_id='$s' AND date='$date' LIMIT 1");
            if(count($check)==1)
            {
                $check=collect($check)->first();
                $students[$k]['attendance']=$check->status;
                
                $late_mins=$check->late;
                if($check->status=='1') $present='<i class="fa fa-check" style="color:green;"></i>';
                else if($check->status=='0') $absent='<i class="fa fa-check" style="color:green;"></i>';
                else if($check->status=='2') $late='<i class="fa fa-check" style="color:green;"></i>'.' ('.$late_mins.' mins)';
                
                $notes=$check->notes;
            }
            
            $data['students'].='<tr>
                                    <td>'.$row4->name.'</td>
                                    <td>'.$present.'</td>
                                    <td>'.$absent.'</td>
                                    <td>'.$late.'</td>
                                    <td>'.$notes.'</td>
                                </tr>';
                
            $k++;
                
        }
        
        return response()->json($data);
    }
    
    public function attendance_fetch_notes_date(Request $request)
    {
        $id=$request->session()->get('id');
        $data=array();
        $data['success']=0;
        
        $course_id=$request->input('course_id');
        $date=addslashes($request->input('date'));
        $date=date_format(new DateTime($date),'Y-m-d');
        
        $notes=DB::select("SELECT * FROM attendance_notes WHERE course_id='$course_id' AND date='$date' ORDER BY id DESC");
        
        $data['notes']='';
        foreach($notes as $note) 
        {
            $data['notes'].="<div style='border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;'>
                                                        <div style='overflow:hidden;'>
                                                            <div class='float-left'>
                                                            </div>
                                                            
                                                            <div class='float-left'>
                                                                ".date_format(new DateTime($note->added_on),'d-m-Y')."
                                                                <p style='color:#777'>".date_format(new DateTime($note->added_on),'H:i')."</p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div>".$note->notes."</div>
                                                        </div>";
        }
        $data['success']=1;
        
        return response()->json($data);
    }
    
    public function create_appointment(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        $data=array();
        $data['success']=0;
        $id=addslashes($request->input('edit'));
        $contact=addslashes($request->input('contact'));
        $room=addslashes($request->input('room'));
        $title=addslashes($request->input('title'));
        $category=addslashes($request->input('category'));
        $description=addslashes($request->input('description'));
        $date=$request->input('date2');
        if($date!='')
        $date=date_format(new DateTime($date),'Y-m-d');
        $time=$request->input('time');
        $time_end=$request->input('time_end');
        $reminder=$request->input('reminder');
        $recurring=$request->input('recurring');
        $until=$request->input('until');
        if($until!='')
        $until=date_format(new DateTime($until),'Y-m-d');
        $data['edit']=$id;
        
        $asg=explode('-', $contact);
        if($asg[0]=='contact') { $contact=$asg[1]; $user_type='2'; }
        else if(isset($asg[1])) { $contact=$asg[1]; $user_type='1'; }
        else $contact=0;
        
        if($id==0)
        {
            $check=DB::select("SELECT id FROM holidays WHERE beginning<='$date' AND end>='$date' LIMIT 1");
            if(count($check)==1)
            {
                $data['error']=trans('forms.full_day_holiday');
                //$data['error']="SELECT id FROM appointments WHERE room='$room' AND date='$date' AND (time>='$time' AND time_end<='$time_end') LIMIT 1";
                return response()->json($data);
            }
            
            $check=DB::select("SELECT id FROM appointments WHERE date='$date' AND ((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time='$time_end') OR (time<='$time' AND time_end='$time_end')) AND status='1' AND contact='$contact' AND user_type='$user_type' LIMIT 1");
            if(count($check)==1)
            {
                $data['error']=trans('forms.already_booked_appointment');
                //$data['error']="SELECT id FROM appointments WHERE room='$room' AND date='$date' AND (time>='$time' AND time_end<='$time_end') LIMIT 1";
                return response()->json($data);
            }
            
            $check=DB::select("SELECT id FROM appointments WHERE room='$room' AND date='$date' AND ((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time='$time_end') OR (time<='$time' AND time_end='$time_end')) AND status='1' LIMIT 1");
            if(count($check)==1)
            {
                $data['error']=trans('forms.already_booked_room');
                //$data['error']="SELECT id FROM appointments WHERE room='$room' AND date='$date' AND (time>='$time' AND time_end<='$time_end') LIMIT 1";
                return response()->json($data);
            }
            $appt_form = $request->input('appointment_form');
            if($appt_form == 'Please Select')
                $appt_form = 'Unknown';
            DB::insert("INSERT INTO appointments (contact, room, title, category, description, reminder, recurring, date, time, time_end, until, added_by, added_on, parent, user_type, appointment_form) VALUES ('$contact', '$room', '$title', '$category', '$description', '$reminder', '$recurring', '$date', '$time', '$time_end', '$until', '$admin_id', NOW(), '0', '$user_type', '$appt_form')");
            $id = DB::getPdo()->lastInsertId();
            
            if($request->input('attendees')!='')
            {
                foreach($request->input('attendees') as $at)
                {
                    $asg=explode('-', $at);
                    if($asg[0]=='contact') { $at=$asg[1]; $user_type2='2'; }
                    else if(isset($asg[1])) { $at=$asg[1]; $user_type2='1'; }
                    else { $at=0; $user_type2='1'; }
                    
                    DB::insert("INSERT INTO attendees (app_id, user_id, user_type) VALUES ('$id', '$at', '$user_type2')");
                }
            }
            
            $this->recurring($request, $contact, $room, $title, $description, $date, $time, $time_end, $recurring, $until, $id, $user_type);
            
            //send notification START
                if($user_type=='1')
                $contact=DB::select("SELECT name, email FROM users WHERE id='$contact' LIMIT 1");
                else
                $contact=DB::select("SELECT name, email FROM contacts WHERE id='$contact' LIMIT 1");
                $contact=collect($contact)->first();
                $name2=$contact->name;
                $email=$contact->email;
                $from=env('MAIL_USERNAME');
                $title2='New Appointment';
                $title_url='Login';
                $url=url('/');
                $text='An appointment has been created for you:<br><br>
                <b>'.$title.'</b><br>';
            
                if($description!='') $text.=$description.'<br>';
            
                $text.='<br>Date: '.$date.'<br>Time: '.$time.' - '.$time_end.'<br>';
            
                $room_details='';
                $row2=DB::select("SELECT name, location FROM rooms WHERE id='$room' LIMIT 1");
                if(count($row2)==1)
                {
                    $row2=collect($row2)->first();
                    $room_details='Room: '.$row2->name;
                
                    $row2=DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                    if(count($row2)==1)
                    {
                        $row2=collect($row2)->first();
                        $room_details.='<br>Room Location: '.$row2->name;
                    }
                }
                $text.=$room_details;
            
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
            //send notification END
            
            //track Activity START
            $name=$title;
            \CommonFunctions::instance()->log_activity($request, 'Created an appointment - #'.$id.' '.$name);
            //track Activity END
        }
        
        else {
            $appointment=DB::select("SELECT date, time, recurring, until, parent FROM appointments WHERE id='$id' LIMIT 1");
            $appointment=collect($appointment)->first();
            
            $check=DB::select("SELECT id FROM holidays WHERE beginning<='$date' AND end>='$date' LIMIT 1");
            if(count($check)==1)
            {
                $data['error']=trans('forms.full_day_holiday');
                //$data['error']="SELECT id FROM appointments WHERE room='$room' AND date='$date' AND (time>='$time' AND time_end<='$time_end') LIMIT 1";
                return response()->json($data);
            }
            
            $check=DB::select("SELECT id FROM appointments WHERE date='$date' AND ((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time='$time_end')) AND status='1' AND contact='$contact' AND user_type='$user_type' AND id!='$id' LIMIT 1");
            if(count($check)==1)
            {
                $data['error']=trans('forms.already_booked_appointment');
                //$data['error']="SELECT id FROM appointments WHERE room='$room' AND date='$date' AND (time>='$time' AND time_end<='$time_end') LIMIT 1";
                return response()->json($data);
            }
            
            $check=DB::select("SELECT id FROM appointments WHERE room='$room' AND date='$date' AND ((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time='$time_end')) AND id!='$id' AND status='1' LIMIT 1");
            if(count($check)==1)
            {
                $data['error']=trans('forms.already_booked_room');
                //$data['error']="SELECT id FROM appointments WHERE room='$room' AND date='$date' AND (time>='$time' AND time_end<='$time_end') LIMIT 1";
                return response()->json($data);
            }
            
            DB::update("UPDATE appointments SET contact='$contact', room='$room', title='$title', category='$category', description='$description', reminder='$reminder', recurring='$recurring', date='$date', time='$time', time_end='$time_end', user_type='$user_type' WHERE id='$id'");
            
            DB::delete("DELETE FROM attendees WHERE app_id='$id'");
            if($request->input('attendees')!='')
            {
                foreach($request->input('attendees') as $at)
                {
                    $asg=explode('-', $at);
                    if($asg[0]=='contact') { $at=$asg[1]; $user_type='2'; }
                    else if(isset($asg[1])) { $at=$asg[1]; $user_type='1'; }
                    else $at=0;
                    
                    DB::insert("INSERT INTO attendees (app_id, user_id, user_type) VALUES ('$id', '$at', '$user_type')");
                }
            }
            
            if($appointment->recurring!=$recurring OR $appointment->until!=$until)
            {
                if($appointment->parent=='0')
                {
                    DB::delete("DELETE FROM appointments WHERE parent='$appointment->id'");
                    $this->recurring($request, $contact, $room, $title, $description, $date, $time, $time_end, $recurring, $until, $id, $user_type);
                }
            }
            
            //track Activity START
            $name=$title;
            \CommonFunctions::instance()->log_activity($request, 'Updated appointment - #'.$id.' '.$name);
            //track Activity END
        }
        
        $data['success']=1;
        $color='#3788d8';
            if($category!=0)
            {
                $category=DB::select("SELECT color FROM calendar_categories WHERE id='$category' LIMIT 1");
                $category=collect($category)->first();
                $color=$category->color;
            }
        $data['id']=$id;
        $data['date']=$date;
        //$data['time']=date("H:i", strtotime($time));
        //$data['time_end']=date("H:i", strtotime($time_end));
        $data['time']=$time;
        $data['time_end']=$time_end;
        $data['title']=$title;
        $data['color']=$color;
        
        $data['time2']='';
        $data['time_end2']='';
        if($recurring!='0')
        {
            $data['time2']=$data['time'];
            $data['time_end2']=$data['time_end'];
        }
            switch($recurring)
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
            
            $data['days']=$days;
            $data['recurring']=$recurring;
        
        return response()->json($data);
    }
    
    public function recurring($request, $contact, $room, $title, $description, $date, $time, $time_end, $recurring, $until, $id, $user_type)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($recurring!='0')
        {
            $startDate   = new \DateTime($date.' '.$time);
        
            if($recurring=='Everyday')
            $rule=new \Recurr\Rule('FREQ=DAILY;UNTIL='.$until.' 23:59:00', $startDate);
            else if($recurring=='Monday')
            $rule=new \Recurr\Rule('FREQ=WEEKLY;BYDAY=MO;UNTIL='.$until.' 23:59:00', $startDate);
            else if($recurring=='Tuesday')
            $rule=new \Recurr\Rule('FREQ=WEEKLY;BYDAY=TU;UNTIL='.$until.' 23:59:00', $startDate);
            else if($recurring=='Wednesday')
            $rule=new \Recurr\Rule('FREQ=WEEKLY;BYDAY=WE;UNTIL='.$until.' 23:59:00', $startDate);
            else if($recurring=='Thursday')
            $rule=new \Recurr\Rule('FREQ=WEEKLY;BYDAY=TH;UNTIL='.$until.' 23:59:00', $startDate);
            else if($recurring=='Friday')
            $rule=new \Recurr\Rule('FREQ=WEEKLY;BYDAY=FR;UNTIL='.$until.' 23:59:00', $startDate);
            else if($recurring=='Saturday')
            $rule=new \Recurr\Rule('FREQ=WEEKLY;BYDAY=SA;UNTIL='.$until.' 23:59:00', $startDate);
            else if($recurring=='Sunday')
            $rule=new \Recurr\Rule('FREQ=WEEKLY;BYDAY=SU;UNTIL='.$until.' 23:59:00', $startDate);
        
            $transformer = new \Recurr\Transformer\ArrayTransformer();
        
            $transformerConfig = new \Recurr\Transformer\ArrayTransformerConfig();
            $transformerConfig->enableLastDayOfMonthFix();
            $transformer->setConfig($transformerConfig);
        
            $t_date=date('Y-m-d');
            $constraint = new \Recurr\Transformer\Constraint\BetweenConstraint(new \DateTime($date.' 00:00:00'), new \DateTime($until.' 23:59:00'), true);
            $results=$transformer->transform($rule, $constraint, null);
            
            foreach($results as $result){
                
                $start = $result->getStart();
                $date2=$start->format('Y-m-d');
                $start_time=$start->format('H:i');
                
                $appt_form = $request->input('appointment_form');
                if($appt_form == 'Please Select')
                    $appt_form = 'Unknown';
                
                if($date!=$date2)
                DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, user_type) VALUES ('$contact', '$room', '$title', '$description', '0', '$date2', '$time', '$time_end', '$admin_id', NOW(), '$id', '$user_type', '$appt_form')");
                
            }
        }
    }
    
    public function fetch_appointment(Request $request)
    {
        $data=array();
        $data['success']=0;
        
        $id=$request->input('id');
        $row=DB::select("SELECT * FROM appointments WHERE id='$id' LIMIT 1");
        if(count($row)==1) 
        {
            $row=collect($row)->first();
            $data['id']=$row->id;
            $data['title']=$row->title;
            if($row->user_type=='1')
            $data['contact']='user-'.$row->contact;
            else
            $data['contact']='contact-'.$row->contact;
            $data['room']=$row->room;
            $data['description']=$row->description;
            $data['date']=$row->date;
            $data['date2']=date_format(new DateTime($row->date),'d-m-Y');
            $data['until']=date_format(new DateTime($row->until),'d-m-Y');
            $data['reminder']=$row->reminder;
            $data['time']=$row->time;
            $data['category']=$row->category;
            $data['time_end']=$row->time_end;
            $data['recurring']=$row->recurring;
            $data['parent']=$row->parent;
            
            $data['attendees']=''; $i=0;
            $row2=DB::select("SELECT user_id, user_type FROM attendees WHERE app_id='$id'");
            foreach($row2 as $r2)
            {
                if($i++!=0) $data['attendees'].=',';
                if($r2->user_type=='1')
                $data['attendees'].='user-'.$r2->user_id;
                else
                $data['attendees'].='contact-'.$r2->user_id;
            }
            
            $color='#3788d8';
            if($row->category!=0)
            {
                $category=DB::select("SELECT color FROM calendar_categories WHERE id='$row->category' LIMIT 1");
                $category=collect($category)->first();
                $color=$category->color;
            }
            $data['color']=$color;
            
            $data['room_details']='';
            $row2=DB::select("SELECT name, location FROM rooms WHERE id='$row->room' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $data['room_details'].='<b>Room:</b> '.$row2->name;
                
                $row2=DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                if(count($row2)==1)
                {
                    $row2=collect($row2)->first();
                    $data['room_details'].='<br><b>Room location:</b> '.$row2->name;
                }
            }
            
            $data['course_details']='';
            $row2=DB::select("SELECT title FROM courses WHERE id='$row->course_id' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $data['course_details'].='<b>Course:</b> '.$row2->title;
            }
            
            $data['success']=1;
        }
        
        return response()->json($data);
    }
    
    public function remove_appointment(Request $request)
    {
        $data=array();
        $data['success']=0;
        
        $id=$request->input('id');
        
            //track Activity START
            $row=DB::select("SELECT id, title, parent FROM appointments WHERE id='$id' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=$row->title;
            \CommonFunctions::instance()->log_activity($request, 'Deleted an appointment - #'.$id.' '.$name);
            //track Activity END
        
        $data['parent']=0;
        if($row->parent=='0') $data['parent']=1;
        $row=DB::delete("DELETE FROM appointments WHERE id='$id' OR parent='$id'");
        $data['id']=$id;
        $data['success']=1;
        
        return response()->json($data);
    }
}
