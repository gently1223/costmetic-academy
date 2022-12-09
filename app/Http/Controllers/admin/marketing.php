<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class marketing extends Controller
{
    public function subscribers(Request $request)
    {
        $subscribers=array(); $i=0;
        $row=DB::select("SELECT * FROM contacts WHERE newsletter='1' OR double_opt_in='1'");
        foreach($row as $r)
        {
            $subscribers[$i]['contact']=$r;
            
            $subscribers[$i]['regular']='';
            $subscribers[$i]['coaching']='';
            $j=0;
            $row2=DB::select("SELECT * FROM contracts WHERE c_id='$r->id' ORDER BY id ASC");
            foreach($row2 as $r2)
            {
                $row3=DB::select("SELECT title, type FROM courses WHERE id='$r2->course_id' LIMIT 1");
                if(count($row3)==0) continue;
                $row3=collect($row3)->first();
                
                $comma='';
                if($j++!=0) $comma=', ';
                if($row3->type=='Regular') $subscribers[$i]['regular'].=$comma.$row3->title;
                else if($row3->type=='Coaching') $subscribers[$i]['coaching'].=$comma.$row3->title;
            }
            
            if($r->type=='Prospect') $type=trans('forms.prospect');
            else if($r->type=='Employee') $type=trans('forms.employee');
            else if($r->type=='Expert Advisor') $type=trans('forms.expert_advisor');
            else if($r->type=='Coach') $type=trans('forms.coach');
            else if($r->type=='Lecturer') $type=trans('forms.lecturer');
            else if($r->type=='Student') $type=trans('forms.student');
            else if($r->type=='Internship Company') $type=trans('forms.internship_company');
            else if($r->type=='Other Contacts') $type=trans('forms.other_contacts');
            
            $subscribers[$i]['type']=$type;
            
            $i++;
        }
        
        return view('panel.subscribers.index', ['title'=>trans('header.subscribers'), 'subscribers'=>$subscribers]);
    }
    
    public function export_subscribers(Request $request)
    {
        $date = date('Y.m.d');
	    $date = rtrim($date);
	    $folder = "subscribers";
        
        $fname = "$folder/$date.csv";
	    $fp = fopen($fname, "w");
        
        //$data=array('');
        //fputcsv($fp, $data, ',', ' ');
        fprintf($fp, "Email, First Name, Last Name, Contact Type, Kombigruppe, Coaching\n");
        $subscribers=array(); $i=0;
        
        if($request->input('users')!='')
        {
            $users=explode(',', $request->input('users'));
            $ids=''; $i2=0;
            foreach($users as $u)
            {
                if($i2++==0) $ids.=' id='.$u;
                else $ids.=' OR id='.$u;
            }
            $row=DB::select("SELECT * FROM contacts WHERE (newsletter='1' OR double_opt_in='1') AND ($ids)");
        }
        else
        $row=DB::select("SELECT * FROM contacts WHERE newsletter='1' OR double_opt_in='1'");
        foreach($row as $r)
        {
            $subscribers[$i]['contact']=$r;
            
            $subscribers[$i]['regular']='';
            $subscribers[$i]['coaching']='';
            $j=0;
            $row2=DB::select("SELECT * FROM contracts WHERE c_id='$r->id' ORDER BY id ASC");
            foreach($row2 as $r2)
            {
                $row3=DB::select("SELECT title, type FROM courses WHERE id='$r2->course_id' LIMIT 1");
                if(count($row3)==0) continue;
                $row3=collect($row3)->first();
                
                $comma='';
                if($j++!=0) $comma=', ';
                if($row3->type=='Regular') $subscribers[$i]['regular'].=$comma.$row3->title;
                else if($row3->type=='Coaching') $subscribers[$i]['coaching'].=$comma.$row3->title;
            }
            
            if($r->type=='Prospect') $type=trans('forms.prospect');
            else if($r->type=='Employee') $type=trans('forms.employee');
            else if($r->type=='Expert Advisor') $type=trans('forms.expert_advisor');
            else if($r->type=='Coach') $type=trans('forms.coach');
            else if($r->type=='Lecturer') $type=trans('forms.lecturer');
            else if($r->type=='Student') $type=trans('forms.student');
            else if($r->type=='Internship Company') $type=trans('forms.internship_company');
            else if($r->type=='Other Contacts') $type=trans('forms.other_contacts');
            
            $regular=$subscribers[$i]['regular'];
            $coaching=$subscribers[$i]['coaching'];
            $name=explode(' ',$r->name);
            
            $first_name=$name[0];
            $last_name='';
            if(isset($name[1])) $last_name=$name[1];
            
            fprintf($fp, "$r->email, $first_name, $last_name, $type, $regular, $coaching\n");
        }
        
        fclose($fp);
        
        header("Content-Type: application/csv");
        header("Content-Disposition: csv; filename=$fname");
        header("Content-Length: " . filesize($fname));

        readfile($fname);
        exit();
    }
}
