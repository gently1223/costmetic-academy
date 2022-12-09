<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use Mail;
use DB;

class to_do extends Controller
{
    public function to_do(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {   
            $delete=addslashes($request->input('delete'));
            DB::delete("DELETE FROM todos WHERE id='$delete'");
            $request->session()->flash('success', 'To-Do item has been deleted successfully.');
            
            return redirect('admin/to-do');
        }
        
        if($request->input('title')!='')
        {
            $title=addslashes($request->input('title'));
            $priority=addslashes($request->input('priority'));
            $description=addslashes($request->input('description'));
            $due_date=addslashes($request->input('due_date'));
            $due_date=date_format(new DateTime($due_date),'Y-m-d');
            
            DB::insert("INSERT INTO todos (title, priority, description, due_date, added_by, added_on) VALUES ('$title', '$priority', '$description', '$due_date', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            return redirect('admin/to-do');
        }
        
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
        $task_contacts=DB::select("SELECT id, name FROM contacts WHERE type!='Prospect' AND type!='Internship Company'");
        $task_users=DB::select("SELECT id, name FROM users WHERE id!='$admin_id'");
        return view('panel.to_do.index', ['title'=>trans('header.todo'), 'todos'=>$todos, 'task_contacts'=>$task_contacts, 'task_users'=>$task_users]);
    }
    
    public function manage_todos(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        $data=array();
        $data['success']=0;
        $data['edit']=0;
        
        if($request->input('delete_todo')!='' AND $request->input('delete_todo')!='0')
        {
            $id=$request->input('delete_todo');
            
            //track Activity START
            $row=DB::select("SELECT id, title FROM todos WHERE id='$id' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=addslashes($row->title);
            \CommonFunctions::instance()->log_activity($request, 'Deleted to-do - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM todos WHERE id='$id'");
            $data['success']=1;
            return response()->json($data);
        }
        
        if($request->input('t_id')=='0')
        {
            $title=addslashes($request->input('title'));
            $priority=addslashes($request->input('priority'));
            $description=addslashes($request->input('description'));
            $due_date=addslashes($request->input('due_date'));
            $due_date=date_format(new DateTime($due_date),'Y-m-d');
            $user_type='2';
            $assign_to=addslashes($request->input('assign_to'));
            $asg=explode('-', $assign_to); 
            if($asg[0]=='contact') { $assign_to=$asg[1]; $user_type='2'; }
            else if(isset($asg[1])) { $assign_to=$asg[1]; $user_type='1'; }
            else $assign_to=0;
            
            if($request->input('reminder')!='') $reminder='1';
            else $reminder='0';
            $reminder_date=$request->input('reminder_date');
            $reminder_date=date_format(new DateTime($reminder_date),'Y-m-d H:i:00');
            
            $file_name='';
            if($request->file('file')!=''){
                $file=$request->file('file');
            
                //Move Uploaded File
                $destinationPath = 'to_do_files/';
                $file_name=$file->getClientOriginalName();
                $array=explode('.', $file_name);
                $file_name=$array[0];
                $ext=$array[1];
                $file_name=rand(pow(10, 4-1), pow(10, 4)-1).'.'.$ext;
                $fileName = $destinationPath . $file_name; // renameing file
                
                if($file->move($destinationPath,$file_name)) {
                }
            }
            
            DB::insert("INSERT INTO todos (title, priority, description, due_date, assign_to, file, reminder, reminder_date, added_by, added_on, user_type) VALUES ('$title', '$priority', '$description', '$due_date', '$assign_to', '$file_name', '$reminder', '$reminder_date', '$admin_id', NOW(), '$user_type')");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            $name=$title;
            \CommonFunctions::instance()->log_activity($request, 'Created a to-do - #'.$id.' '.$name);
            //track Activity END
            
            $image='';
            if($user_type=='2')
            $contact=DB::select("SELECT id, name, profile_image FROM contacts WHERE id='$assign_to' LIMIT 1");
            else
            $contact=DB::select("SELECT id, name, profile_image FROM users WHERE id='$assign_to' LIMIT 1");
            if(count($contact)==1)
            {
                $contact=collect($contact)->first();
                if($contact->profile_image!='')
                    $url=url('images/profile/'.$contact->profile_image);
                else
                    $url=url('images/avatar.jpg');
                $image='<img width="42" class="rounded" src="'.$url.'" alt="'.$contact->name.'" title="'.$contact->name.'">';
            }
            
            $due_date=date_format(new DateTime($due_date),'d-m-Y');
            
            $mark='';
            if($priority=='1') $mark=" <i class='fa fa-arrow-up' style='color:red; font-weight:bold;'></i>";
            else if($priority=='2') $mark=" <i class='fa fa-arrow-up' style='color:green; font-weight:bold;'></i>";
            else if($priority=='3') $mark=" <i class='fa fa-arrow-down' style='color:yellow; font-weight:bold;'></i>";
            
            $data['task']='<li class="list-group-item" id="task-'.$id.'">
                                                                        <div class="todo-indicator bg-info"></div>
                                                                        <div class="widget-content p-0">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left mr-2">
                                                                                     <div class="custom-checkbox custom-control">
                                                                                        <input type="checkbox" name="todo" value="'.$id.'" onclick="update_status(this)" id="exampleCustomCheckbox'.$id.'" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox'.$id.'">&nbsp;</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="widget-content-left mr-3">
                                                                                    <div class="widget-content-left">
                                                                                        '.$image.'
                                                                                    </div>
                                                                                </div>
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading">'.$title.' '.$mark.'
                                                                                    </div>
                                                                                    <div class="widget-subheading">'.$description.'
                                                                                    </div>';
            
                                                                                    $data['task'].='<div class="widget-subheading">';
                                                                            $due_date=date_format(new DateTime($due_date),'d-m-Y');
                                                                            if(date('d-m-Y')>$due_date) $s='end';
                                                                            else $s='start';
            
                                                                                        $data['task'].='<i class="fa fa-hourglass-'.$s.'"></i> <font style="text-decoration:underline;">'.$due_date.'</font> &nbsp;';
            
                                                                                        if(!empty($file_name))
                                                                                        $data['task'].='<i class="fa fa-paperclip"></i> <a href="'.url('to_do_files/'.$file_name).'" target="_blank" style="text-decoration:underline;">'.$file_name.'</a> &nbsp;';
                                                                                        
                                                                                        if($reminder=='1')
                                                                                        $data['task'].='<i class="fa fa-bell"></i> <font style="text-decoration:underline;">'.date_format(new DateTime($reminder_date),'d-m-Y h:i a').'</font>';
                                                                                    
                                                                                    $data['task'].='</div>';

                                                                                $data['task'].='</div>
                                                                                <div class="widget-content-right">
                                                                                    <button class="border-0 btn-transition btn btn-outline-success" onclick="edit_task(\''.$id.'\', \''.$title.'\', \''.$priority.'\', \''.$description.'\', \''.$due_date.'\', \''.$assign_to.'\', \''.$reminder.'\', \''.date_format(new DateTime($reminder_date),'d-m-Y h:i A').'\')" data-toggle="modal" data-target="#add-task">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>
                                                                                    <button class="border-0 btn-transition btn btn-outline-danger">
                                                                                        <i class="fa fa-trash-alt"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>';
            $data['success']=1;
        }
        
        if($request->input('t_id')!='0')
        {
            $id=addslashes($request->input('t_id'));
            $title=addslashes($request->input('title'));
            $priority=addslashes($request->input('priority'));
            $description=addslashes($request->input('description'));
            $due_date=addslashes($request->input('due_date'));
            $due_date=date_format(new DateTime($due_date),'Y-m-d');
            $user_type='2';
            $assign_to=addslashes($request->input('assign_to'));
            $asg=explode('-', $assign_to); 
            if($asg[0]=='contact') { $assign_to=$asg[1]; $user_type='2'; }
            else if(isset($asg[1])) { $assign_to=$asg[1]; $user_type='1'; }
            else $assign_to=0;
            
            if($request->input('reminder')!='') $reminder='1';
            else $reminder='0';
            $reminder_date=$request->input('reminder_date');
            $reminder_date=date_format(new DateTime($reminder_date),'Y-m-d H:i:00');
            
            if($request->file('file')!=''){
                $file=$request->file('file');
            
                //Move Uploaded File
                $destinationPath = 'to_do_files/';
                $file_name=$file->getClientOriginalName();
                $array=explode('.', $file_name);
                $file_name=$array[0];
                $ext=$array[1];
                $file_name=rand(pow(10, 4-1), pow(10, 4)-1).'.'.$ext;
                $fileName = $destinationPath . $file_name; // renameing file
                
                if($file->move($destinationPath,$file_name)) {
                    DB::update("UPDATE todos SET file='$file_name' WHERE id='$id'");
                }
            }
            else{
                $todo=DB::select("SELECT file FROM todos WHERE id='$id' LIMIT 1");
                $todo=collect($todo)->first();
                $file_name=$todo->file;
            }
            
            DB::update("UPDATE todos SET title='$title', priority='$priority', description='$description', due_date='$due_date', assign_to='$assign_to', reminder='$reminder', reminder_date='$reminder_date', user_type='$user_type' WHERE id='$id'");
            
            //track Activity START
            $name=$title;
            \CommonFunctions::instance()->log_activity($request, 'Updated to-do - #'.$id.' '.$name);
            //track Activity END
            
            $image='';
            $contact=DB::select("SELECT id, name, profile_image FROM contacts WHERE id='$assign_to' LIMIT 1");
            if(count($contact)==1)
            {
                $contact=collect($contact)->first();
                if($contact->profile_image!='')
                    $url=url('images/profile/'.$contact->profile_image);
                else
                    $url=url('images/avatar.jpg');
                $image='<img width="42" class="rounded" src="'.$url.'" alt="'.$contact->name.'" title="'.$contact->name.'">';
            }
            
            $due_date=date_format(new DateTime($due_date),'d-m-Y');
            
            $mark='';
            if($priority=='1') $mark=" <i class='fa fa-arrow-up' style='color:red; font-weight:bold;'></i>";
            else if($priority=='2') $mark=" <i class='fa fa-arrow-up' style='color:green; font-weight:bold;'></i>";
            else if($priority=='3') $mark=" <i class='fa fa-arrow-down' style='color:yellow; font-weight:bold;'></i>";
            
            $data['task']='
                                                                        <div class="todo-indicator bg-info"></div>
                                                                        <div class="widget-content p-0">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left mr-2">
                                                                                    <div class="custom-checkbox custom-control">
                                                                                        <input type="checkbox" name="todo" value="'.$id.'" onclick="update_status(this)" id="exampleCustomCheckbox'.$id.'" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox'.$id.'">&nbsp;</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="widget-content-left mr-3">
                                                                                    <div class="widget-content-left">
                                                                                        '.$image.'
                                                                                    </div>
                                                                                </div>
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading">'.$title.' '.$mark.'
                                                                                    </div>
                                                                                    <div class="widget-subheading">'.$description.'
                                                                                    </div>';
            
                                                                            $due_date=date_format(new DateTime($due_date),'d-m-Y');
                                                                            if(date('d-m-Y')>$due_date) $s='end';
                                                                            else $s='start';
            
                                                                                    $data['task'].='<div class="widget-subheading">';
                                                                                        $data['task'].='<i class="fa fa-hourglass-'.$s.'"></i> <font style="text-decoration:underline;">'.$due_date.'</font> &nbsp;';
            
                                                                                        if(!empty($file_name))
                                                                                        $data['task'].='<i class="fa fa-paperclip"></i> <a href="'.url('to_do_files/'.$file_name).'" target="_blank" style="text-decoration:underline;">'.$file_name.'</a> &nbsp;';
                                                                                        
                                                                                        if($reminder=='1')
                                                                                        $data['task'].='<i class="fa fa-bell"></i> <font style="text-decoration:underline;">'.date_format(new DateTime($reminder_date),'d-m-Y h:i a').'</font>';
                                                                                    
                                                                                    $data['task'].='</div>';
            
                                                                                $data['task'].='</div>
                                                                                <div class="widget-content-right">
                                                                                    <button class="border-0 btn-transition btn btn-outline-success" onclick="edit_task(\''.$id.'\', \''.$title.'\', \''.$priority.'\', \''.$description.'\', \''.$due_date.'\', \''.$assign_to.'\', \''.$reminder.'\', \''.date_format(new DateTime($reminder_date),'d-m-Y h:i A').'\')" data-toggle="modal" data-target="#add-task">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>
                                                                                    <button class="border-0 btn-transition btn btn-outline-danger">
                                                                                        <i class="fa fa-trash-alt"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    ';
            $data['edit']=$id;
            $data['success']=1;
        }
        
        return response()->json($data);
    }
    
    public function send_reminders(Request $request)
    {
        $c_date=date('Y-m-d H:i:00');
        
        $todos=array(); $i=0;
        $row=DB::select("SELECT id, title, description, due_date, reminder, reminder_date, type, assign_to, added_by, user_type FROM todos WHERE status='0' AND reminder='1' AND reminder_date<='$c_date'");
        foreach($row as $r)
        {
            $email='';
            $todos[$i]['todo']=$r;
            
            if($r->assign_to!='0')
            {
                if($r->user_type=='2')
                $row2=DB::select("SELECT id, name, profile_image, email FROM contacts WHERE id='$r->assign_to' LIMIT 1");
                else
                $row2=DB::select("SELECT id, name, profile_image, email FROM users WHERE id='$r->assign_to' LIMIT 1");
                if(count($row2)==1)
                {
                    $row2=collect($row2)->first();
                    $email=$row2->email;
                }
            }
            else
            {
                if($r->type=='1')
                {
                    $row2=DB::select("SELECT id, name, profile_image, email FROM users WHERE id='$r->added_by' LIMIT 1");
                    if(count($row2)==1)
                    {
                        $row2=collect($row2)->first();
                        $email=$row2->email;
                    }
                }
                else
                {
                    $row2=DB::select("SELECT id, name, profile_image, email FROM contacts WHERE id='$r->added_by' LIMIT 1");
                    if(count($row2)==1)
                    {
                        $row2=collect($row2)->first();
                        $email=$row2->email;
                    }
                }
            }
            
            //echo $email.'<br>';
            
            if($email!='') 
            {
            //send email alert START
                    $from=env('MAIL_USERNAME');
                    $data2=array(
                        'to_do'=>$r,
                        'email'=>$email,
                        'from'=>$from
                    );
                    Mail::send('emails.todo_reminder', $data2, function($message) use($email, $from) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('To-Do Reminder');
                        //$message->attach($pathToFile);
                    });
            //send email alert END
            }
            
            DB::update("UPDATE todos SET reminder='0' WHERE id='$r->id'");
            
            $i++;
        }
    }
    
    public function update_status(Request $request)
    {
        $data=array();
        $data['success']=0;
        
        $id=$request->input('id');
        $status=$request->input('status');
        
        DB::update("UPDATE todos SET status='$status' WHERE id='$id'");
        $data['success']=1;
        
        return response()->json($data);
    }
}
