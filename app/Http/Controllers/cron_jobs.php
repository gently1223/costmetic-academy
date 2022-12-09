<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;
use Mail;

class cron_jobs extends Controller
{
    public function send_voucher_reminder(Request $request)
    {
        $t_date=date('Y-m-d');
        $row=DB::select("SELECT id, name, email, vouchers, voucher_reminder FROM contacts WHERE vouchers='' AND type='Student'");
        foreach($row as $r)
        {
            //echo $r->voucher_reminder.'<br>';
            $reminder_date = new DateTime($r->voucher_reminder);
            $reminder_date->modify("+2 days");
            $reminder_date=$reminder_date->format("Y-m-d");
            //echo $reminder_date.'<br><br>';
            
            if($r->voucher_reminder=='0000-00-00' OR $reminder_date<=$t_date)
            {
                //send voucher reminder to student
                $email=$r->email;
                $name=$r->name;
                $title='Reminder for Voucher';
                
                $text='This is a reminder that we have not recieved the voucher from you. Please provide it at the earliest, you can send it to the email - support@nextlevelakademie.com<br><br>
                Thank you.<br>
                NextLevel Akademie';
                //send email alert START
                $from=env('MAIL_USERNAME');
                $data2=array(
                    'title'=>$title,
                    'name'=>$name,
                    'text'=>$text,
                    'email'=>$email,
                    'from'=>$from
                );
                Mail::send('emails.notification', $data2, function($message) use($email, $from, $title) {
                    $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject($title);
                });
                //send email alert END
                
                DB::update("UPDATE contacts SET voucher_reminder='$t_date' WHERE id='$r->id'");
            }
        }
        
        $row=DB::select("SELECT id, expiry_date, on_date, c_id, type FROM contracts WHERE document='0' AND status='0' AND reminder='0'");
        foreach($row as $r)
        {
            //echo $r->voucher_reminder.'<br>';
            if($r->expiry_date=='0000-00-00') 
            {
                $date=new DateTime($r->on_date);
                $date=$date->format("Y-m-d");
                $r->expiry_date=$date;
                DB::update("UPDATE contracts SET expiry_date='$date' WHERE id='$r->id'");
            }
            
            $reminder_date = new DateTime($r->expiry_date);
            $reminder_date->modify("-1 day");
            $reminder_date=$reminder_date->format("Y-m-d");
            //echo $reminder_date.'<br><br>';
            
            if($reminder_date<=$t_date)
            {
                //send voucher reminder to student
                //echo 'send reminder<br>'; continue;
                $type=$r->type;
                if($type=='Standard contract for Coach / Trainer') $type=trans('forms.standard_contract_for_coach_trainer');
                else if($type=='Coaching Contract for Coachee') $type=trans('forms.coaching_contract_for_coachee');
                else if($type=='Education Contract for Student') $type=trans('forms.education_contract_for_student');
                else if($type=='Extended Education Contract for Student') $type=trans('forms.extended_education_contract_for_student');
                else if($type=='Retraining Contract for Coachee / Student') $type=trans('forms.retraining_contract_for_coachee_student');
                else if($type=='Amendments to Retraining Contract') $type=trans('forms.amendments_to_retraining_contract');
                else if($type=='Contract for Student / Coachee Internship') $type=trans('forms.contract_for_student_coachee_internship');
                else if($type=='Private Jobsearch contract for Student / Coachee') $type=trans('forms.private_jobsearch_contract_for_student_coachee');
                
                $contact=DB::select("SELECT id, name, email FROM contacts WHERE id='$r->c_id' LIMIT 1");
                $contact=collect($contact)->first();
                $email=$contact->email;
                $name=$contact->name;
                $title='Reminder for Contract';
                
                $text='This is a reminder that your contract "'.$type.'" will be expired within 24 hours. Please sign the contract before it expires.';
                $url_title='Sign now';
                $url=url('contract/'.$r->id);
                //send email alert START
                $from=env('MAIL_USERNAME');
                $data2=array(
                    'title'=>$title,
                    'name'=>$name,
                    'text'=>$text,
                    'email'=>$email,
                    'from'=>$from,
                    'url'=>$url,
                    'title_url'=>$url_title
                );
                Mail::send('emails.notification', $data2, function($message) use($email, $from, $title) {
                    $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject($title);
                });
                //send email alert END
                
                DB::update("UPDATE contracts SET reminder='1' WHERE id='$r->id'");
            }
        }
    }
}
