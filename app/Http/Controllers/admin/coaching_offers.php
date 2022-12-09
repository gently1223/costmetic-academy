<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use DB;
use Mail;
use Illuminate\Support\Facades\Session;
use Auth;
use Validator;
use PDF;
use PDFMerger;
class coaching_offers extends Controller
{
    //
    public static function instance()
    {
        return new coaching_offers();
    }

    public function __construct()
    {
    }

    public function view_offers()
    {
        $courses = DB::select("select distinct cou.id, cou.title from contracts c inner join contacts co on co.id = c.c_id inner join courses cou on cou.id = c.course_id   where co.type = 'Student' and cou.type = 'Coaching'");
        //get offers
        $offers = DB::select("SELECT coaching_offers.*,contacts.name as con_name,courses.title FROM coaching_offers INNER JOIN courses ON coaching_offers.course_id = courses.id INNER JOIN contacts ON coaching_offers.coach_id=contacts.id ORDER BY id DESC");
        return view('panel.coaching_offers.index', [
            'title' => trans('header.offer'),
            'courses' => $courses,
            'offers'  => $offers
        ]);
    }

    public function get_lectures(Request $request)
    {
        $id = $request->input('id');
        $course = DB::select("SELECT coaches FROM courses WHERE id='$id' LIMIT 1");
        $course = collect($course)->first();
        if ($course->coaches == '') {
            return response()->json(['success' => false, 'message' => 'No dozent added to the course.']);
        } else {
            //get lecturers
            $coaches = explode(';', $course->coaches);
            $lecturers = array();
            $i = 0;
            foreach ($coaches as $coach) {
                $coach_data = DB::select("SELECT id, name, email FROM contacts WHERE id='$coach' LIMIT 1");
                if (count($coach_data) == 0)
                    continue;
                $coach_data = collect($coach_data)->first();
                $lecturers[$i]['coach'] = $coach_data;

                $i++;
            }

            $date_info = DB::select("select c.course_id, min(c.beginning) as begin, max(c.end) as end from contracts c inner join contacts co on co.id = c.c_id where co.type = 'Student' and course_id = '$id' group by c.course_id");
            if(isset($date_info[0])) {
            if (strtotime($date_info[0]->begin) > time())
                $date_info['begin'] = date('d-m-Y', strtotime($date_info[0]->begin));
            else
                $date_info['begin'] = date('d-m-Y', time());

            $date_info['end'] = date('d-m-Y', strtotime($date_info[0]->end));
            }
            // get all p/m/mi or the course
            $treeview = $this->get_treeview($id);
            return response()->json(['success' => true, 'message' => 'success', 'lecturers' => $lecturers, 'treeview' => $treeview, 'date_info' => $date_info]);
        }
    }



    private function get_treeview($course_id)
    {
        $course_id = $course_id;
        $exec_msg = '';
        ini_set('memory_limit', '-1');
        require('fpdf17/fpdf.php');

        $course = DB::select("SELECT * FROM courses WHERE id='$course_id' LIMIT 1");
        $course = collect($course)->first();
        if ($course->coaches == '') {
            $request->session()->flash('error', 'No dozent added to the course.');
            return redirect('admin/course-appointments/' . $course->id);
        }
        $coaches = explode(';', $course->coaches);

        $lecturers = array();
        $i = 0;
        foreach ($coaches as $coach) {
            $coach_data = DB::select("SELECT id, name, email FROM contacts WHERE id='$coach' LIMIT 1");
            if (count($coach_data) == 0)
                continue;
            $coach_data = collect($coach_data)->first();
            $lecturers[$i]['coach'] = $coach_data;

            $i++;
        }

        // get all p/m/mi or the course
        $courses = array();
        $i = 0;
        $courses[$i]['total_cost'] = 0;
        $courses[$i]['total_lessons'] = 0;
        $products2 = array();
        $i2 = 0;
        //$row1 = DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$course_id'");
        $row1 = DB::SELECT("select distinct cp.course_id, cp.p_id, p.title from contract_products cp inner join products p on p.id = cp.p_id
inner join 
(select distinct cm.contract_id, cm.course_id, cm.p_id, m.id, m.title
from contract_modules cm inner join modules m on m.id = cm.m_id
inner join contacts c on c.id = cm.c_id
inner join (
select  ci.course_id, ci.contract_id, c.id contact_id, ci.p_id, ci.m_id, mi.id, mi.title,  max(ci.lessons) lessons, max(ci.price_lesson) price_lesson,
 sum(a.ue) booked_lessons, max(ci.lessons) - sum(ifnull(a.ue,0)) available_lessons from contract_items ci
inner join module_items mi on mi.id = ci.i_id
inner join contacts c on c.id = ci.c_id
left outer join (select * from appointments where status = '1') a on ci.course_id = a.course_id and a.item_id = ci.i_id
left outer join coaching_offers_moduleitems com on com.course_id = ci.course_id and com.moduleitem_id = ci.i_id
where c.type = 'Student' and ci.course_id = '$course_id' 
group by  ci.course_id, c.id, ci.p_id, ci.m_id, mi.id, mi.title) mis
on mis.course_id = cm.course_id and mis.m_id = cm.m_id and cm.contract_id = mis.contract_id and mis.contact_id = cm.c_id
where c.type = 'Student' and mis.available_lessons > 0) modules
on modules.course_id = cp.course_id and modules.p_id = cp.p_id
where cp.course_id = '$course_id'");
        
        foreach ($row1 as $r1) {
            $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
            if (count($row22) == 0)
                continue;
            $row22 = collect($row22)->first();
            $products2[$i2]['product'] = $row22;

            $products2[$i2]['total_cost'] = 0;
            $products2[$i2]['total_lessons'] = 0;

            //$row2 = DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$course_id'");
            /* Return all the modules with atleast 1 UE in it's MIs*/
            $row2 = DB::SELECT("select distinct cm.contract_id, cm.course_id, m.id m_id, m.title
from contract_modules cm inner join modules m on m.id = cm.m_id
inner join contacts c on c.id = cm.c_id
inner join (
select  ci.course_id, ci.contract_id, c.id contact_id, ci.p_id, ci.m_id, mi.id, mi.title,  max(ci.lessons) lessons, max(ci.price_lesson) price_lesson,
 sum(a.ue) booked_lessons, max(ci.lessons) - sum(ifnull(a.ue,0)) available_lessons from contract_items ci
inner join module_items mi on mi.id = ci.i_id
inner join contacts c on c.id = ci.c_id
left outer join (select * from appointments where status = '1') a on ci.course_id = a.course_id and a.item_id = ci.i_id
left outer join coaching_offers_moduleitems com on com.course_id = ci.course_id and com.moduleitem_id = ci.i_id
where c.type = 'Student' and ci.course_id = '$course_id' 
group by  ci.course_id, c.id, ci.p_id, ci.m_id, mi.id, mi.title) mis
on mis.course_id = cm.course_id and mis.m_id = cm.m_id and cm.contract_id = mis.contract_id and mis.contact_id = cm.c_id
where cm.course_id = '$course_id' and c.type = 'Student' and cm.p_id = '$r1->p_id' and mis.available_lessons > 0");
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

                //$row3 = DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$course_id'");
                $row3 = DB::SELECT("select  ci.course_id, ci.p_id, ci.m_id, mi.id i_id, mi.title, 
max(ci.lessons) lessons, max(ci.price_lesson) price_lesson,
 sum(ifnull(ifnull(a.ue, com.lessons),0)) booked_lessons, max(ci.lessons) - sum(ifnull(ifnull(a.ue, com.lessons),0)) available_lessons
  from contract_items ci
inner join module_items mi on mi.id = ci.i_id
inner join contacts c on c.id = ci.c_id
left outer join (select course_id, product_id, module_id, item_id, offer_id, sum(ue) ue from appointments where status = 1 
group by course_id, product_id, module_id, item_id, offer_id)
 a on ci.course_id = a.course_id and a.item_id = ci.i_id
left outer join (select com1.course_id, com1.product_id, com1.module_id, com1.moduleitem_id,
sum(com1.lessons - ifnull(a1.ue,0)) lessons
 from coaching_offers_moduleitems com1 
left outer join (select course_id, product_id, module_id, item_id, offer_id, sum(ue) ue from appointments where status = 1 
group by course_id, product_id, module_id, item_id, offer_id) a1 on a1.offer_id = com1.coaching_offers_id
and a1.item_id = com1.moduleitem_id and a1.module_id = com1.module_id and a1.product_id = com1.product_id and a1.course_id = com1.course_id
group by course_id, product_id, module_id, com1.moduleitem_id
) com on com.course_id = ci.course_id and com.moduleitem_id = ci.i_id  
where ci.course_id = '$course_id' and c.type = 'Student' and ci.m_id = '$r2->m_id' 
group by  ci.course_id, ci.p_id, ci.m_id, mi.id, mi.title
having max(ci.lessons) - sum(ifnull(ifnull(a.ue, com.lessons),0)) > 0");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $row4 = collect($row4)->first();
                    $row4->lessons = $r3->available_lessons;
                    $row4->price_lessons = $r3->price_lesson;
                    $module_items[$k]['item'] = $row4;
                    

                    $lessons = $r3->available_lessons;

                    $courses[$i]['total_lessons'] += $lessons;
                    $courses[$i]['total_cost'] += $lessons * $r3->price_lesson;

                    $products2[$i2]['total_lessons'] += $lessons;
                    $products2[$i2]['total_cost'] += $lessons * $r3->price_lesson;

                    $modules[$j]['total_lessons'] += $lessons;
                    $modules[$j]['total_cost'] += $lessons * $r3->price_lesson;

                    $k++;
                }
                $modules[$j]['items'] = $module_items;
                $j++;
            }
            $products2[$i2]['modules'] = $modules;
            $i2++;
        }
        $courses[$i]['products'] = $products2;

        $students = DB::select("SELECT id FROM contracts WHERE course_id='$course_id'");
        $total_students = count($students);

        $treeview = view('panel.coaching_offers.treeview', [
            'title' => $course->title . ' | Appointments',
            'courses' => $courses
        ])->render();

        return $treeview;

        // return response()->json(['success' => true, 'message' => 'success', 'treeview' => $treeview, 'lecturers' => $lecturers]);
    }

    public function manage_offers(Request $request)
    {
        $data = $request->all();

        $validation = Validator::make($request->all(), [
            'name'    => 'required',
            'course_id' => 'required',
            'coach_id' => 'required',
            'begin_date' => 'required',
            'valid_until' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['success' => false, 'message' => 'Bitte alle pflichtfelder hinzufügen']);
        }
        $explode = explode(" - ", $data['begin_date']);
        $begin_date = $explode[0];
        $end_date = $explode[1];
        //get month validation 
        $status = $this->get_month_validation(date('Y-m-d', strtotime($begin_date)), date('Y-m-d', strtotime($end_date)));
        if ($status) {
            return response()->json(['success' => false, 'message' => 'Enddatum darf nicht mehr als 3 Monate sein']);
        }
        //valid untill date valdation. This validation is not required. ValidUntil must be within 2 weeks. However, Begin & End Date can be within 3 months period
        /*$status = $this->get_validdate_validation(date('Y-m-d', strtotime($end_date)), date('Y-m-d', strtotime($data['valid_until'])));
        if ($status) {
            return response()->json(['success' => false, 'message' => 'Valid Date is not more than 2 week']);
        }*/

        //max hours validation
        //valid untill date valdation
        $status = $this->get_max_hours($data);
        if ($status) {
            return response()->json(['success' => false, 'message' => 'Max hours is wrong']);
        }

        //insert into coaching_table
        $id = DB::table('coaching_offers')->insertGetId([
            'name' => $data['name'],
            'course_id' => $data['course_id'],
            'coach_id'  => $data['coach_id'],
            'begin_date' => date('Y-m-d', strtotime($begin_date)),
            'end_date' => date('Y-m-d', strtotime($end_date)),
            'valid_until' => date('Y-m-d', strtotime($data['valid_until'])),
            'created_by' => 1,
            'max_hours' => $data['max_hours'],
            'min_ue_per_week' => $data['min_ue_per_week'],
            'min_appt_per_week' => $data['min_appt_per_week'],
            'notes' => $data['notes'],
            'created_on' => date('Ym-d.h:i:s')

        ]);

        // insert into product table
        if (!empty($data['products'])) {
            foreach ($data['products'] as $key => $value) {
                $proidct_id = DB::table('coaching_offers_products')->insertGetId([
                    'coaching_offers_id' => $id,
                    'course_id' => $data['course_id'],
                    'p_id' => $value
                ]);
                //insert into module detail
                if (!empty($data['modules' . $value])) {
                    foreach ($data['modules' . $value] as $key1 => $value1) {
                        $proidct_id = DB::table('coaching_offers_modules')->insertGetId([
                            'coaching_offer_id' => $id,
                            'course_id' => $data['course_id'],
                            'product_id' => $value,
                            'module_id'  => $value1
                        ]);
                        foreach ($data['items' . $value1] as $key2 => $value2) {
                            $proidct_id = DB::table('coaching_offers_moduleitems')->insertGetId([
                                'coaching_offers_id' => $id,
                                'course_id' => $data['course_id'],
                                'product_id' => $value,
                                'module_id'  => $value1,
                                'moduleitem_id' => $value2,
                                'lessons' => $data['lessons' . $value2],
                                'price_lesson' => $data['prices' . $value2],
                            ]);
                        }
                    }
                }
            }
        }
        // send email
        $lectiur_detail = DB::table("contacts")->where('id', $data['coach_id'])->first();
        $name = $lectiur_detail->name;
        $email = $lectiur_detail->email;
        $from = env('MAIL_USERNAME');
        $title = 'New Coaching offer';
        $title_url = 'View and Create Appointments';
        $text = 'You have a new offer for Coaching: <b>' . $data['name'] . '</b>. Login and accept now.';
        $data2 = array(
            'email' => $email,
            'from' => $from,
            'name' => $name, //name of the recipient
            'offer_name' => $data['name'],
            'coaching_offer_id' => $id,
            'title' => $title,
            'title_url' => $title_url,
            'text' => $text
        );
        Mail::send('emails.offer_notification', $data2, function ($message) use ($email, $from, $name, $title) {
            $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
            $message->to($email);
            $message->subject($title);
        });
        session()->flash('success', trans('forms.offer_created_success'));
        return response()->json(['success' => true, 'message' => trans('forms.offer_created_success')]);
    }

    private function get_month_validation($from, $to)
    {
        // Declare and define two dates
        $date1 = strtotime($from);
        $date2 = strtotime($to);
        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);
        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
        $years = floor($diff / (365 * 60 * 60 * 24));
        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        if ($months > 3) {
            return true;
        } else {
            return false;
        }
    }

    private function get_validdate_validation($from, $to)
    {
        // Declare and define two dates
        $date1 = strtotime($from);
        $date2 = strtotime($to);
        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);
        // To get the year divide the resultant date into
        $years = floor($diff / (365 * 60 * 60 * 24));

        // To get the month, subtract it with years and
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

        // To get the day, subtract it with years and
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        if ($days > 14) {
            return true;
        } else {
            return false;
        }
    }

    private function get_max_hours($data)
    {
        $max_hours = 0;
        // insert into product table
        if (!empty($data['products'])) {
            foreach ($data['products'] as $key => $value) {
                //insert into module detail
                if (!empty($data['modules' . $value])) {
                    //insert module items
                    foreach ($data['modules' . $value] as $key1 => $value1) {
                        foreach ($data['items' . $value1] as $key2 => $value2) {
                            $max_hours += $data['lessons' . $value2];
                        }
                    }
                }
            }
        }
        if ($max_hours < $data['max_hours']) {
            return true;
        } else {
            return false;
        }
    }

    public function view_offer($id)
    {
        $offers = DB::table('coaching_offers')->where('id', $id)->count();
        if ($offers) {
            $row = DB::select("SELECT coaching_offers.*,contacts.name as con_name,courses.title FROM coaching_offers INNER JOIN courses ON coaching_offers.course_id = courses.id INNER JOIN contacts ON coaching_offers.coach_id=contacts.id WHERE coaching_offers.id='$id' LIMIT 1");
            $row = collect($row)->first();
            $products = $this->getmodule_product($id);
            return view('panel.coaching_offers.view-offer', [
                'title' => trans('header.offer'),
                'products' => $products,
                'offer_detail'  => $row
            ]);
        } else {
            session()->flash('error', trans('dashboard.no_detail'));
            return redirect()->route('admin.coaching-offers');
        }
    }

    private function getmodule_product($id)
    {
        $products2 = array();
        $i = 0;
        $products2[$i]['total_cost'] = 0;
        $products2[$i]['total_lessons'] = 0;
        $row = DB::select("SELECT p_id FROM coaching_offers_products WHERE coaching_offers_id='$id'");
        foreach ($row as $key) {
            $row22 = DB::select("SELECT * FROM products WHERE id='$key->p_id' LIMIT 1");
            if (count($row22) == 0)
                continue;
            $row22 = collect($row22)->first();
            $products2[$i]['product'] = $row22;

            $products2[$i]['total_cost'] = 0;
            $products2[$i]['total_lessons'] = 0;

            $row2 = DB::SELECT("SELECT id, module_id FROM coaching_offers_modules WHERE product_id='$key->p_id' AND coaching_offer_id='$id'");
            $modules = array();
            $j = 0;
            foreach ($row2 as $r2) {
                $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->module_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();
                $modules[$j]['module'] = $row22;

                $modules[$j]['total_cost'] = 0;
                $modules[$j]['total_lessons'] = 0;

                //get module items 
                $row3 = DB::SELECT("SELECT id, moduleitem_id,lessons,price_lesson FROM coaching_offers_moduleitems WHERE product_id='$key->p_id' AND coaching_offers_id='$id' AND module_id='$r2->module_id'");
                $items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $row22 = DB::select("SELECT * FROM module_items WHERE id='$r3->moduleitem_id' LIMIT 1");
                    if (count($row22) == 0)
                        continue;

                    $row4 = collect($row22)->first();
                    $row4->lessons = $r3->lessons;
                    $row4->price_lessons = $r3->price_lesson;

                    $items[$k]['item'] = $row4;
                    $lessons = $r3->lessons;

                    $products2[$i]['total_lessons'] += $lessons;
                    $products2[$i]['total_cost'] += $lessons * $row4->price_lessons;

                    $modules[$j]['total_lessons'] += $lessons;
                    $modules[$j]['total_cost'] += $lessons * $row4->price_lessons;

                    $k++;
                }
                $modules[$j]['module_items'] = $items;
                $j++;
            }
            $products2[$i]['modules'] = $modules;
            $i++;
        }

        return $products2;
    }

    //28-12-2021 view appointments function
    public function view_appointments($id)
    {
        $sql = "select appointments.*,rooms.name,contacts.name as c_name from appointments  inner join rooms on appointments.room=rooms.id inner join contacts on appointments.dozents=contacts.id where offer_id='$id'";
        $offersql = "select * from coaching_offers where id = '$id'";
        $appointments = DB::select($sql);
        $offer = DB::select($offersql);
        return view('panel.coaching_offers.view-appointments', [
            'title' => trans('header.view_appointments') . " | " . $offer[0]->name,
            'appointments' => $appointments,
        ]);
    }

    public function update_appointment(Request $request)
    {
        ini_set('memory_limit', '-1');
        require('fpdf17/fpdf.php');
        $data = $request->all(); $count = 0;$contact_id='';$course_id='';
        foreach ($data['appointment_ids'] as $key => $value) {
            $sql = "select appointments.*,rooms.name,contacts.name as c_name from appointments  inner join rooms on appointments.room=rooms.id inner join contacts on appointments.dozents=contacts.id where appointments.id='$value'";
            $appointments = DB::select($sql);
            if($appointments[0]->status != 1) {
                if (isset($data['appointments'][$value])) {
                    $status = 1;
                    $count++;
                    $contact_id = $appointments[0]->contact;
                    $course_id = $appointments[0]->course_id;
                    $offer_id = $appointments[0]->offer_id;
                } else {
                    $status = 4;
                }
                $sql = "UPDATE appointments SET status='$status' WHERE id='$value'";
                DB::update($sql);
            }    
        }
        $data_offer_id = $data['offer_id'];
        $offersql = "select * from coaching_offers where id = '$data_offer_id'";
        $offer_obj = DB::select($offersql);
        
        print_r($course_id);
        //Create appointments for the coachee
        \UserAppointments::instance()->check_all_accepted($request, $offer_obj[0]->course_id);
        
        $sql = "UPDATE coaching_offers SET status=2 WHERE id='$offer_obj[0]->id'";
        DB::update($sql);
        if($count > 0) {
            $this->get_pdf_template($offer_obj[0]->id);
            $this->send_email_coach($contact_id, $offer_obj[0]->id);
        }    
        return response()->json(['success'=>true,'message'=>trans("forms.approved_appointment_message")]);
    }
    
    //31-12-2021
    private function send_email_coach($coach_id, $course_id)
    {
        $coach_detail = DB::table('contacts')->where('id', $coach_id)->first();
        $offer_detail = DB::table('coaching_offers')->where('id', $course_id)->first();
        if ($coach_detail) {
            $email = $coach_detail->email;
            $status = 1; //$this->isValidEmail();
            if ($status) {
                //get appointment detail
                // $sql = "select appointments.*,rooms.name,contacts.name as c_name,courses.title as cc_title from appointments  inner join rooms on appointments.room=rooms.id inner join contacts on appointments.dozents=contacts.id inner join courses on appointments.course_id=courses.id where appointments.id='$appointment_id'";
                // $appointments = DB::select($sql);
                // if (count($appointments) > 0) {
                    $name = $coach_detail->name;
                    $email = $coach_detail->email;
                    $from = env('MAIL_USERNAME');
                    $title = 'Appointments Accepted';
                    $title_url = 'View Accepted Appointments';
                    $url = route('contacts.create-appointment',$course_id);
                    $text = 'Your appointments are approved of offer <b>' . $offer_detail->name . '</b>. Login and check it';
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
                        $message->from($from, 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject($title);
                    });
                    // echo"send email address"; die;
                // }
            }
        }
    }
    private function isValidEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    public function delete_coaching_offer($id)
    {
        //Delete only when the offer doesn't have any approved appointments
        $sql = "select appointments.*,rooms.name,contacts.name as c_name from appointments  inner join rooms on appointments.room=rooms.id inner join contacts on appointments.dozents=contacts.id where offer_id='$id'";
        $appointments = DB::select($sql);
        if (!isset($data['appointments'])) {
            $sql = "DELETE FROM appointments where offer_id='$id'";
            DB::update($sql);
            $sql = "DELETE FROM coaching_offers_products where coaching_offers_id='$id'";
            DB::update($sql);
            $sql = "DELETE FROM coaching_offers_modules where coaching_offer_id='$id'";
            DB::update($sql);
            $sql = "DELETE FROM coaching_offers_moduleitems where coaching_offers_id='$id'";
            DB::update($sql);
            $sql = "DELETE FROM coaching_offers where id='$id'";
            DB::update($sql);
        }
        return $this->view_offers();
    }

    public static function get_approved_ue($id) {
        $total_ue = DB::table('appointments')->where('status',1)->where('offer_id',$id)->sum('ue');
        return $total_ue;
    }

    public function edit_appointment(Request $request) {
        $data = $request->all();$count=0;$ids=array();
        foreach ($data['appointment_ids'] as $key => $value) {
            if (isset($data['appointments'][$value])) { 
                $count++;
                $ids[] = $value;
            }
        }
        if($count > 0) {
            Session::put('ids', $ids);
            $status = true;
            $message = 'success';
        } else {
            $status = false;
            $message = trans('forms.not_selected_appointment');
        }
        return response()->json(['status' => $status,'message' => $message]);
    }

    public function update_appointments() {
        if(Session::get('ids')) {
            $ids = Session::get('ids');
            $implode = implode(",",$ids);
            $sql = "select appointments.*,rooms.name,contacts.name as c_name from appointments  inner join rooms on appointments.room=rooms.id inner join contacts on appointments.dozents=contacts.id where appointments.id IN (".$implode.")";
            $appointments = DB::select($sql);
            return view('panel.coaching_offers.update-appointments', [
                'title' => trans('forms.update_appointments'),
                'appointments' => $appointments,
            ]);
        } else {
            return redirect()->route('admin.coaching-offers');
        }
    }

    public function save_appointment(Request $request) {
        $app_ids = $request->input('appointment_ids');
        $start_time = $request->input('start_time');
        $breaktime = $request->input('breaktime');
        $appointment_form = $request->input('appointment_form');
        $rooms = $request->input('rooms');
        // $end_time = $request->input('end_time');
        $offer_id = $request->input('offer_id');
        $dates = $request->input('dates');
        $errors = array();
        foreach ($app_ids as $key => $value) {
            if($rooms[$key] != '' && $start_time[$key] != '' && $dates[$key] != '' && $breaktime[$key] != '' && $appointment_form[$key] != '') {
                $sql = "select * from appointments where appointments.id='$value'";
                $appointments = DB::select($sql);
                $s_time = $start_time[$key];
                // $e_time = $end_time[$key];
                $e_time = $this->get_end_time($s_time,$appointments[0]->ue,$appointments[0]->breaktime);
                $date = $dates[$key];
                $btime = $breaktime[$key];
                $af = $appointment_form[$key];
                $r = $rooms[$key];
                //status = 5 = Changed thru admin
                // $breaktime = $this->get_break_time($s_time,$e_time,$appointments[0]->ue);
                $sql = "UPDATE appointments SET date='$date',time='$s_time',time_end='$e_time', status='5',breaktime='$btime',appointment_form='$af',room='$r' WHERE id='$value'";
                DB::update($sql);
            } else {
                $errors[] = 1;
            }    
        };
        if(empty($errors)) {
            $this->send_email_coach_edit($offer_id);   
            return response()->json(['success'=>true,'message'=>trans("forms.update_appointment_message")]);
        } else {
            return response()->json(['success'=>false,'message'=>trans("forms.fill_all_fields")]);
        }    
    }

    public function send_email_coach_edit($offer_id) {
        $offer_detail = DB::table('coaching_offers')->where('id', $offer_id)->first();
        $coach_detail = DB::table('contacts')->where('id', $offer_detail->coach_id)->first();
        if ($coach_detail) {
            $email = $coach_detail->email;
            $status = 1; //$this->isValidEmail();
            if ($status) {
                    $name = $coach_detail->name;
                    $email = $coach_detail->email;
                    $from = env('MAIL_USERNAME');
                    $title = 'Appointments Edit';
                    $title_url = 'View Edied Appointments';
                    if($offer_detail->status == 0) {
                        $url = route('contacts.create-appointment',$offer_id);
                    } else {
                        $url = route('contacts.view-appointment',$offer_id);
                    }
                    $text = 'Your some appointments are changed datetime of offer <b>' . $offer_detail->name . '</b>. Login and check it';
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
                        $message->from($from, 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject($title);
                    });
            }
        }
    }

    public function check_appointment(Request $request) {
        $data = $request->all();
        $appointment_detail = DB::table('appointments')->where('id',$data['id'])->first();
        $offer_detail = DB::table('coaching_offers')->where('id',$appointment_detail->offer_id)->first();
        if(strtotime($data['app_date']) >= strtotime($offer_detail->begin_date) && strtotime($data['app_date']) <= strtotime($offer_detail->end_date)) {

            $count = DB::table('appointments')->where('id','!=',$data['id'])->where('time','>=',$data['start_time'])->where('time_end','<=',$data['start_time'])->where('date',$data['app_date'])->count();
            if($count > 0) {
                $status = false;
                $message = "This date time is matched to other coach & coachee";
            } else {
                $status = true;
                $message = '';
            }
        } else {
            $status = false;
            $message = "This newly selected date must be within Angebot Begin-End Dates";
        }   

        return response()->json(['success' => $status,'message' => $message]);
    }

    private function get_break_time($startdate, $enddate,$hour)
    {
        //get end time 
        $ue = 45 * $hour;
        $time_ue = $ue * 60;
        $difference = strtotime($enddate)-strtotime($startdate);
        $breaktime = abs(($difference - $time_ue)/60);
        return $breaktime;
    }

    private function get_pdf_template($offer_id) {
        //get offer detail
        $offer_detail = DB::table('coaching_offers')->where('id',$offer_id)->first();
        if($offer_detail->pdf_file != '') {
            $coach_detail = DB::table('contacts')->where('id',$offer_detail->coach_id)->first();
            $course_detail =  DB::table('courses')->where('id',$offer_detail->course_id)->first(); 
            $product_details = $this->get_productmodule_detail($offer_id);
            $rooms = $this->get_room_detail($offer_id);
            $newpdf = PDF::loadView('panel.coaching_offers.teacher_lehrauftrag',compact('offer_detail','coach_detail','course_detail','product_details','rooms'));
            $newpdf->setOptions([
                'dpi' => 96,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'debugCss' => true
            ]);
            $teacher_lehrauftrag = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
            $newpdf->save('company_files/coaching_offers/' . $teacher_lehrauftrag);
        
            //DB PDf file in coaching offer
            DB::table('coaching_offers')->where('id',$offer_id)->update(["pdf_file" => $teacher_lehrauftrag]);
        }    
    }

    private function get_productmodule_detail($offer_id) {
        $products_detail = array();
        $products = DB::table('appointments')->where('offer_id',$offer_id)->where('status',1)->groupBy('product_id')->get();
        if(count($products) > 0) {
            foreach($products as $key) {
                $product_detail = DB::table('products')->where('id',$key->product_id)->first();
                $name = $product_detail->title." ".$product_detail->auth_no;
                //get module detail = 
                $modules = DB::table('appointments')->where('offer_id',$offer_id)->where('product_id',$key->product_id)->where('status',1)->groupBy('module_id')->get();
                $modules_detail = array();
                if(count($modules) > 0) {
                    foreach($modules as $key1) {
                        $m_detail = DB::table('modules')->where('id',$key1->module_id)->first();
                        $i_array = array();
                        $items = DB::table('appointments')->select('offer_id','item_id','product_id','module_id')->where('offer_id',$offer_id)->where('module_id',$key1->module_id)->where('product_id',$key->product_id)->where('status',1)->distinct()->get();
                        if(count($items) > 0) {
                            foreach($items as $key2) {
                                //get lession and price
                                $offer_item_detail = DB::table('coaching_offers_moduleitems')->where('coaching_offers_id',$key2->offer_id)->where('product_id',$key2->product_id)->where('module_id',$key2->module_id)->where('moduleitem_id',$key2->item_id)->first();
                                //item detail
                                $i_detail = DB::table('module_items')->where('id',$key2->item_id)->first();
                                $mi_totalUE = DB::table('appointments')->where('offer_id',$offer_id)->where('item_id',$i_detail->id)->where('module_id',$key1->module_id)->where('product_id',$key->product_id)->where('status',1)->sum('ue');
                                
                                $i_array[] = $i_detail->title." UE : ".$mi_totalUE;
                            }    
                        }
                        $i_array = array_unique($i_array);
                        $modules_detail[$m_detail->title] = $i_array;
                    }
                }
                $products_detail[$name] = $modules_detail;
            }    
        }
        return $products_detail;
    }

    private function get_room_detail($offer_id) {
        $rooms_d = DB::table('appointments')->select('room')->where('offer_id',$offer_id)->where('status',1)->distinct()->get();
        $rooms = array();
        if(count($rooms_d) > 0) {
           foreach($rooms_d as $key) {
               $room_detail = DB::table('rooms')->where('id',$key->room)->first();
               $location = DB::table('room_locations')->where('id',$room_detail->location)->first();
               $rooms[] = $location->name;
           }
        }
        $rooms = array_unique($rooms);
        return $rooms;
    }

    private function get_end_time($start_time,$ue,$breaktime) {
         //get end time 
         $ue = 45 * $ue;
         $time = date_format(new DateTime($start_time), 'H:i');
         $time_ue = $ue * 60;
         if($breaktime != '') {
            $break = $breaktime * 60;
         } else {
            $break = 60;
         }   
         $timestamp = strtotime($time) + $time_ue + $break;
         $end_time = date('H:i', $timestamp);
         return $end_time;
    }

    public function get_rooms(Request $request)
    {
        $select_date = $request->input('selected_date');
        $hours = $request->input("hour");
        $break = $request->input("break_time");
        $start_time = $request->input('start_time');

        //get end time 
        $time = date_format(new DateTime($start_time), 'H:i');
        $time_ue = 45 * $hours * 60;
        $break = $break * 60;
        $timestamp = strtotime($time) + $time_ue + $break;
        $end_time = date('H:i', $timestamp);

        $sql = "select * from rooms where id not in (
select distinct app.room /*, app.date, app.time time_start, app.time_end time_end*/ from appointments app where status != 3 
and app.date = '$select_date' and ( (('$start_time' between time and time_end) or ('$end_time' between time and time_end))  or 
 ((time between '$start_time' and '$end_time') or (time_end between '$start_time' and '$end_time')) ))";

        //get room detail
        $rooms = DB::select($sql);
        $option = "<option value=''>Bitte auswählen</option>";
        if (count($rooms) > 0) {
            foreach ($rooms as $key) {
                $option .= "<option value='" . $key->id . "'>" . $key->name . " (Kapazität: " . $key->capacity . ")</option>";
            }
            return response()->json(['success' => true, 'rooms' => $option]);
        } else {
            return response()->json(['success' => false, 'rooms' => $option, 'message' => 'No room available on this time']);
        }
    }

    public static function get_rooms_detail($date,$ue,$breaktime,$starttime,$roomId)
    {
        $select_date = $date;
        $hours = $ue;
        $break = $breaktime;
        $start_time = $starttime;
     
        //get end time 
        $time = date_format(new DateTime($start_time), 'H:i');
        $time_ue = 45 * $hours * 60;
        $break = $break * 60;
        $timestamp = strtotime($time) + $time_ue + $break;
        $end_time = date('H:i', $timestamp);

        $sql = "select * from rooms where id not in (
select distinct app.room /*, app.date, app.time time_start, app.time_end time_end*/ from appointments app where status != 3 
and app.date = '$select_date' and ( (('$start_time' between time and time_end) or ('$end_time' between time and time_end))  or 
 ((time between '$start_time' and '$end_time') or (time_end between '$start_time' and '$end_time')) ))";

        //get room detail
        $rooms = DB::select($sql);
        $sql = "select * from rooms where id='$roomId'";
        $rooms1 = DB::select($sql);
        $option = "<option value=''>Bitte auswählen</option>";
        foreach ($rooms1 as $key) {
            $option .= "<option value='" . $key->id . "' selected='selected'>" . $key->name . " (Kapazität: " . $key->capacity . ")</option>";
        }
        if (count($rooms) > 0) {
            foreach ($rooms as $key) {
                if($key->id == $roomId) {
                    $option .= "<option value='" . $key->id . "' selected='selected'>" . $key->name . " (Kapazität: " . $key->capacity . ")</option>";
                } else {
                    $option .= "<option value='" . $key->id . "'>" . $key->name . " (Kapazität: " . $key->capacity . ")</option>";
                }
                
            }
            $option;
        }
        return $option;
    }
}
