<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;
use Mail;
use App\Models\Attendance;
use App\Models\AttendanceAdditional;
use App\Models\AttendanceNotes;
use App\Models\AttendanceVerhalten;
use App\Models\AttendanceAttachments;
use App\Models\Appointment;
use App\Models\Module;
use App\Models\ModuleItems;
use App\Models\ModuleItemServices;
use App\Models\Contact;
use App\Models\ModuleItemModuleItemServices;
use App\Models\TeachingMethod;
use App\Models\CVs;
use PDF;
use PDFMerger;


class appointments extends Controller
{
    //
    public static function instance()
    {
        return new appointments();
    }

    public function get_readonly_appointments(Request $request)
    {
        $room_filter=''; 
        if($request->input('room')!='') {
            $room=$request->input('room');
            $room_filter=" AND room='$room' ";
        }
        
        $appointments=DB::select("SELECT * FROM appointments WHERE status='1' AND id!='0' $room_filter ");
        $i=0; $app='';
        foreach($appointments as $appointment)
        {
            if($appointment->course_id!=0 AND $appointment->type=='1') continue;
            $time=date("H:i", strtotime($appointment->time));
            $time_end=date("H:i", strtotime($appointment->time_end));
            
            $title="Busy";
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
        return view('read_only_appointments.index', 
            ['title'=>trans('header.appointments'), 
                'sub_title'=>count($appointments).' total '.trans('header.appointments'), 
                'appointments'=>$app, 'rooms'=>$rooms, 
                'calendar_categories'=>$calendar_categories, 
                'holidays'=>$holidays]);
            
    }
    
    public function index(Request $request)
    {
        $id = $request->session()->get('id');

        $date = date('Y-m-d');
        $appointments = array();
        $i = 0;
        $row = DB::select("SELECT * FROM appointments WHERE date='$date' AND contact='$id'");
        foreach ($row as $r) {
            $appointments[$i]['appointment'] = $r;

            $row2 = DB::select("SELECT id, name FROM contacts WHERE id='$r->contact' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $appointments[$i]['contact'] = $row2;
            } else
                $appointments[$i]['contact'] = 'NA';

            $row2 = DB::select("SELECT id, name, location FROM rooms WHERE id='$r->room' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $appointments[$i]['room'] = $row2;

                $row2 = DB::select("SELECT id, name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                if (count($row2) == 1) {
                    $row2 = collect($row2)->first();
                    $appointments[$i]['room_location'] = $row2;
                } else
                    $appointments[$i]['room_location'] = 'NA';
            } else {
                $appointments[$i]['room'] = 'NA';
                $appointments[$i]['room_location'] = 'NA';
            }

            $i ++;
        }

        $appointments = DB::select("SELECT * FROM appointments WHERE contact='$id' AND status='1'");
        $i = 0;
        $app = '';
        foreach ($appointments as $appointment) {
            $time = date("H:i", strtotime($appointment->time));
            $time_end = date("H:i", strtotime($appointment->time_end));

            $title = addslashes($appointment->title);
            $row2 = DB::select("SELECT name, location FROM rooms WHERE id='$appointment->room' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $row3 = DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                if (count($row3) == 1) {
                    $row3 = collect($row3)->first();
                    $title .= ' (' . $row2->name . ' - ' . $row3->name . ')';
                } else
                    $title .= ' (' . addslashes($row2->name) . ')';
            }

            $color = '#3788d8';
            if ($appointment->category != 0) {
                $category = DB::select("SELECT color FROM calendar_categories WHERE id='$appointment->category' LIMIT 1");
                $category = collect($category)->first();
                $color = $category->color;
            }

            if ($i ++ != 0)
                $app .= ',';
            $app .= '{
                            "id": "' . $appointment->id . '",
                            "title": "' . $title . '",
                            "start": "' . $appointment->date . 'T' . $time . '",
                            "end": "' . $appointment->date . 'T' . $time_end . '",
                            "backgroundColor": "' . $color . '",
                            "borderColor": "' . $color . '"
                            ';

            if ($appointment->recurring != '0') {

                switch ($appointment->recurring) {
                    case 'Everyday':
                        $days = '0, 1, 2, 3, 4, 5, 6';
                        break;
                    case 'Sunday':
                        $days = '0';
                        break;
                    case 'Monday':
                        $days = '1';
                        break;
                    case 'Tuesday':
                        $days = '2';
                        break;
                    case 'Wednesday':
                        $days = '3';
                        break;
                    case 'Thursday':
                        $days = '4';
                        break;
                    case 'Friday':
                        $days = '5';
                        break;
                    case 'Saturday':
                        $days = '6';
                        break;
                    default:
                        $days = '';
                        break;
                }

                $app .= ',
                            "daysOfWeek": [' . $days . '],
                            "startTime": "' . $time . '",
                            "endTime": "' . $time_end . '"
                    ';
            }

            $app .= '}';
        }

        $holidays = array();
        $row = DB::select("SELECT title, beginning, end FROM holidays");
        foreach ($row as $r) {
            $holidays2 = \CommonFunctions::instance()->getDatesFromRange($r->beginning, $r->end, 'Y-m-d');
            foreach ($holidays2 as $h) {
                $holidays[] = $h;
            }
        }
        return view('appointments.index', [
            'title' => 'My Appointments',
            'appointments' => $app,
            'holidays' => $holidays
        ]);
    }

    public function attendance_register(Request $request)
    {
        $id = $request->session()->get('id');
        $date = date('Y-m-d');
        $course_id = 0;

        if ($request->input('test_name') != '') {
            $course_id = addslashes($request->input('course_id'));
            $date = addslashes($request->input('test_date'));
            $date = date_format(new DateTime($date), 'Y-m-d');
            $test_name = addslashes($request->input('test_name'));

            DB::insert("INSERT INTO tests (course_id, name, date, added_by, added_on) VALUES (:course_id, :test_name, :date, :id, NOW())", [
                'course_id' => $course_id,
                'test_name' => $test_name,
                'date' => $date,
                'id' => $id
            ]);
            return redirect('attendance-register?c=' . $course_id . '&t=1');
        }

        $course_ids = array();
        $row = DB::select("SELECT course_id FROM course_offers WHERE coach='$id' ORDER BY id DESC");
        foreach ($row as $r) {
            if (! in_array($r->course_id, $course_ids))
                $course_ids[] = $r->course_id;
        }

        $courses = array();
        $i = 0;
        foreach ($course_ids as $course_id) {
            $row = DB::select("SELECT id, title, description, students, type FROM courses WHERE id='$course_id' LIMIT 1");
            if (count($row) == 0)
                continue;
            $row = collect($row)->first();

            $appointments = array();
            $j = 0;
            $row2 = DB::select("SELECT * FROM appointments WHERE course_id='$course_id' AND status='1' AND contact='$id' AND type='2'");
            if (count($row2) == 0)
                continue;
            $courses[$i]['course'] = $row;
            foreach ($row2 as $r) {
                $appointments[$j]['appointment'] = $r;

                $attendance_row = DB::select("SELECT * FROM attendance WHERE appointment_id='$r->id' and status = 1");
                if (count($attendance_row) == 1) {
                    $attendance_row = collect($attendance_row)->first();
                    $appointments[$j]['attendance'] = $attendance_row;
                }
                
                $appointments[$j]['room'] = '';
                $appointments[$j]['room_location'] = '';
                $appointments[$j]['location'] = '';

                $row2 = DB::select("SELECT name, location FROM rooms WHERE id='$r->room' LIMIT 1");
                if (count($row2) == 1) {
                    $row2 = collect($row2)->first();
                    $appointments[$j]['room'] = $row2->name;

                    $row2 = DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                    if (count($row2) == 1) {
                        $row2 = collect($row2)->first();
                        $appointments[$j]['location'] = $row2->name;
                    }
                }

                $j ++;
            }
            $courses[$i]['appointments'] = $appointments;

            $date = date('Y-m-d');
            $attendance = array();
            $j = 0;
            $row2 = DB::select("SELECT id, title, room, date, time, time_end, contact, product_id, module_id, item_id FROM appointments WHERE course_id='$course_id' AND status='1' AND contact='$id' AND type='2'");
            foreach ($row2 as $r) {
                
                    
                $attendance[$j]['appointment'] = $r;

                $attendance[$j]['room'] = '';
                $attendance[$j]['room_location'] = '';

                $row2 = DB::select("SELECT name, location FROM rooms WHERE id='$r->room' LIMIT 1");
                if (count($row2) == 1) {
                    $row2 = collect($row2)->first();
                    $attendance[$j]['room'] = $row2->name;

                    $row2 = DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                    if (count($row2) == 1) {
                        $row2 = collect($row2)->first();
                        $attendance[$j]['location'] = $row2->name;
                    }
                }
                $courses[$i]['attendance'] = $attendance;

                $j ++;
            }

            $students_ids = array();
            $row3 = DB::select("SELECT id, title, room, date, time, time_end, contact, product_id, module_id, item_id FROM appointments WHERE course_id='$course_id' AND status='1' AND type='1'");
            foreach ($row3 as $r2) {
                if (in_array($r2->contact, $students_ids))
                    continue;
                $students_ids[] = $r2->contact;
            }

            $students = array();
            $k = 0;
            foreach ($students_ids as $s) {
                $row4 = DB::select("SELECT id, name, email FROM contacts WHERE id='$s' LIMIT 1");
                $row4 = collect($row4)->first();
                $students[$k]['student'] = $row4;

                $students[$k]['attendance'] = 'NA';
                $students[$k]['late'] = '';
                $check = DB::select("SELECT status, late FROM attendance WHERE course_id='$course_id' AND student_id='$s' AND date='$date' LIMIT 1");
                if (count($check) == 1) {
                    $check = collect($check)->first();
                    $students[$k]['attendance'] = $check->status;
                    $students[$k]['late'] = $check->late;
                }

                $k ++;
            }
            $courses[$i]['students'] = $students;

            $notes = array();
            $k = 0;
            $row2 = DB::select("SELECT * FROM course_notes WHERE course_id='$course_id' AND added_by='$id' ORDER BY id DESC");
            foreach ($row2 as $r2) {
                $notes[$k]['note'] = $r2;

                $k ++;
            }
            $courses[$i]['notes'] = $notes;

            $tests = array();
            $k = 0;
            $row2 = DB::select("SELECT * FROM tests WHERE course_id='$course_id' AND added_by='$id' ORDER BY id DESC");
            foreach ($row2 as $r2) {
                $tests[$k]['test'] = $r2;

                $students = array();
                $k2 = 0;
                foreach ($students_ids as $s) {
                    $row4 = DB::select("SELECT id, name, email FROM contacts WHERE id='$s' LIMIT 1");
                    $row4 = collect($row4)->first();
                    $students[$k2]['student'] = $row4;

                    $students[$k2]['notes'] = '';
                    $check = DB::select("SELECT notes FROM tests_notes WHERE course_id='$course_id' AND student_id='$s' AND test_id='$r2->id' LIMIT 1");
                    if (count($check) == 1) {
                        $check = collect($check)->first();
                        $students[$k2]['notes'] = $check->notes;
                    }

                    $students[$k2]['result'] = '';
                    $check = DB::select("SELECT result FROM tests_results WHERE course_id='$course_id' AND student_id='$s' AND test_id='$r2->id' LIMIT 1");
                    if (count($check) == 1) {
                        $check = collect($check)->first();
                        $students[$k2]['result'] = $check->result;
                    }

                    $students[$k2]['score'] = '';
                    $check = DB::select("SELECT score FROM tests_scores WHERE course_id='$course_id' AND student_id='$s' AND test_id='$r2->id' LIMIT 1");
                    if (count($check) == 1) {
                        $check = collect($check)->first();
                        $students[$k2]['score'] = $check->score;
                    }

                    $k2 ++;
                }
                $tests[$k]['students'] = $students;

                $k ++;
            }
            $courses[$i]['tests'] = $tests;

            $i ++;
        }

        $attendance_notes = array();
        $i = 0;
        $row = DB::select("SELECT * FROM attendance_notes WHERE date='$date' AND course_id='$course_id' ORDER BY id DESC");
        foreach ($row as $r) {
            $attendance_notes[$i]['note'] = $r;

            $i ++;
        }
        $teaching_methods=DB::select("SELECT * FROM teaching_methods");
        return view('attendance_register.index', [
            'title' => 'Attendance Register',
            'courses' => $courses,
            'attendance_notes' => $attendance_notes,
            'teaching_methods' => $teaching_methods
        ]);
    }

    public function my_attendance(Request $request)
    {
        $id = $request->session()->get('id');

        $course_ids = array();
        $row = DB::select("SELECT id, date, course_id FROM appointments WHERE contact='$id' AND status='1' AND type='1'");
        foreach ($row as $r) {
            if (! in_array($r->course_id, $course_ids))
                $course_ids[] = $r->course_id;
        }

        $courses = array();
        $i = 0;
        foreach ($course_ids as $course_id) {
            $row = DB::select("SELECT id, title, description, students FROM courses WHERE id='$course_id' LIMIT 1");
            if (count($row) == 0)
                continue;
            $row = collect($row)->first();

            $appointments = array();
            $j = 0;
            $row2 = DB::select("SELECT * FROM appointments WHERE course_id='$course_id' AND status='1' AND contact='$id' AND type='1'");
            if (count($row2) == 0)
                continue;
            $courses[$i]['course'] = $row;
            foreach ($row2 as $r) {
                $appointments[$j]['appointment'] = $r;

                $appointments[$j]['room'] = '';
                $appointments[$j]['room_location'] = '';
                $appointments[$j]['location'] = '';

                $row2 = DB::select("SELECT name, location FROM rooms WHERE id='$r->room' LIMIT 1");
                if (count($row2) == 1) {
                    $row2 = collect($row2)->first();
                    $appointments[$j]['room'] = $row2->name;

                    $row2 = DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                    if (count($row2) == 1) {
                        $row2 = collect($row2)->first();
                        $appointments[$j]['location'] = $row2->name;
                    }
                }

                $j ++;
            }
            $courses[$i]['appointments'] = $appointments;

            $dates = array();
            $attendance = array();
            $j = 0;
            $row2 = DB::select("SELECT id, title, date FROM appointments WHERE course_id='$course_id' AND status='1' AND contact='$id' AND type='1'");
            foreach ($row2 as $r) {
                if (in_array($r->date, $dates))
                    continue;
                $dates[] = $r->date;
                $attendance[$j]['appointment'] = $r;

                $attendance[$j]['attendance'] = 'NA';
                $attendance[$j]['late'] = '';
                $check = DB::select("SELECT status, late FROM attendance WHERE course_id='$course_id' AND student_id='$id' AND date='$r->date' LIMIT 1");
                if (count($check) == 1) {
                    $check = collect($check)->first();
                    $attendance[$j]['attendance'] = $check->status;
                    $attendance[$j]['late'] = $check->late;
                }

                $j ++;
            }
            $courses[$i]['attendance'] = $attendance;

            $notes = array();
            $k = 0;
            $row2 = DB::select("SELECT * FROM course_notes WHERE course_id='$course_id' AND added_by='$id' ORDER BY id DESC");
            foreach ($row2 as $r2) {
                $notes[$k]['note'] = $r2;

                $k ++;
            }
            $courses[$i]['notes'] = $notes;

            $i ++;
        }

        return view('my_attendance.index', [
            'title' => 'My Attendance',
            'courses' => $courses
        ]);
    }

    public function mark_attendance(Request $request)
    {
        $data = array();
        $data['success'] = 0;

        $status = addslashes($request->input('status'));
        $late = addslashes($request->input('late'));
        if ($status != '2')
            $late = '0';
        $date = addslashes($request->input('date'));
        $student_id = addslashes($request->input('student_id'));
        $course_id = addslashes($request->input('course_id'));
        $email_flag = 0;

        $check = DB::select("SELECT id, leave_email FROM attendance WHERE course_id='$course_id' AND student_id='$student_id' AND date='$date' LIMIT 1");
        if (count($check) == 1) {
            $check = collect($check)->first();
            $id = $check->id;
            if ($check->leave_email == '0')
                $email_flag = 1;

            DB::update("UPDATE attendance SET status='$status', late='$late' WHERE id='$check->id'");
            $data['success'] = 1;
        } else {
            $email_flag = 1;
            DB::insert("INSERT INTO attendance (course_id, student_id, date, status, late) VALUES ('$course_id', '$student_id', '$date', '$status', '$late')");
            $id = DB::getPdo()->lastInsertId();
            $data['success'] = 1;
        }

        if ($status == '0' and $email_flag == 1) {
            // send email alert to student for sick leave if not uploaded
            $check = DB::select("SELECT id FROM sick_leaves WHERE user_id='$student_id' AND beginning<='$date' AND end>='$date' LIMIT 1");
            if (count($check) == 0) {
                $user = DB::select("SELECT id, name, email FROM contacts WHERE id='$student_id' LIMIT 1");
                $user = collect($user)->first();

                $course = DB::select("SELECT id, title FROM courses WHERE id='$course_id' LIMIT 1");
                $course = collect($course)->first();

                $name = $user->name;
                $email = $user->email;
                $from = env('MAIL_USERNAME');
                $title = 'Sick leave required | ' . $course->title;
                $title_url = 'Upload Sick Leave';
                $url = url('sick-leaves');

                $text = 'Hi ' . $name . ',<br><br>
            This is to notify that a sick leave is required for your appointment on ' . $date . ' that you have not attended. Please login to your portal and provide the sick leave.';

                $data2 = array(
                    'email' => $email,
                    'from' => $from,
                    'name' => $name,
                    'title' => $title,
                    'title_url' => $title_url,
                    'url' => $url,
                    'text' => $text
                );

                Mail::send('emails.notification', $data2, function ($message) use ($email, $from, $name, $title) {
                    $message->from('krankmeldung@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject($title);
                });
            }

            DB::update("UPDATE attendance SET leave_email='1' WHERE id='$id'");
        }

        return response()->json($data);
    }

    public function attendance_late(Request $request)
    {
        $data = array();
        $data['success'] = 0;

        $late = addslashes($request->input('late'));
        $date = addslashes($request->input('date'));
        $student_id = addslashes($request->input('student_id'));
        $course_id = addslashes($request->input('course_id'));

        $check = DB::select("SELECT id FROM attendance WHERE course_id='$course_id' AND student_id='$student_id' AND date='$date' LIMIT 1");
        if (count($check) == 1) {
            $check = collect($check)->first();
            DB::update("UPDATE attendance SET late='$late' WHERE id='$check->id'");
            $data['success'] = 1;
        }

        return response()->json($data);
    }

    public function update_student_attendance_notes(Request $request)
    {
        $data = array();
        $data['success'] = 0;

        $notes = addslashes($request->input('notes'));
        $date = addslashes($request->input('date'));
        $student_id = addslashes($request->input('student_id'));
        $course_id = addslashes($request->input('course_id'));

        $check = DB::select("SELECT id FROM attendance WHERE course_id='$course_id' AND student_id='$student_id' AND date='$date' LIMIT 1");
        if (count($check) == 1) {
            $check = collect($check)->first();
            DB::update("UPDATE attendance SET notes='$notes' WHERE id='$check->id'");
            $data['success'] = 1;
        }

        return response()->json($data);
    }

    public function update_student_attendance_servicerating(Request $request)
    {
        $data = array();
        $data['success'] = 0;

        $rating = addslashes($request->input('rating'));
        $date = addslashes($request->input('date'));
        $student_id = addslashes($request->input('student_id'));
        $course_id = addslashes($request->input('course_id'));

        $check = DB::select("SELECT id FROM attendance WHERE course_id='$course_id' AND student_id='$student_id' AND date='$date' LIMIT 1");
        if (count($check) == 1) {
            $check = collect($check)->first();
            DB::update("UPDATE attendance SET motivationrating='$rating' WHERE id='$check->id'");
            $data['success'] = 1;
        }

        return response()->json($data);
    }

    public function update_student_attendance_motivationrating(Request $request)
    {
        $data = array();
        $data['success'] = 0;

        $rating = addslashes($request->input('rating'));
        $date = addslashes($request->input('date'));
        $student_id = addslashes($request->input('student_id'));
        $course_id = addslashes($request->input('course_id'));

        $check = DB::select("SELECT id FROM attendance WHERE course_id='$course_id' AND student_id='$student_id' AND date='$date' LIMIT 1");
        if (count($check) == 1) {
            $check = collect($check)->first();
            DB::update("UPDATE attendance SET servicerating='$rating' WHERE id='$check->id'");
            $data['success'] = 1;
        }

        return response()->json($data);
    }

    public function update_student_test_result(Request $request)
    {
        $id = $request->session()->get('id');
        $data = array();
        $data['success'] = 0;

        $test_id = addslashes($request->input('test_id'));
        $result = addslashes($request->input('result'));
        $date = addslashes($request->input('date'));
        $student_id = addslashes($request->input('student_id'));
        $course_id = addslashes($request->input('course_id'));

        $check = DB::select("SELECT id FROM tests_results WHERE test_id='$test_id' AND course_id='$course_id' AND student_id='$student_id' LIMIT 1");
        if (count($check) == 1) {
            $check = collect($check)->first();
            DB::update("UPDATE tests_results SET result='$result' WHERE id='$check->id'");
            $data['success'] = 1;
        } else {
            DB::insert("INSERT INTO tests_results (test_id, course_id, student_id, result, added_by, added_on) VALUES (:test_id, :course_id, :student_id, :result, :id, NOW())", [
                'test_id' => $test_id,
                'course_id' => $course_id,
                'student_id' => $student_id,
                'result' => $result,
                'id' => $id
            ]);
        }

        return response()->json($data);
    }

    public function update_student_test_score(Request $request)
    {
        $id = $request->session()->get('id');
        $data = array();
        $data['success'] = 0;

        $test_id = addslashes($request->input('test_id'));
        $score = addslashes($request->input('score'));
        $date = addslashes($request->input('date'));
        $student_id = addslashes($request->input('student_id'));
        $course_id = addslashes($request->input('course_id'));

        $check = DB::select("SELECT id FROM tests_scores WHERE test_id='$test_id' AND course_id='$course_id' AND student_id='$student_id' LIMIT 1");
        if (count($check) == 1) {
            $check = collect($check)->first();
            DB::update("UPDATE tests_scores SET score='$score' WHERE id='$check->id'");
            $data['success'] = 1;
        } else {
            DB::insert("INSERT INTO tests_scores (test_id, course_id, student_id, score, added_by, added_on) VALUES (:test_id, :course_id, :student_id, :score, :id, NOW())", [
                'test_id' => $test_id,
                'course_id' => $course_id,
                'student_id' => $student_id,
                'score' => $score,
                'id' => $id
            ]);
        }

        return response()->json($data);
    }

    public function update_student_test_notes(Request $request)
    {
        $id = $request->session()->get('id');
        $data = array();
        $data['success'] = 0;

        $test_id = addslashes($request->input('test_id'));
        $notes = addslashes($request->input('notes'));
        $date = addslashes($request->input('date'));
        $student_id = addslashes($request->input('student_id'));
        $course_id = addslashes($request->input('course_id'));

        $check = DB::select("SELECT id FROM tests_notes WHERE test_id='$test_id' AND course_id='$course_id' AND student_id='$student_id' LIMIT 1");
        if (count($check) == 1) {
            $check = collect($check)->first();
            DB::update("UPDATE tests_notes SET notes='$notes' WHERE id='$check->id'");
            $data['success'] = 1;
        } else {
            DB::insert("INSERT INTO tests_notes (test_id, course_id, student_id, notes, added_by, added_on) VALUES (:test_id, :course_id, :student_id, :notes, :id, NOW())", [
                'test_id' => $test_id,
                'course_id' => $course_id,
                'student_id' => $student_id,
                'notes' => $notes,
                'id' => $id
            ]);
        }

        return response()->json($data);
    }

    public function update_teaching_data(Request $request)
    {
        $data = array();
        $data['success'] = 0;
        $appointment_id = addslashes($request->input('appointment_id'));
        $teaching_form = addslashes($request->input('teaching_form'));
        $teaching_method = addslashes($request->input('teaching_method'));

        DB::update("UPDATE appointments SET teaching_form='$teaching_form', teaching_method='$teaching_method' WHERE id='$appointment_id'");

        $data['success'] = 1;
        return response()->json($data);
    }

    public function attendance_register_date(Request $request)
    {
        $data = array();
        $data['success'] = 1;
        $data['students'] = '';

        $course_id = addslashes($request->input('course_id'));
        $appt_id = addslashes($request->input('appointment_id'));
        $date = addslashes($request->input('date'));
        $date = date_format(new DateTime($date), 'Y-m-d');

        $students_ids = array();

        $row3 = DB::select("SELECT id, title, room, date, time, time_end, contact, teaching_form, teaching_method FROM appointments WHERE id = '$appt_id' and course_id='$course_id' AND status='1' AND type='1' AND date='$date'");
        foreach ($row3 as $r2) {

            if (in_array($r2->contact, $students_ids))
                continue;
            $students_ids[] = $r2->contact;
        }

        if (! isset($students_ids) || count($students_ids) == 0) {

            $apptrow = DB::select("SELECT * FROM appointments WHERE id='$appt_id' and course_id='$course_id' AND status='1' AND type='2' AND date='$date' LIMIT 1");
            $apptrow = collect($apptrow)->first();

            $row3 = DB::select("SELECT attendees.id, attendees.user_id, attendees.user_type FROM attendees inner join contacts on contacts.id = attendees.user_id and contacts.type = 'Student' WHERE app_id='$apptrow->id'");
            foreach ($row3 as $r2) {
                if (in_array($r2->user_id, $students_ids))
                    continue;
                $students_ids[] = $r2->user_id;

                // The record may not be existing in appointments table. So insert it
                $check = DB::select("SELECT id FROM appointments WHERE type = '1' and title='$apptrow->title' and contact='$r2->user_id' AND course_id='$apptrow->course_id' AND date='$apptrow->date' AND time='$apptrow->time' AND time_end='$apptrow->time_end'");
                if (count($check) == 0) {
                    DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, appointment_form) VALUES ('$r2->user_id', '$apptrow->room', '$apptrow->title', '', '0', '$apptrow->date', '$apptrow->time', '$apptrow->time_end', '0', NOW(), '0', '0', '$apptrow->course_id', '$apptrow->product_id', '$apptrow->module_id', '$apptrow->item_id', '1', '$apptrow->appointment_form')");
                }
            }
        }

        $row3 = DB::select("SELECT id, title, room, date, time, time_end, contact, teaching_form, teaching_method FROM appointments WHERE id = '$appt_id'  and course_id='$course_id' AND status='1' AND type='2' AND date='$date' LIMIT 1");
        $row3 = collect($row3)->first();
        $data['appointment'] = $row3->id;
        $data['teaching_form'] = $row3->teaching_form;
        /*
         * if($row3->teaching_form!='')
         * {
         * $data['teaching_form']=''; $i=0;
         * $d=explode(',', $row3->teaching_form);
         * foreach($d as $v)
         * {
         * if($i++==0)
         * $data['teaching_form']="'".$v."'";
         * else
         * $data['teaching_form'].=",'".$v."'";
         * }
         * }
         */
        $data['teaching_method'] = $row3->teaching_method;
        $data['studentids'] = $students_ids;
        $students = array();
        $k = 0;
        foreach ($students_ids as $s) {
            $row4 = DB::select("SELECT id, name, email FROM contacts WHERE id='$s' LIMIT 1");
            $row4 = collect($row4)->first();
            $students[$k]['student'] = $row4;

            $present = '';
            $absent = '';
            $late = '';
            $late_mins = '';
            $notes = '';
            $motivationrating = '';
            $servicerating = '';
            $students[$k]['attendance'] = 'NA';
            $check = DB::select("SELECT status, late, notes, motivationrating, servicerating FROM attendance WHERE course_id='$course_id' AND student_id='$s' AND date='$date' LIMIT 1");
            if (count($check) == 1) {
                $check = collect($check)->first();
                $students[$k]['attendance'] = $check->status;

                if ($check->status == '1')
                    $present = 'checked';
                else if ($check->status == '0')
                    $absent = 'checked';
                else if ($check->status == '2')
                    $late = 'checked';
                $late_mins = $check->late;

                $notes = $check->notes;
                $motivationrating = $check->motivationrating;
                $servicerating = $check->servicerating;
            }

            $motivationrating_1 = '';
            $motivationrating_2 = '';
            $motivationrating_3 = '';
            $motivationrating_4 = '';
            $motivationrating_5 = '';

            if ($motivationrating == '1')
                $motivationrating_1 = 'selected';
            else if ($motivationrating == '2')
                $motivationrating_2 = 'selected';
            else if ($motivationrating == '3')
                $motivationrating_3 = 'selected';
            else if ($motivationrating == '4')
                $motivationrating_4 = 'selected';
            else if ($motivationrating == '5')
                $motivationrating_5 = 'selected';

            $servicerating_1 = '';
            $servicerating_2 = '';
            $servicerating_3 = '';
            $servicerating_4 = '';
            $servicerating_5 = '';

            if ($servicerating == '1')
                $servicerating_1 = 'selected';
            else if ($servicerating == '2')
                $servicerating_2 = 'selected';
            else if ($servicerating == '3')
                $servicerating_3 = 'selected';
            else if ($servicerating == '4')
                $servicerating_4 = 'selected';
            else if ($servicerating == '5')
                $servicerating_5 = 'selected';

            $data['students'] .= '<tr>
                                    <td>' . $row4->name . '</td>
                                    <td><input type="radio" name="status-' . $row4->id . '" value="1" onchange="change_status(\'1\', \'' . $row4->id . '\',\'' . $date . '\', \'' . $course_id . '\', \'#late-' . $row4->id . '\')" ' . $present . ' ></td>
                                    <td><input type="radio" name="status-' . $row4->id . '" value="0" onchange="change_status(\'0\', \'' . $row4->id . '\',\'' . $date . '\', \'' . $course_id . '\', \'#late-' . $row4->id . '\')" ' . $absent . ' ></td>
                                    <td><input type="radio" name="status-' . $row4->id . '" value="2" onchange="change_status(\'2\', \'' . $row4->id . '\',\'' . $date . '\', \'' . $course_id . '\', \'#late-' . $row4->id . '\')" ' . $late . ' >
                                    <div class="" style="display:inline-block; margin-left:10px;">
                                                                    <div class="input-group" style="border-radius:5px;">
<input class="form-control" type="number" min="0" step="any" name="late-' . $row4->id . '" value="' . $late_mins . '" id="late-' . $row4->id . '" style="display:inline-block; max-width:70px;" onkeyup="change_late(\'' . $row4->id . '\',\'' . $date . '\', \'' . $course_id . '\', this.value)">
<span class="input-group-append" style="border-radius:5px;">
<span class="input-group-text" style="border-left:0px;">min</span>
</span>
</div>
                                                                            </div>
                                    </td>
                                    <td>
                                    <select name="motivationrating-' . $row4->id . '" class="form-control" onchange="update_motivationrating(\'' . $row4->id . '\',\'' . $date . '\', \'' . $course_id . '\', this.value)">
                                    <option>Bitte auswählen</option>
                                     <option value="1" ' . $motivationrating_1 . '>1 star - Low</option>
                                    <option value="2" ' . $motivationrating_2 . '>2 stars</option>
                                    <option value="3" ' . $motivationrating_3 . '>3 stars</option>
                                    <option value="4" ' . $motivationrating_4 . '>4 stars</option>
                                    <option value="5" ' . $motivationrating_5 . '>5 stars - Awesome</option>
                                    </select>
                                    </td>
                                    <td>
                                    <select name="servicerating-' . $row4->id . '" class="form-control" onchange="update_servicerating(\'' . $row4->id . '\',\'' . $date . '\', \'' . $course_id . '\', this.value)">
                                    <option>Bitte auswählen</option>
                                    <option value="1" ' . $servicerating_1 . '>1 star - Low</option>
                                    <option value="2" ' . $servicerating_2 . '>2 stars</option>
                                    <option value="3" ' . $servicerating_3 . '>3 stars</option>
                                    <option value="4" ' . $servicerating_4 . '>4 stars</option>
                                    <option value="5" ' . $servicerating_5 . '>5 stars - Awesome</option>
                                    </select>
                                    </td>
                                    <td>
                                                                    <div class="input-group" style="border-radius:5px;">
<input class="form-control" type="text" name="notes-' . $row4->id . '" value="' . $notes . '" id="notes-' . $row4->id . '" style="display:inline-block; width:100%;" onkeyup="update_notes(\'' . $row4->id . '\',\'' . $date . '\', \'' . $course_id . '\', this.value)">
</div>
                                    </td>
                                </tr>';

            $k ++;
        }

        return response()->json($data);
    }

    public function attendance_add_notes(Request $request)
    {
        $id = $request->session()->get('id');
        $data = array();
        $data['success'] = 0;

        $course_id = $request->input('course_id');
        $notes = $request->input('notes');

        DB::insert("INSERT INTO course_notes (course_id, notes, added_by, added_on) VALUES ('$course_id', '$notes', '$id', NOW())");
        $id = DB::getPdo()->lastInsertId();

        $notes = DB::select("SELECT * FROM course_notes WHERE id='$id' LIMIT 1");
        $notes = collect($notes)->first();

        $data['notes'] = "<div style='border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;'>
                                                        <div style='overflow:hidden;''>
                                                            <div class='float-left'>
                                                            </div>
                                                            
                                                            <div class='float-left'>
                                                                " . date_format(new DateTime($notes->added_on), 'd-m-Y') . "
                                                                <p style='color:#777'>" . date_format(new DateTime($notes->added_on), 'H:i') . "</p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div>" . $request->input('notes') . "</div>
                                                        </div>";
        $data['success'] = 1;

        return response()->json($data);
    }

    public function attendance_add_notes_date(Request $request)
    {
        $id = $request->session()->get('id');
        $data = array();
        $data['success'] = 0;

        $course_id = $request->input('course_id');
        $notes = $request->input('notes');
        $date = addslashes($request->input('date'));
        $date = date_format(new DateTime($date), 'Y-m-d');

        DB::insert("INSERT INTO attendance_notes (course_id, notes, date, added_by, added_on) VALUES ('$course_id', '$notes', '$date', '$id', NOW())");
        $id = DB::getPdo()->lastInsertId();

        $notes = DB::select("SELECT * FROM attendance_notes WHERE id='$id' LIMIT 1");
        $notes = collect($notes)->first();

        $data['notes'] = "<div style='border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;'>
                                                        <div style='overflow:hidden;'>
                                                            <div class='float-left'>
                                                            </div>
                                                            
                                                            <div class='float-left'>
                                                                " . date_format(new DateTime($notes->added_on), 'd-m-Y') . "
                                                                <p style='color:#777'>" . date_format(new DateTime($notes->added_on), 'H:i') . "</p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div>" . $request->input('notes') . "</div>
                                                        </div>";
        $data['success'] = 1;

        return response()->json($data);
    }

    public function attendance_fetch_notes_date(Request $request)
    {
        $id = $request->session()->get('id');
        $data = array();
        $data['success'] = 0;

        $course_id = $request->input('course_id');
        $date = addslashes($request->input('date'));
        $date = date_format(new DateTime($date), 'Y-m-d');

        $notes = DB::select("SELECT * FROM attendance_notes WHERE course_id='$course_id' AND date='$date' ORDER BY id DESC");

        $data['notes'] = '';
        foreach ($notes as $note) {
            $data['notes'] .= "<div style='border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;'>
                                                        <div style='overflow:hidden;'>
                                                            <div class='float-left'>
                                                            </div>
                                                            
                                                            <div class='float-left'>
                                                                " . date_format(new DateTime($note->added_on), 'd-m-Y') . "
                                                                <p style='color:#777'>" . date_format(new DateTime($note->added_on), 'H:i') . "</p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div>" . $note->notes . "</div>
                                                        </div>";
        }
        $data['success'] = 1;

        return response()->json($data);
    }

    public function sick_leaves(Request $request)
    {
        $id = $request->session()->get('id');

        if ($request->input('delete') != '') {
            $delete = addslashes($request->input('delete'));
            DB::delete("DELETE FROM sick_leaves WHERE id='$delete'");
            $request->session()->flash('success', 'Sick leave deleted successfully.');
            return redirect('sick-leaves');
        }

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $forr = addslashes($request->input('for'));
            $documents = $request->input('documents');
            $beginning = '';
            $end = '';
            $period = addslashes($request->input('period'));
            if ($period != '') {
                $dates = explode(' - ', $period);
                $beginning = date_format(new DateTime($dates[0]), 'Y-m-d');
                $end = date_format(new DateTime($dates[1]), 'Y-m-d');
            }

            DB::insert("INSERT INTO sick_leaves (user_id, title, documents, beginning, end, on_date, forr) VALUES ('$id', '$title', '$documents', '$beginning', '$end', NOW(), '$forr')");
            $request->session()->flash('success', 'Sick leave has been added successfully.');

            $contact = DB::select("SELECT id, name, email FROM contacts WHERE id='$id' LIMIT 1");
            $contact = collect($contact)->first();
            $title2 = $title;

            $users = DB::select("SELECT name, email FROM users");
            foreach ($users as $user) {

                // send timetable to student START
                $name = $user->name;
                $email = $user->email;
                $from = env('MAIL_USERNAME');
                $title = 'Sick leave | ' . $contact->name;
                $title_url = 'Login now';
                $url = url('admin');
                $text = 'There is a new sick leave uploaded.<br><br>
                    <b>Contact name:</b> ' . $contact->name . '<br>
                    <b>Contact email:</b> ' . $contact->email . '<br><br>
                    <b>Sick leave:</b> ' . $title2 . ' (' . $forr . ')<br>
                    <b>Date:</b> ' . $period;
                $data2 = array(
                    'email' => $email,
                    'from' => $from,
                    'name' => $name,
                    'title' => $title,
                    'title_url' => $title_url,
                    'url' => $url,
                    'text' => $text,
                    'documents' => $documents
                );
                Mail::send('emails.notification', $data2, function ($message) use ($email, $from, $name, $title, $documents) {
                    $message->from('krankmeldung@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject($title);

                    if ($documents != '') {
                        $d2 = explode(',', $documents);
                        foreach ($d2 as $file) {
                            $message->attach('company_files/documents/' . $file);
                        }
                    }
                });
                // send timetable to student END
            }

            return redirect('sick-leaves');
        }

        $sick_leaves = array();
        $i = 0;
        $row = DB::select("SELECT * FROM sick_leaves WHERE user_id='$id' ORDER BY id DESC");
        foreach ($row as $r) {
            $sick_leaves[$i]['leave'] = $r;

            $i ++;
        }

        return view('sick_leaves.index', [
            'title' => trans('header.sick_leaves'),
            'sick_leaves' => $sick_leaves
        ]);
    }

    public function edit_sick_leave(Request $request, $id)
    {
        $user_id = $request->session()->get('id');

        $row = DB::select("SELECT * FROM sick_leaves WHERE user_id='$user_id' AND id='$id' LIMIT 1");
        $row = collect($row)->first();

        if ($request->input('documents') != '') {
            $documents = $request->input('documents');

            DB::insert("UPDATE sick_leaves SET documents='$documents' WHERE id='$id'");
            $request->session()->flash('success', 'Sick leave updated successfully.');

            $contact = DB::select("SELECT id, name, email FROM contacts WHERE id='$user_id' LIMIT 1");
            $contact = collect($contact)->first();
            $title2 = $row->title;
            $period = date_format(new DateTime($row->beginning), 'd-m-Y') . ' - ' . date_format(new DateTime($row->end), 'd-m-Y');

            $users = DB::select("SELECT name, email FROM users");
            foreach ($users as $user) {

                // send timetable to student START
                $name = $user->name;
                $email = $user->email;
                $from = env('MAIL_USERNAME');
                $title = 'Sick leave | ' . $contact->name;
                $title_url = 'Login now';
                $url = url('admin');
                $text = 'Sick leave updated:<br><br>
                    <b>Contact name:</b> ' . $contact->name . '<br>
                    <b>Contact email:</b> ' . $contact->email . '<br><br>
                    <b>Sick leave:</b> ' . $title2 . ' (' . $row->forr . ')<br>
                    <b>Date:</b> ' . $period;
                $data2 = array(
                    'email' => $email,
                    'from' => $from,
                    'name' => $name,
                    'title' => $title,
                    'title_url' => $title_url,
                    'url' => $url,
                    'text' => $text,
                    'documents' => $documents
                );
                Mail::send('emails.notification', $data2, function ($message) use ($email, $from, $name, $title, $documents) {
                    $message->from('krankmeldung@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject($title);

                    if ($documents != '') {
                        $d2 = explode(',', $documents);
                        foreach ($d2 as $file) {
                            $message->attach('company_files/documents/' . $file);
                        }
                    }
                });
                // send timetable to student END
            }

            return redirect('sick-leaves');
        }

        return view('edit_sick_leave.index', [
            'title' => trans('header.sick_leaves'),
            'sick_leave' => $row
        ]);
    }

    public function course_offers(Request $request)
    {
        ini_set('memory_limit', '-1');
        require ('fpdf17/fpdf.php');

        $id = $request->session()->get('id');
        $user_id = $request->session()->get('id');

        if ($request->input('create_send') != '') {
            $course_id = addslashes($request->input('course_id'));
            $mis = '';
            // if(!empty($request->input('mis')))
            $mis = $request->input('mis');

            DB::update("UPDATE courses SET mis='$mis' WHERE id='$course_id'");

            $course = DB::select("SELECT * FROM courses WHERE id='$course_id' LIMIT 1");
            $course = collect($course)->first();

            $beginning = '';
            $end = '';
            $period = addslashes($request->input('appointments_period'));
            if ($period != '') {
                $dates = explode(' - ', $period);
                $beginning = date_format(new DateTime($dates[0]), 'Y-m-d');
                $end = date_format(new DateTime($dates[1]), 'Y-m-d');
            }

            $classes_id = $request->input('classes_id');
            $classes = $request->input('classes');
            $froms = $request->input('froms');
            $tos = $request->input('tos');
            $ues = $request->input('ues');
            $breaks = $request->input('breaks');
            $notes = $request->input('notes');
            $rooms = $request->input('rooms');

            $row = DB::select("SELECT id FROM classes WHERE course_id='$course_id' AND coach='$user_id'");
            foreach ($row as $r) {
                if (! in_array($r->id, $classes_id))
                    DB::delete("DELETE FROM classes WHERE id='$r->id'");
            }

            for ($i = 0; $i < count($froms); $i ++) {
                if (isset($classes_id[$i]))
                    $id = $classes_id[$i];
                else
                    $id = '0';

                $class = addslashes($classes[$i]);
                $day = '';
                if (! empty($request->input('days' . $i)))
                    $day = implode(';', $request->input('days' . $i));
                $mis = '';
                $mis = addslashes($request->input('mis' . $i));

                $from = $froms[$i];
                $to = '';
                $ue = $ues[$i];
                $break = $breaks[$i];
                $note = addslashes($notes[$i]);
                $room = $rooms[$i];

                if ($id == '' or $id == '0')
                    DB::insert("INSERT INTO classes (course_id, name, day, fromm, ue, breaks, notes, room, coach, beginning, end, mis) VALUES ('$course_id', '$class', '$day', '$from', '$ue', '$break', '$note', '$room', '$user_id', '$beginning', '$end', '$mis')");
                else {
                    DB::update("UPDATE classes SET name='$class', day='$day', fromm='$from', ue='$ue', breaks='$break', notes='$note', room='$room', beginning='$beginning', end='$end', mis='$mis' WHERE id='$id' AND coach='$user_id'");
                }
            }

            $this->create_appointments($request, $course, $user_id);

            return redirect('course-offers?c=' . $course->id);
        }

        $course_ids = array();
        $row = DB::select("SELECT course_id FROM course_offers WHERE coach='$user_id' ORDER BY id DESC");
        foreach ($row as $r) {
            if (! in_array($r->course_id, $course_ids))
                $course_ids[] = $r->course_id;
        }

        $courses = array();
        $i = 0;
        foreach ($course_ids as $course_id) {
            $row = DB::select("SELECT id, title, description, students, type, mis FROM courses WHERE id='$course_id' LIMIT 1");
            if (count($row) == 0)
                continue;
            $row = collect($row)->first();
            $courses[$i]['course'] = $row;

            $mis = array();
            $j = 0;
            $row2 = DB::select("SELECT p_id, m_id, i_id FROM course_items WHERE c_id='$row->id'");
            foreach ($row2 as $r2) {
                $row3 = DB::select("SELECT id, title FROM modules WHERE id='$r2->m_id' LIMIT 1");
                $row3 = collect($row3)->first();
                $mis[$j]['module'] = $row3;

                $row3 = DB::select("SELECT id, title, lessons FROM module_items WHERE id='$r2->i_id' LIMIT 1");
                $row3 = collect($row3)->first();
                $mis[$j]['module_item'] = $row3;

                $j ++;
            }

            $courses[$i]['mis'] = $mis;

            $classes = array();
            $i2 = 0;
            $row1 = DB::SELECT("SELECT * FROM classes WHERE course_id='$course_id' AND coach='$user_id'");
            foreach ($row1 as $r1) {
                $classes[$i2]['class'] = $r1;

                $classes[$i2]['room'] = '';
                $row22 = DB::select("SELECT id, name, location FROM rooms WHERE id='$r1->room' LIMIT 1");
                if (count($row22) == 1) {
                    $row22 = collect($row22)->first();
                    $classes[$i2]['room'] = $row22->name;

                    $row22 = DB::select("SELECT id, name FROM room_locations WHERE id='$row22->location' LIMIT 1");
                    if (count($row22) == 1) {
                        $row22 = collect($row22)->first();
                        $classes[$i2]['room'] .= ' (' . $row22->name . ')';
                    }
                }

                $i2 ++;
            }
            $courses[$i]['classes'] = $classes;

            $appointments = array();
            $j = 0;
            if ($row->type == 'Coaching')
                $row = DB::select("SELECT * FROM appointments WHERE course_id='$course_id' AND status!='3' AND type='2'");
            else
                $row = DB::select("SELECT * FROM appointments WHERE course_id='$course_id' AND status!='3' AND status!='0' AND type='2'");
            foreach ($row as $r) {
                $appointments[$j]['appointment'] = $r;

                $appointments[$j]['room'] = '';
                $appointments[$j]['room_location'] = '';

                $row2 = DB::select("SELECT name, location FROM rooms WHERE id='$r->room' LIMIT 1");
                if (count($row2) == 1) {
                    $row2 = collect($row2)->first();
                    $appointments[$j]['room'] = $row2->name;

                    $row2 = DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                    if (count($row2) == 1) {
                        $row2 = collect($row2)->first();
                        $appointments[$j]['location'] = $row2->name;
                    }
                }

                $j ++;
            }
            $courses[$i]['appointments'] = $appointments;

            // get all p/m/mi or the course
            $courses[$i]['total_cost'] = 0;
            $courses[$i]['total_lessons'] = 0;
            $products2 = array();
            $i2 = 0;
            $row1 = DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$course_id'");
            foreach ($row1 as $r1) {
                $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();
                $products2[$i2]['product'] = $row22;

                $products2[$i2]['total_cost'] = 0;
                $products2[$i2]['total_lessons'] = 0;

                $row2 = DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$course_id'");
                $modules = array();
                $j = 0;
                foreach ($row2 as $r2) {
                    $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                    if (count($row22) == 0)
                        continue;
                    $row22 = collect($row22)->first();
                    $modules[$j]['module'] = $row22;

                    $modules[$j]['total_cost'] = 0;
                    $modules[$j]['total_lessons'] = 0;

                    $row3 = DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$course_id'");
                    $module_items = array();
                    $k = 0;
                    foreach ($row3 as $r3) {
                        $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                        if (count($row4) == 0)
                            continue;
                        $row4 = collect($row4)->first();
                        $module_items[$k]['item'] = $row4;

                        $lessons = DB::select("SELECT lessons FROM contract_lessons WHERE course_id='$course_id' AND i_id='$r3->id' LIMIT 1");
                        if (count($lessons) == 1) {
                            $lessons = collect($lessons)->first();
                            $row4->lessons = $lessons->lessons;
                            $lessons = $lessons->lessons;
                            $module_items[$k]['item'] = $row4;
                        } else
                            $lessons = $row4->lessons;

                        $courses[$i]['total_lessons'] += $lessons;
                        $courses[$i]['total_cost'] += $lessons * $row4->price_lessons;

                        $products2[$i2]['total_lessons'] += $lessons;
                        $products2[$i2]['total_cost'] += $lessons * $row4->price_lessons;

                        $modules[$j]['total_lessons'] += $lessons;
                        $modules[$j]['total_cost'] += $lessons * $row4->price_lessons;

                        $k ++;
                    }
                    $modules[$j]['items'] = $module_items;
                    $j ++;
                }
                $products2[$i2]['modules'] = $modules;
                $i2 ++;
            }
            $courses[$i]['products'] = $products2;

            $i ++;
        }

        if ($request->input('selected_ids') != '') {
            $course_id = $request->input('course_id');
            $selected_ids = explode(',', $request->input('selected_ids'));
            foreach ($selected_ids as $id) {
                $app = DB::select("SELECT status, course_id, contact FROM appointments WHERE id='$id' LIMIT 1");
                $app = collect($app)->first();

                // check if someone else has accepted the appointment
                if ($app->contact != '0' and $app->contact != $user_id) {
                    // $data['error']='Appointment already accepted by someone else.';
                    continue;
                }

                if ($app->status != '1')
                    DB::update("UPDATE appointments SET status='1', contact='$user_id' WHERE id='$id'");
            }

            $this->check_all_accepted($request, $course_id);

            return redirect('course-offers');
        }

        if ($request->input('accept_all') != '') {
            $course_id = $request->input('course_id');
            $check = DB::select("SELECT id FROM appointments WHERE course_id='$course_id' AND status!='1'");

            if (count($check) != 0) {
                foreach ($check as $ch) {
                    DB::update("UPDATE appointments SET status='1', contact='$user_id' WHERE id='$ch->id'");
                }
                $this->check_all_accepted($request, $course_id);
            }

            return redirect('course-offers');
        }

        return view('course_offers.index', [
            'title' => 'Course Offers',
            'courses' => $courses
        ]);
    }

    public function create_appointments(Request $request, $course, $coach)
    {
        $classes = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT * FROM classes WHERE course_id='$course->id' AND coach='$coach'");
        foreach ($row1 as $r1) {
            $classes[$i2]['class'] = $r1;

            $beginning = $r1->beginning;
            $end = $r1->end;

            $classes[$i2]['room'] = '';
            $row22 = DB::select("SELECT id, name, location FROM rooms WHERE id='$r1->room' LIMIT 1");
            if (count($row22) == 1) {
                $row22 = collect($row22)->first();
                $classes[$i2]['room'] = $row22->name;

                $row22 = DB::select("SELECT id, name FROM room_locations WHERE id='$row22->location' LIMIT 1");
                if (count($row22) == 1) {
                    $row22 = collect($row22)->first();
                    $classes[$i2]['room'] .= ' (' . $row22->name . ')';
                }
            }

            $i2 ++;
        }

        $participants = 0;
        if ($course->coaches != '') {
            $c2 = array();
            $c2 = explode(';', $course->coaches);
            $participants += count($c2);
        }
        if ($course->students != '') {
            $c2 = array();
            $c2 = explode(';', $course->students);
            $participants += count($c2);
        }

        $total_hours = 0;
        $row = DB::select("SELECT p_id, m_id, i_id FROM course_items WHERE c_id='$course->id'");
        foreach ($row as $r) {
            $row2 = DB::select("SELECT id, title, lessons FROM module_items WHERE id='$r->i_id' LIMIT 1");
            $row2 = collect($row2)->first();
            $total_hours += $row2->lessons;
        }

        $count = round($total_hours / 4);
        $check = DB::select("SELECT id, status FROM appointments WHERE course_id='$course->id' AND status='3'");
        $count += count($check) + 150;

        $days = array();
        $i = 0;
        $days_filter = '';
        $day_hours = array();
        // get all available days for the course
        if (! empty($classes)) {
            foreach ($classes as $class) {
                $days2 = explode(';', $class['class']->day);
                $time = date_format(new DateTime($class['class']->fromm), 'H:i');
                $timestamp = strtotime($time) + ($class['class']->ue * 45 * 60);
                $time_end = date('H:i', $timestamp);
                $class_id = $class['class']->id;
                DB::update("UPDATE classes SET too='$time_end' WHERE id='$class_id'");
                // $time_end=date_format(new DateTime($time_end),'H:i');
                $max_hours = 0;
                $time1 = strtotime($time);
                $time2 = strtotime($time_end);
                $max_hours = round(abs($time2 - $time1) / 3600, 2);

                foreach ($days2 as $dd2) {
                    if (! in_array($dd2, $days)) {
                        $days[] = $dd2;
                        if ($i ++ != 0)
                            $days_filter .= ',';

                        $day_hours[$dd2]['room'] = $class['class']->room;
                        $day_hours[$dd2]['mis'] = explode(';', $class['class']->mis);
                        $day_hours[$dd2]['hours'] = $max_hours;
                        $day_hours[$dd2]['time_start'] = $time;
                        $day_hours[$dd2]['time_end'] = $time_end;
                        $day_hours[$dd2]['break'] = $class['class']->breaks;

                        if ($dd2 == 'Monday')
                            $days_filter .= 'MO';
                        else if ($dd2 == 'Tuesday')
                            $days_filter .= 'TU';
                        else if ($dd2 == 'Wednesday')
                            $days_filter .= 'WE';
                        else if ($dd2 == 'Thursday')
                            $days_filter .= 'TH';
                        else if ($dd2 == 'Friday')
                            $days_filter .= 'FR';
                        else if ($dd2 == 'Saturday')
                            $days_filter .= 'SA';
                        else if ($dd2 == 'Sunday')
                            $days_filter .= 'SU';
                    }
                }
            }
        }

        // get all available dates for the days between beginning and end
        $app_dates = array();
        $app_dates2 = array();
        $startDate = new \DateTime($beginning);
        // $until=$course->end;
        $until = date_format(new DateTime($end), 'Y-m-d');
        // echo $beginning.'---'.$until; exit();
        $rule = new \Recurr\Rule('FREQ=WEEKLY;BYDAY=' . $days_filter, $startDate);

        $transformer = new \Recurr\Transformer\ArrayTransformer();

        $transformerConfig = new \Recurr\Transformer\ArrayTransformerConfig();
        $transformerConfig->enableLastDayOfMonthFix();
        $transformer->setConfig($transformerConfig);

        $t_date = date('Y-m-d');
        $constraint = new \Recurr\Transformer\Constraint\BeforeConstraint(new \DateTime($end . ' 00:00:00'), true);
        $results = $transformer->transform($rule, $constraint, null);

        foreach ($results as $result) {
            $start = $result->getStart();
            $date = $start->format('Y-m-d');
            // $app_dates[$date]=array();
            $start_time = $start->format('H:i');
            $day = date_format(new DateTime($date), 'l');

            $check = DB::select("SELECT id FROM holidays WHERE (beginning<='$date' AND end>='$date') LIMIT 1");
            if (count($check) == 1)
                continue;

            $room = $day_hours[$day]['room'];
            $hours = $day_hours[$day]['hours'];
            $break = $day_hours[$day]['break'];
            $time_start = $day_hours[$day]['time_start'];
            $time_end = $day_hours[$day]['time_end'];

            // echo "SELECT r_id FROM rooms_availability WHERE day='$day' AND (from_time>='$time_start' AND (to_time<='$time_end' OR to_time>='$time_end')) LIMIT 1"; exit();
            $room_avl = DB::select("SELECT r_id FROM rooms_availability WHERE day='$day' AND ((from_time>='$time_start' OR from_time<='$time_start') AND to_time>='$time_end') AND capacity>='$participants' ORDER BY capacity ASC");
            if (count($room_avl) == 0) {
                // echo "SELECT r_id FROM rooms_availability WHERE day='$day' AND ((from_time>='$time_start' OR from_time<='$time_start') AND to_time>='$time_end') AND capacity>='$participants' ORDER BY capacity ASC"; exit();
                $request->session()->flash('error', 'No room available on ' . $day . ' from ' . $time_start . ' to ' . $time_end);
                return redirect('course-offers?c=' . $course->id);
            }
            $room = 0;
            foreach ($room_avl as $check_room) {
                // echo $check_room->id.'<br>';
                // check if there is no appointment for the room
                $check = DB::select("SELECT id FROM appointments WHERE room='$check_room->r_id' AND date='$date' AND ((time>='$time_start' AND time_end<='$time_end') OR (time>='$time_start' AND time='$time_end') OR (time<='$time_start' AND time_end='$time_end') OR (time<='$time_start' AND time_end>'$time_start')) LIMIT 1");
                if (count($check) == 0) {
                    $room = $check_room->r_id;
                    break;
                }
            } // exit();
            if ($room == 0) {
                $request->session()->flash('error', 'No room available on ' . $day . ' from ' . $time_start . ' to ' . $time_end);
                return redirect('course-offers?c=' . $course->id);
            }
            // $room_avl=collect($room_avl)->first();
            // $room=$room_avl->r_id;

            // remove the break from the total time available for the day
            $app_dates2[$date] = $time_start . ' - ' . $time_end . ' - ' . $break . ' - ' . $room;

            $timestamp = strtotime($time_end) - $break * 60;
            $time_end = date('H:i', $timestamp);

            // get all available time slots for appointments of 45 minutes each
            for ($i = 1; $i <= $hours; $i ++) {
                $timestamp = strtotime($time_start) + 45 * 60;
                $time = date('H:i', $timestamp);

                if ($time > $time_end)
                    break;

                $app_dates[] = $date . ' ; ' . $time_start . ' - ' . $time . ' ; ' . $room;

                $time_start = $time;
            }

            // echo $date.'<< <br>';
        }

        // get all course items and create appointments for approval by coach
        $app_time_start = '';
        $app_time_end = '';
        $coaches = explode(';', $course->coaches);
        $j = 0;
        $course_mis = array();
        if ($course->mis != '')
            $course_mis = explode(';', $course->mis);
        $row = DB::select("SELECT p_id, m_id, i_id FROM course_items WHERE c_id='$course->id'");
        foreach ($row as $r) {
            if (! in_array($r->i_id, $course_mis))
                continue;
            $row2 = DB::select("SELECT id, title FROM modules WHERE id='$r->m_id' LIMIT 1");
            $row2 = collect($row2)->first();
            $module_name = $row2->title;

            $row2 = DB::select("SELECT id, title, lessons FROM module_items WHERE id='$r->i_id' LIMIT 1");
            $row2 = collect($row2)->first();
            $lessons = $row2->lessons;

            $check = DB::select("SELECT ue FROM appointments WHERE course_id='$course->id' AND product_id='$r->p_id' AND module_id='$r->m_id' AND item_id='$r->i_id'");
            foreach ($check as $ch) {
                $lessons -= $ch->ue;
            }
            if ($lessons <= 0)
                continue;

            $ue = 0;
            // echo 'Lessons: '.$lessons.'<br><br>'; exit();

            for ($i = 1; $i <= $lessons; $i ++) {
                // echo $i.'<br>';
                $old_i = $i;
                $ue = 0;
                foreach ($app_dates2 as $date => $time_period) {
                    if ($i > $lessons)
                        break;
                    // echo 'Date: '.$date.'<br>';
                    // echo 'Time Period: '.$time_period.'<br><br>'; //continue;
                    $data2 = explode(' - ', $time_period);
                    $time = $data2[0];
                    $time_end = $data2[1]; // echo $time_end.'<br>';
                    $break = $data2[2];
                    // if(!isset($data2[3])) { echo 'Time Period: '.$time_period.'<br><br>'; exit(); }
                    $room = $data2[3];

                    $app_time_start = $time;
                    $time_start = $time;
                    for (; $i <= $lessons; $i ++) {
                        // echo '$i='.$i.'<< DATE LOOP<br>';
                        $timestamp = strtotime($time_start) + 45 * 60;
                        $time_end2 = date('H:i', $timestamp);
                        // echo $time_end2.' - ';
                        if ($time_end2 >= $time_end) {
                            unset($app_dates2[$date]);
                        }

                        if ($time_end2 > $time_end) {
                            // $app_time_start=''; $app_time_end='';
                            $i --;
                            $timestamp = strtotime($time_start) - 45 * 60;
                            $time_end2 = date('H:i', $timestamp);
                            break;
                        }

                        $app_time_end = $time_end2;
                        $ue += 1;

                        $time_start = $app_time_end;
                        if ($time_start < $time_end)
                            $app_dates2[$date] = $time_start . ' - ' . $time_end . ' - ' . $break . ' - ' . $room;
                    }

                    // }
                    // exit();
                    if ($app_time_start == '' or $app_time_end == '')
                        continue;

                    $timestamp = strtotime($app_time_end) + ($break * 60);
                    $app_time_end = date('H:i', $timestamp);

                    // echo 'Create Appointment: '.$app_time_start.' - '.$app_time_end.'<br><br>'; exit();
                    // check if appointment already exists for the course on same date and time
                    $check = DB::select("SELECT id, status FROM appointments WHERE course_id='$course->id' AND date='$date' AND ((time>='$app_time_start' AND time_end<='$app_time_end') OR (time>='$app_time_start' AND time_end>='$app_time_end')) LIMIT 1");
                    // ((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time_end>='$time_end') OR (time='$time' OR time_end='$time_end'))
                    // ('$time' BETWEEN time AND time_end) OR ('$time_end' BETWEEN time AND time_end)
                    if (count($check) == 1) {
                        $check = collect($check)->first();
                        if ($check->status == 3) {
                            unset($app_dates2[$date]);
                            $j ++;
                            $i ++;
                            // echo 'DELETED DATE > '.$date.' - '.$old_i.'<br><br>';
                            // $i=$old_i;
                            $ue = 0;
                            continue;
                            // break;
                        } else {
                            unset($app_dates2[$date]);
                            $j ++;
                            $i ++;
                            $ue = 0;
                            continue;
                            // break;
                        }
                    }

                    // TODO: save appointment_form. When Please select, then set it to Unkonwn
                    $appt_form = $request->input('appointment_form');
                    if ($appt_form == 'Please Select')
                        $appt_form = 'Unknown';
                    $title = $module_name . ' > ' . $row2->title;
                    DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, type, ue, appointment_form) VALUES ('0', '$room', '$title', '', '0', '$date', '$app_time_start', '$app_time_end', '0', NOW(), '0', '0', '$course->id', '$r->p_id', '$r->m_id', '$r->i_id', '0', '2', '$ue', '$appt_form')");
                    break;
                }
            }
            // exit();
        }

        $check = DB::select("SELECT id, status, ue, product_id, module_id, item_id FROM appointments WHERE course_id='$course->id' AND status='3'");
        foreach ($check as $ch) {
            $row2 = DB::select("SELECT id, title FROM modules WHERE id='$ch->module_id' LIMIT 1");
            $row2 = collect($row2)->first();
            $module_name = $row2->title;

            $row2 = DB::select("SELECT id, title, lessons FROM module_items WHERE id='$ch->item_id' LIMIT 1");
            $row2 = collect($row2)->first();
            $lessons = $row2->lessons;
            $ue = 0;

            $check2 = DB::select("SELECT ue FROM appointments WHERE course_id='$course->id' AND status!='3' AND product_id='$ch->product_id' AND module_id='$ch->module_id' AND item_id='$ch->item_id'");
            $ue2 = 0;
            foreach ($check2 as $ch2) {
                $ue2 += $ch2->ue;
            }

            if ($ue2 >= $lessons)
                continue;
            $lessons = $lessons - $ue2;

            for ($i = 1; $i <= $lessons; $i ++) {
                // echo $i.'<br>';
                $old_i = $i;
                $ue = 0;
                foreach ($app_dates2 as $date => $time_period) {
                    if ($i > $lessons)
                        break;
                    // echo 'Date: '.$date.'<br>';
                    // echo 'Time Period: '.$time_period.'<br><br>'; //continue;
                    $data2 = explode(' - ', $time_period);
                    $time = $data2[0];
                    $time_end = $data2[1]; // echo $time_end.'<br>';
                    $break = $data2[2];

                    $app_time_start = $time;
                    $time_start = $time;
                    for (; $i <= $lessons; $i ++) {
                        // echo '$i='.$i.'<< DATE LOOP<br>';
                        $timestamp = strtotime($time_start) + 45 * 60;
                        $time_end2 = date('H:i', $timestamp);
                        // echo $time_end2.' - ';
                        if ($time_end2 >= $time_end) {
                            unset($app_dates2[$date]);
                        }

                        if ($time_end2 > $time_end) {
                            // $app_time_start=''; $app_time_end='';
                            $i --;
                            $timestamp = strtotime($time_start) - 45 * 60;
                            $time_end2 = date('H:i', $timestamp);
                            break;
                        }

                        $app_time_end = $time_end2;
                        $ue += 1;

                        $time_start = $app_time_end;
                        if ($time_start < $time_end)
                            $app_dates2[$date] = $time_start . ' - ' . $time_end . ' - ' . $break;
                    }

                    // }
                    // exit();
                    if ($app_time_start == '' or $app_time_end == '')
                        continue;

                    $timestamp = strtotime($app_time_end) + ($break * 60);
                    $app_time_end = date('H:i', $timestamp);

                    // echo 'Create Appointment: '.$app_time_start.' - '.$app_time_end.'<br><br>';
                    // check if appointment already exists for the course on same date and time
                    $check = DB::select("SELECT id, status FROM appointments WHERE course_id='$course->id' AND date='$date' AND ((time>='$app_time_start' AND time_end<='$app_time_end') OR (time>='$app_time_start' AND time_end>='$app_time_end')) LIMIT 1");
                    // ('$time' BETWEEN time AND time_end) OR ('$time_end' BETWEEN time AND time_end)
                    if (count($check) == 1) {
                        $check = collect($check)->first();
                        if ($check->status == 3) {
                            unset($app_dates2[$date]);
                            $j ++;
                            // echo 'DELETED DATE > '.$date.' - '.$old_i.'<br><br>';
                            $i = $old_i;
                            $ue = 0;
                            continue;
                            // break;
                        } else {
                            unset($app_dates2[$date]);
                            $j ++; // $i++;
                                   // echo 'ANOTHER APPOINTMENT > '.$date.' - '.$old_i.'<br><br>';
                            $ue = 0;
                            $i = $old_i;
                            continue;
                            // break;
                        }
                    }

                    $title = $module_name . ' > ' . $row2->title;
                    $appt_form = $request->input('appointment_form');
                    if ($appt_form == 'Please Select')
                        $appt_form = 'Unknown';
                    DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, type, ue, appointment_form) VALUES ('0', '$room', '$title', '', '0', '$date', '$app_time_start', '$app_time_end', '0', NOW(), '0', '0', '$course->id', '$ch->product_id', '$ch->module_id', '$ch->item_id', '0', '2', '$ue', '$appt_form')");
                    break;
                }
            }
        }
        // exit();
    }

    public function check_all_accepted($request, $course_id)
    {
        $user_id = $request->session()->get('id');

        // create appointments for student if all appointments are accepted
        $check = DB::select("SELECT id FROM appointments WHERE course_id='$course_id' AND status='2'");
        if (count($check) == 0) {
            $course = DB::select("SELECT * FROM courses WHERE id='$course_id' LIMIT 1");
            $course = collect($course)->first();
            $students = array();
            if ($course->students != '')
                $students = explode(';', $course->students);

            $coaches = array();
            if (1) // $course->coach=='' OR $course->coach=='0'
            {
                // get all appointments for the course
                $appointments = DB::select("SELECT * FROM appointments WHERE course_id='$course_id' AND status='1' AND type='2'");
                foreach ($appointments as $appointment) {
                    if (! in_array($appointment->contact, $coaches))
                        $coaches[] = $appointment->contact;
                    foreach ($students as $student) {
                        // check if the module item is assigned to the contact object
                        $check = DB::select("SELECT id FROM contract_items WHERE c_id='$student' AND course_id='$course_id' AND p_id='$appointment->product_id' AND m_id='$appointment->module_id' AND i_id='$appointment->item_id' LIMIT 1");
                        if (count($check) == 0)
                            continue;

                        // assign the appointment to student if not assigned already
                        $check = DB::select("SELECT id FROM appointments WHERE contact='$student' AND course_id='$appointment->course_id' AND date='$appointment->date' AND time='$appointment->time' AND time_end='$appointment->time_end'");
                        if (count($check) == 0) {

                            DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, appointment_form) VALUES ('$student', '$appointment->room', '$appointment->title', '', '0', '$appointment->date', '$appointment->time', '$appointment->time_end', '0', NOW(), '0', '0', '$appointment->course_id', '$appointment->product_id', '$appointment->module_id', '$appointment->item_id', '1', '$appointment->appointment_form')");
                        } // add as attendee to the coach appointment
                        DB::insert("INSERT INTO attendees (app_id, user_id, user_type) VALUES ('$appointment->id', '$student', '2')");
                    }
                }

                foreach ($students as $student) {
                    $student = DB::select("SELECT * FROM contacts WHERE id='$student' LIMIT 1");
                    if (count($student) == 0)
                        continue;
                    $student = collect($student)->first();

                    $timetable = $this->create_appointments_pdf($request, $course, $student);

                    // send timetable to student START
                    $name = $student->name;
                    $email = $student->email;
                    $from = env('MAIL_USERNAME');
                    $title = 'Timetable | ' . $course->title;
                    $title_url = 'View Timetable';
                    $url = url('company_files/timetables/' . $timetable);
                    $text = 'Timetable for course : <b>' . $course->title . '</b> has been generated. You can download it using the following link below.';
                    $data2 = array(
                        'email' => $email,
                        'from' => $from,
                        'name' => $name,
                        'title' => $title,
                        'title_url' => $title_url,
                        'url' => $url,
                        'text' => $text
                    );
                    Mail::send('emails.notification', $data2, function ($message) use ($email, $from, $name, $title) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject($title);
                    });
                    // send timetable to student END
                }

                // create contract for all dozents START
                $contract_type = addslashes($course->title . ' - Course Contract');
                foreach ($coaches as $coach) {
                    $contact = DB::select("SELECT * FROM contacts WHERE id='$coach' LIMIT 1");
                    $contact = collect($contact)->first();

                    $contract = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                    $check = DB::select("SELECT id FROM contracts WHERE c_id='$coach' AND course_id='$course->id' LIMIT 1");
                    if (count($check) == 0) {
                        DB::insert("INSERT INTO contracts (c_id, contract, course_id, type, on_date, beginning, end, professional_qualifications, elective_qualifications, installments, consultation_date, job_title, student, phase1_begin, phase1_end, phase2_begin, phase2_end, test1_begin, test1_end, test2_begin, test2_end) VALUES ('$coach', '$contract', '$course->id', '$contract_type', NOW(), '$course->beginning', '$course->end', '', '', '', '', '', '', '', '', '', '', '', '', '', '')");
                        $c_id = DB::getPdo()->lastInsertId();

                        $contract = DB::select("SELECT * FROM contracts WHERE id='$c_id' LIMIT 1");
                        $contract = collect($contract)->first();

                        $c_id = \Contracts::instance()->course_contract($request, $contact, $contract_type, $contract, $coach);
                        // send email alert with contract link start
                        \Contacts::instance()->email_contract($coach, $c_id);
                        // send email alert with contract link end
                    }
                }
                // create contract for all dozents END

                // add coach to the course
                DB::update("UPDATE courses SET coach='$user_id' WHERE id='$course_id'");
            }
        }
    }

    public function accept_appointment(Request $request)
    {
        ini_set('memory_limit', '-1');
        require ('fpdf17/fpdf.php');

        $user_id = $request->session()->get('id');
        $data = array();
        $data['success'] = 0;
        if ($request->input('id') != '') {
            $id = $request->input('id');
            $data['id'] = $id;

            $app = DB::select("SELECT status, course_id, contact FROM appointments WHERE id='$id' LIMIT 1");
            $app = collect($app)->first();
            $data['course'] = $app->course_id;

            // check if someone else has accepted the appointment
            if ($app->contact != '0' and $app->contact != $user_id) {
                $data['error'] = '';
                if ($app->contact != $user_id)
                    $data['error'] = 'Appointment already accepted by someone else.';
                return response()->json($data);
            }

            // mark appointment as accepted
            if ($app->status != '1')
                DB::update("UPDATE appointments SET status='1', contact='$user_id' WHERE id='$id'");
            $data['success'] = 1;

            // create appointments for student if all appointments are accepted
            $check = DB::select("SELECT id FROM appointments WHERE course_id='$app->course_id' AND status='2'");
            if (count($check) == 0) {
                $course_id = $app->course_id;
                $course = DB::select("SELECT * FROM courses WHERE id='$course_id' LIMIT 1");
                $course = collect($course)->first();
                $students = array();
                if ($course->students != '')
                    $students = explode(';', $course->students);

                if (1) // $course->coach=='' OR $course->coach=='0'
                {
                    // get all appointments for the course
                    $appointments = DB::select("SELECT * FROM appointments WHERE course_id='$course_id' AND status='1' AND type='2'");
                    foreach ($appointments as $appointment) {
                        foreach ($students as $student) {
                            // check if the module item is assigned to the contact object
                            $check = DB::select("SELECT id FROM contract_items WHERE c_id='$student' AND course_id='$course_id' AND p_id='$appointment->product_id' AND m_id='$appointment->module_id' AND i_id='$appointment->item_id' LIMIT 1");
                            if (count($check) == 0)
                                continue;

                            // assign the appointment to student if not assigned already
                            $check = DB::select("SELECT id FROM appointments WHERE contact='$student' AND course_id='$appointment->course_id' AND date='$appointment->date' AND time='$appointment->time' AND time_end='$appointment->time_end'");
                            if (count($check) == 0) {
                                DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, appointment_form) VALUES ('$student', '$appointment->room', '$appointment->title', '', '0', '$appointment->date', '$appointment->time', '$appointment->time_end', '0', NOW(), '0', '0', '$appointment->course_id', '$appointment->product_id', '$appointment->module_id', '$appointment->item_id', '1', '$appointment->appointment_form')");
                                // add as attendee to the coach appointment
                                DB::insert("INSERT INTO attendees (app_id, user_id, user_type) VALUES ('$id', '$student', '2')");
                            }
                        }
                    }

                    foreach ($students as $student) {
                        $student = DB::select("SELECT * FROM contacts WHERE id='$student' LIMIT 1");
                        if (count($student) == 0)
                            continue;
                        $student = collect($student)->first();

                        $timetable = $this->create_appointments_pdf($request, $course, $student);

                        // send timetable to student START
                        $name = $student->name;
                        $email = $student->email;
                        $from = env('MAIL_USERNAME');
                        $title = 'Timetable | ' . $course->title;
                        $title_url = 'View Timetable';
                        $url = url('timetables/' . $timetable);
                        $text = 'Timetable for course : <b>' . $course->title . '</b> has been generated. You can download it using the following link below.';
                        $data2 = array(
                            'email' => $email,
                            'from' => $from,
                            'name' => $name,
                            'title' => $title,
                            'title_url' => $title_url,
                            'url' => $url,
                            'text' => $text
                        );
                        Mail::send('emails.notification', $data2, function ($message) use ($email, $from, $name, $title) {
                            $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                            $message->to($email);
                            $message->subject($title);
                        });
                        // send timetable to student END
                    }

                    // add coach to the course
                    DB::update("UPDATE courses SET coach='$user_id' WHERE id='$course_id'");
                }
            }
        }

        return response()->json($data);
    }

    public function delete_appointment(Request $request)
    {
        $user_id = $request->session()->get('id');
        $data = array();
        $data['success'] = 0;

        if ($request->input('id') != '') {
            $id = $request->input('id');
            $data['id'] = $id;

            $app = DB::delete("DELETE FROM appointments WHERE id='$id' LIMIT 1");
            $data['success'] = 1;
        }

        return response()->json($data);
    }

    public function create_appointments_pdf($request, $course, $student)
    {
        $pdf = new \Fpdf('P', 'mm', 'A4'); // 8.5" x 11" laser form
        $pdf->AddFont('GOTHIC', 'I', 'GOTHICI.php');
        $pdf->AddFont('GOTHIC', '', 'GOTHIC.php');
        $pdf->AddFont('GOTHIC', 'BI', 'GOTHICBI.php');
        $pdf->AddFont('GOTHIC', 'B', 'GOTHICB.php');
        $pdf->setTitle('Timetable | ' . $course->title);
        $pdf->SetDrawColor(172, 172, 172);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetMargins(16.35, 16.35, 16.35);

        $r_id = 1;
        $page_height = 0;
        $one_section = 0;
        $i = 0;
        $current_page = $pdf->PageNo();
        $starting_page_no = $pdf->PageNo();
        $end_page_no = $current_page;
        $end_page_height = 0;

        $pdf->AddPage();
        $pdf->setLeftMargin(8);
        $pdf->setTopMargin(30);
        $pdf->ln(10);

        $pdf->SetDrawColor(172, 172, 172);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('GOTHIC', 'B', 15);
        $pdf->Cell(190, 14, iconv('UTF-8', 'windows-1252', $course->title), 0, 0, 'C');
        $pdf->ln(9);

        // Add coach details
        /*
         * $pdf->SetFont('GOTHIC','B',10.8);
         * $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Coach:'), 0, 0, 'L');
         * $pdf->ln(10);
         *
         * $address=$course['coach']->door_no.', '.$course['coach']->street_name;
         * if($course['coach']->address!='')
         * $address.=', '.$course['coach']->address;
         * $address.=', '.$course['coach']->city.', '.$course['coach']->zip_code;
         * $dob='';
         * $pdf->SetFont('GOTHIC','',10.8);
         * $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','Name, Vorname: '.$course['coach']->name.'
         * Anschrift/PLZ/Ort: '.$address.'
         * Telefon/Handy: '.$course['coach']->phone_no.'
         * E-Mail : '.$course['coach']->email.'
         * '),0,'LR');
         *
         * $pdf->ln(1);
         */

        // Add student details
        $pdf->SetFont('GOTHIC', 'B', 10.8);
        // $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Student:'), 0, 0, 'L');
        $pdf->ln(7);

        $address = $student->door_no . ', ' . $student->street_name;
        if ($student->address != '')
            $address .= ', ' . $student->address;
        $address .= ', ' . $student->city . ', ' . $student->zip_code;
        $dob = '';
        $pdf->SetFont('GOTHIC', '', 10.8);
        $pdf->MultiCell(190, 4, iconv('UTF-8', 'windows-1252', 'Name, Vorname:            ' . $student->name . '
Anschrift/PLZ/Ort:           ' . $address . '
Telefon/Handy:               ' . $student->phone_no . '
E-Mail       :                     ' . $student->email . '
'), 0, 'LR');

        $pdf->ln(0);

        // Create appointments table START
        $data = array();
        $page_height = $pdf->GetY();
        $pdf->SetXY(8, $page_height + 7);
        $header = array(
            iconv('UTF-8', 'windows-1252', 'Date'),
            iconv('UTF-8', 'windows-1252', 'Time'),
            iconv('UTF-8', 'windows-1252', 'Module Item'),
            iconv('UTF-8', 'windows-1252', 'Room')
        );

        $appointments = array();
        $added = array();
        $row = DB::select("SELECT * FROM appointments WHERE course_id='$course->id' AND contact='$student->id' ORDER BY date ASC");
        foreach ($row as $r) {
            $room = '';
            $room_location = '';

            $row2 = DB::select("SELECT name, location FROM rooms WHERE id='$r->room' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $room = $row2->name;

                $row2 = DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                if (count($row2) == 1) {
                    $row2 = collect($row2)->first();
                    $room_location = $row2->name;
                }
            }

            $data[] = array(
                iconv('UTF-8', 'windows-1252', $r->date),
                iconv('UTF-8', 'windows-1252', $r->time . ' - ' . $r->time_end),
                iconv('UTF-8', 'windows-1252', $r->title),
                iconv('UTF-8', 'windows-1252', $room . ' (' . $room_location . ')')
            );
        }

        // Column widths
        $w = array(
            23,
            28,
            72,
            70
        );
        // Header
        $pdf->SetFont('GOTHIC', 'B', 10);
        for ($i2 = 0; $i2 < count($header); $i2 ++)
            $pdf->Cell($w[$i2], 13, $header[$i2], 0, 0, 'LR');
        $pdf->Ln(14);

        $pdf->SetXY(8, $page_height + 20);
        $pdf->Cell(array_sum($w), 0, '', 'T');
        $pdf->Ln(2);
        $current_y = $page_height + 22;

        // Data
        $pdf->SetFont('GOTHIC', '', 10);
        $i2 = 0;
        $ys = array();
        $ys[] = $pdf->GetY();
        foreach ($data as $row) {
            $current_x = 8;
            $pdf->SetXY($current_x, $current_y);
            $pdf->MultiCell($w[0], 4, $row[0], 0, 'LR');
            $current_x += $w[0];

            $ys[] = $pdf->GetY();
            $pdf->SetXY($current_x, $current_y);

            $pdf->MultiCell($w[1], 4, $row[1], 0, 'LR');
            $current_x += $w[1];

            $ys[] = $pdf->GetY();
            $pdf->SetXY($current_x, $current_y);

            $pdf->MultiCell($w[2], 4, $row[2], 0, 'LR');
            $current_x += $w[2];

            $ys[] = $pdf->GetY();
            $pdf->SetXY($current_x, $current_y);

            $pdf->MultiCell($w[3], 4, $row[3], 0, 'LR');
            $current_x += $w[3];

            $pdf->Ln(3);

            $current_y = $pdf->GetY();
        }

        $y = max($ys);
        $pdf->SetXY($pdf->GetX(), $y + 2);
        // Closing line
        $pdf->Ln(0);
        $pdf->Cell(array_sum($w), 0, '', 'T');
        $pdf->Ln(4);

        // Validity
        // $pdf->SetFont('GOTHIC','B',10);
        // $pdf->Cell($w[0],4,'Validity:',0,'LR');
        // $pdf->Cell($w[1],4,'12/02/2020 - 18/01/20202',0,'LR');

        $pdf->Ln(6);
        // Create earnings table END

        // $pdf->output(); exit();

        $timetable = $course->id . $student->id . rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
        // $pdf->Output(); exit();
        $pdf->Output('company_files/timetables/' . $timetable, 'F');

        DB::insert("INSERT INTO timetables (course_id, contact_id, on_date) VALUES ('$course->id', '$student->id', NOW())");
        return $timetable;
    }



    /*------------------------------------------*/


    public function ajaxTagesdokuDetails(){

        $appointment = Appointment::find(request()->input('appointment_id'));
        $module_item = ModuleItems::find($appointment->item_id);
        // $cvs = CVs::get()->first();
        $cvs = CVs::all();
        $data['cvs'] = $cvs;
        $module_item_services = ModuleItemServices::getQuery()->where('module_item_module_item_services.mi_id','=',$appointment->item_id)->get();
        $appointment->date = date_format(new DateTime($appointment->date), 'd.m.Y');
        $data['appointment'] = $appointment;
        $data['module'] = Module::find($appointment->module_id);
        $data['module_item'] = $module_item;
        $data['module_item_services'] = $module_item_services;
        $data['contact'] = Contact::select('id','name')->where('id','=',$appointment->contact)->get()->first();
        $next_appointment = Appointment::where('course_id','=',$appointment->course_id)->where('date','>',date_format(new DateTime($appointment->date), 'Y-m-d') )->where('status','=',1)->get()->first();
        if(isset($next_appointment))
            $next_appointment->date = date_format(new DateTime($next_appointment->date), 'd.m.Y');
        else
            $data['next_appointment_missing'] = $appointment->course_id . '#' . $appointment->date ; 
        $data['next_appointment'] = $next_appointment;
        $data['teaching_method_all'] = TeachingMethod::get();
        $attendance = Attendance::where('appointment_id','=',request()->input('appointment_id'))->get()->first();
        $data['attendance'] = $attendance;
        $attendance_record_id = 0;
        if(isset($attendance)) {
            $attendance_record_id = $attendance->id;
        } else {
            //TODO: Retrieve the previous attendance record with the same moduleitem_id as the current appointment of this course_id & coachee
            //TODO: Populate attendance_additional with the previous data
             $prevappts = DB::select("select att.id attendance_id, a.* from appointments a
                                 inner join (select * from appointments where id = " . request()->input('appointment_id') . " ) pa
                                 on pa.course_id = a.course_id and pa.product_id = a.product_id
                                 and pa.module_id = a.module_id
                                 and pa.item_id = a.item_id and pa.contact = a.contact
                                 and pa.id != a.id
                                 inner join attendance att on att.appointment_id = a.id
                                 order by str_to_date(concat(a.date, ' ',a.time), '%Y-%m-%d %T') desc");
             $prevappt_record = collect($prevappts)->first();
             if(isset($prevappt_record))
                 $attendance_record_id = $prevappt_record->attendance_id;
        }
        if(isset($attendance_record_id) && $attendance_record_id > 0) {
            //BEGIN - Set the other attendance records. Either current appointment or previous appoint is set in $attendance_record_id
            $attendance_addl = AttendanceAdditional::where('attendance_id','=',$attendance_record_id)->get()->first();
            if(isset($attendance_addl)) 
                $data['attendance_additional'] = $attendance_addl; 
                
            $attendance_attachments = AttendanceAttachments::where('attendance_id','=',$attendance_record_id)->get();
            if(isset($attendance_attachments))
                $data['attendance_attachments'] = $attendance_attachments;
            
            
            //Coaching Verhalten will not be carried over between each attendance. 
            //The average will be calculated in Abschlussreport
            
            //END - Set the other attendance records
        }
        
        $attendance_notes = AttendanceNotes::where('course_id','=',$appointment->course_id)->get();
        if(isset($attendance_notes))
            $data['attendance_notes'] = $attendance_notes;
        if (isset($attendance) && isset($attendance->id))    
            $attendance_verhalten = AttendanceVerhalten::where('attendance_id', '=', $attendance->id)->get()->first();
        if(isset($attendance_verhalten))
            $data['attendance_verhalten'] = $attendance_verhalten;
        
        $log_data = '';
        $students_ids = array();
        
        $row3 = DB::select("SELECT id, title, room, date, time, time_end, contact, teaching_form, teaching_method FROM appointments WHERE id = '$appointment->id' AND status='1' AND type='1'");
        foreach ($row3 as $r2) {
            
            if (in_array($r2->contact, $students_ids))
                continue;
                $students_ids[] = $r2->contact;
                $log_data .= ' ApptContact: ' . $r2->contact;
        }
        
        if (! isset($students_ids) || count($students_ids) == 0) {
               
            $row3 = DB::select("SELECT attendees.id, attendees.user_id, attendees.user_type FROM attendees inner join contacts on contacts.id = attendees.user_id and contacts.type = 'Student' WHERE app_id='$appointment->id'");
            foreach ($row3 as $r2) {
                if (in_array($r2->user_id, $students_ids))
                    continue;
                    $students_ids[] = $r2->user_id;
                    $log_data .= ' ' . $r2->user_id;
                    
                    // The record may not be existing in appointments table. So insert it
                    /*$check = DB::select("SELECT id FROM appointments WHERE type = '1' and title='$appointment->title' and contact='$r2->user_id' AND course_id='$appointment->course_id' AND date='$appointment->date' AND time='$appointment->time' AND time_end='$appointment->time_end'");
                    if (count($check) == 0) {
                        DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, appointment_form) VALUES ('$r2->user_id', '$appointment->room', '$appointment->title', '', '0', '" .  date_format(new DateTime($appointment->date), 'Y-m-d') . "', '$appointment->time', '$appointment->time_end', '0', NOW(), '0', '0', '$appointment->course_id', '$appointment->product_id', '$appointment->module_id', '$appointment->item_id', '1', '$appointment->appointment_form')");
                    }*/
            }
        }
        $data['log_data'] = $log_data;
        $data['studentids'] = $students_ids;
        $students = array();
        $k = 0;
        foreach ($students_ids as $s) {
            $row4 = DB::select("SELECT id, name, email FROM contacts WHERE id='$s' LIMIT 1");
            $row4 = collect($row4)->first();
            $students[$k]['student'] = $row4;
            $k++;
        }
        $data['students'] = $students;
        
        return view('ajax.tagasdoku',$data);
    }

     /*------------------------------------------*/

    public function ajaxStoreTagesdoku(){

        $resp = array('code'=>0,'error'=>'','output'=>array());
        $appointment = Appointment::find(request()->input('appointment_id'));

        $submit_type = request()->input('submit_type');

        $check = Attendance::where('appointment_id','=',request()->input('appointment_id'))->get()->first();
        if (isset($check->id)) {
            $obj = Attendance::find($check->id);
            
            $check_addl = AttendanceAdditional::where('attendance_id','=',$check->id)->get()->first();
            if (isset($check_addl->id)) {
                $obj_additional =  AttendanceAdditional::find($check_addl->id);
            }
            else 
                $obj_additional = new AttendanceAdditional;
            
            $check_notes = AttendanceNotes::where('course_id','=',$appointment->course_id)->get(); 
            
            $check_ver = AttendanceVerhalten::where('attendance_id','=',$check->id)->get()->first();
            if (isset($check_ver->id)) {
                $obj_verhalten =  AttendanceVerhalten::find($check_ver->id);
            }else 
                $obj_verhalten = new AttendanceVerhalten;
            
           //TODO: Find all the existing attachments and delete the physical files & delete the records in database
            $attendance_attachments = AttendanceAttachments::where('attendance_id','=',$check->id)->get();
            
        }else{
            $obj = new Attendance;
            $obj_additional = new AttendanceAdditional;
            $obj_verhalten = new AttendanceVerhalten;
            $obj_notes = new AttendanceNotes;
        }

        $obj->appointment_id = request()->input('appointment_id');
        $appointment_data = Appointment::find(request()->input('appointment_id'));

        if (request()->input('tagesdoku_teaching_method')) {
            $teaching_methods = request()->input('tagesdoku_teaching_method');
            $appointment_data->teaching_method = implode(',', $teaching_methods);
        }else{
            $appointment_data->teaching_method = "";
        }
        
        $appointment_data->save();
        
        $obj->course_id = $appointment_data->course_id;
        
        
        $students_ids = array();
        
        $row3 = DB::select("SELECT id, title, room, date, time, time_end, contact, teaching_form, teaching_method FROM appointments WHERE id = '$appointment_data->id' AND status='1' AND type='1'");
        foreach ($row3 as $r2) {
            
            if (in_array($r2->contact, $students_ids))
                continue;
                $students_ids[] = $r2->contact;
                
        }
        
        if (! isset($students_ids) || count($students_ids) == 0) {
            
            $row3 = DB::select("SELECT attendees.id, attendees.user_id, attendees.user_type FROM attendees inner join contacts on contacts.id = attendees.user_id and contacts.type = 'Student' WHERE app_id='$appointment_data->id'");
            foreach ($row3 as $r2) {
                if (in_array($r2->user_id, $students_ids))
                    continue;
                    $students_ids[] = $r2->user_id;
                    
                    
                    // The record may not be existing in appointments table. So insert it
                    /*$check = DB::select("SELECT id FROM appointments WHERE type = '1' and title='$appointment_data->title' and contact='$r2->user_id' AND course_id='$appointment_data->course_id' AND date='$appointment_data->date' AND time='$appointment_data->time' AND time_end='$appointment_data->time_end'");
                    if (count($check) == 0) {
                        DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, appointment_form) VALUES ('$r2->user_id', '$appointment_data->room', '$appointment_data->title', '', '0', '" . date_format(new DateTime($appointment_data->date), 'Y-m-d') . "', '$appointment_data->time', '$appointment_data->time_end', '0', NOW(), '0', '0', '$appointment_data->course_id', '$appointment_data->product_id', '$appointment_data->module_id', '$appointment_data->item_id', '1', '$appointment_data->appointment_form')");
                    }*/
            }
        }
        
        $data['studentids'] = $students_ids;
        $students = array();
      
        foreach ($students_ids as $s) {
            $row4 = DB::select("SELECT id, name, email FROM contacts WHERE id='$s' LIMIT 1");
            $row4 = collect($row4)->first();
            $students[] = $row4->id;
           
        }
        
        
        
        $obj->student_id = implode(',', $students);
        $obj->teacher_id = $appointment_data->contact;
        $obj->date = date_format(new DateTime($appointment_data->date), 'Y-m-d');
        // All the other tagesdoku_mis_other should be instered into the MIS table
        // and it's ids should be saved in mis_ids
        $mis_others =  request()->input('tagesdoku_mis_other');
        $mis_other_array = explode(PHP_EOL, $mis_others);
        $module_item_id = $appointment_data->item_id;
        $mis_other_ids = array();
        
        foreach($mis_other_array as $mis_oth) {
            //Add all the new mis to module item table
            if(strlen(ltrim(rtrim($mis_oth)))){
                $mis_record = ModuleItemServices::where('title','=',$mis_oth)->first();
                
                if (!(isset($mis_record) && !empty($mis_record))){
                    $mis_record =new ModuleItemServices;
                }
                
                $mis_record->title = $mis_oth;
                $mis_record->daily_documentation_text = $mis_oth;
                $mis_record->endreport_documentation_text = $mis_oth;
                $mis_record->added_by = $appointment_data->contact;
                $mis_record->added_on = date_format(new DateTime(), 'Y-m-d');
                $mis_record->save();
                
                $whereCondition = [
                    ['mi_id', '=', $module_item_id],
                    ['mis_id', '=', $mis_record->id]                
                ];
                if(isset($mis_record->id) && $mis_record->id > 0) {
                    $mi_mis_record = ModuleItemModuleItemServices::where($whereCondition)->first();
                    if (!(isset($mi_mis_record) && !empty($mi_mis_record))){
                        $mi_mis_record = new ModuleItemModuleItemServices;
                    }
                    
                    $mi_mis_record->mi_id =  $module_item_id;
                    $mi_mis_record->mis_id = $mis_record->id;
                    $mi_mis_record->save();
                    
                    $mis_other_ids[] = $mis_record->id;
                }
            }
        }
                
        if (request()->input('tagesdoku_mis')) {
            $obj->mis_ids = implode(";",request()->input('tagesdoku_mis'));
        }else{
           $obj->mis_ids = ""; 
        }
        if(isset($mis_other_ids) && is_array($mis_other_ids)){
            $obj->mis_ids .= ';' . implode(";", $mis_other_ids);
        }

        if(strlen($obj->mis_ids) > 0) {
            $final_mis = array_unique(explode(';', $obj->mis_ids));
            $obj->mis_ids = implode(';', $final_mis);
        }
        //---sign1---
        if (!empty(request()->input('sign1'))) {
            $signature1 = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.png';
            $img = str_replace('data:image/png;base64,', '', request()->input('sign1'));
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            if (file_put_contents("signatures/" . $signature1, $fileData)) {
               $obj->teacher_signature = $signature1;
            }
        }
        //------sign------
         if (!empty(request()->input('sign2'))) {
            $signature2 = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.png';
            $img = str_replace('data:image/png;base64,', '', request()->input('sign2'));
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            if (file_put_contents("signatures/" . $signature2, $fileData)) {
               $obj->student_signature = $signature2;
            }
        }
        $obj->status = 1;
        $obj->save();
        if(isset($obj->id)) {
            $obj_additional->attendance_id = $obj->id;
            $obj_verhalten->attendance_id = $obj->id;
            // MI_DURCHHALTEVERMOEGEN_BELASTBARKEIT
            $durch_belast_options = '';
            if(request()->input('durch_belast_options_gesund') !== null)
                $durch_belast_options .= 'durch_belast_options_gesund;';
                if(request()->input('durch_belast_options_familie')!== null)
                $durch_belast_options .= 'durch_belast_options_familie;';
                if(request()->input('durch_belast_options_partner')!== null)
                $durch_belast_options .= 'durch_belast_options_partner;';
                if(request()->input('durch_belast_options_kinder')!== null)
                $durch_belast_options .= 'durch_belast_options_kinder;';
                if(request()->input('durch_belast_options_financial')!== null)
                $durch_belast_options .= 'durch_belast_options_financial;';
                if(request()->input('durch_belast_options_recht')!== null)
                $durch_belast_options .= 'durch_belast_options_recht;';
                if(request()->input('durch_belast_options_sprach')!== null)
                $durch_belast_options .= 'durch_belast_options_sprach;';
                if(request()->input('durch_belast_options_pflege')!== null)
                $durch_belast_options .= 'durch_belast_options_pflege;';
            
            if(strlen($durch_belast_options) > 0)
                $obj_additional->durch_belast_options = $durch_belast_options;
            
                if(request()->input('durch_belast_options_other')!== null)
            {
                $obj_additional->durch_belast_options_other = request()->input('durch_belast_options_other');
            }
       
            //MI_SELBST_UND_FREMDWAHRNEHMUNG_TEIL_1
            if(request()->input('selbst_fremd_strengths')!== null)
                $obj_additional->selbst_fremd_strengths = request()->input('selbst_fremd_strengths');
                if(request()->input('selbst_fremd_weakness')!== null)
                $obj_additional->selbst_fremd_weakness = request()->input('selbst_fremd_weakness');
                if(request()->input('selbst_fremd_potential')!== null)
                $obj_additional->selbst_fremd_potential = request()->input('selbst_fremd_potential');
                if(request()->input('selbst_fremd_energykiller')!== null)
                $obj_additional->selbst_fremd_energykiller = request()->input('selbst_fremd_energykiller');
                if(request()->input('selbst_fremd_energygiver')!== null)
                $obj_additional->selbst_fremd_energygiver = request()->input('selbst_fremd_energygiver');
                if(request()->input('selbst_fremd_ziel_planung')!== null)
                $obj_additional->selbst_fremd_ziel_planung = request()->input('selbst_fremd_ziel_planung');
                if(request()->input('selbst_fremd_beruf_persp')!== null)
                $obj_additional->selbst_fremd_beruf_persp = request()->input('selbst_fremd_beruf_persp');
            
            //MI_MOEGLICHKEITEN_VISIONEN
                if(request()->input('moeglich_vision_competence')!== null)
                $obj_additional->moeglich_vision_competence = request()->input('moeglich_vision_competence');
                if(request()->input('moeglich_vision_experience')!== null)
                $obj_additional->moeglich_vision_experience = request()->input('moeglich_vision_experience');
                        
                //MI_PROFESSIONALE_BEWERBUNGSUNTERLAGEN
                $obj_additional->prof_bewerbung_platforms_used = '';
                if(request()->input('jobborse_fur_stellensuche')!== null)
                    $obj_additional->prof_bewerbung_platforms_used .= ';jobborse_fur_stellensuche';
                if(request()->input('kursnet_fur_weiterbildungen_und_umschulungen')!== null)
                    $obj_additional->prof_bewerbung_platforms_used .= ';kursnet_fur_weiterbildungen_und_umschulungen';
                if(request()->input('berufsnet_fur_ausfuhrliche_berufsinformationen')!== null)
                    $obj_additional->prof_bewerbung_platforms_used .= ';berufsnet_fur_ausfuhrliche_berufsinformationen';
                if(request()->input('prof_bewerbung_platforms_used_other')!== null)
                    $obj_additional->prof_bewerbung_platforms_used_other = nl2br(request()->input('prof_bewerbung_platforms_used_other'));
                    $obj_additional->prof_bewerbung_mappe = '';
                if(request()->input('professionelles_anschreiben_erarbeitet')!== null)
                    $obj_additional->prof_bewerbung_mappe .= ';professionelles_anschreiben_erarbeitet';
                if(request()->input('professionellen_lebenslauf_erarbeitet')!== null)
                    $obj_additional->prof_bewerbung_mappe .= ';professionellen_lebenslauf_erarbeitet';
                if(request()->input('zertifikate_wurden_fur_die_mappe_zusammengestellt')!== null)
                    $obj_additional->prof_bewerbung_mappe .= ';zertifikate_wurden_fur_die_mappe_zusammengestellt';
                            
            if(request()->input('prof_bewerbung_sent_cv1_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv1_to = request()->input('prof_bewerbung_sent_cv1_to');
            if(request()->input('prof_bewerbung_sent_cv2_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv2_to = request()->input('prof_bewerbung_sent_cv2_to');
            if(request()->input('prof_bewerbung_sent_cv3_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv3_to = request()->input('prof_bewerbung_sent_cv3_to');
            if(request()->input('prof_bewerbung_sent_cv4_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv4_to = request()->input('prof_bewerbung_sent_cv4_to');
            if(request()->input('prof_bewerbung_sent_cv5_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv5_to = request()->input('prof_bewerbung_sent_cv5_to');
            if(request()->input('prof_bewerbung_sent_cv6_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv6_to = request()->input('prof_bewerbung_sent_cv6_to');
            if(request()->input('prof_bewerbung_sent_cv7_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv7_to = request()->input('prof_bewerbung_sent_cv7_to');
            if(request()->input('prof_bewerbung_sent_cv8_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv8_to = request()->input('prof_bewerbung_sent_cv8_to');
            if(request()->input('prof_bewerbung_sent_cv9_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv9_to = request()->input('prof_bewerbung_sent_cv9_to');
            if(request()->input('prof_bewerbung_sent_cv10_to')!== null)
                $obj_additional->prof_bewerbung_sent_cv10_to = request()->input('prof_bewerbung_sent_cv10_to');

            if(request()->input('pdf_bewerbung_sent_cv1_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv1_cvs_id = request()->input('pdf_bewerbung_sent_cv1_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv2_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv2_cvs_id = request()->input('pdf_bewerbung_sent_cv2_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv3_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv3_cvs_id = request()->input('pdf_bewerbung_sent_cv3_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv4_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv4_cvs_id = request()->input('pdf_bewerbung_sent_cv4_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv5_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv5_cvs_id = request()->input('pdf_bewerbung_sent_cv5_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv6_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv6_cvs_id = request()->input('pdf_bewerbung_sent_cv6_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv7_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv7_cvs_id = request()->input('pdf_bewerbung_sent_cv7_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv8_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv8_cvs_id = request()->input('pdf_bewerbung_sent_cv8_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv9_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv9_cvs_id = request()->input('pdf_bewerbung_sent_cv9_cvs_id');
            if(request()->input('pdf_bewerbung_sent_cv10_cvs_id')!== null)
                $obj_additional->pdf_bewerbung_sent_cv10_cvs_id = request()->input('pdf_bewerbung_sent_cv10_cvs_id');
                

            if(request()->file('cv1')!='')
            {
            $file=request()->file('cv1');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv1=$cv_id;
                }
            }else if(null !== request()->input('cv1_name_hidden')){
                $cv_id = request()->input('cv1_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv1=$cv_id;
            }

            if(request()->file('cv2')!='')
            {
            $file=request()->file('cv2');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv2=$cv_id;
                }
            }else if(null !== request()->input('cv2_name_hidden')){
                $cv_id = request()->input('cv2_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv2=$cv_id;
            }

            if(request()->file('cv3')!='')
            {
            $file=request()->file('cv3');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv3=$cv_id;
                }
            } else if(null !== request()->input('cv3_name_hidden')){
                $cv_id = request()->input('cv3_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv3=$cv_id;
            }

            if(request()->file('cv4')!='')
            {
            $file=request()->file('cv4');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv4=$cv_id;
                }
            } else if(null !== request()->input('cv4_name_hidden')){
                $cv_id = request()->input('cv4_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv4=$cv_id;
            }

            if(request()->file('cv5')!='')
            {
            $file=request()->file('cv5');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv5=$cv_id;
                }
            } else if (null !== request()->input('cv5_name_hidden')){
                $cv_id = request()->input('cv5_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv5=$cv_id;
            }

            if(request()->file('cv6')!='')
            {
            $file=request()->file('cv6');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv6=$cv_id;
                }
            } else if (null !== request()->input('cv6_name_hidden')){
                $cv_id = request()->input('cv6_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv6=$cv_id;
            }

            if(request()->file('cv7')!='')
            {
            $file=request()->file('cv7');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv7=$cv_id;
                }
            } else if (null !== request()->input('cv7_name_hidden')){
                $cv_id = request()->input('cv7_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv7=$cv_id;
            }

            if(request()->file('cv8')!='')
            {
            $file=request()->file('cv8');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv8=$cv_id;
                }
            } else if (null !== request()->input('cv8_name_hidden')){
                $cv_id = request()->input('cv8_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv8=$cv_id;
            }

            if(request()->file('cv9')!='')
            {
            $file=request()->file('cv9');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv9=$cv_id;
                }
            } else if (null !== request()->input('cv9_name_hidden')) {
                $cv_id = request()->input('cv9_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv9=$cv_id;
            }

            if(request()->file('cv10')!='')
            {
            $file=request()->file('cv10');
            
            //Move Uploaded File
            $destinationPath = 'company_files/tagesdoku/cvs/';
                $cv_name=$file->getClientOriginalName();
                $cv_id=rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
                if($file->move($destinationPath,$cv_name)) {
                    $obj_additional->pdf_bewerbung_sent_cv10=$cv_id;
                }
            } else if (null !== request()->input('cv10_name_hidden')) {
                $cv_id = request()->input('cv10_name_hidden');
                $obj_additional->pdf_bewerbung_sent_cv10=$cv_id;
            }
            
           
                //MI_WEG_ZIEL_PLANUNG
            if(request()->input('plan_a')!== null)
                $obj_additional->weg_ziel_planung_plan_a = request()->input('plan_a');
            if(request()->input('plan_b')!== null)
                $obj_additional->weg_ziel_planung_plan_b = request()->input('plan_b');
            if(request()->input('plan_c')!== null)
                $obj_additional->weg_ziel_planung_plan_c = request()->input('plan_c');
            if(request()->input('plan_d')!== null)
                $obj_additional->weg_ziel_planung_plan_d = request()->input('plan_d');
            if(request()->input('plan_e')!== null)
                $obj_additional->weg_ziel_planung_plan_e = request()->input('plan_e');

                if(isset($obj_additional->durch_belast_options) || isset($obj_additional->durch_belast_options_other) ||
                    isset($obj_additional->selbst_fremd_strengths) ||
                    isset($obj_additional->selbst_fremd_weakness) ||
                    isset($obj_additional->selbst_fremd_potential) ||
                    isset($obj_additional->selbst_fremd_energykiller) ||
                    isset($obj_additional->selbst_fremd_energygiver) ||
                    isset($obj_additional->moeglich_vision_competence) ||
                    isset($obj_additional->moeglich_vision_experience) ||
                    isset($obj_additional->selbst_fremd_beruf_persp) ||
                    isset($obj_additional->selbst_fremd_ziel_planung) ||
                    isset($obj_additional->weg_ziel_planung_plan_a) ||
                    isset($obj_additional->weg_ziel_planung_plan_b) ||
                    isset($obj_additional->weg_ziel_planung_plan_c) ||
                    isset($obj_additional->weg_ziel_planung_plan_d) ||
                    isset($obj_additional->weg_ziel_planung_plan_e) ||
                    isset($obj_additional->prof_bewerbung_platforms_used) ||
                    isset($obj_additional->prof_bewerbung_platforms_used_other) ||
                    isset($obj_additional->prof_bewerbung_mappe) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv1) || 
                    isset($obj_additional->pdf_bewerbung_sent_cv2) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv3) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv4) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv5) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv6) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv7) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv8) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv9) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv10) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv1_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv2_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv3_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv4_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv5_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv6_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv7_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv8_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv9_cvs_id) ||
                    isset($obj_additional->pdf_bewerbung_sent_cv10_cvs_id) ||
                    isset($obj_additional->prof_bewerbung_sent_cv1_to) 
                    || isset($obj_additional->prof_bewerbung_sent_cv2_to) ||
                    isset($obj_additional->prof_bewerbung_sent_cv3_to) ||
                    isset($obj_additional->prof_bewerbung_sent_cv4_to) ||
                    isset($obj_additional->prof_bewerbung_sent_cv5_to) ||
                    isset($obj_additional->prof_bewerbung_sent_cv6_to) ||
                    isset($obj_additional->prof_bewerbung_sent_cv7_to) ||
                    isset($obj_additional->prof_bewerbung_sent_cv8_to) ||
                    isset($obj_additional->prof_bewerbung_sent_cv9_to) ||
                    isset($obj_additional->prof_bewerbung_sent_cv10_to))
            $obj_additional->save();

            
            //COACHING_VERHALTEN
            if(request()->input('vorbildlich') !== null)
                $obj_verhalten->vorbildlich = request()->input('vorbildlich');
            if(request()->input('sucht_loesungen') !== null)
                $obj_verhalten->sucht_loesungen = request()->input('sucht_loesungen');
            if(request()->input('agiert_entscheidung') !== null)
                $obj_verhalten->agiert_entscheidung = request()->input('agiert_entscheidung');
            if(request()->input('motiviert_konflikt_solve') !== null)
                $obj_verhalten->motiviert_konflikt_solve = request()->input('motiviert_konflikt_solve');
            if(request()->input('motiviert_problem_solve') !== null)
                $obj_verhalten->motiviert_problem_solve = request()->input('motiviert_problem_solve');
            if(request()->input('formuliert_klare_erwartung') !== null)
                $obj_verhalten->formuliert_klare_erwartung = request()->input('formuliert_klare_erwartung');

            if(isset($obj_verhalten->vorbildlich) || isset($obj_verhalten->sucht_loesungen) ||
             isset($obj_verhalten->agiert_entscheidung) || isset($obj_verhalten->motiviert_konflikt_solve) ||
             isset($obj_verhalten->motiviert_problem_solve) || isset($obj_verhalten->formuliert_klare_erwartung ))
                $obj_verhalten->save();
            
        }
        

        $resp['code'] = 1;
        $resp['output']['appointment_id'] = $appointment_data->id;
        $resp['output']['course_id'] = $appointment_data->course_id;
        
        if ($submit_type=="save_pdf") {
            $this->generateTagesdoku($obj->id);
        }

        if ($submit_type=="save_send") {
            $attendance = Attendance::find($obj->id);
            $data['link'] = route('tagesdokuStudent',['id'=>base64_encode($attendance->id)]);
            $coachee = Contact::select('id','name', 'email')->where('id','=',$attendance->student_id)->get()->first();
            $from = env('MAIL_USERNAME');
            $name = $coachee->name;
            $email = $coachee->email;

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $resp['error'] = "Invalid email format";
            }else{
                $mail =   Mail::send('emails.tagesdoku', $data, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Signature Tagesdoku');
                        //$message->attach($pathToFile);
                    });
            }
        }
        
         

        //$resp['code'] = 0;
        //$resp['error'] = implode(';',$mis_other_ids);
        echo json_encode($resp);
        
    }

    /*------------------------------------------*/

    public function generateTagesdoku($id) {
        $attendance = Attendance::find($id);
        $attendance_additional = AttendanceAdditional::where('attendance_id','=',$attendance->id)->get()->first();
        //TODO: $attendance_attachments = AttendanceAttachments::where('attendance_id','=',$attendance->id);
        $attendance_verhalten = AttendanceVerhalten::where('attendance_id','=',$attendance->id)->get()->first();
        $appointment = Appointment::find($attendance->appointment_id);       
        $module_item = ModuleItems::find($appointment->item_id);
        $module_item_services = ModuleItemServices::getQuery()->where('module_item_module_item_services.mi_id','=',$appointment->item_id)->get();
        $data['appointment'] = $appointment;
        $data['attendance_additional'] = $attendance_additional;
        //TODO: $data['attendance_attachments'] = $attendance_attachments;
        $cvs = CVs::all();
        $data['cvs'] = $cvs;        
        $data['attendance_verhalten'] = $attendance_verhalten;
        $data['module'] = Module::find($appointment->module_id);
        $data['module_item'] = $module_item;
        $data['module_item_services'] = $module_item_services;
        $data['coachee'] = Contact::select('id','name')->where('id','=',$attendance->student_id)->get()->first();
        $data['coach'] = Contact::select('id','name')->where('id','=',$attendance->teacher_id)->get()->first();
        $data['next_appointment'] = Appointment::where('course_id','=',$appointment->course_id)->where('date','>',$appointment->date)->where('status','=',1)->get()->first();
        $data['teaching_method_all'] = TeachingMethod::get();
        $data['attendance'] = $attendance;

        $pdf = PDF::loadView('pdf.tagasdoku',$data);
        
        $pdf->setOptions([
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'debugCss' => true
        ]);
        $tagesdokufilename = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
        $pdf->save('company_files/tagesdoku/' . $tagesdokufilename);
        $attendance->pdf_url = $tagesdokufilename;
        $attendance->save();
        
        return $pdf->stream();
    }

    public function tagasdokuPdf($id=""){
        
        $id = base64_decode($id);
        return $this->generateTagesdoku($id);
    }


    /*------------------------------------------*/

    public function tagasdokuSend($id=""){

        $attendance = Attendance::find(base64_decode($id));
        $data['link'] = route('tagesdokuStudent',['id'=>$id]);
        $coachee = Contact::select('id','name')->where('id','=',$attendance->student_id)->get()->first();
        $from = env('MAIL_USERNAME');
        $name = $coachee->name;
        $email = $coachee->email;

         $test =   Mail::send('emails.tagesdoku', $data, function($message) use($email, $from, $name) {
                    $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject('Signature Tagesdoku');
                    //$message->attach($pathToFile);
                });
         echo "mail sended at ".$email;

    }

    /*------------------------------------------*/

    
}
