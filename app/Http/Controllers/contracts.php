<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;

class contracts extends Controller
{
    public function index(Request $request)
    {
        $user_id=$request->session()->get('id');
        
        $contracts=array(); $i=0;
        
        $row=DB::select("SELECT * FROM contact_courses WHERE coach='$user_id' ORDER BY id DESC");
        foreach($row as $r)
        {
            $row2=DB::select("SELECT * FROM contracts WHERE id='$r->contract_id' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $contracts[$i]['contract']=$row2;
                
                $contracts[$i]['sign_btn']=0;
                if($row2->coach_signature=='') $contracts[$i]['sign_btn']=1;
            }
            
            $i++;
        }
        
        $t_date=date('Y-m-d');
        $row=DB::select("SELECT * FROM contracts WHERE c_id='$user_id' AND document='0' AND status!='3' ORDER BY id DESC");
        foreach($row as $r)
        {
            $contracts[$i]['contract']=$r;
            
            $contracts[$i]['sign_btn']=0;
            if($r->signature=='' AND $r->status=='0')
            {
                $contracts[$i]['sign_btn']=1;
                $date=new DateTime($r->on_date);
                $date=$date->format("Y-m-d");
                if($r->expiry_date=='0000-00-00')
                {
                    $r->expiry_date=$date;
                    DB::update("UPDATE contracts SET expiry_date='$date' WHERE id='$r->id'");
                }
                
                $expiry_date = new DateTime($r->expiry_date);
                $expiry_date->modify("+2 days");
                $expiry_date=$expiry_date->format("Y-m-d");
                
                if($t_date>=$expiry_date)
                {
                    //echo 'Expired.<br>';
                    DB::update("UPDATE contracts SET status='3' WHERE id='$r->id'");
                    $contracts[$i]['sign_btn']=0;
                }
            }
            $i++;
        }
        return view('contracts.index', ['title'=>'My Contracts', 'contracts'=>$contracts]);
    }
}