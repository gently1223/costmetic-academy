<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use DB;
use Lang;
use PDF;

class account extends Controller {
    public function upload_profile_image(Request $request)
    {
        $data=array();
        $data['success']=0;
        
        if($request->file('file')!=''){
            $error='';
            $file=$request->file('file');
            
            //Move Uploaded File
            $destinationPath = 'company_files/profile_images/';
                $img_name=$file->getClientOriginalName();
                $array=explode('.', $img_name);
                $img_name=$array[0];
                $ext=$array[1];
                $img_name=rand(pow(10, 4-1), pow(10, 4)-1).'.'.$ext;
                $fileName = $destinationPath . $img_name; // renameing image
                
                if($file->move($destinationPath,$img_name)) {
                    $data['name']=$img_name;
                    $data['success']=1;
                }
        }
        
        return response()->json($data);
    }
    
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

    public function login(Request $request) {
        if ($request->input('email') != '') {
            $email = addslashes($request->input('email'));
            $pass = addslashes($request->input('pass'));

            $result = DB::select("SELECT id, type, suspend FROM contacts WHERE email='$email' AND pass='$pass' LIMIT 1");
            if (count($result) == 1) {
                $result = collect($result)->first();
                if ($result->suspend == '1') {
                    $request->session()->flash('error', 'We are sorry to inform you that your account has been suspended. Please contact at support@example.com for further details.');
                } else {
                    $request->session()->put('id', $result->id);
                    $request->session()->put('type', $result->type);
                    $request->session()->put('logged_in', '1');

                    DB::update("UPDATE contacts SET last_login=NOW() WHERE id='$result->id'");

                    $next = $request->session()->get('next');
                    if ($next != '') {
                        $request->session()->put('next', '');
                        return redirect($next);
                    } else
                        return redirect('dashboard');
                }
            } else
                $request->session()->flash('error', Lang::get('login.email_password_wrong'));

            return redirect('login');
        }
        
        $data = [
          'title' => 'First PDF for Medium',
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.'        
            ];
        
        //$pdf = PDF::loadView('cvs.cv1', $data);
        //$pdf->setOptions(['dpi' => 96, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'debugCss' => true]);
        //return $pdf->download('medium.pdf');
        //return view('cvs.cv1', ['title' => 'Login']);

        return view('login.index', ['title' => 'Login']);
    }

    public function set_password(Request $request, $user_id, $code) {
        $request->session()->flash('success', '');
        $row = DB::select("SELECT id FROM reset_password WHERE user_id='$user_id' AND code='$code' LIMIT 1");

        if (count($row) == 0) {
            echo '<p>Sorry, This link is expired.</p>';
            exit();
        } else {
            $row = collect($row)->first();
            $id = $row->id;   //id of row in verify table

            $user = DB::select("SELECT id FROM contacts WHERE id='$user_id' LIMIT 1");
            if (count($user) == 1) {
                $user = collect($user)->first();

                if ($request->input('pass1') != '') {
                    $pass1 = addslashes($request->input('pass1'));
                    $pass2 = addslashes($request->input('pass2'));
                    if ($pass1 == $pass2) {
                        DB::update("UPDATE contacts SET pass='$pass1', double_opt_in='1' WHERE id='$user_id'");
                        DB::delete("DELETE FROM reset_password WHERE user_id='$user_id' AND code='$code'");
                        $request->session()->flash('success', 'Your password has been set successfully!');
                        return redirect('login');
                    } else
                        $request->session()->flash('error', 'Passwords did not match.');
                }
            }
            else {
                echo '<p>User not found!</p>';
                exit();
            }
        }

        return view('set_password.index', ['title' => 'Set Password']);
    }

    public function email_confirmation(Request $request, $user_id, $code) {

        $row = DB::select("SELECT id, new_email FROM contacts WHERE id='$user_id' AND code='$code' LIMIT 1");

        if (count($row) == 0) {
            echo '<p>Sorry, This link is expired.</p>';
            exit();
        } else {
            $row = collect($row)->first();
            $id = $row->id;   //id of row in verify table

            DB::update("UPDATE contacts SET email='$row->new_email', new_email='' WHERE id='$id'");
            $request->session()->flash('success', 'Your email has been updated successfully.');
            return redirect('my-profile');
        }
    }

    public function reset_password(Request $request, $user_id, $code) {
        $request->session()->flash('success', '');
        $row = DB::select("SELECT id FROM reset_password WHERE user_id='$user_id' AND code='$code' LIMIT 1");

        if (count($row) == 0) {
            echo '<p>Sorry, This link is expired.</p>';
            exit();
        } else {
            $row = collect($row)->first();
            $id = $row->id;   //id of row in verify table

            $user = DB::select("SELECT id FROM users WHERE id='$user_id' LIMIT 1");
            if (count($user) == 1) {
                $user = collect($user)->first();

                if ($request->input('pass1') != '') {
                    $pass1 = addslashes($request->input('pass1'));
                    $pass2 = addslashes($request->input('pass2'));
                    if ($pass1 == $pass2) {
                        $sh2 = hash('sha256', $pass1);
                        DB::update("UPDATE contacts SET password=unhex('$sh2') WHERE id='$user_id'");
                        DB::delete("DELETE FROM reset_password WHERE user_id='$user_id' AND code='$code'");
                        $request->session()->flash('success', 'Your password has been set successfully!');
                    } else
                        $request->session()->flash('error', 'Passwords did not match.');
                }
            }
            else {
                echo '<p>User not found!</p>';
                exit();
            }
        }

        return view('reset_password.index', ['title' => 'Reset Password']);
    }

    public function get_prospect_page(Request $request){
        //echo "get prospect page called : " . $prospect_code; 
        $prospect_code = $request->get('prospect_code');
        
        $c_addl = DB::table('contacts_additional')->where('prospect_code', $prospect_code)->first();
        if ($c_addl) {
            
            $c_row = DB::select("SELECT * FROM contacts WHERE id='" . $c_addl->contact_id . "' LIMIT 1");
            $c_row = collect($c_row)->first();
            
            // Input Treeview
            $products = array();
            $i = 0;
            $row = DB::select("SELECT * FROM products where auth_no is not null and auth_no != ''");
            foreach ($row as $r) {
                $products[$i]['product'] = $r;
                
                $products[$i]['total_cost'] = 0;
                $products[$i]['total_lessons'] = 0;
                $row2 = DB::SELECT("SELECT id, m_id FROM product_modules WHERE p_id='$r->id'");
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
                        
                        $row3 = DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r2->m_id'");
                        $module_items = array();
                        $k = 0;
                        foreach ($row3 as $r3) {
                            $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->m_id' LIMIT 1");
                            if (count($row4) == 0)
                                continue;
                                $row4 = collect($row4)->first();
                                $module_items[$k]['item'] = $row4;
                                
                                $products[$i]['total_lessons'] += $row4->lessons;
                                $products[$i]['total_cost'] += $row4->lessons * $row4->price_lessons;
                                
                                $modules[$j]['total_lessons'] += $row4->lessons;
                                $modules[$j]['total_cost'] += $row4->lessons * $row4->price_lessons;
                                
                                $k ++;
                        }
                        $modules[$j]['items'] = $module_items;
                        $j ++;
                }
                $products[$i]['modules'] = $modules;
                
                $i ++;
            }
            $modules = DB::select("SELECT id, title FROM modules ORDER BY title ASC");
            $modules_items = DB::select("SELECT id, title FROM module_items ORDER BY title ASC");
            
            $funding_sources = DB::select("SELECT id, name, address FROM funding_sources ORDER BY name ASC");
            $referral_sources = DB::select("SELECT id, name FROM referral_sources ORDER BY name ASC");
            
           // echo json_encode($c_row);
            
            return view('panel.prospect-page.index', [
                'is_prospect_sign_page' => 1,
                'contact_row' => $c_row,
                'contact_addl_row' => $c_addl,
                'products' => $products,
                'funding_sources' => $funding_sources,
                'referral_sources' => $referral_sources,
            ]);
          
        } else {
            session()->flash('error', trans('dashboard.no_detail'));
            return redirect('/login');
        }
        
    }
    
    public function forgot_password(Request $request) {
        if ($request->input('email') != '') {
            $email = addslashes($request->input('email'));

            $result = DB::select("SELECT id, name FROM contacts WHERE email='$email' LIMIT 1");
            if (count($result) == 1) {
                $data = collect($result)->first();
                $id = $data->id;

                //send password reset link START
                $code = substr(md5(uniqid(rand(), true)), 0, 20);
                DB::insert("INSERT INTO reset_password (user_id, code) VALUES ('$id','$code')");

                $from = env('MAIL_USERNAME');
                $name = $data->name;
                $data2 = array(
                    'u_id' => $id,
                    'code' => $code,
                    'email' => $email,
                    'from' => $from,
                    'name' => $name
                );
                Mail::send('emails.reset', $data2, function($message) use($email, $from, $name) {
                    $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                    $message->to($email);
                    $message->subject('Reset Password');
                    //$message->attach($pathToFile);
                });
                //send password reset link END

                $request->session()->flash('success', Lang::get('login.password_email_sent'));
            } else
                $request->session()->flash('error', Lang::get('login.email_not_registered'));

            return redirect('/forgot-password');
        }

        return view('forgot_password.index', ['title' => 'Forgot Password']);
    }

    public function logout(Request $request) {
        $request->session()->put('id', '');
        $request->session()->put('type', '');

        return redirect('login');
    }

}
