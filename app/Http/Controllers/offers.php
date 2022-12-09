<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use DB;
use Mail;
use Validator;

class offers extends Controller
{
    public static function get_approved_ue($id) {
        $total_ue = DB::table('appointments')->where('status',1)->where('offer_id',$id)->sum('ue');
        return $total_ue;
    }
    //
    public function view(Request $request)
    {
        $user_id = $request->session()->get('id');
        $offers = DB::select("SELECT coaching_offers.*,courses.title FROM coaching_offers INNER JOIN courses ON coaching_offers.course_id = courses.id WHERE coach_id='$user_id' ORDER BY id DESC");
        return view('coaching_offers.index', ['title' => trans('header.offer'), 'offers' => $offers]);
    }

    public function create_appointment(Request $request, $id)
    {
        $user_id = $request->session()->get('id');
        $offers = DB::table('coaching_offers')->where('id', $id)->where('coach_id', $user_id)->count();
        if ($offers) {
            $row = DB::select("SELECT coaching_offers.*,contacts.name as con_name,courses.title FROM coaching_offers INNER JOIN courses ON coaching_offers.course_id = courses.id INNER JOIN contacts ON coaching_offers.coach_id=contacts.id WHERE coaching_offers.id='$id' LIMIT 1");
            $row = collect($row)->first();
            $products = $this->getmodule_product($id);
            $items =  DB::SELECT("SELECT coaching_offers_moduleitems.id, coaching_offers_moduleitems.moduleitem_id,coaching_offers_moduleitems.lessons,coaching_offers_moduleitems.price_lesson,module_items.title FROM coaching_offers_moduleitems INNER JOIN module_items ON coaching_offers_moduleitems.moduleitem_id=module_items.id WHERE coaching_offers_id='$id'");

            $sql = "select appointments.*,rooms.name from appointments  inner join rooms on appointments.room=rooms.id where contact='$user_id' and offer_id='$id'";
            $appointments = DB::select($sql);

            return view('coaching_offers.create-appointment', [
                'title' => $row->title . ' | ' . $row->name . ' | ' . trans('forms.appointments'),
                'products' => $products,
                'offer_detail'  => $row,
                'items' => $items,
                'appointments' => $appointments
            ]);
        } else {
            session()->flash('error', trans('dashboard.no_detail'));
            return redirect()->route('contacts.view');
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

    public function get_lession(Request $request)
    {
        $offer_id = $request->input('offer_id');
        $item_id  = $request->input('item_id');
        $item_detail = DB::table('coaching_offers_moduleitems')->where('coaching_offers_id', $offer_id)->where('id', $item_id)->first();
        if ($item_detail) {
            return response()->json(['success' => true, 'message' => 'success', 'detail' => $item_detail]);
        } else {
            return response()->json(['success' => false, 'message' => 'success']);
        }
    }

    public function manage_appointment(Request $request)
    {
        $offer_id         = $request->input("offer_id");
        $offer_detail     = $this->get_offer_detail($offer_id);
        $dates            = $request->input("dates");
        $items            = $request->input("items");
        $hours            = $request->input('hours');
        $breaks           = $request->input('breaks');
        $start_time       = $request->input('start_time');
        $appointment_form = $request->input('appointment_form');
        $rooms            = $request->input('rooms');
        $appointment_form = $request->input('appointment_form');
        if ($request->has("dates")) {
            //save appointment detail on table
            $errors = [];
            $i = 1;
            $x = 0;
            $insert = [];
            //check for validation
            foreach ($dates as $key => $value) {
                if ($value != '' && $hours[$key] != '' && $breaks[$key] != '' && $start_time[$key] != '' && $rooms[$key] != '') {
                    $hour    = $hours[$key];
                    if($hour == 0) {
                        $errors[] = "Line ".$i." UE is 0";
                    }
                }else {
                    $errors[] = "Line ".$i." ".trans("forms.fill_all_fields");
                }
                $i++;
            } 
            if(count($errors) > 0) {
                $implode_errors = implode("<br>",$errors);
                return response()->json(['success' => false, 'message' => $implode_errors]);
            }       
            foreach ($dates as $key => $value) {
                if ($value != '' && $hours[$key] != '' && $breaks[$key] != '' && $start_time[$key] != '' && $rooms[$key] != '') {
                    $hour    = $hours[$key];
                    if($hour > 0) {
                        $break   = $breaks[$key];
                        $start   = $start_time[$key];
                        $detail  = $this->get_module_item($items[$key]);
                        //get end date 
                        $end_date = $this->get_end_date($start, $hour, $break);
                        $insert[$x]['contact']                = $offer_detail->coach_id;
                        $insert[$x]['room']                   = $rooms[$key];
                        $insert[$x]['title']                  = $detail[0]->m_title . " > " . $detail[0]->mt_title;;
                        $insert[$x]['description']            = " ";
                        $insert[$x]['date']                   = $value;
                        $insert[$x]['time']                   = $start;
                        $insert[$x]['time_end']               = $end_date;
                        $insert[$x]['added_by']               = $offer_detail->coach_id;
                        $insert[$x]['added_on']               = date("Y-m-d h:i:s");
                        $insert[$x]['recurring']              = "0";
                        $insert[$x]['until']                  = "0";
                        $insert[$x]['parent']                 = "0";
                        $insert[$x]['contract_id']            = "0";
                        $insert[$x]['course_id']              = $offer_detail->course_id;
                        $insert[$x]['status']                 = "0";
                        $insert[$x]['product_id']             = $detail[0]->product_id;
                        $insert[$x]['module_id']              = $detail[0]->module_id;
                        $insert[$x]['item_id']                = $detail[0]->moduleitem_id;
                        $insert[$x]['type']                   = '2'; //2 type is used for appointment with courses (coaching / regular course)
                        $insert[$x]['reminder']               = "0";
                        $insert[$x]['category']               = "0";
                        $insert[$x]['user_type']              = "0";
                        $insert[$x]['ue']                     = $hour;
                        $insert[$x]['dozents']                = $offer_detail->coach_id;
                        $insert[$x]['teaching_form']          = "0";
                        $insert[$x]['teaching_method']        = "0";
                        $insert[$x]['appointment_form']       = $appointment_form[$key];
                        $insert[$x]['offer_id']               = $offer_id;
                        $insert[$x]['breaktime']              = $breaks[$key];
                        $x++;
                    }
                } else {
                    $errors[] = $i;
                }
                $i++;
            }
            if (count($dates) == count($errors)) {
                return response()->json(['success' => false, 'message' => trans("forms.fill_all_fields")]);
            } else {
                if (count($errors) == 0) {
                    DB::table('appointments')->insert($insert);
                    session()->flash('success', trans("forms.appointment_created_message"));
                    return response()->json(['success' => true, 'message' => trans("forms.appointment_created_message")]);
                } else {
                    $implode = implode(',', $errors);
                    $message = "Line " . $implode . " of fill all fields";
                    return response()->json(['success' => false, 'message' => $message]);
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => trans("forms.select_one_field_error")]);
        }
    }
    private function get_offer_detail($id)
    {
        $detail = DB::table("coaching_offers")->where('id', $id)->first();
        return $detail;
    }
    private function get_end_date($time, $hour, $break)
    {
        //get end time 
        $ue = 45 * $hour;
        $time = date_format(new DateTime($time), 'H:i');
        $time_ue = $ue * 60;
        $break = $break * 60;
        $timestamp = strtotime($time) + $time_ue + $break;
        $end_time = date('H:i', $timestamp);
        return $end_time;
    }

    private function get_module_item($id)
    {
        $sql = "select com.*,p.title as p_title,m.title as m_title,mi.title as mt_title from coaching_offers_moduleitems com inner join products p on com.product_id=p.id inner join modules m on com.module_id=m.id inner join module_items mi on com.moduleitem_id=mi.id where com.id='$id'";
        $detail = DB::select($sql);
        return  $detail;
    }

    public function check_ue(Request $request)
    {
        $offer_id = $request->input('offer_id');
        $item_id  = $request->input('item_id');
        $contact_id = $request->input('contact_id');
        $item_detail = DB::table('coaching_offers_moduleitems')->where('coaching_offers_id', $offer_id)->where('id', $item_id)->first();
        if ($item_detail) {
            //check appointment
            $total_hours = DB::table('appointments')->where('offer_id',$offer_id)->where('product_id',$item_detail->product_id)->where('module_id',$item_detail->module_id)->where('item_id',$item_detail->moduleitem_id)->where('offer_id',$item_detail->coaching_offers_id)->where('contact',$contact_id)->sum('ue');
            return response()->json(['success' => true, 'message' => 'success', 'ue' => $total_hours]);
        } else {
            return response()->json(['success' => false, 'message' => 'no detail found']);
        }
    }

    public function create_final_appointments(Request $request) {
        $offer_id = $request->input('offer_id');
        $offer_detail = DB::table('coaching_offers')->where('id', $offer_id)->first();

        $total_hours = DB::table('appointments')->where('offer_id',$offer_id)->sum('ue');
        $total_rows = DB::table('appointments')->where('offer_id',$offer_id)->count();
        if($offer_detail->min_appt_per_week <= $total_rows) {
           if($total_hours >= $offer_detail->min_ue_per_week) {
                //send email to admin for new appointments
                $this->send_email($offer_id);
                DB::table('coaching_offers')->where('id',$offer_id)->update(['status' => 1]);
                return response()->json(['success' => true,'message' => trans("forms.appointments_submit_success")]);
           } else {
              return response()->json(['success' => false,'message' => trans("forms.min_ue_message")]);
           }
        } else {
            return response()->json(['success' => false,'message' => trans("forms.min_apt_message")]);
        }
    }
    private function send_email($id) 
    {
        //get admin detail
        $admin_detail = DB::table('users')->where('type',2)->first();
        $offer_detail = DB::table('coaching_offers')->where('id',$id)->first();
        $contact_detail = DB::table('contacts')->where('id',$offer_detail->coach_id)->first();
        $name = $admin_detail->name;
        $email = $admin_detail->email;
        $from = env('MAIL_USERNAME');
        $title = 'New Appointments for approvel';
        $title_url = 'View and Approvel';
        $url = route('admin.view-appointments', $offer_detail->id);
        $text = 'You have received new appointments for approvel of <b>' . $offer_detail->name . '</b>. and received from '.$contact_detail->name.' Login and Approve now.';
        $data2 = array(
            'email' => $email,
            'from' => $from,
            'name' => $name,
            'title' => $title,
            'title_url' => $title_url,
            'text' => $text,
            'url' => $url
        );
        Mail::send('emails.approvel_notification', $data2, function ($message) use ($email, $from, $name, $title) {
            $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
            $message->to($email);
            $message->subject($title);
        });
    }

    public function accept_appointments(Request $request) {
        $data = $request->all(); $contact_id ='';$course_id = '';$count=0;
        foreach ($data['appointment_ids'] as $key => $value) {
            $sql = "select appointments.*,rooms.name,contacts.name as c_name from appointments inner join rooms on appointments.room=rooms.id inner join contacts on appointments.dozents=contacts.id where appointments.id='$value'";
            $appointments = DB::select($sql);
            if (isset($data['appointments'][$value])) {
                $status = 0;
                $count++;
                $contact_id = $appointments[0]->contact;
                $offer_id = $appointments[0]->offer_id;
                $sql = "UPDATE appointments SET status='$status' WHERE id='$value'";
                DB::update($sql);
            }
        }
        if($count > 0) {
            $this->send_email_one($data['offer_id']);
            return response()->json(['success'=>true,'message'=>trans("forms.accept_appointment_message")]);
        } else {
            return response()->json(['success'=>false,'message'=>'Please select atleast one appointment']);
        }   
        
    }
    private function send_email_one($id) 
    {
        //get admin detail
        $admin_detail = DB::table('users')->where('type',2)->first();
        $offer_detail = DB::table('coaching_offers')->where('id',$id)->first();
        $contact_detail = DB::table('contacts')->where('id',$offer_detail->coach_id)->first();
        $name = $admin_detail->name;
        $email = $admin_detail->email;
        $from = env('MAIL_USERNAME');
        $title = 'Changed Appointments Accepted';
        $title_url = 'View and Approvel';
        $url = route('admin.view-appointments', $offer_detail->id);
        $text = 'Changed appointments are accepted by <b>'.$contact_detail->name.'</b> of offer <b>'.$offer_detail->name.'</b> Login and Approve now.';
        $data2 = array(
            'email' => $email,
            'from' => $from,
            'name' => $name,
            'title' => $title,
            'title_url' => $title_url,
            'text' => $text,
            'url' => $url
        );
        Mail::send('emails.approvel_notification', $data2, function ($message) use ($email, $from, $name, $title) {
            $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
            $message->to($email);
            $message->subject($title);
        });
    }
}
