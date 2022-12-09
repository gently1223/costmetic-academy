<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use DB;
use Lang;

class account extends Controller
{
     public function upload_files(Request $request)
    {
        $data=array();
        $data['success']=1;
        if($request->file('file')!='') 
        {
            $file=$request->file('file');
            
            //Move Uploaded File
            $destinationPath = 'company_files/documents';
            $file_name=$file->getClientOriginalName();
            $array=explode('.', $file_name);
            $file_name=$array[0];
            $ext=$array[1];
            $file_name=rand(pow(10, 4-1), pow(10, 4)-1).'-'.time().'.'.$ext;
            
            if($file->move($destinationPath,$file_name)) {
                $data['filename']=$file_name;
            }
        }
        
        return response()->json($data);
    }
    
    public function login(Request $request)
    {
        if($request->input('username')!='')
        {
            $username=addslashes($request->input('username'));
            $pass=addslashes($request->input('pass'));
            
            $result=DB::select("SELECT id, type, suspend FROM users WHERE username='$username' AND pass='$pass' LIMIT 1");
            if(count($result)==1)
            {
                $result=collect($result)->first();
                if($result->suspend=='1') {
                    $request->session()->flash('error','We are sorry to inform you that your account has been suspended. Please contact at support@example.com for further details.');
                }
                else {
                $request->session()->put('admin_id',$result->id);
                $request->session()->put('admin_type',$result->type);
                    
                    DB::update("UPDATE users SET last_login=NOW() WHERE id='$result->id'");
                    return redirect('admin/dashboard');
                }
            }
            else $request->session()->flash('error', Lang::get('login.email_password_wrong'));
            
            return redirect('admin/login');
        }
        
        return view('panel.login.index');
    }
    
    public function manage_users(Request $request)
    {
        
       
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            
            $delete=addslashes($request->input('delete'));
            DB::delete("DELETE FROM users WHERE id='$delete'");
            $request->session()->flash('success', 'User has been deleted successfully.');
            
            return redirect('admin/manage-users');
        }
        
        if($request->input('username')!='')
        {
            $username=addslashes($request->input('username'));
            $pass=addslashes($request->input('pass'));
            $name=addslashes($request->input('name'));
            $email=addslashes($request->input('email'));
            $type=addslashes($request->input('type'));
            
            $check=DB::select("SELECT id FROM users WHERE username='$username' LIMIT 1");
            if(count($check)==0)
            {
                $signature1='';
                if($request->mysignaturee!='')
        {
              $signature = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.png';

            $img = str_replace('data:image/png;base64,', '', $request->mysignaturee);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            file_put_contents("admin_signatures/" . $signature, $fileData);
            $signature1=$signature;
        }
               DB::insert("INSERT INTO users (username, pass, name, email, type, added_by,signature, created_on) VALUES ('$username', '$pass', '$name', '$email', '$type', '$admin_id','$signature1', NOW())");
                $id=DB::getPdo()->lastInsertId();
                
                //send password set link START
                    $code=substr(md5(uniqid(rand(),true)),0,20);
                    DB::insert("INSERT INTO reset_password (user_id, code) VALUES ('$id','$code')");
                
                    $from=env('MAIL_USERNAME');
                    $data2=array(
                        'u_id'=>$id,
                        'code'=>$code,
                        'email'=>$email,
                        'from'=>$from,
                        'name'=>$name
                    );
                    Mail::send('emails.admin_set', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Set Password');
                        //$message->attach($pathToFile);
                    });
                //send password set link END
                $request->session()->flash('success', 'User has been created successfully.');
            }
            else $request->session()->flash('error', 'Sorry, this username already exists.');
            
            return redirect('admin/manage-users');
        }
        
        $users=DB::select("SELECT * FROM users WHERE type!='1'");
        return view('panel.manage_users.index', ['title'=>'Manage Users', 'sub_title'=>count($users).' total users', 'users'=>$users]);
    }
    
    public function edit_user(Request $request, $id)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('username')!='')
        {
            $username=addslashes($request->input('username'));
            $pass=addslashes($request->input('pass'));
            $name=addslashes($request->input('name'));
            $email=addslashes($request->input('email'));
            $type=addslashes($request->input('type'));
              $signature1='';
             if($request->mysignaturee!='')
             {
            
              $signature = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.png';

            $img = str_replace('data:image/png;base64,', '', $request->mysignaturee);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            file_put_contents("admin_signatures/" . $signature, $fileData);
            $signature1=$signature;
        }
        else if($request->signature!='')
        {
             $signature1=$request->signature;
        }
            DB::update("UPDATE users SET username='$username', pass='$pass', name='$name', email='$email', type='$type',signature='$signature1' WHERE id='$id'");
            $request->session()->flash('success', 'User details been updated successfully.');
            
            return redirect('admin/edit-user/'.$id);
        }
        
        $user=DB::select("SELECT * FROM users WHERE id='$id' LIMIT 1");
        $user=collect($user)->first();
        return view('panel.edit_user.index', ['title'=>'Edit User', 'user'=>$user]);
    }
    
    public function set_password(Request $request, $user_id, $code){
        $request->session()->flash('success', '');
        $row=DB::select("SELECT id FROM reset_password WHERE user_id='$user_id' AND code='$code' LIMIT 1");
        
        if(count($row)==0){
            echo '<p>Sorry, This link is expired.</p>';
            exit();
        }
        else{
            $row=collect($row)->first();
            $id=$row->id;   //id of row in verify table
            
            $user=DB::select("SELECT id FROM users WHERE id='$user_id' LIMIT 1");
            if(count($user)==1) {
            $user=collect($user)->first();
                
                if($request->input('pass1')!=''){
            $pass1=addslashes($request->input('pass1'));
            $pass2=addslashes($request->input('pass2'));
                if($pass1==$pass2){
                    DB::update("UPDATE users SET pass='$pass1' WHERE id='$user_id'");
                    DB::delete("DELETE FROM reset_password WHERE user_id='$user_id' AND code='$code'");
                    $request->session()->flash('success', 'Your password has been set successfully!');
                    return redirect('admin/login');
                }
                else $request->session()->flash('error', 'Passwords did not match.');
                }
            }
            else {
                echo '<p>User not found!</p>';
                exit();
            }
        }
        
        return view('panel.set_password.index', ['title'=>'Set Password']);
    }
    
    public function reset_password(Request $request, $user_id, $code){
        $request->session()->flash('success', '');
        $row=DB::select("SELECT id FROM reset_password WHERE user_id='$user_id' AND code='$code' LIMIT 1");
        
        if(count($row)==0){
            echo '<p>Sorry, This link is expired.</p>';
            exit();
        }
        else{
            $row=collect($row)->first();
            $id=$row->id;   //id of row in verify table
            
            $user=DB::select("SELECT id FROM users WHERE id='$user_id' LIMIT 1");
            if(count($user)==1) {
            $user=collect($user)->first();
                
                if($request->input('pass1')!=''){
            $pass1=addslashes($request->input('pass1'));
            $pass2=addslashes($request->input('pass2'));
                if($pass1==$pass2){
                    $sh2 = hash('sha256', $pass1);
                    DB::update("UPDATE users SET password=unhex('$sh2') WHERE id='$user_id'");
                    DB::delete("DELETE FROM reset_password WHERE user_id='$user_id' AND code='$code'");
                    $request->session()->flash('success', 'Your password has been set successfully!');
                }
                else $request->session()->flash('error', 'Passwords did not match.');
                }
            }
            else {
                echo '<p>User not found!</p>';
                exit();
            }
        }
        
        return view('reset_password.index', ['title'=>'Reset Password']);
    }
    
    public function forgot_password(Request $request){
        if($request->input('email')!=''){
            $email=addslashes($request->input('email'));
            
            $result=DB::select("SELECT id, name FROM users WHERE email='$email' LIMIT 1");
            if(count($result)==1){
                $data=collect($result)->first();
                $id=$data->id;
                
                //send password reset link START
                    $code=substr(md5(uniqid(rand(),true)),0,20);
                    DB::insert("INSERT INTO reset_password (user_id, code) VALUES ('$id','$code')");
                
                    $from=env('MAIL_USERNAME');
                    $name=$data->name;
                    $data2=array(
                        'u_id'=>$id,
                        'code'=>$code,
                        'email'=>$email,
                        'from'=>$from,
                        'name'=>$name
                    );
                    Mail::send('emails.admin_reset', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Reset Password');
                        //$message->attach($pathToFile);
                    });
                //send password reset link END
                
                $request->session()->flash('success','We have sent you an email with reset password link.');
            } 
            else $request->session()->flash('error', Lang::get('login.email_not_registered'));
            
            return redirect('/admin/forgot-password');
        }
        
        return view('panel.forgot_password.index', ['title'=>'Forgot Password']);
    }
    
    public function logout(Request $request)
    {
        $request->session()->put('admin_id', '');
        $request->session()->put('admin_type', '');
        
        return redirect('admin/login');
    }
}
