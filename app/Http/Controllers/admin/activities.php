<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class activities extends Controller
{
    public function activities(Request $request)
    {
        $activities=array(); $i=0;
        $log=DB::select("SELECT id, user_id, user_type, activity, on_date FROM activity_log ORDER BY id DESC LIMIT 200");
        if(!empty($log)) 
        {
            foreach($log as $l)
            {
                $user=DB::select("SELECT id, name, username FROM users WHERE id='$l->user_id' LIMIT 1");
                if(count($user)==0) continue;
                $user=collect($user)->first();
                
                $activities[$i]['activity']=$l;
                
                
                $activities[$i]['user']=$user;
                
                $i++;
            }
        }
        return view('panel.activities.index', ['title'=>trans('header.activities'), 'activities'=>$activities]);
    }
}
