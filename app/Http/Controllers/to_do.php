<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;

class to_do extends Controller
{
    public function to_do(Request $request)
    {
        $admin_id=$request->session()->get('id');
        $id=$request->session()->get('id');
        
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
            $description=addslashes($request->input('description'));
            $due_date=addslashes($request->input('due_date'));
            $due_date=date_format(new DateTime($due_date),'Y-m-d');
            
            DB::insert("INSERT INTO todos (title, description, due_date, added_by, added_on) VALUES ('$title', '$description', '$due_date', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            return redirect('admin/to-do');
        }
        
        $todos=array(); $i=0;
        $row=DB::select("SELECT * FROM todos WHERE (added_by='$id' AND type='2') OR (assign_to='$id' AND user_type='2') ORDER BY priority, due_date ASC");
        foreach($row as $r)
        {
            $todos[$i]['todo']=$r;
            
            $row2=DB::select("SELECT id, name, profile_image FROM contacts WHERE id='$r->assign_to' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $todos[$i]['contact']=$row2;
            }
            else $todos[$i]['contact']='NA';
            
            $i++;
        }
        $task_contacts=DB::select("SELECT id, name FROM contacts WHERE type='Student' OR type='Coach'");
        return view('to_do.index', ['title'=>'To-Do', 'todos'=>$todos, 'task_contacts'=>$task_contacts, 'task_contacts'=>$task_contacts]);
    }
    
    public function manage_todos(Request $request)
    {
        $admin_id=$request->session()->get('id');
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
            $assign_to=addslashes($request->input('assign_to'));
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
            
            DB::insert("INSERT INTO todos (title, priority, description, due_date, assign_to, file, reminder, reminder_date, added_by, added_on, type) VALUES ('$title', '$priority', '$description', '$due_date', '$assign_to', '$file_name', '$reminder', '$reminder_date', '$admin_id', NOW(), '2')");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            $name=$title;
            \CommonFunctions::instance()->log_activity($request, 'Created a to-do - #'.$id.' '.$name);
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
            $assign_to=addslashes($request->input('assign_to'));
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
            
            DB::update("UPDATE todos SET title='$title', priority='$priority', description='$description', due_date='$due_date', assign_to='$assign_to', reminder='$reminder', reminder_date='$reminder_date' WHERE id='$id'");
            
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
                                                                                    <button class="border-0 btn-transition btn btn-outline-success" onclick="edit_task(\''.$id.'\', \''.$title.'\', \''.$description.'\', \''.$due_date.'\', \''.$assign_to.'\', \''.$reminder.'\', \''.date_format(new DateTime($reminder_date),'d-m-Y h:i A').'\')" data-toggle="modal" data-target="#add-task">
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
        $c_date=date('Y');
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
