<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use Mail;
use DB;
use \setasign\Fpdi\Fpdi;

class contacts extends Controller
{
    public static function instance()
     {
         return new contacts();
     }
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            
            $delete=addslashes($request->input('delete'));
            DB::delete("DELETE FROM contacts WHERE id='$delete'");
            $request->session()->flash('success', 'Contact has been deleted successfully.');
            
            return redirect('admin/contacts');
        }
        
        if($request->input('email')!='')
        {
            $username=addslashes($request->input('username'));
            $pass=addslashes($request->input('pass'));
            $first_name=addslashes($request->input('first_name'));
            $last_name=addslashes($request->input('last_name'));
            $name=$first_name.' '.$last_name;
            $email=addslashes($request->input('email'));
            $type=addslashes($request->input('type'));
            
            $product=addslashes($request->input('product'));
            $funding_donors=addslashes($request->input('funding_donors'));
            $contact_name=addslashes($request->input('contact_name'));
            $contact_email=addslashes($request->input('contact_email'));
            $address=addslashes($request->input('address'));
            $city=addslashes($request->input('city'));
            $zip_code=addslashes($request->input('zip_code'));
            $measure_no=addslashes($request->input('measure_number'));
            $subject_area=addslashes($request->input('subject_area'));
            $internship_company=addslashes($request->input('internship_company'));
            $organisation=addslashes($request->input('organisation'));
            $position=addslashes($request->input('position'));
            $comments=addslashes($request->input('comments'));
            $other_client=addslashes($request->input('other_client'));
            $jurisdiction=addslashes($request->input('jurisdiction'));
            $source_funding=addslashes($request->input('source_funding'));
            $source_name=addslashes($request->input('source_name'));
            $source_location=addslashes($request->input('source_location'));
            
            $company_name=addslashes($request->input('company_name'));
            if($type=='Internship Company') $name=$company_name;
            $gender=addslashes($request->input('gender'));
            $street_name=addslashes($request->input('street_name'));
            $door_no=addslashes($request->input('door_no'));
            $dob=addslashes($request->input('dob'));
            $phone_no=addslashes($request->input('phone_no'));
            $marital_status=addslashes($request->input('marital_status'));
            $child_care=addslashes($request->input('child_care'));
            $funding_source=addslashes($request->input('funding_source'));
            $contact_person='';
            if($request->input('contact_person')!='')
            $contact_person=implode(',', $request->input('contact_person'));
            
            $customer_no=addslashes($request->input('customer_no'));
            $org_zeichen=addslashes($request->input('org_zeichen'));
            
            $start_working=addslashes($request->input('start_working'));
            $bank_name=addslashes($request->input('bank_name'));
            $iban=addslashes($request->input('iban'));
            $bic=addslashes($request->input('bic'));
            
            $price_ue=addslashes($request->input('price_ue'));
            
            $parent_first_name=addslashes($request->input('parent_first_name'));
            $parent_last_name=addslashes($request->input('parent_last_name'));
            $parent_email=addslashes($request->input('parent_email'));
            $parent_street_name=addslashes($request->input('parent_street_name'));
            $parent_door_no=addslashes($request->input('parent_door_no'));
            $parent_address=addslashes($request->input('parent_address'));
            $parent_city=addslashes($request->input('parent_city'));
            $parent_zip_code=addslashes($request->input('parent_zip_code'));
            $parent_dob=addslashes($request->input('parent_dob'));
            $parent_phone_no=addslashes($request->input('parent_phone_no'));
            
            $unlimited_employment=addslashes($request->input('unlimited_employment'));
            $employment_end=addslashes($request->input('employment_end'));
            $yearly_salary=addslashes($request->input('yearly_salary'));
            $working_hours=addslashes($request->input('working_hours'));
            $probation_period=addslashes($request->input('probation_period'));
            $employment_position=addslashes($request->input('employment_position'));
            
            $vouchers=addslashes($request->input('vouchers'));
            
            $types='';
            if($request->input('types')!='') $types=implode(',', $request->input('types'));
            
            if($type=='Coach' AND $request->input('types2')!='') $types=implode(',', $request->input('types2'));
            
            $beginning=''; $end='';
            $period=addslashes($request->input('period'));
            if($period!='')
            {
                $dates=explode(' - ', $period);
                $beginning=date_format(new DateTime($dates[0]),'Y-m-d');
                $end=date_format(new DateTime($dates[1]),'Y-m-d');
            }
            
            $check=DB::select("SELECT id FROM contacts WHERE email='$email' LIMIT 1");
            if(count($check)==1)
            {
                $request->session()->flash('error', $email.' - Email already exists.');
                return redirect('admin/contacts');
            }
            
                DB::insert("INSERT INTO contacts (username, pass, name, email, type, product, funding_donors, contact_name, contact_email, address, city, zip_code, measure_no, subject_area, internship_company, organisation, position, comments, other_client, jurisdiction, source_funding, source_name, source_location, company_name, gender, street_name, door_no, dob, phone_no, marital_status, child_care, funding_source, contact_person, beginning, end, added_by, created_on, types, customer_no, org_zeichen, start_working, bank_name, iban, bic, parent_first_name, parent_last_name, parent_email, parent_street_name, parent_door_no, parent_address, parent_city, parent_zip_code, parent_dob, parent_phone_no, unlimited_employment, employment_end, yearly_salary, working_hours, probation_period, employment_position, vouchers, price_ue) VALUES ('$username', '$pass', '$name', '$email', '$type', '$product', '$funding_donors', '$contact_name', '$contact_email', '$address', '$city', '$zip_code', '$measure_no', '$subject_area', '$internship_company', '$organisation', '$position', '$comments', '$other_client', '$jurisdiction', '$source_funding', '$source_name', '$source_location', '$company_name', '$gender', '$street_name', '$door_no', '$dob', '$phone_no', '$marital_status', '$child_care', '$funding_source', '$contact_person', '$beginning', '$end','$admin_id', NOW(), '$types', '$customer_no', '$org_zeichen', '$start_working', '$bank_name', '$iban', '$bic', '$parent_first_name', '$parent_last_name', '$parent_email', '$parent_street_name', '$parent_door_no', '$parent_address', '$parent_city', '$parent_zip_code', '$parent_dob', '$parent_phone_no', '$unlimited_employment', '$employment_end', '$yearly_salary', '$working_hours', '$probation_period', '$employment_position', '$vouchers', '$price_ue')");
                $id=DB::getPdo()->lastInsertId();
               
                if($request->input('notes')!='')
                {
                    foreach($request->input('notes') as $notes)
                    {
                        DB::insert("INSERT INTO notes (contact_id, notes, added_by, added_on) VALUES ('$id', '$notes', '$admin_id', NOW())");
                    }
                }
            
                if($vouchers!='')
                {
                    $vouchers2=explode(',', $vouchers);
                    foreach($vouchers2 as $voucher)
                    {
                        DB::insert("INSERT INTO contracts (type, contract, c_id, added_by, on_date, document) VALUES ('Voucher', '$voucher', '$id', '$admin_id', NOW(), '1')");
                    }
                }
            
                //track Activity START
                \CommonFunctions::instance()->log_activity($request, 'Created contact - #'.$id.' '.$name.' ('.$type.')');
                //track Activity END
            
                if(!empty($request->input('products')))
                {
                    foreach($request->input('products') as $p)
                    {
                        DB::insert("INSERT INTO contact_products (c_id, p_id) VALUES ('$id', '$p')");
                        
                        if(!empty($request->input('modules'.$p)))
                        {
                            foreach($request->input('modules'.$p) as $m)
                            {
                                DB::insert("INSERT INTO contact_modules (c_id, p_id, m_id) VALUES ('$id', '$p', '$m')");
                                
                                if(!empty($request->input('items'.$p)))
                                {
                                    foreach($request->input('items'.$p) as $i)
                                    {
                                        $lessons=$request->input('lessons'.$i);
                                        DB::insert("INSERT INTO contact_items (c_id, p_id, m_id, i_id, lessons) VALUES ('$id', '$p', '$m', '$i', '$lessons')");
                                    }
                                }
                            }
                        }
                    }
                }
                
                if($type!='Prospect' AND $type!='Internship Company') {
                //send password reset link START
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
                    Mail::send('emails.set', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Welcome to NextLevel Akademie');
                        //$message->attach($pathToFile);
                    });
                //send password reset link END
                }
            
                $request->session()->flash('success', 'User has been created successfully.');
            
            return redirect('admin/contacts');
        }
        
        $products=array(); $i=0;
        $row=DB::select("SELECT * FROM products");
        foreach($row as $r)
        {
            $products[$i]['product']=$r;
            
            $products[$i]['total_cost']=0;
            $products[$i]['total_lessons']=0;
            $row2=DB::SELECT("SELECT id, m_id FROM product_modules WHERE p_id='$r->id'");
            $modules=array(); $j=0;
            foreach($row2 as $r2)
            {
                $row22=DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                if(count($row22)==0) continue;
                $row22=collect($row22)->first();
                $modules[$j]['module']=$row22;
                
                $modules[$j]['total_cost']=0;
                $modules[$j]['total_lessons']=0;
                
                $row3=DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r2->m_id'");
                $module_items=array(); $k=0;
                foreach($row3 as $r3)
                {
                    $row4=DB::SELECT("SELECT * FROM module_items WHERE id='$r3->m_id' LIMIT 1");
                    if(count($row4)==0) continue;
                    $row4=collect($row4)->first();
                    $module_items[$k]['item']=$row4;
                    
                    $products[$i]['total_lessons']+=$row4->lessons;
                    $products[$i]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                    $modules[$j]['total_lessons']+=$row4->lessons;
                    $modules[$j]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                    $k++;
                }
                $modules[$j]['items']=$module_items;
                $j++;
            }
                $products[$i]['modules']=$modules;
            
            $i++;
        }
        
        $contacts=array(); $i=0;
        $row=DB::select("SELECT * FROM contacts ORDER BY id DESC");
        foreach($row as $r)
        {
            $contacts[$i]['contact']=$r;
            
            $contracts=array(); $j=0;
            $row2=DB::select("SELECT * FROM contracts WHERE c_id='$r->id' ORDER BY id DESC");
            if(count($row2)!=0)
            {
                foreach($row2 as $r2)
                {
                    $contracts[$j]['contract']=$r2;
                    
                    $j++;
                }
            }
            
            $contacts[$i]['contracts']=$contracts;
            
            $i++;
        }
        
        $courses=array(); $i=0;
        $row=DB::select("SELECT * FROM courses ORDER BY title ASC");
        foreach($row as $r)
        {
            $courses[$i]['course']=$r;
            
            $courses[$i]['total_cost']=0;
            $courses[$i]['total_lessons']=0;
            $products2=array(); $i2=0;
            $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$r->id'");
            foreach($row1 as $r1)
            {
                $row22=DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
                if(count($row22)==0) continue;
                $row22=collect($row22)->first();
                $products2[$i2]['product']=$row22;
                
                
                $products2[$i2]['total_cost']=0;
                $products2[$i2]['total_lessons']=0;
                
                $row2=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$r->id'");
                $modules=array(); $j=0;
                foreach($row2 as $r2)
                {
                    $row22=DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                    if(count($row22)==0) continue;
                    $row22=collect($row22)->first();
                    $modules[$j]['module']=$row22;
                
                    $modules[$j]['total_cost']=0;
                    $modules[$j]['total_lessons']=0;
                
                    $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$r->id'");
                    $module_items=array(); $k=0;
                    foreach($row3 as $r3)
                    {
                        $module_items[$k]['course_item']=$r3;
                        
                        $row4=DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                        if(count($row4)==0) continue;
                        $row4=collect($row4)->first();
                        $module_items[$k]['item']=$row4;
                    
                        $courses[$i]['total_lessons']+=$row4->lessons;
                        $courses[$i]['total_cost']+=$row4->lessons*$row4->price_lessons;
                        
                        $products2[$i2]['total_lessons']+=$row4->lessons;
                        $products2[$i2]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                        $modules[$j]['total_lessons']+=$row4->lessons;
                        $modules[$j]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                        $k++;
                    }
                    $modules[$j]['items']=$module_items;
                    $j++;
                }
                $products2[$i2]['modules']=$modules;
                $i2++;
            }
            $courses[$i]['products']=$products2;
            
            $i++;
        }
        
        $courses_kg=DB::select("SELECT * FROM courses WHERE type='Regular' ORDER BY title ASC");
        $courses_coaching=DB::select("SELECT * FROM courses WHERE type='Coaching' ORDER BY title ASC");
        
        $funding_sources=DB::select("SELECT id, name, address FROM funding_sources ORDER BY name ASC");
        $experts=DB::select("SELECT id, name FROM contacts WHERE type='Expert Advisor' ORDER BY name ASC");
        return view('panel.contacts.index', ['title'=>trans('header.contacts'), 'sub_title'=>count($contacts).' total '.trans('header.contacts'), 'contacts'=>$contacts, 'products'=>$products, 'funding_sources'=>$funding_sources, 'experts'=>$experts, 'courses'=>$courses, 'courses_kg'=>$courses_kg, 'courses_coaching'=>$courses_coaching]);
    }
    
    public function edit_contact(Request $request, $id)
    {
        $admin_id=$request->session()->get('admin_id');
        
        $contact=DB::select("SELECT * FROM contacts WHERE id='$id' LIMIT 1");
        if(count($contact)==0) return redirect('admin/contacts');
        $contact=collect($contact)->first();
        
        $funding_source=array();
        $funding_source['address']='';
        $check=DB::select("SELECT address FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if(count($check)==1)
        {
            $check=collect($check)->first();
            $funding_source['address']=$check->address;
        }
        
        if($request->input('type')!='')
        {
            $convert=addslashes($request->input('type'));
            $username=addslashes($request->input('username'));
            $pass=addslashes($request->input('pass'));
            $first_name=addslashes($request->input('first_name'));
            $last_name=addslashes($request->input('last_name'));
            $name=$first_name.' '.$last_name;
            $email=addslashes($request->input('email'));
            $type=addslashes($request->input('type'));
            
            $product=addslashes($request->input('product'));
            $funding_donors=addslashes($request->input('funding_donors'));
            $contact_name=addslashes($request->input('contact_name'));
            $contact_email=addslashes($request->input('contact_email'));
            $address=addslashes($request->input('address'));
            $city=addslashes($request->input('city'));
            $zip_code=addslashes($request->input('zip_code'));
            $measure_no=addslashes($request->input('measure_number'));
            $subject_area=addslashes($request->input('subject_area'));
            $internship_company=addslashes($request->input('internship_company'));
            $organisation=addslashes($request->input('organisation'));
            $position=addslashes($request->input('position'));
            $comments=addslashes($request->input('comments'));
            $other_client=addslashes($request->input('other_client'));
            $jurisdiction=addslashes($request->input('jurisdiction'));
            $source_funding=addslashes($request->input('source_funding'));
            $source_name=addslashes($request->input('source_name'));
            $source_location=addslashes($request->input('source_location'));
            
            $company_name=addslashes($request->input('company_name'));
            if($type=='Internship Company') $name=$company_name;
            $gender=addslashes($request->input('gender'));
            $street_name=addslashes($request->input('street_name'));
            $door_no=addslashes($request->input('door_no'));
            $dob=addslashes($request->input('dob'));
            $phone_no=addslashes($request->input('phone_no'));
            $marital_status=addslashes($request->input('marital_status'));
            $child_care=addslashes($request->input('child_care'));
            $funding_source=addslashes($request->input('funding_source'));
            $contact_person='';
            if($request->input('contact_person')!='')
            $contact_person=implode(',', $request->input('contact_person'));
            
            $customer_no=addslashes($request->input('customer_no'));
            $org_zeichen=addslashes($request->input('org_zeichen'));
            
            $start_working=addslashes($request->input('start_working'));
            $bank_name=addslashes($request->input('bank_name'));
            $iban=addslashes($request->input('iban'));
            $bic=addslashes($request->input('bic'));
            
            $price_ue=addslashes($request->input('price_ue'));
            
            $parent_first_name=addslashes($request->input('parent_first_name'));
            $parent_last_name=addslashes($request->input('parent_last_name'));
            $parent_email=addslashes($request->input('parent_email'));
            $parent_street_name=addslashes($request->input('parent_street_name'));
            $parent_door_no=addslashes($request->input('parent_door_no'));
            $parent_address=addslashes($request->input('parent_address'));
            $parent_city=addslashes($request->input('parent_city'));
            $parent_zip_code=addslashes($request->input('parent_zip_code'));
            $parent_dob=addslashes($request->input('parent_dob'));
            $parent_phone_no=addslashes($request->input('parent_phone_no'));
            
            $unlimited_employment=addslashes($request->input('unlimited_employment'));
            $employment_end=addslashes($request->input('employment_end'));
            $yearly_salary=addslashes($request->input('yearly_salary'));
            $working_hours=addslashes($request->input('working_hours'));
            $probation_period=addslashes($request->input('probation_period'));
            $employment_position=addslashes($request->input('employment_position'));
            
            $vouchers=addslashes($request->input('vouchers'));
            
            if($vouchers!='')
            {
                $vouchers2=explode(',', $vouchers);
                foreach($vouchers2 as $voucher)
                {
                    DB::insert("INSERT INTO contracts (type, contract, c_id, added_by, on_date, document) VALUES ('Voucher', '$voucher', '$id', '$admin_id', NOW(), '1')");
                }
            }
            
            $types='';
            if($request->input('types')!='') $types=implode(',', $request->input('types'));
            
            if($type=='Coach' AND $request->input('types2')!='') $types=implode(',', $request->input('types2'));
            
            $beginning=''; $end='';
            $period=addslashes($request->input('period'));
            if($period!='')
            {
                $dates=explode(' - ', $period);
                $beginning=date_format(new DateTime($dates[0]),'Y-m-d');
                $end=date_format(new DateTime($dates[1]),'Y-m-d');
            }
            
            $contact=DB::select("SELECT id, name, email, type FROM contacts WHERE id='$id' LIMIT 1");
            $contact=collect($contact)->first();
            
            DB::update("UPDATE contacts SET type='$convert', name='$name', email='$email', type='$convert', product='$product', funding_donors='$funding_donors', contact_name='$contact_name', contact_email='$contact_email', address='$address', city='$city', zip_code='$zip_code', measure_no='$measure_no', subject_area='$subject_area', internship_company='$internship_company', organisation='$organisation', position='$position', comments='$comments', other_client='$other_client', jurisdiction='$jurisdiction', source_funding='$source_funding', source_name='$source_name', source_location='$source_location', company_name='$company_name', gender='$gender', street_name='$street_name', door_no='$door_no', dob='$dob', phone_no='$phone_no', marital_status='$marital_status', child_care='$child_care', funding_source='$funding_source', contact_person='$contact_person', beginning='$beginning', end='$end', types='$types', customer_no='$customer_no', org_zeichen='$org_zeichen', start_working='$start_working', bank_name='$bank_name', iban='$iban', bic='$bic', parent_first_name='$parent_first_name', parent_last_name='$parent_last_name', parent_email='$parent_email', parent_street_name='$parent_street_name', parent_door_no='$parent_door_no', parent_address='$parent_address', parent_city='$parent_city', parent_zip_code='$parent_zip_code', parent_dob='$parent_dob', parent_phone_no='$parent_phone_no', unlimited_employment='$unlimited_employment', employment_end='$employment_end', yearly_salary='$yearly_salary', working_hours='$working_hours', probation_period='$probation_period', employment_position='$employment_position', vouchers='$vouchers', price_ue='$price_ue' WHERE id='$id'");
            
            $email=$contact->email;
            $type=$contact->type;
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Updated a contact - #'.$id.' '.$name.' ('.$convert.')');
            //track Activity END
            
            /*$contract=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$id', '$contract', '$convert', NOW())");
            $c_id=DB::getPdo()->lastInsertId();
            $contract=DB::select("SELECT * FROM contracts WHERE id='$c_id' LIMIT 1");
            $contract=collect($contract)->first();*/
            
            /*DB::delete("DELETE FROM contact_courses WHERE c_id='$id' AND contract_id='$c_id'");
            if(!empty($request->input('courses')))
                {
                    foreach($request->input('courses') as $c)
                    {
                        DB::insert("INSERT INTO contact_courses (c_id, course_id, contract_id) VALUES ('$id', '$c', '$c_id')");
                        $id2=DB::getPdo()->lastInsertId();
                        
                        $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$c'");
                        foreach($row1 as $r1)
                        {
                
                            $row2=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$c'");
                            foreach($row2 as $r2)
                            {
                
                                $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$c'");
                                $module_items=array(); $k=0;
                                foreach($row3 as $r3)
                                {
                                    $lessons=$request->input('lessons'.$r3->id);
                                    DB::insert("INSERT INTO contract_lessons (c_id, course_id, contract_id, i_id, lessons) VALUES ('$id', '$c', '$c_id', '$r3->id', '$lessons')");
                                }
                            }
                        }
                    }
                }*/
            
            /*DB::delete("DELETE FROM contact_items WHERE c_id='$id'");
            DB::delete("DELETE FROM contact_modules WHERE c_id='$id'");
            DB::delete("DELETE FROM contact_products WHERE c_id='$id'");
            if(!empty($request->input('products')))
                {
                    foreach($request->input('products') as $p)
                    {
                        DB::insert("INSERT INTO contact_products (c_id, p_id) VALUES ('$id', '$p')");
                        
                        if(!empty($request->input('modules'.$p)))
                        {
                            foreach($request->input('modules'.$p) as $m)
                            {
                                DB::insert("INSERT INTO contact_modules (c_id, p_id, m_id) VALUES ('$id', '$p', '$m')");
                                
                                if(!empty($request->input('items'.$p)))
                                {
                                    foreach($request->input('items'.$p) as $i)
                                    {
                                        DB::insert("INSERT INTO contact_items (c_id, p_id, m_id, i_id) VALUES ('$id', '$p', '$m', '$i')");
                                    }
                                }
                            }
                        }
                    }
                }*/
            
            //create contract start
            //$c_id=$this->create_contract($request, $id, $convert, $contract);
            //create contract end
            
            /*if($type=='Prospect' OR $type=='Internship Company') {
                //send password reset link START
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
                    Mail::send('emails.set', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Welcome to NextLevel Akademie');
                        //$message->attach($pathToFile);
                    });
                //send password reset link END
                }*/
            
            //send email alert with contract link start
                    /*$from=env('MAIL_USERNAME');
                    $data2=array(
                        'type'=>$convert,
                        'c_id'=>$c_id,
                        'email'=>$email,
                        'from'=>$from,
                        'name'=>$name
                    );
                    Mail::send('emails.converted', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Congratulations!');
                        //$message->attach($pathToFile);
                    });*/
            //send email alert with contract link end
            
            $request->session()->flash('success', 'Contact has been updated successfully.');
            return redirect('admin/edit-contact/'.$id);
        }
        
        $courses=array(); $i=0;
        $row=DB::select("SELECT * FROM courses ORDER BY title ASC");
        foreach($row as $r)
        {
            $courses[$i]['course']=$r;
            
            $courses[$i]['total_cost']=0;
            $courses[$i]['total_lessons']=0;
            $products2=array(); $i2=0;
            $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$r->id'");
            foreach($row1 as $r1)
            {
                $row22=DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
                if(count($row22)==0) continue;
                $row22=collect($row22)->first();
                $products2[$i2]['product']=$row22;
                
                
                $products2[$i2]['total_cost']=0;
                $products2[$i2]['total_lessons']=0;
                
                $row2=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$r->id'");
                $modules=array(); $j=0;
                foreach($row2 as $r2)
                {
                    $row22=DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                    if(count($row22)==0) continue;
                    $row22=collect($row22)->first();
                    $modules[$j]['module']=$row22;
                
                    $modules[$j]['total_cost']=0;
                    $modules[$j]['total_lessons']=0;
                
                    $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$r->id'");
                    $module_items=array(); $k=0;
                    foreach($row3 as $r3)
                    {
                        $module_items[$k]['course_item']=$r3;
                        
                        $row4=DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                        if(count($row4)==0) continue;
                        $row4=collect($row4)->first();
                        $module_items[$k]['item']=$row4;
                    
                        $courses[$i]['total_lessons']+=$row4->lessons;
                        $courses[$i]['total_cost']+=$row4->lessons*$row4->price_lessons;
                        
                        $products2[$i2]['total_lessons']+=$row4->lessons;
                        $products2[$i2]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                        $modules[$j]['total_lessons']+=$row4->lessons;
                        $modules[$j]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                        $k++;
                    }
                    $modules[$j]['items']=$module_items;
                    $j++;
                }
                $products2[$i2]['modules']=$modules;
                $i2++;
            }
            $courses[$i]['products']=$products2;
            
            $i++;
        }
        
        $notes=array(); $i=0;
        $row=DB::select("SELECT * FROM notes WHERE contact_id='$id' ORDER BY id DESC");
        foreach($row as $r)
        {
            $notes[$i]['note']=$r;
            
            $notes[$i]['user']='NA';
            $user=DB::select("SELECT id, name, email FROM users WHERE id='$r->added_by' LIMIT 1");
            if(count($user)==1)
            {
                $user=collect($user)->first();
                $notes[$i]['user']=$user;
            }
            
            $i++;
        }
        
        $funding_sources=DB::select("SELECT id, name, address FROM funding_sources ORDER BY name ASC");
        $experts=DB::select("SELECT id, name FROM contacts WHERE type='Expert Advisor' ORDER BY name ASC");
        return view('panel.edit_contact.index', ['title'=>'Edit Contact', 'contact'=>$contact, 'funding_sources'=>$funding_sources, 'experts'=>$experts, 'funding_source'=>$funding_source, 'courses'=>$courses, 'notes'=>$notes]);
    }
    
    public function add_notes(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        $data=array();
        $data['success']=0;
        
        $c_id=$request->input('c_id');
        $notes=$request->input('notes');
        
        DB::insert("INSERT INTO notes (contact_id, notes, added_by, added_on) VALUES ('$c_id', '$notes', '$admin_id', NOW())");
        $id=DB::getPdo()->lastInsertId();
        
        $notes=DB::select("SELECT * FROM notes WHERE id='$id' LIMIT 1");
        $notes=collect($notes)->first();
        
        $user=DB::select("SELECT id, name, email FROM users WHERE id='$admin_id' LIMIT 1");
        $user=collect($user)->first();
        
        $data['notes']="<div style='border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;'>
                                                        <div style='overflow:hidden;''>
                                                            <div class='float-left'>
                                                                ".$user->name."
                                                                <p style='color:#777'>".$user->email."</p>
                                                            </div>
                                                            
                                                            <div class='float-right'>
                                                                ".date_format(new DateTime($notes->added_on),'d-m-Y')."
                                                                <p style='color:#777'>".date_format(new DateTime($notes->added_on),'H:i')."</p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div>".$request->input('notes')."</div>
                                                        </div>";
        $data['success']=1;
        
        return response()->json($data);
    }
    
    public function delete_notes(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        $data=array();
        $data['success']=0;
        
        $id=$request->input('id');
        
        DB::delete("DELETE FROM notes WHERE id='$id'");
        $data['success']=1;
        
        return response()->json($data);
    }
    
    public function check_email(Request $request)
    {
        $data=array();
        $data['success']=0;
        
        $id=$request->input('id');
        $email=$request->input('email');
        
        $check=DB::select("SELECT id FROM contacts WHERE email='$email' AND id!='$id' LIMIT 1");
        if(count($check)==0) $data['success']=1;
        
        return response()->json($data);
    }
    
    public function convert(Request $request, $id)
    {
        $contact=DB::select("SELECT * FROM contacts WHERE id='$id' LIMIT 1");
        if(count($contact)==0) return redirect('admin/contacts');
        $contact=collect($contact)->first();
        
        $funding_source=array();
        $funding_source['address']='';
        $check=DB::select("SELECT address FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if(count($check)==1)
        {
            $check=collect($check)->first();
            $funding_source['address']=$check->address;
        }
        
        if($request->input('convert')!='')
        {
            $convert=addslashes($request->input('convert'));
            $username=addslashes($request->input('username'));
            $pass=addslashes($request->input('pass'));
            $first_name=addslashes($request->input('first_name'));
            $last_name=addslashes($request->input('last_name'));
            $name=$first_name.' '.$last_name;
            $email=addslashes($request->input('email'));
            $type=addslashes($request->input('type'));
            
            $product=addslashes($request->input('product'));
            $funding_donors=addslashes($request->input('funding_donors'));
            $contact_name=addslashes($request->input('contact_name'));
            $contact_email=addslashes($request->input('contact_email'));
            $address=addslashes($request->input('address'));
            $city=addslashes($request->input('city'));
            $zip_code=addslashes($request->input('zip_code'));
            $measure_no=addslashes($request->input('measure_number'));
            $subject_area=addslashes($request->input('subject_area'));
            $internship_company=addslashes($request->input('internship_company'));
            $organisation=addslashes($request->input('organisation'));
            $position=addslashes($request->input('position'));
            $comments=addslashes($request->input('comments'));
            $other_client=addslashes($request->input('other_client'));
            $jurisdiction=addslashes($request->input('jurisdiction'));
            $source_funding=addslashes($request->input('source_funding'));
            $source_name=addslashes($request->input('source_name'));
            $source_location=addslashes($request->input('source_location'));
            
            $company_name=addslashes($request->input('company_name'));
            if($type=='Internship Company') $name=$company_name;
            $gender=addslashes($request->input('gender'));
            $street_name=addslashes($request->input('street_name'));
            $door_no=addslashes($request->input('door_no'));
            $dob=addslashes($request->input('dob'));
            $phone_no=addslashes($request->input('phone_no'));
            $marital_status=addslashes($request->input('marital_status'));
            $child_care=addslashes($request->input('child_care'));
            $funding_source=addslashes($request->input('funding_source'));
            
            $contact_person='';
            if($request->input('contact_person')!='')
            $contact_person=implode(',', $request->input('contact_person'));
            
            $customer_no=addslashes($request->input('customer_no'));
            $org_zeichen=addslashes($request->input('org_zeichen'));
            
            $start_working=addslashes($request->input('start_working'));
            $bank_name=addslashes($request->input('bank_name'));
            $iban=addslashes($request->input('iban'));
            $bic=addslashes($request->input('bic'));
            
            $parent_first_name=addslashes($request->input('parent_first_name'));
            $parent_last_name=addslashes($request->input('parent_last_name'));
            $parent_email=addslashes($request->input('parent_email'));
            $parent_street_name=addslashes($request->input('parent_street_name'));
            $parent_door_no=addslashes($request->input('parent_door_no'));
            $parent_address=addslashes($request->input('parent_address'));
            $parent_city=addslashes($request->input('parent_city'));
            $parent_zip_code=addslashes($request->input('parent_zip_code'));
            $parent_dob=addslashes($request->input('parent_dob'));
            $parent_phone_no=addslashes($request->input('parent_phone_no'));
            
            $unlimited_employment=addslashes($request->input('unlimited_employment'));
            $employment_end=addslashes($request->input('employment_end'));
            $yearly_salary=addslashes($request->input('yearly_salary'));
            $working_hours=addslashes($request->input('working_hours'));
            $probation_period=addslashes($request->input('probation_period'));
            $employment_position=addslashes($request->input('employment_position'));
            
            $vouchers=addslashes($request->input('vouchers'));
            
            $types='';
            if($request->input('types')!='') $types=implode(',', $request->input('types'));
            
            if($type=='Coach' AND $request->input('types2')!='') $types=implode(',', $request->input('types2'));
            
            $beginning=''; $end='';
            $period=addslashes($request->input('period'));
            if($period!='')
            {
                $dates=explode(' - ', $period);
                $beginning=date_format(new DateTime($dates[0]),'Y-m-d');
                $end=date_format(new DateTime($dates[1]),'Y-m-d');
            }
            
            $contact=DB::select("SELECT id, name, email, type FROM contacts WHERE id='$id' LIMIT 1");
            $contact=collect($contact)->first();
            $name=$contact->name;
            $email=$contact->email;
            $type=$contact->type;
            
            DB::update("UPDATE contacts SET type='$convert', name='$name', email='$email', type='$convert', product='$product', funding_donors='$funding_donors', contact_name='$contact_name', contact_email='$contact_email', address='$address', city='$city', zip_code='$zip_code', measure_no='$measure_no', subject_area='$subject_area', internship_company='$internship_company', organisation='$organisation', position='$position', comments='$comments', other_client='$other_client', jurisdiction='$jurisdiction', source_funding='$source_funding', source_name='$source_name', source_location='$source_location', company_name='$company_name', gender='$gender', street_name='$street_name', door_no='$door_no', dob='$dob', phone_no='$phone_no', marital_status='$marital_status', child_care='$child_care', funding_source='$funding_source', contact_person='$contact_person', beginning='$beginning', end='$end', types='$types', customer_no='$customer_no', org_zeichen='$org_zeichen', start_working='$start_working', bank_name='$bank_name', iban='$iban', bic='$bic', parent_first_name='$parent_first_name', parent_last_name='$parent_last_name', parent_email='$parent_email', parent_street_name='$parent_street_name', parent_door_no='$parent_door_no', parent_address='$parent_address', parent_city='$parent_city', parent_zip_code='$parent_zip_code', parent_dob='$parent_dob', parent_phone_no='$parent_phone_no', unlimited_employment='$unlimited_employment', employment_end='$employment_end', yearly_salary='$yearly_salary', working_hours='$working_hours', probation_period='$probation_period', employment_position='$employment_position', vouchers='$vouchers' WHERE id='$id'");
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Converted contact to '.$convert.' - #'.$id.' '.$name);
            //track Activity END
            
            $contract=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$id', '$contract', '$convert', NOW())");
            $c_id=DB::getPdo()->lastInsertId();
            $contract=DB::select("SELECT * FROM contracts WHERE id='$c_id' LIMIT 1");
            $contract=collect($contract)->first();
            
            DB::delete("DELETE FROM contact_courses WHERE c_id='$id' AND contract_id='$c_id'");
            if(!empty($request->input('courses')))
                {
                    foreach($request->input('courses') as $c)
                    {
                        $course=DB::select("SELECT coach FROM courses WHERE id='$c' LIMIT 1");
                        if(count($course)==1) {
                            $course=collect($course)->first();
                            DB::update("UPDATE contracts SET coach='$course->coach' WHERE id='$contract->id'");
                        }
                        
                        DB::insert("INSERT INTO contact_courses (c_id, course_id, contract_id) VALUES ('$id', '$c', '$c_id')");
                        $id2=DB::getPdo()->lastInsertId();
                        
                        $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$c'");
                        foreach($row1 as $r1)
                        {
                
                            $row2=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$c'");
                            foreach($row2 as $r2)
                            {
                
                                $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$c'");
                                $module_items=array(); $k=0;
                                foreach($row3 as $r3)
                                {
                                    $lessons=$request->input('lessons'.$r3->id);
                                    DB::insert("INSERT INTO contract_lessons (c_id, course_id, contract_id, i_id, lessons) VALUES ('$id', '$c', '$c_id', '$r3->id', '$lessons')");
                                }
                            }
                        }
                    }
                }
            
            /*DB::delete("DELETE FROM contact_items WHERE c_id='$id'");
            DB::delete("DELETE FROM contact_modules WHERE c_id='$id'");
            DB::delete("DELETE FROM contact_products WHERE c_id='$id'");
            if(!empty($request->input('products')))
                {
                    foreach($request->input('products') as $p)
                    {
                        DB::insert("INSERT INTO contact_products (c_id, p_id) VALUES ('$id', '$p')");
                        
                        if(!empty($request->input('modules'.$p)))
                        {
                            foreach($request->input('modules'.$p) as $m)
                            {
                                DB::insert("INSERT INTO contact_modules (c_id, p_id, m_id) VALUES ('$id', '$p', '$m')");
                                
                                if(!empty($request->input('items'.$p)))
                                {
                                    foreach($request->input('items'.$p) as $i)
                                    {
                                        DB::insert("INSERT INTO contact_items (c_id, p_id, m_id, i_id) VALUES ('$id', '$p', '$m', '$i')");
                                    }
                                }
                            }
                        }
                    }
                }*/
            
            //create contract start
            if($convert=='Student' OR $convert=='Coach')
            {
                if($request->input('contract_type')!='')
                {
                    $convert=$request->input('contract_type');
                }
            }
            $c_id=$this->create_contract($request, $id, $convert, $contract);
            //create contract end
            
            if($type=='Prospect' OR $type=='Internship Company') {
                //send password reset link START
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
                    Mail::send('emails.set', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Welcome to NextLevel Akademie');
                        //$message->attach($pathToFile);
                    });
                //send password reset link END
                }
            
            //send email alert with contract link start
            $this->email_contract($id, $c_id);
                    /*$from=env('MAIL_USERNAME');
                    $data2=array(
                        'type'=>$convert,
                        'c_id'=>$c_id,
                        'email'=>$email,
                        'from'=>$from,
                        'name'=>$name
                    );
                    Mail::send('emails.converted', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Congratulations!');
                        //$message->attach($pathToFile);
                    });*/
            //send email alert with contract link end
            
            $request->session()->flash('success', 'Contact has been converted successfully.');
            return redirect('admin/contacts');
        }
        
        $courses=array(); $i=0;
        $row=DB::select("SELECT * FROM courses ORDER BY title ASC");
        foreach($row as $r)
        {
            $courses[$i]['course']=$r;
            
            $courses[$i]['total_cost']=0;
            $courses[$i]['total_lessons']=0;
            $products2=array(); $i2=0;
            $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$r->id'");
            foreach($row1 as $r1)
            {
                $row22=DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
                if(count($row22)==0) continue;
                $row22=collect($row22)->first();
                $products2[$i2]['product']=$row22;
                
                
                $products2[$i2]['total_cost']=0;
                $products2[$i2]['total_lessons']=0;
                
                $row2=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$r->id'");
                $modules=array(); $j=0;
                foreach($row2 as $r2)
                {
                    $row22=DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                    if(count($row22)==0) continue;
                    $row22=collect($row22)->first();
                    $modules[$j]['module']=$row22;
                
                    $modules[$j]['total_cost']=0;
                    $modules[$j]['total_lessons']=0;
                
                    $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$r->id'");
                    $module_items=array(); $k=0;
                    foreach($row3 as $r3)
                    {
                        $module_items[$k]['course_item']=$r3;
                        
                        $row4=DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                        if(count($row4)==0) continue;
                        $row4=collect($row4)->first();
                        $module_items[$k]['item']=$row4;
                    
                        $courses[$i]['total_lessons']+=$row4->lessons;
                        $courses[$i]['total_cost']+=$row4->lessons*$row4->price_lessons;
                        
                        $products2[$i2]['total_lessons']+=$row4->lessons;
                        $products2[$i2]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                        $modules[$j]['total_lessons']+=$row4->lessons;
                        $modules[$j]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                        $k++;
                    }
                    $modules[$j]['items']=$module_items;
                    $j++;
                }
                $products2[$i2]['modules']=$modules;
                $i2++;
            }
            $courses[$i]['products']=$products2;
            
            $i++;
        }
        
        $funding_sources=DB::select("SELECT id, name, address FROM funding_sources ORDER BY name ASC");
        $experts=DB::select("SELECT id, name FROM contacts WHERE type='Expert Advisor' ORDER BY name ASC");
        return view('panel.convert.index', ['title'=>'Convert', 'contact'=>$contact, 'funding_sources'=>$funding_sources, 'experts'=>$experts, 'funding_source'=>$funding_source, 'courses'=>$courses]);
    }
    
    public function contract(Request $request)
    {
        $id=addslashes($request->input('c_id'));
        
        $contact=DB::select("SELECT * FROM contacts WHERE id='$id' LIMIT 1");
        if(count($contact)==0) return redirect('admin/contacts');
        $contact=collect($contact)->first();
        $type=$contact->type;
        $name=$contact->name;
        $email=$contact->email;
        
        $funding_source=array();
        $funding_source['address']='';
        $check=DB::select("SELECT address FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if(count($check)==1)
        {
            $check=collect($check)->first();
            $funding_source['address']=$check->address;
        }
        
        if($request->input('contract_type')!='')
        {
            $contract_type=addslashes($request->input('contract_type'));
            $id=addslashes($request->input('c_id'));
            $beginning=''; $end='';
            $period=addslashes($request->input('period'));
            if($period!='')
            {
                $dates=explode(' - ', $period);
                $beginning=date_format(new DateTime($dates[0]),'Y-m-d');
                $end=date_format(new DateTime($dates[1]),'Y-m-d');
            }
            
            $p_qualifications='';
            if($request->input('p_qualifications')!='') $p_qualifications=implode(';', $request->input('p_qualifications'));
            $e_qualifications='';
            if($request->input('e_qualifications')!='') $e_qualifications=implode(';', $request->input('e_qualifications'));
            
            $course_id=addslashes($request->input('course'));
            $installments=addslashes($request->input('installments'));
            $consultation_date='';
            if($request->input('consultation_date')!='')
            $consultation_date=date_format(new DateTime($request->input('consultation_date')),'Y-m-d');
            
            $contract=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
            DB::insert("INSERT INTO contracts (c_id, contract, course_id, type, on_date, beginning, end, professional_qualifications, elective_qualifications, installments, consultation_date) VALUES ('$id', '$contract', '$course_id', '$contract_type', NOW(), '$beginning', '$end', '$p_qualifications', '$e_qualifications', '$installments', '$consultation_date')");
            $c_id=DB::getPdo()->lastInsertId();
            $contract=DB::select("SELECT * FROM contracts WHERE id='$c_id' LIMIT 1");
            $contract=collect($contract)->first();
            
            /*DB::delete("DELETE FROM contact_courses WHERE c_id='$id' AND contract_id='$c_id'");
            if(!empty($request->input('courses')))
                {
                    foreach($request->input('courses') as $c)
                    {
                        DB::insert("INSERT INTO contact_courses (c_id, course_id, contract_id) VALUES ('$id', '$c', '$c_id')");
                        $id2=DB::getPdo()->lastInsertId();
                        $course_id=$c;
                        
                        $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$c'");
                        foreach($row1 as $r1)
                        {
                
                            $row2=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$c'");
                            foreach($row2 as $r2)
                            {
                
                                $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$c'");
                                $module_items=array(); $k=0;
                                foreach($row3 as $r3)
                                {
                                    $lessons=$request->input('lessons'.$r3->id);
                                    DB::insert("INSERT INTO contract_lessons (c_id, course_id, contract_id, i_id, lessons) VALUES ('$id', '$c', '$c_id', '$r3->id', '$lessons')");
                                }
                            }
                        }
                    }
                }*/
            
            //add products to the contract created
            $p_ids=array();
            if(!empty($request->input('products')))
                {
                    foreach($request->input('products') as $p)
                    {
                        DB::insert("INSERT INTO contract_products (contract_id, course_id, c_id, p_id) VALUES ('$c_id', '$course_id', '$id', '$p')");
                        if(!in_array($p, $p_ids)) $p_ids[]=$p;
                        
                        if(!empty($request->input('modules'.$p)))
                        {
                            foreach($request->input('modules'.$p) as $m)
                            {
                                DB::insert("INSERT INTO contract_modules (contract_id, course_id, c_id, p_id, m_id) VALUES ('$c_id', '$course_id', '$id', '$p', '$m')");
                                
                                if(!empty($request->input('items'.$p)))
                                {
                                    foreach($request->input('items'.$p) as $i)
                                    {
                                        $lessons=$request->input('lessons'.$i);
                                        DB::insert("INSERT INTO contract_items (contract_id, course_id, c_id, p_id, m_id, i_id, lessons) VALUES ('$c_id', '$course_id', '$id', '$p', '$m', '$i', '$lessons')");
                                    }
                                }
                            }
                        }
                    }
                }
            
            //add student to the course
            $course=DB::select("SELECT students FROM courses WHERE id='$course_id' LIMIT 1");
            if(count($course)==1) 
            {
                $course=collect($course)->first();
                $students=array();
                if($course->students!='') $students=explode(';', $course->students);
            
                $students[]=$id;
                $new_students=implode(';', $students);
                DB::update("UPDATE courses SET students='$new_students' WHERE id='$course_id'");
            }
            
            
            //add products to the course
            $products_added=array();
            $c=$course_id;
            foreach($p_ids as $p)
            {
                $check=DB::select("SELECT id FROM course_products WHERE p_id='$p' AND c_id='$course_id' LIMIT 1");
                if(count($check)==0)
                {
                    $row22=DB::select("SELECT * FROM products WHERE id='$p' LIMIT 1");
                    if(count($row22)==0) continue;
                    $row22=collect($row22)->first();
                    
                    if(in_array($p, $products_added)) continue;
                    $products_added[]=$p;
                    
                    DB::insert("INSERT INTO course_products (c_id, p_id) VALUES ('$c', '$p')");
                
                    $row2=DB::SELECT("SELECT id, m_id FROM product_modules WHERE p_id='$p'");
                    $modules=array(); $j=0;
                    foreach($row2 as $r2)
                    {
                        $row22=DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                        if(count($row22)==0) continue;
                        $row22=collect($row22)->first();
                        
                        DB::insert("INSERT INTO course_modules (c_id, p_id, m_id) VALUES ('$c', '$p', '$row22->id')");
                
                        $row3=DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r2->m_id'");
                        $module_items=array(); $k=0;
                        foreach($row3 as $r3)
                        {
                            $row4=DB::SELECT("SELECT * FROM module_items WHERE id='$r3->m_id' LIMIT 1");
                            if(count($row4)==0) continue;
                            $row4=collect($row4)->first();
                                
                            DB::insert("INSERT INTO course_items (c_id, p_id, m_id, i_id) VALUES ('$c', '$p', '$r2->m_id', '$r3->m_id')");
                        }
                    }
                }
            }
            
            //create contract start
            $c_id=$this->create_contract($request, $id, $contract_type, $contract);
            //create contract end
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Created contract "'.$contract_type.'" for - #'.$id.' '.$name);
            //track Activity END
            
            if($type=='Prospect' OR $type=='Internship Company') {
                //send password reset link START
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
                    Mail::send('emails.set', $data2, function($message) use($email, $from, $name) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject('Welcome to NextLevel Akademie');
                        //$message->attach($pathToFile);
                    });
                //send password reset link END
                }
            
            //send email alert with contract link start
                    $this->email_contract($id, $c_id);
            //send email alert with contract link end
            
            $request->session()->flash('success', 'Contract has been created successfully.');
            return redirect('admin/contacts');
        }
    }
    
    public function create_contract(Request $request, $c_id, $type, $contract=0, $coach=0)
    {
        ini_set('memory_limit', '-1');
        require('fpdf17/fpdf.php');
        //require('fpdi/src/autoload.php');
        
        $contact=DB::select("SELECT * FROM contacts WHERE id='$c_id' LIMIT 1");
        $contact=collect($contact)->first();
        
        //create contract
        if($type=='Student' OR $type=='Education Contract for Student') $c_id=$this->student_contract($request, $contact, $type, $contract, $coach);
        
        else if($type=='Extended Education Contract for Student') $c_id=\Contracts::instance()->extended_contract($request, $contact, $type, $contract, $coach);
        
        else if($type=='Retraining Contract for Coachee / Student') $c_id=\Contracts::instance()->retraining_contract($request, $contact, $type, $contract, $coach);
        
        else if($type=='Amendments to Retraining Contract') $c_id=\Contracts::instance()->amendments_contract($request, $contact, $type, $contract, $coach);
        
        else if($type=='Coachee' OR $type=='Coaching Contract for Coachee') $c_id=$this->coachee_contract($request, $contact, $type, $contract, $coach);
        
        else if($type=='Coach' OR $type=='Lecturer' OR $type=='Standard contract for Coach / Trainer') $c_id=$this->coach_contract($request, $contact, $type, $contract, $coach);
        
        else if($type=='Private Jobsearch contract for Student / Coachee') $c_id=\Contracts::instance()->private_jobsearch_contract($request, $contact, $type, $contract, $coach);
        
        else $c_id=$this->student_contract($request, $contact, $type, $contract, $coach);
        
        //Create execution plan 
        $courses=array(); $i=0;
        $row=DB::select("SELECT * FROM contact_courses WHERE c_id='$contact->id' AND contract_id='$c_id'");
        if(count($row)!=0)
        {
            foreach($row as $r)
            {
                $row2=DB::select("SELECT id, title, coach FROM courses WHERE id='$r->course_id' LIMIT 1");
                if(count($row2)==0) continue;
                $row2=collect($row2)->first();
                
                $courses[$i]['contract']=$c_id;
                $courses[$i]['course']=$row2;
                
                $courses[$i]['coach']='NA';
                $row1=DB::select("SELECT * FROM contacts WHERE id='$row2->coach' LIMIT 1");
                if(count($row1)==1)
                {
                    $row1=collect($row1)->first();
                    $courses[$i]['coach']=$row1;
                }
                
                $courses[$i]['contact']=$contact;
                
                $classes=array(); $i2=0;
                $row1=DB::SELECT("SELECT * FROM classes WHERE course_id='$row2->id'");
                foreach($row1 as $r1)
                {
                    $classes[$i2]['class']=$r1;
                
                    $classes[$i2]['room']='';
                    $row22=DB::select("SELECT id, name, location FROM rooms WHERE id='$r1->room' LIMIT 1");
                    if(count($row22)==1)
                    {
                        $row22=collect($row22)->first();
                        $classes[$i2]['room']=$row22->name;
                    
                        $row22=DB::select("SELECT id, name FROM room_locations WHERE id='$row22->location' LIMIT 1");
                        if(count($row22)==1)
                        {
                            $row22=collect($row22)->first();
                            $classes[$i2]['room'].=' ('.$row22->name.')';
                        }
                    }
                
                    $i2++;
                }
                $courses[$i]['classes']=$classes;
                
                
                $i++;
            }
        }
        
        
        //$c_pdf=$this->create_timetable($courses);
        //$this->create_tiemtable_appointments($courses);
        //Create execution plan END
        
        return $c_id;
    }
    
    public function email_contract($c, $c_id)
    {
        $contact=DB::select("SELECT * FROM contacts WHERE id='$c' LIMIT 1");
        if(count($contact)==0) return redirect('admin/contacts');
        $contact=collect($contact)->first();
        $type=$contact->type;
        $name=$contact->name;
        $email=$contact->email;
        
        $contract=DB::select("SELECT * FROM contracts WHERE id='$c_id' LIMIT 1");
        if(count($contract)==0) return redirect('admin/contacts');
        $contract=collect($contract)->first();
        $contract_type=$contract->type;
        $timetable=$contract->timetable;
        
                    $from=env('MAIL_USERNAME');
                    $data2=array(
                        'contract_type'=>$contract_type,
                        'timetable'=>$timetable,
                        'c_id'=>$c_id,
                        'email'=>$email,
                        'from'=>$from,
                        'name'=>$name
                    );
                    Mail::send('emails.contract', $data2, function($message) use($email, $from, $name, $contract_type) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject($contract_type.' | Contract');
                        //$message->attach($pathToFile);
                    });
        
        //Send email to coach with Timetable
        $courses=array(); $i=0;
        $row=DB::select("SELECT id, course_id, timetable FROM contact_courses WHERE c_id='$c' AND contract_id='$c_id'");
        if(count($row)!=0)
        {
            foreach($row as $r)
            {
                $row2=DB::select("SELECT id, title, coach FROM courses WHERE id='$r->course_id' LIMIT 1");
                if(count($row2)==0) continue;
                $row2=collect($row2)->first();
                
                $courses[$i]['contract']=$c_id;
                $courses[$i]['course']=$row2;
                
                $courses[$i]['coach']='NA';
                $row1=DB::select("SELECT id, email FROM contacts WHERE id='$row2->coach' LIMIT 1");
                if(count($row1)==1)
                {
                    $row1=collect($row1)->first();
                    $courses[$i]['coach']=$row1;
                    
                    $timetable=$r->timetable;
                    $email=$row1->email;
                    $from=env('MAIL_USERNAME');
                    $data2=array(
                        'contract_type'=>$contract_type,
                        'timetable'=>$timetable,
                        'c_id'=>$c_id,
                        'email'=>$email,
                        'from'=>$from,
                        'name'=>$name
                    );
                    Mail::send('emails.contract', $data2, function($message) use($email, $from, $name, $contract_type) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject($contract_type.' | Contract');
                        //$message->attach($pathToFile);
                    });
                }
            }
        }
        //Send email to coach with Timetable
    }
    
    public function create_timetable_appointments($request, $contact_id, $type, $contract, $coach)
    {
        $data=array();
        $data['success']=0;
        
        if($contract->beginning=='0000-00-00' OR $contract->end=='0000-00-00')
                {
                    $flag=0; 
                    $reason='Begining and End dates are not set.';
                    $data['error']=$reason;
                    return response()->json($data);
                }
        
        $c_id=$contract->id;
        $courses=array(); $i=0; $total_lessons=0;
        $row=DB::select("SELECT * FROM contact_courses WHERE c_id='$contact_id' AND contract_id='$c_id'");
        if(count($row)!=0)
        {
            foreach($row as $r)
            {
                $row2=DB::select("SELECT id, title, coach, type FROM courses WHERE id='$r->course_id' LIMIT 1");
                if(count($row2)==0) continue;
                $row2=collect($row2)->first();
                
                $courses[$i]['contract']=$c_id;
                $courses[$i]['course']=$row2;
                
                $c=$r->course_id;
                $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$c'");
                foreach($row1 as $r1)
                {
                    $row22=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$c'");
                    foreach($row22 as $r2)
                    {
                        $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$c'");
                        $module_items=array(); $k=0;
                        foreach($row3 as $r3)
                        {
                            $row4=DB::select("SELECT lessons FROM contract_lessons WHERE c_id='$contact_id' AND course_id='$c' AND contract_id='$c_id' AND i_id='$r3->id' LIMIT 1");
                            if(count($row4)==1)
                            {
                                $row4=collect($row4)->first();
                                $total_lessons+=$row4->lessons;
                            }
                        }
                    }
                }
                
                $courses[$i]['coach']='NA';
                $row1=DB::select("SELECT * FROM contacts WHERE id='$row2->coach' LIMIT 1");
                if(count($row1)==1)
                {
                    $row1=collect($row1)->first();
                    $courses[$i]['coach']=$row1;
                }
                
                $courses[$i]['contact']=$contact_id;
                
                $classes=array(); $i2=0;
                $row1=DB::SELECT("SELECT * FROM classes WHERE course_id='$row2->id'");
                foreach($row1 as $r1)
                {
                    $classes[$i2]['class']=$r1;
                
                    $i2++;
                }
                $courses[$i]['classes']=$classes;
                
                
                $i++;
            }
        }
        
        $dates=array(); $date=$contract->beginning; $di=0; $dates2=array();
        $days=array(); $days_filter='';
        foreach($courses as $course)
        {
            if(empty($course['classes'])) 
                {
                    $flag=0; 
                    $reason='Timetable is not created.';
                    $data['error']=$reason;
                    return response()->json($data);
                }
            
            $coach=$course['course']->coach;
            $app_dates=array(); $j=0;
            for($i=0; $i<$total_lessons; $i++)
            {
                //echo $i;
                for(; $j<count($course['classes']); )
                {
                    $from=$course['classes'][$j]['class']->fromm;
                    $date2=date('Y-m-d', strtotime("+".$di." day", strtotime($date)));
                    if(in_array($date.' '.$from, $dates2))
                    { $date=$date2; $di++; }
                    
                    $dates2[]=$date.' '.$from;
                    $days2=explode(';', $course['classes'][$j]['class']->day);
                    
                    foreach($days2 as $dd2) {
                    if(!in_array($dd2, $days))
                    {
                        $days[]=$dd2;
                        if($i!=0) $days_filter.=',';
                        
                        if($dd2=='Monday')
                        $days_filter.='MO';
                        else if($dd2=='Tuesday')
                        $days_filter.='TU';
                        else if($dd2=='Wednesday')
                        $days_filter.='WE';
                        else if($dd2=='Thursday')
                        $days_filter.='TH';
                        else if($dd2=='Friday')
                        $days_filter.='FR';
                        else if($dd2=='Saturday')
                        $days_filter.='SA';
                        else if($dd2=='Sunday')
                        $days_filter.='SU';
                    }
                    }
                        
                    $dates[$dd2][]=$date;
                    //echo 'Date: '.$date.' '.$from.' >> '.$course['classes'][$j]['class']->name.'<br>';
                    if($j==count($course['classes'])-1) $j=0;
                    else
                    $j++;
                    break;
                }
                //echo '<br>';
            }
            
            $startDate   = new \DateTime($contract->beginning);
            $until=$contract->end;
            $until=date_format(new DateTime($until),'Y-m-d');
            $rule=new \Recurr\Rule('FREQ=WEEKLY;BYDAY='.$days_filter.';UNTIL='.$until, $startDate);
            
            $transformer = new \Recurr\Transformer\ArrayTransformer();
        
            $transformerConfig = new \Recurr\Transformer\ArrayTransformerConfig();
            $transformerConfig->enableLastDayOfMonthFix();
            $transformer->setConfig($transformerConfig);
        
            $t_date=date('Y-m-d');
            $constraint = new \Recurr\Transformer\Constraint\BetweenConstraint(new \DateTime($contract->beginning.' 00:00:00'), new \DateTime($until.' 23:59:00'), true);
            $results=$transformer->transform($rule, $constraint, null);
            
            foreach($results as $result){
                $start = $result->getStart();
                $app_dates[]=$start->format('Y-m-d');
                $start_time=$start->format('H:i');
                
                //echo $date2.'<< <br>';
            }
            //echo '<br>';
            
            $flag=1; $reason='';
            $app_assigned=array(); $total_hours=1;
            foreach($app_dates as $date)
            {
                $day=date_format(new DateTime($date),'l');
                foreach($course['classes'] as $class)
                {
                    if($total_hours>$total_lessons) break;
                    $title=$class['class']->name;
                    $description='';
                    $time=date_format(new DateTime($class['class']->fromm),'H:i');
                    $time_end=date_format(new DateTime($class['class']->too),'H:i');
                    $date2=date_format(new DateTime($date),'d-m-Y');
                    $room=$class['class']->room;
                    $app=$date.' '.$class['class']->fromm;
                    
                    $course_id=$class['class']->course_id;
                    
                    if($day==$class['class']->day)
                    {
                        if(!in_array($app, $app_assigned))
                        {
                            $check=DB::select("SELECT id FROM appointments WHERE room='$room' AND course_id!='$course_id' AND date='$date' AND (time>='$time' AND time_end<='$time_end')");
                            if(count($check)!=0)
                            {
                                //not available
                                $room=DB::select("SELECT name, location FROM rooms WHERE id='$room' LIMIT 1");
                                $room=collect($room)->first();
                                
                                $room_location=DB::select("SELECT name FROM room_locations WHERE id='$room->location' LIMIT 1");
                                $room_location=collect($room_location)->first();
                                $room_location=$room_location->name;
                                
                                $reason.=$room->name.' ('.$room_location.') is not available on <b>'.$day.' '.$date2.' at '.$time.' - '.$time_end.'</b> for class: '.$title.'<br>';
                                $flag=0;
                            }
                        }
                    }
                }
            }
            
            if($flag==0)
            {
                DB::update("UPDATE contracts SET appointments='$flag', reason='$reason' WHERE id='$contract->id'");
                $request->session()->flash('error', $reason);
                
                $data['error']=$reason;
                return response()->json($data);
                //return redirect('admin/contracts-documents');
            }
            
            if($courses[0]['course']->type=='Regular')
            {
                DB::update("UPDATE contracts SET appointments='1', reason='' WHERE id='$contract->id'");
            }
            
            if($flag==1 AND $courses[0]['course']->type=='Regular')
            {
            DB::update("UPDATE contracts SET appointments='1', reason='' WHERE id='$contract->id'");
                
            $app_assigned=array(); $total_hours=1;
            foreach($app_dates as $date)
            {
                //echo $date.' - '.date_format(new DateTime($date),'l').'<br>';
                
                $day=date_format(new DateTime($date),'l');
                foreach($course['classes'] as $class)
                {
                    if($total_hours>$total_lessons) break;
                    $title=$class['class']->name;
                    $description='';
                    $time=date_format(new DateTime($class['class']->fromm),'H:i');
                    $time_end=date_format(new DateTime($class['class']->too),'H:i');
                    $room=$class['class']->room;
                    $app=$date.' '.$class['class']->fromm;
                    
                    $course_id=$class['class']->course_id;
                    
                    if($day==$class['class']->day)
                    {
                        if(!in_array($app, $app_assigned))
                        {
                            //echo 'Appointment at '.$app.'<br>';
                            
                            DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id) VALUES ('$contract->c_id', '$room', '$title', '$description', '0', '$date', '$time', '$time_end', '0', NOW(), '0', '$contract->id', '$course_id')");
                            
                            DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id) VALUES ('$coach', '$room', '$title', '$description', '0', '$date', '$time', '$time_end', '0', NOW(), '0', '$contract->id', '$course_id')");
                            
                            $app_assigned[]=$app;
                            $total_hours+=1;
                        }
                    }
                }
                //echo '<br>';
            }
                
                $data['success']=1;
                return response()->json($data);
            }
        }
        
        //echo $total_hours;
        
        //echo '<br>';
        
        
        //exit();
    }
    
    public function create_timetable($courses)
    {
        foreach($courses as $course)
        {
            $pdf = new \Fpdf('P','mm','A4'); //8.5" x 11" laser form
            $pdf->setTitle('Timetable');
	        $pdf->SetDrawColor(172, 172, 172);
	        $pdf->SetTextColor(0, 0, 0);
            $pdf->SetAutoPageBreak(true, 20);
            $pdf->SetMargins(16.35, 16.35, 16.35);
        
            $r_id=1;
            $page_height=0;
            $one_section=0;
            $i=0;
            $current_page=$pdf->PageNo();
            $starting_page_no=$pdf->PageNo();
            $end_page_no=$current_page;
            $end_page_height=0;
        
            $pdf->AddPage();
            $pdf->setLeftMargin(8);
            $pdf->setTopMargin(30);
            $pdf->ln(10);
        
            $pdf->SetDrawColor(172, 172, 172);
	        $pdf->SetTextColor(0, 0, 0);
                
	        $pdf->SetFont('Arial','B',15);
            $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252',$course['course']->title), 0, 0, 'C');
            $pdf->ln(9);
        
            //Add coach details
            $pdf->SetFont('Arial','B',10.8);
            $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Coach:'), 0, 0, 'L');
            $pdf->ln(10);
        
            $address=$course['coach']->door_no.', '.$course['coach']->street_name;
            if($course['coach']->address!='')
            $address.=', '.$course['coach']->address;
            $address.=', '.$course['coach']->city.', '.$course['coach']->zip_code;
            $dob='';
            $pdf->SetFont('Arial','',10.8);
            $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','Name, Vorname:            '.$course['coach']->name.'
Anschrift/PLZ/Ort:           '.$address.'
Telefon/Handy:               '.$course['coach']->phone_no.'
E-Mail       :                     '.$course['coach']->email.'
'),0,'LR');
        
        $pdf->ln(1);
            
            //Add student details
            $pdf->SetFont('Arial','B',10.8);
            $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Student:'), 0, 0, 'L');
            $pdf->ln(10);
        
            $address=$course['contact']->door_no.', '.$course['contact']->street_name;
            if($course['contact']->address!='')
            $address.=', '.$course['contact']->address;
            $address.=', '.$course['contact']->city.', '.$course['contact']->zip_code;
            $dob='';
            $pdf->SetFont('Arial','',10.8);
            $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','Name, Vorname:            '.$course['contact']->name.'
Anschrift/PLZ/Ort:           '.$address.'
Telefon/Handy:               '.$course['contact']->phone_no.'
E-Mail       :                     '.$course['contact']->email.'
'),0,'LR');
        
        $pdf->ln(0);
            
            // Create earnings table START
        $data=array();
        $page_height=$pdf->GetY();
        $pdf->SetXY(8, $page_height+10);
        $header=array(iconv('UTF-8', 'windows-1252', 'Class'), iconv('UTF-8', 'windows-1252', 'From'), iconv('UTF-8', 'windows-1252', 'To'), iconv('UTF-8', 'windows-1252', 'Room'));
            
        foreach($course['classes'] as $class)
        {
            $data[]=array(iconv('UTF-8', 'windows-1252', $class['class']->name), iconv('UTF-8', 'windows-1252', date_format(new DateTime($class['class']->fromm),'H:i')), iconv('UTF-8', 'windows-1252', date_format(new DateTime($class['class']->too),'H:i')), iconv('UTF-8', 'windows-1252', $class['room']));
        }
        
        // Column widths
        $w = array(70, 22, 22, 80);
        // Header
        $pdf->SetFont('Arial','B',10);
        for($i2=0;$i2<count($header);$i2++)
            $pdf->Cell($w[$i2],13,$header[$i2],0,0,'LR');
            $pdf->Ln(14);
                
            $pdf->SetXY(8, $page_height+20);
            $pdf->Cell(array_sum($w),0,'','T');
            $pdf->Ln(2);
            $current_y=$page_height+22;
        
            // Data
                $pdf->SetFont('Arial','',10);
                    $i2=0; $ys=array(); $ys[]=$pdf->GetY();
                    foreach($data as $row)
                    {   
                        $current_x=8;
                        $pdf->MultiCell($w[0],4,$row[0],0,'LR');
                        $current_x+=$w[0];
                        
                        $ys[]=$pdf->GetY();
                        $pdf->SetXY($current_x, $current_y);
                        
                        $pdf->MultiCell($w[1],4,$row[1],0,'LR');
                        $current_x+=$w[1];
                        
                        $ys[]=$pdf->GetY();
                        $pdf->SetXY($current_x, $current_y);
                        
                        $pdf->MultiCell($w[2],4,$row[2],0,'LR');
                        $current_x+=$w[2];
                        
                        $ys[]=$pdf->GetY();
                        $pdf->SetXY($current_x, $current_y);
                        
                        $pdf->MultiCell($w[3],4,$row[3],0,'LR');
                        $current_x+=$w[3];
                        
                        $pdf->Ln(3);
                        
                        $current_y=$pdf->GetY();
                    }
                
            $y=max($ys);
            $pdf->SetXY($pdf->GetX(), $y+2);
            // Closing line
            $pdf->Ln(0);
            $pdf->Cell(array_sum($w),0,'','T');
            $pdf->Ln(4);
        
            //Validity
            //$pdf->SetFont('Arial','B',10);
            //$pdf->Cell($w[0],4,'Validity:',0,'LR');            
            //$pdf->Cell($w[1],4,'12/02/2020 - 18/01/20202',0,'LR');
        
            $pdf->Ln(6);
            // Create earnings table END
            
            //$pdf->output();
            
            $timetable=$course['contract'].rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
            $pdf->Output('timetables/'.$timetable, 'F');
            
            $coach_id=$course['coach']->id;
            $contact_id=$course['contact']->id;
            $course_id=$course['course']->id;
            $contract_id=$course['contract'];
            DB::update("UPDATE contact_courses SET timetable='$timetable', coach='$coach_id' WHERE contract_id='$contract_id' AND course_id='$course_id' AND c_id='$contact_id'");
        }
    }
    
    public function student_contract(Request $request, $contact, $type, $contract=0, $coach=0)
    {
        //ini_set('memory_limit', '-1');
        //require('fpdf17/fpdf.php');
        //require('fpdi/src/autoload.php');
        
        $courses=''; $total_lessons=0; $total_costs=0;
        $products2=array(); $i2=0;
        $row1=DB::SELECT("SELECT id, p_id FROM contract_products WHERE contract_id='$contract->id'");
        foreach($row1 as $r1)
        {
            $row22=DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
            if(count($row22)==0) continue;
            $row22=collect($row22)->first();
            
            $row21=DB::SELECT("SELECT id, m_id FROM contract_modules WHERE p_id='$r1->p_id' AND contract_id='$contract->id'");
            $modules=array(); $j=0;
            foreach($row21 as $r2)
            {
                $row22=DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                if(count($row22)==0) continue;
                $row22=collect($row22)->first();
                
                $row3=DB::SELECT("SELECT id, i_id, lessons FROM contract_items WHERE m_id='$r2->m_id' AND contract_id='$contract->id'");
                $module_items=array(); $k=0;
                foreach($row3 as $r3)
                {
                    $row4=DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                    if(count($row4)==0) continue;
                    $row4=collect($row4)->first();
                    
                    $total_lessons+=$r3->lessons;
                    $total_costs+=$row4->lessons*$row4->price_lessons;
                    
                    $k++;
                }
                $j++;
             }
             $i2++;
          }
         
         $row2=DB::select("SELECT title FROM courses WHERE id='$contract->course_id' LIMIT 1");
         $row2=collect($row2)->first();
         $courses=$row2->title;
        
        if($contract->installments=='0')
        $installments=1;
        else
        $installments=$contract->installments;
        $installment_price=$total_costs/$installments;
        $consultation_date=date_format(new DateTime($contract->consultation_date),'d.m.Y');
        
        $installments_line='';
        if($installments>1)
        $installments_line='Die Gebühren teilen sich in '.$installments.' monatliche Teilzahlungen in Höhe von '.$installment_price.' € pro Monat.';
        
        $funding_source='';
        $funding_address='';
        $funding=DB::select("SELECT * FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if(count($funding)==1)
        {
            $funding=collect($funding)->first();
            $funding_source=$funding->name;
            $funding_address=$funding->address;
        }
        
        $contact_name='';
        $contact_address='';
        $contact_phone='';
        $contact_email='';
        $funding=DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if(count($funding)==1)
        {
            $funding=collect($funding)->first();
            $contact_name=$funding->name;
            $contact_address=$funding->door_no.', '.$funding->street_name;
            if($funding->address!='')
            $contact_address.=', '.$funding->address;
            $contact_address.=', '.$funding->city.', '.$funding->zip_code;
            $contact_phone=$funding->phone_no;
            $contact_email=$funding->email;
        }
        
        if($contract->beginning!='0000-00-00')
        {
            $begin=date_format(new DateTime($contract->beginning),'d.m.Y');
            $end=date_format(new DateTime($contract->end),'d.m.Y');
        }
        else
        {
            $begin=date_format(new DateTime($contact->beginning),'d.m.Y');
            $end=date_format(new DateTime($contact->end),'d.m.Y');
        }
        $c_date=date('d.m.Y');
        
        //$pdf = new \setasign\Fpdi\Fpdi();
        $pdf = new \Fpdf('P','mm','A4'); //8.5" x 11" laser form
        $pdf->setTitle('Contract');
	    $pdf->SetDrawColor(172, 172, 172);
	    $pdf->SetTextColor(0, 0, 0);
	    //$pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetMargins(16.35, 16.35, 16.35);
        
        if($request->input('s')=='0') $status=0;
        else $status=1;
        
        $r_id=1;
        $page_height=0;
        $one_section=0;
        $i=0;
        $current_page=$pdf->PageNo();
        $starting_page_no=$pdf->PageNo();
        $end_page_no=$current_page;
        $end_page_height=0;
        
        $pdf->AddPage();
        $pdf->setLeftMargin(8);
        $pdf->setTopMargin(30);
        $pdf->ln(15);
        
        $pdf->SetDrawColor(172, 172, 172);
	    $pdf->SetTextColor(0, 0, 0);
                
	    $pdf->SetFont('Arial','B',15);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Vertrag über die schulische (Erst-)Ausbildung'), 0, 0, 'C');
        $pdf->ln(9);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Zwischen'), 0, 0, 'L');
        $pdf->ln(14);
        
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','Nextlevel Akademie
Bundesallee 86
12161 Berlin
vertreten durch: Frau Gülhan Dündar (Geschäftsführung)
(nachstehend NLA genannt)'),0,'LR');
        
        $pdf->ln(1);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','und'), 0, 0, 'L');
        
        $pdf->ln(14);
        $address=$contact->door_no.', '.$contact->street_name;
        if($contact->address!='')
        $address.=', '.$contact->address;
        $address.=', '.$contact->city.', '.$contact->zip_code;
        $dob='';
        
        $parent_address='';
        if($contact->parent_door_no!='')
        $parent_address=$contact->parent_door_no.', '.$contact->parent_street_name;
        if($contact->parent_address!='')
        $parent_address.=', '.$contact->parent_address;
        if($contact->parent_city!='')
        $parent_address.=', '.$contact->parent_city.', '.$contact->parent_zip_code;
        $parent_dob='';
        if($parent_dob!='01-01-1900') $dob=$contact->parent_dob;
        
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','Name, Vorname:            '.$contact->name.'
Geburtsdatum(-ort):        '.$dob.'
Anschrift/PLZ/Ort:           '.$address.'
Telefon/Handy:               '.$contact->phone_no.'
E-Mail       :                     '.$contact->email.'
Gesetzlicher Vertreter:

Fördergeldgeber:            '.$funding_source.'
Ansprechpartner:            '.$contact_name.'
Anschrift/PLZ/Ort:           '.$contact_address.'
Telefon/Durchwahl:         '.$contact_phone.'
E-Mail       :                     '.$contact_email.'
'),0,'LR');
        
        $t_date=new DateTime('today');
        $driver_age=date_diff(date_create($dob), $t_date)->y;
        
        if($driver_age<15) {
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','der Auszubildende wird durch seinen gesetzlichen Vertreter vertreten (bei
Minderjährigen):

Name, Vorname:            '.$contact->parent_first_name.' '.$contact->parent_last_name.'
Geburtsdatum(-ort):        '.$parent_dob.'
Anschrift/PLZ/Ort:           '.$parent_address.'
Telefon/Handy:               '.$contact->parent_phone_no.'
E-Mail       :                     '.$contact->parent_email.'
'),0,'LR');
        }
        
        $professional_qualifications=array();
        if($contract->professional_qualifications!='') $professional_qualifications=explode(';', $contract->professional_qualifications);
        $elective_qualifications=array();
        if($contract->elective_qualifications!='') $elective_qualifications=explode(';', $contract->elective_qualifications);
        
        $qualifications='';
        foreach($professional_qualifications as $qual)
        {
            $qualifications.='• '.$qual.'<br> ';
        }
        
        $e_qualifications='';
        foreach($elective_qualifications as $qual)
        {
            $e_qualifications.='• '.$qual.'<br> ';
        }
        
        $pdf->ln(4);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Der Auszubildende vertreten durch seinen gesetzlichen Vertreter und die NLA schließen folgenden Vertrag:<br><br><b>Voraussetzung für den Abschluss dieses Vertrages ist die Vorlegung eines aktuellen Bewilligungsbescheides des Fördergeldgebers, aus dem sich ergibt, dass der Fördergeldgeber die Kosten der Umschulung, die unter Ziffer 4 dieses Vertrages geregelt sind, übernehmen wird.<br>1. Gegenstand und Dauer der Ausbildung</b><br><br>1.1. Gegenstand dieses Vertrages ist eine Umschulung mit IHK <b>- Berufsabschluss zum/zur:<br>
'.$qualifications.'</b>
<br>
Beginn:		'.$begin.'<br>
Ende:			  '.$end.'<br>Als Wahlqualifikation wird festgelegt:<br><br>
'.$e_qualifications.'
<br>Der theoretische Unterricht findet in den Räumlichkeiten der NLA in der Bundesallee 86, 12161 Berlin, statt. (ggf. auch an anderen Orten wie zum Bsp. Nähschule)<br><br>1.2. Der Vertrag beginnt am '.$begin.' und endet am '.$end.' .<br><br>1.3. Zum Beginn der Ausbildung ist ein Pauschalbetrag von 500,00€ für Materialkosten (Bewerbungskosten, Zusatzqualifikation: Nähkurs, Änderungsschneiderei, Pinselset, versch. Trainings uvm.) fällig. Der Betrag kann maximal in zwei Monatsraten ab Beginn zum Monatsanfang gezahlt werden. Bei einem vorzeitigen Abbruch der Ausbildung werden die Kosten nicht zurückerstattet.<br><br>1.3 Das Ausbildungsverhältnis kann sich auf Verlangen des Auszubildenden um maximal ein Jahr gem. § 21 Abs. 3 BBiG verlängern, wenn er die Abschlussprüfung nicht bestanden hat. Ein zusätzlicher Bildungsgutschein ist dann nötig.<br><br>1.4 Der in der Anlage 1 zu diesem Vertrag ersichtliche Termin- und Lehrplan sowie die in der Anlage 2 beigefügte Aufteilung der Ausbildungsphasen stellen einen Bestandteil dieses Vertrages dar. Die als Anlage 3 beigefügte Hausordnung der NLA, die als Anlage 4 beigefügten Allgemeinen Geschäftsbedingungen der NLA stellen einen wesentlichen Bestandteil dieses Vertrages.<br><br><b>2. Rechte und Pflichten der NLA</b><br><br>2.1. Die NLA verpflichtet sich, die fachtheoretischen Ausbildungsinhalte gemäß gültiger „Verordnung für die Berufsausbildung“ mit dem Ziel des Bestehens der Abschlussprüfung durch den schulischen Auszubildenden (m/w) vor der IHK Berlin zu vermitteln.<br><br>2.2. Die NLA erstellt den Termin- und Lehrplan auf der Grundlage der jeweils gültigen „Verordnung für die Berufsausbildung“. Die NLA behält sich vor, den Stoff- und Terminplan zu ändern.<br><br>2.3. Die NLA führt täglich eine Anwesenheitskontrolle durch und dokumentiert diese. Auf Anfrage der IHK Berlin, des Fördergeldgebers oder des BAföG Amtes informiert sie die diese über die An- und Abwesenheiten des Auszubildenden.<br><br>2.4. Die NLA erstellt bei erfolgreichem Abschluss ein Abschlusszeugnis und bei nicht erfolgreichem Beenden der Ausbildung ein Abgangszeugnis, sowie eine Teilnahmebescheinigung über die besuchten Themenbereiche und zusätzlich erworbenen Kompetenzen.<br><br>2.5. Die NLA bestimmt den Ausbildungsbeginn und die Unterrichtszeiten. Sie behält sich vor, den Ausbildungsbeginn oder die Unterrichtszeiten aus begründetem Anlass und mit rechtzeitiger Ankündigung zu ändern. Die Änderungen werden an der Infotafel (und digital über Edupage) ausgehangen. Die NLA informiert den Auszubildenden über die Änderung mit dem Aushang der Information.<br><br>2.6. Die fachpraktische Ausbildung erfolgt auf Grundlage des gültigen Ausbildungsrahmenplans in einem geeigneten Kooperationsunternehmen. Die NLA verpflichtet sich, den Auszubildenden bei der Suche nach einem Kooperationsunternehmen zu unterstützen. Der/Die Auszubildende ist aber ausdrücklich aufgefordert Eigeninitiative in der Suche zu zeigen.<br><br>2.7. Das jeweilige Kooperationsunternehmen erstellt bei Abschluss der Praxisphase ein qualifiziertes Zeugnis. Die NLA hat keine Pflicht, das von dem Kooperationsunternehmen erstellte Zeugnis zu überprüfen. Die NLA hat keinen Einfluss auf das von dem jeweiligen Kooperationsunternehmen erstellte Zeugnis.<br>br>2.8. Unter der Leitung des Kooperationsunternehmens findet die fachpraktische Ausbildung entsprechend des gültigen Ausbildungsrahmenplans in dem Unternehmen statt. Das Kooperationsunternehmen ist gegenüber dem schulischen Auszubildenden (m/w) in allen ausbildungsplatzbezogenen Fragen weisungsberechtigt. Die disziplinarische Verantwortung für den schulischen Auszubildenden (m/w) verbleibt bei der NLA.<br><br>2.9. Die NLA ist berechtigt, den Ausbildungsverlauf beim Kooperationsunternehmen zu kontrollieren. Die NLA hat das Recht, während der fachpraktischen Phase der Ausbildung Kontakt zu seinen schulischen Auszubildenden (m/w) aufzunehmen und sich über die Leistungen und das Verhalten im Kooperationsunternehmen zu informieren.<br><br>2.10. Die regelmäßige wöchentliche Arbeitszeit des schulischen Auszubildenden (m/w) beträgt im Kooperationsunternehmen 37,5 Stunden exklusive Pausen und wird individuell mit dem Kooperationsunternehmen abgesprochen.<br><br>2.11. Die ersten 4 Monate der Theoriephase gelten als Probezeit innerhalb der NextLevel Akademie. Die ersten 2 Monate der fachpraktischen Ausbildung gelten als Probezeit im Kooperationsunternehmen. Am Ende der Probezeit wird in einem gemeinsamen Gespräch zwischen der NLA, dem Kooperationsunternehmen und dem schulischen Auszubildenden (m/w) über die Fortführung der fachpraktischen Ausbildung entschieden.<br><br>2.12. Die fachpraktische Ausbildungsphase im Kooperationsunternehmen ist ein echtes Praktikum, welches nach der Ausbildungsordnung einen zwingend vorgeschriebenen begleitenden Praxisteil darstellt und Voraussetzung für die Zulassung des Auszubildenden (m/w) zur IHK-Abschlussprüfung ist. Dem Auszubildenden (m/w) steht daher kein Vergütungsanspruch zu. Etwas Anderes kann gelten, wenn der Auszubildende mit dem Kooperationsunternehmen eine Vergütungsvereinbarung geschlossen hat. Etwaige Ansprüche auf die Zahlung der Vergütung müssen ggf. gegen das Kooperationsunternehmen und nicht gegen die NLA gerichtet werden.<br><br>2.13. NLA hat unentgeltlich, räumlich und zeitlich unbeschränkt, das Recht zur Verwertung entstandener Fotos, Videos und Sonstiges welche innerhalb der NLA und dessen Unterricht entsteht. Diese werden ausschließlich für Marketingzwecke verwendet. Ein Widerruf ist schriftlich möglich.<br><br><b>3. Rechte und Pflichten des Auszubildenden (m/w)</b><br><br>3.1. Der Auszubildende (m/w) versichert, dass gegen seine Teilnahme an der Ausbildung keine gesundheitlichen Bedenken bestehen.<br><br>3.2. Ist der Auszubildende (m/w) unter 16 Jahre bekommt er mindestens 30 Werktage Urlaub pro Jahr, unter 17 Jahre bekommt er mindestens 27 Werktage Urlaub pro Jahr, unter18 Jahre bekommt er mindestens 25 Werktage Urlaub. Erwachsene Auszubildende haben einen Anspruch auf 24 Werktage Urlaub pro Jahr.<br><br>3.3. Der Auszubildende ist verpflichtet, den Termin- und Lehrplan zu befolgen. Der Auszubildende verpflichtet sich zur ordnungsgemäßen Anwesenheit an dem in dem Termin- und Lehrplan ersichtlichen Unterricht. Der Auszubildende verpflichtet sich zum Führen des Berichtsheftes und zur aktiven Mitwirkung am Unterricht.<br><br>3.4. Der Auszubildende ist verpflichtet, bei Krankheit die NLA unverzüglich zu informieren. Der Auszubildende ist verpflichtet, jede Krankheitsmeldung mit einer Arbeitsunfähigkeitsbescheinigung zu belegen. Eine Kopie der Arbeitsunfähigkeitsbescheinigung hat bei der NLA allerspätestens innerhalb von 3 Werktagen seit der Krankheitsmeldung einzugehen. Für den Fall, dass bei der NLA innerhalb der vorgenannten Frist keine Arbeitsunfähigkeitsbescheinigung eingeht, gilt die Abwesenheit des Auszubildenden als unentschuldigt.<br><br>3.5. Der Auszubildende ist verpflichtet, auf Verlangen der NLA an einem Auswertungs- und Zielvereinbarungsgespräch mit der NLA teilzunehmen. Das Gespräch findet in den Räumlichkeiten der NLA oder in den Räumlichkeiten des Kooperationsunternehmens, in dem der Auszubildende die praktische Ausbildungsphase hat, statt. Den Ort und die Zeit des Gesprächs bestimmt die NLA. Die NLA hat dabei die Belange des Auszubildenden zu berücksichtigen. Als Belange des Auszubildenden gelten insb. Unterrichtszeiten und Termine des Auszubildenden bei den Ämtern.<br><br>3.6. Im Falle, dass die Ausbildung und/oder der Unterhalt des Auszubildenden (m/w) über einen Sozialleistungsträger/Fördergeldgeber finanziert wird, ist der Auszubildende zur Wahrnehmung von Terminen beim Sozialträger/Fördergeldgeber auch während der Unterrichtszeiten bzw. Praktikumszeiten bei dem Kooperationsunternehmen berechtigt. Der Auszubildende ist verpflichtet, die NLA (und während der praktischen Ausbildungsphase auch das Kooperationsunternehmen) über den Termin unverzüglich schriftlich oder per E-Mail zu informieren. Unverzüglich bedeutet spätestens 3 Werktage nach dem Erhalt einer Information über den wahrzunehmenden Termin. Des Weiteren ist der Auszubildende verpflichtet, spätestens 3 Werktage nach dem wahrgenommenen Termin der NLA einen Nachweis für die tatsächliche Teilnahme an dem Termin vorzulegen. Für den Fall, dass der Auszubildenden innerhalb der vorgenannten Frist keinen Nachweis vorlegt, gilt seine Abwesenheit als unentschuldigt.<br><br>3.7. Hat der Auszubildende mit dem Kooperationsunternehmen eine Vergütungsvereinbarung geschlossen, hat er darüber die NLA unverzüglich zu informieren.<br><br>3.8. Sollte der Auszubildende während der praktischen Phase das Kooperationsunternehmen wechseln wollen, muss er hierfür vorher eine schriftliche Zustimmung der NLA holen. Das Wechseln des Kooperationsunternehmens ohne vorherige schriftliche Zustimmung der NLA ist nicht zulässig. Die NLA ist verpflichtet, dem Wechsel des Kooperationsunternehmens nur im Notfall zuzustimmen.<br><br>3.9. Der Auszubildende hat die NLA über sämtliche wichtigen Ereignisse, die im Zusammenhang mit seiner Tätigkeit (bzw. seiner ehemaligen Tätigkeit) für das Kooperationsunternehmen eingetreten sind, unverzüglich zu informieren. Zu diesen Ereignissen gehören insbesondere: Arbeitsangebot seitens des Kooperationsunternehmens, ausgesprochene Belobigungen, Kündigung des Ausbildungsverhältnisses, Abmahnungen seitens des Kooperationsunternehmens sowie alle etwaigen Streitigkeiten und Missverständnisse zwischen dem Auszubildenden und dem Kooperationsunternehmen bzw. mit einem Mitarbeiter des Kooperationsunternehmens.<br><br>3.10. Sollte ein Kooperationsunternehmen während der praktischen Ausbildungsphase das Ausbildungsverhältnis kündigen, ist der Auszubildende verpflichtet, unverzüglich nach einem neuen geeigneten Betrieb zu suchen, in dem der Auszubildende die praktische Ausbildungsphase absolvieren wird. Des Weiteren ist der Auszubildende verpflichtet, an dem Übergangsunterricht teilzunehmen. Der Auszubildende hat sich daher bei der NLA zu melden und nach den Zeiten des Übergangsunterrichts zu erkundigen.<br><br>Etwaige Bewerbungsgesprächstermine dürfen nicht in den Unterrichtszeiten erfolgen.<br>Sollte ein Bewerbungsgespräch während der Dauer des Unterrichts vereinbart werden, hat der Auszubildende darüber die NLA unverzüglich schriftlich oder per E-Mail informieren. Wenn der Auszubildende die NLA über das Bewerbungsgespräch im Vorfeld nicht informiert und wenn er innerhalb von 3 Werktagen nach dem Bewerbungsgespräch der NLA keinen Nachweis, aus dem sich ergibt, dass der Auszubildende den Termin wahrgenommen hat und dass der Termin außerhalb der Unterrichtszeiten nicht stattfinden konnte, zukommen lässt, wird seine Abwesenheit unentschuldigt bleiben.<br><br>3.11. Der Auszubildende hat die Anweisungen der NLA und ihres Personals zu folgen. Er hat die NLA und ihr Personal, das Kooperationsunternehmen sowie die anderen Auszubildenden mit Respekt zu behandeln.<br><br>3.12. Der Auszubildende verpflichtet sich, die Allgemeinen Geschäftsbedingungen der NLA, die Hausordnung der NLA und die Umfallverhütungsvorschriften der NLA zu befolgen.<br><br>3.13. Der Auszubildende ist verpflichtet, sich selbst über etwaige Änderungen hinsichtlich des Termins- und Lehrplanes durch Info-Gespräche in der Gruppe bzw. auf Nachfrage in der Verwaltung zu erkundigen.<br><br>3.14. Der Auszubildende ist verpflichtet, die NLA über etwaige Aufhebung, Änderung oder Rücknahme des Bewilligungsbescheides durch den Fördergeldgeber zu informieren.<br><br><b>4. Zahlungsbedingungen</b><br><br>4.1 Die Kosten der Ausbildung belaufen sich auf '.$total_costs.' €. Der schulische Auszubildende bzw. sein gesetzlicher Vertreter verpflichten sich zur Zahlung der Gebühren für die schulische Ausbildung.<br><br>4.2 '.$installments_line.' Die Gebühren sind jeweils zum 1. des Monats fällig, beginnend mit dem ersten Ausbildungsmonat und werden per Lastschriftverfahren eingezogen. Dazu erteilt der schulische Auszubildende zu Beginn der Ausbildung eine Einzugsermächtigung (siehe Formular).<br><br>4.3 Ferienzeiten, Phasen der fachpraktischen Ausbildung oder Krankheit des schulischen Auszubildenden (m/w) ändern an der Verpflichtung zur Zahlung der Gebühren der schulischen Ausbildung nichts.<br><br>4.4 Bei einer Vorauszahlung der Gesamtsumme gewähren wir einen Nachlass von 5%. Bei einer Zahlung in drei Jahresraten, jeweils zu Beginn des Ausbildungsjahres gewähren wir einen Nachlass von 3 %. Bei vorzeitigem Beenden der schulischen Ausbildung wird eine mögliche Überzahlung rückerstattet. Zusätzlich zahlt der schulische Auszubildende (m/w) die Prüfungsgebühren zum Zeitpunkt der Rechnungsstellung durch die IHK Berlin.<br><br>4.5 Bei Nichtzahlung trotz Fälligkeit aller vorgenannten Zahlungsbeträge wird von NLA für den Verzugszeitraum ein Verzugszinssatz von 10% per anno erhoben. Ferner wird pro Mahnung pauschal eine Mahngebühr von 10,00 EUR berechnet.<br><br>4.6 Im Falle einer Kündigung wird der Fördergeldgeber weitere 3 monatliche Raten beginnend ab dem Zeitpunkt des Abbruches der Umschulung zahlen.<br><br><b>5. Rücktritt und Kündigung</b><br><br>5.1 Während der ersten 3 Monate (Probezeit) kann das Ausbildungsverhältnis von beiden Seiten mit einer Kündigungsfrist von 1 Monat zum Monatsende gekündigt werden. Nach Ablauf der vier monatigen Probezeit kann das Ausbildungsverhältnis durch den Auszubildenden mit einer Kündigungsfrist von 3 Monate zum Monatsende gekündigt werden. Die Kündigung muss schriftlich erfolgen.<br><br>5.2 Beide Parteien haben das Recht, von dem schulischen Ausbildungsverhältnis bis Ausbildungsbeginn unter Einhaltung einer Stornofrist von 6 Wochen zurückzutreten. Im Fall einer Stornierung durch den Auszubildenden ist eine Bearbeitungs- und Stornogebühr in Höhe von 5% der Gesamtgebühr zu zahlen.<br><br>5.3 Die NLA und der Auszubildende können das Ausbildungsverhältnis jederzeit fristlos kündigen, wenn ein wichtiger Grund im Sinne des § 22 Abs. 2 Nr. 1 BBiG vorliegt. Die Kündigung muss schriftlich erfolgen. Die NLA und der Auszubildende sind sich einig, dass ein wichtiger Grund im Sinne des § 22 Abs. 2 Nr. 1 BBiG u.a. auch dann vorliegt, wenn:<br><br>a. der Auszubildende trotz 2 schriftlichen Abmahnungen ein Berichtsheft nicht ordnungsgemäß führt;<br>b. der Auszubildende seit dem Beginn des Ausbildungsverhältnisses zu Unterricht in 30% der Fälle verspätet kommt,<br>c. die unentschuldigten Abwesenheiten des Auszubildenden seit dem Beginn des Semesters mehr als 5% des gesamten im jeweiligen Semester anwesenheitspflichtigen Unterrichts darstellen,<br>d. der Auszubildende zum Auswertungs- und Zielvereinbarungsgespräch und zu zwei weiteren Ausweichterminen für das bereits seitens des Auszubildenden versäumte Auswertungs- und Zielvereinbarungsgespräch unentschuldigt nicht kommt;<br>e. der Auszubildende zum dritten Mal gegen seine Mitteilungs- und Informationspflichten verstoßen hat, insbesondere nach Ziffer 3.8 dieses Vertrages;<br>f. der Auszubildende trotz zwei erfolgten schriftlichen Abmahnungen die Anweisungen der NLA und ihres Personals nicht gefolgt hat;<br>g. der Auszubildende trotz zwei erfolgten schriftlichen Abmahnungen sich gegenüber der NLA und ihrem Personal, den anderen Auszubildenden oder den Kooperationsunternehmen respektlos benommen hat. Die Respektlosigkeit liegt u.a. vor, wenn der Auszubildende Schimpfwörter benutzt oder bei der Durchführung des Unterrichts stört;<br>h. der Auszubildende die anderen Auszubildenden gegen die NLA, das Personal der NLA oder die Kooperationsunternehmen aufhetzt oder wenn er auf Social Media (u.a. Facebook, Twitter usw.) Inhalte postet, die dem Aufhetzten gegen die NLA und ihrem Personal sowie Kooperationsunternehmen dienen. Eine fristlose Kündigung ist berechtigt, wenn der Auszubildende Behauptungen über die NLA, ihr Personal und die Kooperationsunternehmen online sowie offline verbreitet, die nicht der Wahrheit entsprechen. Die Behauptungen gelten als wahr erst dann, wenn die Behauptungen in einem rechtskräftigen Urteil durch ein zuständiges Gericht für zutreffend erkannt wurden.<br>i. der Auszubildende trotz zwei schriftlichen Abmahnungen gegen die Hausordnung, die Allgemeinen Geschäftsbedingungen und die Umfallverhütungsvorschriften der NLA verstoßen hat;<br>j. der Auszubildende das Kooperationsunternehmen während der praktischen Ausbildungsphase ohne vorherige schriftliche Zustimmung der NLA gewechselt hat;<br>k. Der Fördergeldgeber den in der Präambel zu diesem Vertrag erwähnten Bewilligungsbescheid aufhebt oder zurücknimmt oder der Übernahme von weiteren Kosten, die aufgrund der Verlängerung der Umschuldungszeit entstehen, nicht zustimmt.<br><br>5.4 Kündigt das Kooperationsunternehmen das Ausbildungsverhältnis mit dem Auszubildenden aus den Gründen, die eine fristlose Kündigung nach Ziffer 5.4. dieses Vertrages berechtigen würden, ist die NLA zur fristlosen Kündigung dieses Vertrages berechtigt. Die Kündigung muss schriftlich erfolgen. Die Kündigung der NLA ist unwirksam, wenn die fristlose Kündigung durch das Kooperationsunternehmen der NLA länger als zwei Wochen bekannt ist.<br><br>5.5 Wird das Ausbildungsverhältnis durch ein Kooperationsunternehmen während der praktischen Ausbildungsphase gekündigt oder will der Auszubildende das Kooperationsunternehmen mit der vorherigen Zustimmung der NLA wechseln und beginnt der Auszubildende innerhalb von drei Monaten nach der Beendigung des vorherigen praktischen Ausbildungsverhältnisses bei dem Kooperationsunternehmen kein neues praktisches Ausbildungsverhältnis bei einem anderen geeigneten Unternehmen, wird der erfolgreiche Abschluss dieser Umschulung in der vorgesehenen Zeit nicht mehr möglich sein. Daher ist dieser Vertrag mit Zustimmung des Fördergeldgebers schriftlich zum Ende des dann folgenden Monats aufzulösen.<br><br><b>6. Haftung</b><br><br>6.1 Die NLA haftet nicht für Körper- und Sachschäden des Auszubildenden, die von Dritten verursacht wurden. Die NLA haftet nicht für Verlust oder Diebstahl von persönlichem Eigentum des Auszubildenden.<br><br>6.2 Die NLA haftet dem Auszubildenden gegenüber für eigenes grob fahrlässiges und vorsätzliches Verhalten.<br><br>6.3 Die persönliche Haftung vom Personal der NLA das als Erfüllungsgehilfe tätig geworden ist, ist ausgeschlossen. Eine weitergehende Haftung ist ausgeschlossen, soweit dies gesetzlich zulässig ist.<br><br>6.4 Der Auszubildende (m/w) ist bei der Verwaltungsberufsgenossenschaft für die Dauer der Ausbildung wegen gesetzlicher Unfallversicherung versichert.<br><br>6.5 Der Auszubildende hat eine eigene Krankenversicherung und kann diese ggf. nachweisen.<br><br><b>7. Verschwiegenheit und Datenschutz</b><br><br>7.1 Der Auszubildende ist verpflichtet, über alles, was er in der Ausbildung, aus Anlass oder im Zusammenhang mit seiner Tätigkeit erfährt, gemäß §5 BDSG gegenüber Dritten Stillschweigen zu bewahren. Die Verschwiegenheitsverpflichtung ist auch nach Beendigung des Vertragsverhältnisses gültig.<br><br>7.2 Der Auszubildende erklärt sich mit der Speicherung seiner persönlichen Daten in internen Systemen der NLA durch die NLA zur Durchführung der Ausbildung einverstanden. Der Auszubildende ist zudem mit der Übersendung der gespeicherten Daten durch die NLA an die zuständige Industrie- und Handelskammer sowie an das Jobcenter oder Bafög Amt zwecks der Durchführung der Ausbildung einverstanden.<br><br>7.3 Der Auszubildende (m/w) erklärt sich einverstanden, dass seine Bewerbungsunterlagen zum Zweck der Vermittlung in ein Kooperationsunternehmen im Rahmen der praktischen Ausbildungsphase von der NLA an interessierte Kooperationsunternehmen weitergegeben werden.<br><br><b>8. Schlussbestimmungen</b><br><br>8.1 Zusätzliche oder abweichende Vereinbarungen bedürfen der Schriftform. Mündliche Nebenabreden bestehen nicht.<br><br>8.2 Sind oder werden einzelne Bestimmungen dieses Vertrages unwirksam, so wird dadurch die Gültigkeit der übrigen Bestimmungen nicht berührt. Der Vertragspartner wird in diesem Fall die ungültigen Bestimmungen durch eine andere ersetzen, die dem Zweck der weggefallenen Regelung in zulässiger Weise am nächsten kommt.<br><br>8.3 Die Parteien erklären, dass dieser Vertrag auf die Beratung vom '.$consultation_date.' zurückzuführen ist. Das Beratungsprotokoll ist in der Anlage 5 beigefügt.<br><br>8.4 Der Auszubildende erklärt, dass er folgende Unterlagen erhalten hat und zur Kenntnis genommen hat:<br><br>
• Anlage 1 Termin- und Lehrplan<br>
• Anlage 2 Aufteilung der Ausbildungsphasen<br>
• Anlage 3 Hausordnung<br>
• Anlage 4 Allgemeine Geschäftsbedingungen<br>
• Anlage 5 Beratungsprotokoll über das Bildungsangebot<br><br>')),0,'LR');
        
        $pdf->ln(10);
        
        $pdf->AddPage();
        
        $date=date('d.m.Y');
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','
Berlin, den '.$date.'
'),0,'LR');
        
        $pdf->ln(10);
        $y=$pdf->GetY();
        $image='';
        if(isset($contract->id) AND $contract->signature!='')
        $image=$pdf->Image('signatures/'.$contract->signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'








_______________________
(schulische/r Auszubildende/r)
'),0,'LR');
        
        $pdf->setXY('100', $y);
        $image='';
        if(isset($contract->id) AND $contract->coach_signature!='')
        $image=$pdf->Image('signatures/'.$contract->coach_signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'








_______________________
(ggf. gesetzlicher Vertreter)
'),0,'LR');
        
        $pdf->ln(10);
        $image='';
        $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'








_______________________
(Nextlevel Akademie)
'),0,'LR');
        
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',15);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Allgemeine Geschäftsbedingungen'), 0, 0, 'C');
        $pdf->ln(9);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1. Anmeldeverfahren</b><br><br>1.1 Die Nextlevel Akademie verpflichtet sich, den/die Interessenten/in im Vorfeld des Vertragsabschlusses umfassend über das Bildungsangebot zu beraten.<br><br>1.2 Der/die Interessentin erhält eine Anmeldebestätigung und den Ausbildungsvertrag ggf. zur Vorlage beim Fördergeldgeber.<br><br>1.3 Der/die Interessent/in  gibt den unterschriebenen Ausbildungsvertrag und ggf. den entsprechenden Bildungsgutschein an die Nextlevel Akademie zurück. Damit gilt die Anmeldung für beide Seiten als verbindlich.<br><br><b>2. Durchführung</b><br><br>2.1 Die Nextlevel Akademie verpflichtet sich die Ausbildung so durchzuführen, dass Wissen, Fähigkeiten und Fertigkeiten zum Erreichen des Bildungsziels vermittelt werden. Die vorgesehenen Lehr- und Lernmittel werden dem/der Teilnehmer/in zur Verfügung gestellt.<br><br>2.2 Der Unterricht erfolgt im Rahmen der durch den Ausbildungsvertrag festgelegten Qualifizierungsmaßnahme. Die inhaltliche und methodische Gestaltung richtet sich nach dem zuvor dem/der Teilnehmer/in  vorgelegten Lehrplan sowie dem mitgeteilten Konzept.<br><br>2.3 Termine, Kosten, Unterrichtszeiten und Ferienregelungen werden im Lehrgangsvertrag festgelegt.<br><br>2.4 Die Nextlevel Akademie ist berechtigt, Termine und Unterrichtszeiten in einem für die Beteiligten zumutbaren Umfang zu ändern. Die Nextlevel Akademie ist ebenso berechtigt, den Unterrichtsinhalt zu ändern und den aktuellen Gegebenheiten anzupassen.<br><br>2.5 Bei zu geringer Teilnehmerzahl ist die Nextlevel Akademie berechtigt, bis zum geplanten Beginn eines Lehrgangs vom Vertrag zurückzutreten, wenn die geplante Mindestteilnehmerzahl von mindestens 5 Teilnehmern für den betreffenden Lehrgang nicht erreicht wird. In diesem Fall werden sämtliche bereits geleisteten Zahlungen zurückerstattet. Schadensersatzansprüche des/der Teilnehmers/in sind in diesem Fall ausgeschlossen.<br><br>2.6 Muss ein einzelnes Ausbildungsmodul aus Gründen, die die Nextlevel Akademie nicht zu vertreten hat, abgesagt werden, wird sich die Nextlevel Akademie bemühen, einen Ersatztermin anzubieten.<br><br>2.7 Die Nextlevel Akademie ist verpflichtet, täglich Anwesenheitskontrollen durchzuführen, zu dokumentieren und auf Anfrage nachzuweisen.<br><br>2.8 Der/die Teilnehmer/in erhält nach Abschluss der Ausbildung und erfolgter Prüfung ein Zertifikat oder eine Teilnahmebescheinigung der Nextlevel Akademie. Der/die Teilnehmer/in erhält für jeden durchgeführten Lehrgang ab einer Anwesenheit von 90% an den Lehrgangsveranstaltungen ein Zertifikat. Liegt die Anwesenheit unter 90% erhält der/die Teilnehmer/in lediglich eine Teilnahmebestätigung für die besuchten Lehrveranstaltungen.  Zusätzlich werden in regelmäßigen Abständen Leistungsbewertungen zur Erreichung der Lernziele durchgeführt.<br><br>2.9 Zur Ermittlung de Kundenzufriedenheit in Rahmen des Qualitätsmanagements führt die Nextlevel Akademie regelmäßigen Abständen Teilnehmerbefragungen und Hospitationen durch. Darüber hinaus ist die Nextlevel Akademie für Hinweise, Vorschläge und Ideen seitens der Teilnehmer/innen aufgeschlossen.<br><br>2.10 Die jeweiligen Ansprechpartner der einzelnen Fachbereiche stellen sich zu Beginn des Lehrgangs vor.<br><br>2.11 Der/die Teilnehmer/in erklärt, erklärt vorab über die Inhalte der Bildungsmaßnahme, das Bildungsziel und alle vertraglichen Gegenstandspunkte eingehend beraten worden zu sein.<br><br>2.12 Der/die Teilnehmer/in ist darüber informiert worden, dass gegenseitige Anwendungsdemonstrationen und Übungen stattfinden werden und die Nextlevel Akademie für eventuell auftretende gesundheitliche Schäden keine Haftung übernimmt. Schadensersatzansprüche gegen die Nextlevel Akademie sind davon ausgeschlossen, wenn nicht grobe Fahrlässigkeit oder Vorsatz nachzuweisen sind.<br><br>2.13 Der/die Teilnehmer/in erteilt der NextLevel Akademie die Erlaubnis, Fotos und Filmmaterial, das im Rahmen der Ausbildung entsteht, für Werbezwecke zu veröffentlichen. Dies gilt für Fotos und Filmmaterial, welches die NextLevel Akademie erstellt, fotografiert bzw. gefilmt hat und für solches Material, auf dem der/die Teilnehmer/in selbst abgebildet ist. Ein Widerruf der übertragenen Bildrechte ist zulässig und bedarf der Schriftform.<br><br><b>3. Gebühren</b><br><br>3.1 Die Höhe der Ausbildungsgebühren ergibt sich aus den Vereinbarungen im Ausbildungsvertrag.<br><br>3.2 Die Ausbildungsgebühr ist mit Zugang der Rechnung fällig. Sie ist unter Angabe der Rechnungsnummer auf das in der Rechnung angegebene Konto zu zahlen. Das Recht zur Teilnahme an einer Veranstaltung setzt die vorherige (An-)Zahlung der Ausbildungsgebühr bzw. die Einreichung des Bildungsgutscheins voraus.<br><br>3.3 Bis zur vollständigen Zahlung aller Ausbildungsgebühren steht Nextlevel Akademie ein Zurückbehaltungsrecht an dem Abschlusszeugnis und an der Teilnahmebescheinigung zu.<br><br>3.4 Tritt ein Dritter (z.B. die Agentur für Arbeit, Jobcenter) in die Zahlungsverpflichtung des/der Teilnehmer/in ganz oder teilweise ein oder tritt der/die Teilnehmer/in seine Ansprüche auf Zahlung der Gebühren an die Nextlevel Akademie ab, so erfolgt die Abrechnung direkt mit dem Dritten.<br><br>3.5 Der/die Teilnehmer/in haftet neben einem eventuellen Dritten für die Zahlung der Gebühren. Überweist der Fördergeldgeber die Ausbildungsgebühren an den/die Teilnehmer/in, so verpflichtet er/sie die jeweilige Rate innerhalb von 14 Tagen auf das Konto der Nextlevel Akademie unter Angabe der Lehrgangsbezeichnung einzuzahlen. Bei Verzögerungen sind bankübliche Zinsen fällig.<br><br>3.6 Im Falle einer Förderung muss die Zahlungsweise entsprechend den Zahlungen des Fördergeldgebers erfolgen, längstens bis zum Ende der Ausbildung.<br><br>3.7 Sofern der/die Dritte nicht die Gebühren übernimmt (z.B. durch einen Bildungsgutschein), hat der/die Teilnehmer/in  ein sofortiges kostenfreies Recht zu kündigen.<br><br><b>4. Rücktritt</b>4.1 Der/die Teilnehmer/in ist berechtigt, den Ausbildungsvertrag mit einer Frist von sechs Wochen, erstmals zum Ende der ersten drei Monate, danach jeweils zum Ende der nächsten drei Monate ohne Angabe von Gründen zu kündigen. Die Kündigung muss in schriftlicher Form erfolgen.<br><br>4.2 Das Recht der Kündigung aus wichtigem Grund für den/die Teilnehmer/in oder für die Nextlevel Akademie bleibt unberührt. Der Grund ist auf Verlangen schriftlich zu bezeichnen und durch Nachweise zu belegen.<br><br>4.3 Die Nextlevel Akademie kann zu jeder Zeit aus wichtigen Gründen den bestehenden Ausbildungsvertrag kündigen. Wichtige Gründe sind insbesondere: häufige Verspätungen, Fehlzeiten oder unentschuldigte Abwesenheit des/der Teilnehmer/in, vorsätzliche Entwendung, Beschädigung oder Zerstörung von Lehrmaterial und Einrichtung der Nextlevel Akademie, Nichtbefolgung von Anordnungen der Mitarbeiter der Nextlevel Akademie, Nichteinhaltung der Hausordnung.<br><br>4.4 Bei Rücktritt durch Arbeitsaufnahme wird gemäß den Regelungen des Fördergeldgebers verfahren.<br><br><b>5. Pflichten des/der Teilnehmer/in</b>5.1 Der/die Teilnehmer/in verpflichtet sich zur regelmäßigen Teilnahme am Ausbildungslehrgang.<br><br>5.2 Die Hausordnung und die Unfallverhütungsvorschriften sind zu befolgen.<br><br>5.3 Der/die Teilnehmer/in ist verpflichtet, bei Krankheit die Nextlevel Akademie umgehend zu informieren. Die Arbeitsunfähigkeitsbescheinigung ist innerhalb von 3 Tagen an die Nextlevel Akademie zu senden. Eine Kopie der Arbeitsunfähigkeitsbescheinigung erhält ggf. der zuständige Fördergeldgeber ebenfalls innerhalb von 3 Kalendertagen.<br><br>5.4 Für unentschuldigt versäumte Stunden und Tage ist die volle Ausbildungsgebühr  vom Fördergeldgeber zu entrichten.<br><br>5.5 Alle Lehrmaterialien und Instrumente sind nur nach Anweisung der Dozenten und sorgsam zu bedienen. Das Lehrmaterial ist nicht aus den Räumen der Nextlevel Akademie zu entfernen und/oder für kommerzielle /private Zwecke zu nutzen.<br><br><b>6. Haftungsbeschränkung</b><br><br>6.1 Die Nextlevel Akademie haftet nur für Schäden die auf Vorsatz oder grober Fahrlässigkeit seiner gesetzlichen Vertreter oder Mitarbeiter beruhen. Jegliche weitere Haftung ist ausgeschlossen, soweit gesetzlich zulässig.<br><br><b>7. Versicherung</b><br><br>7.1 Es besteht für alle Teilnehmer/innen eine Unfallversicherung bei der Verwaltungsberufsgenossenschaft innerhalb der Schulräume.  Die Krankenversicherung ist durch den/die Teilnehmer/in zu gewährleisten und auf Anfrage nachzuweisen.<br><br><b>8. Allgemeines</b><br><br>8.1 Soweit einzelne Bestimmungen dieses Vertrages unwirksam sind oder werden, wird dadurch die Wirksamkeit des Vertrages im Übrigen nicht berührt, unwirksame Regelungen sind durch sinngemäße wirksame zu ersetzen.<br><br>8.2 Änderungen oder Ergänzungen des Vertrages bedürfen zu ihrer Wirksamkeit der Schriftform.')),0,'LR');
        
        //$pdf->Output(); exit();
        
        if(!isset($contract->id))
        {
            $contract=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
            $pdf->Output('company_files/contracts/'.$contract, 'F');
        
            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
            $id=DB::getPdo()->lastInsertId();
        }
        else
        {
            $id=$contract->id;
            $contract=$contract->contract;
            $pdf->Output('company_files/contracts/'.$contract, 'F');
        }
        return $id;
        
        exit();
    }
    
    public function coachee_contract(Request $request, $contact, $type, $contract=0, $coach=0)
    {
        //ini_set('memory_limit', '-1');
        //require('fpdf17/fpdf.php');
        //require('fpdi/src/autoload.php');
        
        $courses='';
        $row=DB::select("SELECT * FROM contact_courses WHERE c_id='$contact->id' AND contract_id='$contract->id'");
        if(count($row)!=0)
        { $i=0;
            foreach($row as $r)
            {
                $row2=DB::select("SELECT title FROM courses WHERE id='$r->course_id' LIMIT 1");
                if(count($row2)==0) continue;
                $row2=collect($row2)->first();
                
                if($i++==0)
                $courses.=$row2->title;
                else
                $courses.=', '.$row2->title;
            }
        }
        
        $funding_source='';
        $funding_address='';
        $funding=DB::select("SELECT * FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if(count($funding)==1)
        {
            $funding=collect($funding)->first();
            $funding_source=$funding->name;
            $funding_address=$funding->address;
        }
        
        $contact_name='';
        $contact_address='';
        $contact_phone='';
        $contact_email='';
        $funding=DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if(count($funding)==1)
        {
            $funding=collect($funding)->first();
            $contact_name=$funding->name;
            $contact_address=$funding->door_no.', '.$funding->street_name;
            if($funding->address!='')
            $contact_address.=', '.$funding->address;
            $contact_address.=', '.$funding->city.', '.$funding->zip_code;
            $contact_phone=$funding->phone_no;
            $contact_email=$funding->email;
        }
        
        if($contract->beginning!='0000-00-00')
        {
            $begin=date_format(new DateTime($contract->beginning),'d.m.Y');
            $end=date_format(new DateTime($contract->end),'d.m.Y');
        }
        else
        {
            $begin=date_format(new DateTime($contact->beginning),'d.m.Y');
            $end=date_format(new DateTime($contact->end),'d.m.Y');
        }
        $c_date=date('d.m.Y');
        
        //$pdf = new \setasign\Fpdi\Fpdi();
        $pdf = new \Fpdf('P','mm','A4'); //8.5" x 11" laser form
        $pdf->setTitle('Contract');
	    $pdf->SetDrawColor(172, 172, 172);
	    $pdf->SetTextColor(0, 0, 0);
	    //$pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetMargins(16.35, 16.35, 16.35);
        
        if($request->input('s')=='0') $status=0;
        else $status=1;
        
        $r_id=1;
        $page_height=0;
        $one_section=0;
        $i=0;
        $current_page=$pdf->PageNo();
        $starting_page_no=$pdf->PageNo();
        $end_page_no=$current_page;
        $end_page_height=0;
        
        $pdf->AddPage();
        $pdf->setLeftMargin(8);
        $pdf->setTopMargin(30);
        $pdf->ln(15);
        
        $pdf->SetDrawColor(172, 172, 172);
	    $pdf->SetTextColor(0, 0, 0);
                
	    $pdf->SetFont('Arial','B',15);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Coaching-Vertrag'), 0, 0, 'C');
        $pdf->ln(9);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Zwischen'), 0, 0, 'L');
        $pdf->ln(14);
        
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','Nextlevel Akademie
Bundesallee 86
12161 Berlin
vertreten durch: Frau Gülhan Dündar (Geschäftsführung)
(nachstehend NLA genannt)'),0,'LR');
        
        $pdf->ln(1);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','und'), 0, 0, 'L');
        
        $pdf->ln(14);
        $address=$contact->door_no.', '.$contact->street_name;
        if($contact->address!='')
        $address.=', '.$contact->address;
        $address.=', '.$contact->city.', '.$contact->zip_code;
        $dob='';
        if($dob!='01-01-1900') $dob=$contact->dob;
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','Name, Vorname:            '.$contact->name.'
Geburtsdatum(-ort):        '.$dob.'
Anschrift/PLZ/Ort:           '.$address.'
Telefon/Handy:               '.$contact->phone_no.'
E-Mail       :                     '.$contact->email.'
Gesetzlicher Vertreter:

Fördergeldgeber:            '.$funding_source.'
Ansprechpartner:            '.$contact_name.'
Anschrift/PLZ/Ort:           '.$contact_address.'
Telefon/Durchwahl:         '.$contact_phone.'
E-Mail       :                     '.$contact_email.'
'),0,'LR');
        
        $pdf->ln(4);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Nachstehend Teilnehmer (m/w) genannt, wird folgender Vertrag geschlossen:<br><br><b>1. Gegenstand<br>Ziel der Maßnahme: '.$courses.'</b><br><br>
Maßnahmennr.:	____________<br>
Beginn:		'.$begin.'<br>
Ende:			  '.$end.'<br><br>Unterrichtsort: 	Bundesallee 86, 12161 Berlin<br><br>Die Aufteilung der Maßnahmephasen sowie die Ferienzeiten sind dem beiliegenden Zeit-/Lehrplan* zu entnehmen, der Bestandteil des Vertrages ist.<br>*Änderungen sind vorbehalten
Vertragslaufzeit ist die Dauer der Maßnahme, vorbehaltlich der Regelung unter Punkt 4.<br><br><b>2. Rechte und Pflichten der NLA</b><br><br>2.1 Die NLA verpflichtet sich, die fachtheoretischen und ggf. fachpraktischen Inhalte gemäß § 45 Abs. 1 Satz 1 Nr. 4 SGB III mit dem Ziel der Heranführung an den Arbeits- und Ausbildungsmarkt zu vermitteln. Unabhängig davon erstellt NLA bei erfolgreichem Abschluss ein Zertifikat und bei nicht erfolgreichem Beenden der Maßnahme eine Teilnahmebescheinigung über die besuchten Themenbereiche und zusätzlich erworbenen Kompetenzen.<br><br>2.2 NLA behält sich vor, den Beginn der Maßnahme oder die Unterrichtszeiten aus begründetem Anlass und mit rechtzeitiger Ankündigung zu ändern.<br><br><b>3. Rechte und Pflichten des Teilnehmers (m/w)</b><br><br>3.1 NLA führt die vereinbarte Maßnahme je nach Zielsetzung gemäß vorliegendem Themen- und Terminplan oder individuell durch. Terminänderungen des Themenplans bleiben vorbehalten.<br><br>3.2 Der Teilnehmer (m/w) versichert, dass gegen seine Teilnahme an der Maßnahme keine gesundheitlichen Bedenken bestehen.<br><br>3.3 Der Teilnehmer (m/w) ist zur ordnungsgemäßen Anwesenheit, Mitwirkung am Unterricht, Teilnahme an Coaching-Gesprächen und Lernerfolgskontrollen sowie zum Führen des Berichtsheftes verpflichtet. NLA ist gegenüber der Fördergeldgeber verpflichtet, täglich Anwesenheitskontrollen durchzuführen, zu dokumentieren und auf Anfrage nachzuweisen.<br><br>3.4 Die Teilnehmer (m/w) sind verpflichtet, bei Krankheit die Nextlevel Akademie umgehend zu informieren. Die Arbeitsunfähigkeitsbescheinigung ist innerhalb von 3 Tagen an die Nextlevel Akademie zu senden. Eine Kopie der Arbeitsunfähigkeitsbescheinigung erhält ggf. der zuständige Fördergeldgeber ebenfalls innerhalb von 3 Kalendertagen.<br><br>3.5 Die Allgemeinen Geschäftsbedingungen, die Hausordnung und die Unfallverhütungsvorschriften sind zu befolgen. Der  Teilnehmer (m/w) wird die Räumlichkeiten, Geräte und Unterlagen von NLA pfleglich behandeln und entsprechenden Anweisungen folgen. Alle Arbeitsmittel werden kostenfrei während der Maßnahme zu Verfügung gestellt  und ein Teil geht in das Eigentum des Teilnehmers  kostenfrei über und wird schriftlich dokumentiert.<br><br>3.6 Bis zur vollständigen Zahlung aller Schulgebühren steht NLA ein Zurückbehaltungsrecht an dem Abschlusszeugnis und an der Teilnahmebescheinigung zu.<br><br>3.7 Der Fördergeldgeber verpflichtet sich zur Zahlung der Gebühren für die Maßnahme.<br><br>3.8 Die Gebühren teilen sich in Std. und Teilzahlungen. Die Gebühren sind jeweils nach Abrechnung der Std. fällig, beginnend mit dem Starttermin der Maßnahme.<br><br>3.9 Bei Krankheit des Teilnehmers (m/w) und kurzfristiger Absage wird der Tag voll  beim Fördergeldgeber berechnet.<br><br><b>4. Laufzeit des Vertrages, Rücktritt, Kündigung</b><br><br>4.1 Der Vertrag wird über die Dauer von zwölf Wochen abgeschlossen. Vertragsbeginn ist der '.$c_date.'. Der Gesamtpreis beträgt Zehntausendachthundertachtundvierzig Euro und Null Cent.<br><br>4.2 Basis für die Vergütung stellen die unter der Maßnahmennummer vereinbarten Konditionen dar. Der Gesamtpreis wird aufwands- und erbringungsbasiert berechnet. Sie entspricht im Erbringungszeitraum maximal Zweihundertsechsundzwanzig Stunden, die je nach Aufwand mit maximal Achtundvierzig Euro berechnet werden.<br><br>4.3 Beide Parteien haben das Recht, von dem Vertragsverhältnis bis zum Beginn der Maßnahme unter Einhaltung einer Stornofrist von 2 Wochen zurückzutreten.<br><br>4.4 Wesentlicher Bestandteil des Vertrages sind die Allgemeinen Geschäftsbedingungen (AGB) und die Hausordnung.<br><br>4.5 Die Kündigungsfrist  und -bedingungen richten sich nach den Richtlinien des Fördergeldgebers.<br><br>4.6 Jede Vertragspartei kann das Vertragsverhältnis aus wichtigem Grund (z.B. bei Arbeitsaufnahme und andauernder Krankheit) ohne Einhaltung einer Kündigungsfrist kündigen, wenn Tatsachen vorliegen, auf Grund derer die Kündigung unter Berücksichtigung  aller Umstände unter Abwägung der Interessen beider Vertragsparteien die Fortsetzung nicht zugemutet werden kann. Demzufolge wird ein Termin für ein Abschlussgespräch mit dem Teilnehmer (m/w) vereinbart, welcher gleichzeitig als letzter Tag der Anwesenheit des Teilnehmers (m/w) gilt.<br><br>4.7 Ist ein vorgesehenes Güteverfahren vor einer außergerichtliche Stelle eingeleitet, so wird bis zu dessen Beendigung der Lauf dieser Frist gehemmt.<br><br>4.8 Die Kündigung muss schriftlich und im Fall der Kündigung gemäß Ziffer 4.5 dieses Vertrages unter Angabe der wesentlichen Kündigungsgründe erfolgen.<br><br>4.9 Wird das Vertragsverhältnis gemäß Ziffer 4.5 dieses Vertrages gekündigt, so schuldet der Fördergeldgeber 2 Monatsraten gemäß der Richtlinien der bewilligten Förderung.<br><br>4.10 Bei andauernder Krankheit über 4 Wochen ab dem Tag der Krankmeldung besteht eine Rücktrittsmöglichkeit für den/die Teilnehmer/in nach Absprache mit der NLA und dem Fördergeldgeber sofern ein ärztliches Attest vorliegt.<br><br><b>5. Haftung</b><br><br>5.1 NLA haftet dem  Teilnehmer (m/w) gegenüber für eigenes grob fahrlässiges und vorsätzliches Verhalten.<br><br>5.2 Die persönliche Haftung von Mitarbeitern/innen von NLA die als Erfüllungsgehilfen tätig geworden sind, ist ausgeschlossen. Eine weitergehende Haftung ist ausgeschlossen, soweit dies gesetzlich zulässig ist.<br><br>Der Teilnehmer (m/w) ist bei der Verwaltungsberufsgenossenschaft für die Dauer der Maßnahme versichert.<br><br>5.4 Die Teilnehmer haben eine eigene Krankenversicherung und können diese ggf. nachweisen.<br><br><b>6. Verschwiegenheit und Datenschutz</b><br><br>6.1 Der Teilnehmer ist verpflichtet, über alles, was er in der Maßnahme, aus Anlass oder im Zusammenhang mit seiner Tätigkeit erfährt, gemäß §5 BDSG gegenüber Dritten Stillschweigen zu bewahren. Die Verschwiegenheitsverpflichtung ist auch nach Beendigung des Vertragsverhältnisses gültig.<br><br>6.2 Die von NLA erbetenen persönliche Angaben sowie alle während der Maßnahme erhobenen Daten, wie z.B. Noten, Fehltage u.ä.m. werden vertraulich behandelt und unterliegen den datenschutzrechtlichen Bestimmungen. Die Daten werden NLA-Systemen verarbeitet. Der Teilnehmer (m/w) erklärt sich einverstanden, dass seine Bewerbungsunterlagen zum Zweck der Vermittlung in einen Praxisbetrieb von NLA an interessierte Unternehmen weitergegeben werden.<br><br><b>7. Schlussbestimmungen</b><br><br>7.1 Zusätzliche oder abweichende Vereinbarungen bedürfen der Schriftform. Mündliche Nebenabreden bestehen nicht.<br><br>7.2 Sind oder werden einzelne Bestimmungen dieses Vertrages unwirksam, so wird dadurch die Gültigkeit der übrigen Bestimmungen nicht berührt. Der Vertragspartner wird in diesem Fall die ungültigen Bestimmungen durch eine andere ersetzen, die dem Zweck der weggefallenen Regelung in zulässiger Weise am nächsten kommt.')),0,'LR');
        
        $pdf->ln(10);
        
        $date=date('d.m.Y');
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','
Berlin, den '.$date.'
'),0,'LR');
        
        $pdf->ln(10);
        $y=$pdf->GetY();
        $image='';
        if(isset($contract->id) AND $contract->signature!='')
        $image=$pdf->Image('signatures/'.$contract->signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'








_______________________
(Teilnehmer/in)
'),0,'LR');
        
        $pdf->setXY('100', $y);
        $image='';
        if(isset($contract->id) AND $contract->coach_signature!='')
        $image=$pdf->Image('signatures/'.$contract->coach_signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'








_______________________
(NextLevel Akademie) GF
'),0,'LR');
        
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',15);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Allgemeine Geschäftsbedingungen'), 0, 0, 'C');
        $pdf->ln(9);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1. Anmeldeverfahren</b><br><br>1.1 Die Nextlevel Akademie verpflichtet sich, den/die Interessenten/in im Vorfeld des Vertragsabschlusses umfassend über das Bildungsangebot zu beraten.<br><br>1.2 Der/die Interessentin erhält eine Anmeldebestätigung und den Ausbildungsvertrag ggf. zur Vorlage beim Fördergeldgeber.<br><br>1.3 Der/die Interessent/in  gibt den unterschriebenen Ausbildungsvertrag und ggf. den entsprechenden Bildungsgutschein an die Nextlevel Akademie zurück. Damit gilt die Anmeldung für beide Seiten als verbindlich.<br><br><b>2. Durchführung</b><br><br>2.1 Die Nextlevel Akademie verpflichtet sich die Ausbildung so durchzuführen, dass Wissen, Fähigkeiten und Fertigkeiten zum Erreichen des Bildungsziels vermittelt werden. Die vorgesehenen Lehr- und Lernmittel werden dem/der Teilnehmer/in zur Verfügung gestellt.<br><br>2.2 Der Unterricht erfolgt im Rahmen der durch den Ausbildungsvertrag festgelegten Qualifizierungsmaßnahme. Die inhaltliche und methodische Gestaltung richtet sich nach dem zuvor dem/der Teilnehmer/in  vorgelegten Lehrplan sowie dem mitgeteilten Konzept.<br><br>2.3 Termine, Kosten, Unterrichtszeiten und Ferienregelungen werden im Lehrgangsvertrag festgelegt.<br><br>2.4 Die Nextlevel Akademie ist berechtigt, Termine und Unterrichtszeiten in einem für die Beteiligten zumutbaren Umfang zu ändern. Die Nextlevel Akademie ist ebenso berechtigt, den Unterrichtsinhalt zu ändern und den aktuellen Gegebenheiten anzupassen.<br><br>2.5 Bei zu geringer Teilnehmerzahl ist die Nextlevel Akademie berechtigt, bis zum geplanten Beginn eines Lehrgangs vom Vertrag zurückzutreten, wenn die geplante Mindestteilnehmerzahl von mindestens 5 Teilnehmern für den betreffenden Lehrgang nicht erreicht wird. In diesem Fall werden sämtliche bereits geleisteten Zahlungen zurückerstattet. Schadensersatzansprüche des/der Teilnehmers/in sind in diesem Fall ausgeschlossen.<br><br>2.6 Muss ein einzelnes Ausbildungsmodul aus Gründen, die die Nextlevel Akademie nicht zu vertreten hat, abgesagt werden, wird sich die Nextlevel Akademie bemühen, einen Ersatztermin anzubieten.<br><br>2.7 Die Nextlevel Akademie ist verpflichtet, täglich Anwesenheitskontrollen durchzuführen, zu dokumentieren und auf Anfrage nachzuweisen.<br><br>2.8 Der/die Teilnehmer/in erhält nach Abschluss der Ausbildung und erfolgter Prüfung ein Zertifikat oder eine Teilnahmebescheinigung der Nextlevel Akademie. Der/die Teilnehmer/in erhält für jeden durchgeführten Lehrgang ab einer Anwesenheit von 90% an den Lehrgangsveranstaltungen ein Zertifikat. Liegt die Anwesenheit unter 90% erhält der/die Teilnehmer/in lediglich eine Teilnahmebestätigung für die besuchten Lehrveranstaltungen.  Zusätzlich werden in regelmäßigen Abständen Leistungsbewertungen zur Erreichung der Lernziele durchgeführt.<br><br>2.9 Zur Ermittlung de Kundenzufriedenheit in Rahmen des Qualitätsmanagements führt die Nextlevel Akademie regelmäßigen Abständen Teilnehmerbefragungen und Hospitationen durch. Darüber hinaus ist die Nextlevel Akademie für Hinweise, Vorschläge und Ideen seitens der Teilnehmer/innen aufgeschlossen.<br><br>2.10 Die jeweiligen Ansprechpartner der einzelnen Fachbereiche stellen sich zu Beginn des Lehrgangs vor.<br><br>2.11 Der/die Teilnehmer/in erklärt, erklärt vorab über die Inhalte der Bildungsmaßnahme, das Bildungsziel und alle vertraglichen Gegenstandspunkte eingehend beraten worden zu sein.<br><br>2.12 Der/die Teilnehmer/in ist darüber informiert worden, dass gegenseitige Anwendungsdemonstrationen und Übungen stattfinden werden und die Nextlevel Akademie für eventuell auftretende gesundheitliche Schäden keine Haftung übernimmt. Schadensersatzansprüche gegen die Nextlevel Akademie sind davon ausgeschlossen, wenn nicht grobe Fahrlässigkeit oder Vorsatz nachzuweisen sind.<br><br>2.13 Der/die Teilnehmer/in erteilt der NextLevel Akademie die Erlaubnis, Fotos und Filmmaterial, das im Rahmen der Ausbildung entsteht, für Werbezwecke zu veröffentlichen. Dies gilt für Fotos und Filmmaterial, welches die NextLevel Akademie erstellt, fotografiert bzw. gefilmt hat und für solches Material, auf dem der/die Teilnehmer/in selbst abgebildet ist. Ein Widerruf der übertragenen Bildrechte ist zulässig und bedarf der Schriftform.<br><br><b>3. Gebühren</b><br><br>3.1 Die Höhe der Ausbildungsgebühren ergibt sich aus den Vereinbarungen im Ausbildungsvertrag.<br><br>3.2 Die Ausbildungsgebühr ist mit Zugang der Rechnung fällig. Sie ist unter Angabe der Rechnungsnummer auf das in der Rechnung angegebene Konto zu zahlen. Das Recht zur Teilnahme an einer Veranstaltung setzt die vorherige (An-)Zahlung der Ausbildungsgebühr bzw. die Einreichung des Bildungsgutscheins voraus.<br><br>3.3 Bis zur vollständigen Zahlung aller Ausbildungsgebühren steht Nextlevel Akademie ein Zurückbehaltungsrecht an dem Abschlusszeugnis und an der Teilnahmebescheinigung zu.<br><br>3.4 Tritt ein Dritter (z.B. die Agentur für Arbeit, Jobcenter) in die Zahlungsverpflichtung des/der Teilnehmer/in ganz oder teilweise ein oder tritt der/die Teilnehmer/in seine Ansprüche auf Zahlung der Gebühren an die Nextlevel Akademie ab, so erfolgt die Abrechnung direkt mit dem Dritten.<br><br>3.5 Der/die Teilnehmer/in haftet neben einem eventuellen Dritten für die Zahlung der Gebühren. Überweist der Fördergeldgeber die Ausbildungsgebühren an den/die Teilnehmer/in, so verpflichtet er/sie die jeweilige Rate innerhalb von 14 Tagen auf das Konto der Nextlevel Akademie unter Angabe der Lehrgangsbezeichnung einzuzahlen. Bei Verzögerungen sind bankübliche Zinsen fällig.<br><br>3.6 Im Falle einer Förderung muss die Zahlungsweise entsprechend den Zahlungen des Fördergeldgebers erfolgen, längstens bis zum Ende der Ausbildung.<br><br>3.7 Sofern der/die Dritte nicht die Gebühren übernimmt (z.B. durch einen Bildungsgutschein), hat der/die Teilnehmer/in  ein sofortiges kostenfreies Recht zu kündigen.<br><br><b>4. Rücktritt</b>4.1 Der/die Teilnehmer/in ist berechtigt, den Ausbildungsvertrag mit einer Frist von sechs Wochen, erstmals zum Ende der ersten drei Monate, danach jeweils zum Ende der nächsten drei Monate ohne Angabe von Gründen zu kündigen. Die Kündigung muss in schriftlicher Form erfolgen.<br><br>4.2 Das Recht der Kündigung aus wichtigem Grund für den/die Teilnehmer/in oder für die Nextlevel Akademie bleibt unberührt. Der Grund ist auf Verlangen schriftlich zu bezeichnen und durch Nachweise zu belegen.<br><br>4.3 Die Nextlevel Akademie kann zu jeder Zeit aus wichtigen Gründen den bestehenden Ausbildungsvertrag kündigen. Wichtige Gründe sind insbesondere: häufige Verspätungen, Fehlzeiten oder unentschuldigte Abwesenheit des/der Teilnehmer/in, vorsätzliche Entwendung, Beschädigung oder Zerstörung von Lehrmaterial und Einrichtung der Nextlevel Akademie, Nichtbefolgung von Anordnungen der Mitarbeiter der Nextlevel Akademie, Nichteinhaltung der Hausordnung.<br><br>4.4 Bei Rücktritt durch Arbeitsaufnahme wird gemäß den Regelungen des Fördergeldgebers verfahren.<br><br><b>5. Pflichten des/der Teilnehmer/in</b>5.1 Der/die Teilnehmer/in verpflichtet sich zur regelmäßigen Teilnahme am Ausbildungslehrgang.<br><br>5.2 Die Hausordnung und die Unfallverhütungsvorschriften sind zu befolgen.<br><br>5.3 Der/die Teilnehmer/in ist verpflichtet, bei Krankheit die Nextlevel Akademie umgehend zu informieren. Die Arbeitsunfähigkeitsbescheinigung ist innerhalb von 3 Tagen an die Nextlevel Akademie zu senden. Eine Kopie der Arbeitsunfähigkeitsbescheinigung erhält ggf. der zuständige Fördergeldgeber ebenfalls innerhalb von 3 Kalendertagen.<br><br>5.4 Für unentschuldigt versäumte Stunden und Tage ist die volle Ausbildungsgebühr  vom Fördergeldgeber zu entrichten.<br><br>5.5 Alle Lehrmaterialien und Instrumente sind nur nach Anweisung der Dozenten und sorgsam zu bedienen. Das Lehrmaterial ist nicht aus den Räumen der Nextlevel Akademie zu entfernen und/oder für kommerzielle /private Zwecke zu nutzen.<br><br><b>6. Haftungsbeschränkung</b><br><br>6.1 Die Nextlevel Akademie haftet nur für Schäden die auf Vorsatz oder grober Fahrlässigkeit seiner gesetzlichen Vertreter oder Mitarbeiter beruhen. Jegliche weitere Haftung ist ausgeschlossen, soweit gesetzlich zulässig.<br><br><b>7. Versicherung</b><br><br>7.1 Es besteht für alle Teilnehmer/innen eine Unfallversicherung bei der Verwaltungsberufsgenossenschaft innerhalb der Schulräume.  Die Krankenversicherung ist durch den/die Teilnehmer/in zu gewährleisten und auf Anfrage nachzuweisen.<br><br><b>8. Allgemeines</b><br><br>8.1 Soweit einzelne Bestimmungen dieses Vertrages unwirksam sind oder werden, wird dadurch die Wirksamkeit des Vertrages im Übrigen nicht berührt, unwirksame Regelungen sind durch sinngemäße wirksame zu ersetzen.<br><br>8.2 Änderungen oder Ergänzungen des Vertrages bedürfen zu ihrer Wirksamkeit der Schriftform.')),0,'LR');
        
        //$pdf->Output();
        
        if(!isset($contract->id))
        {
            $contract=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
            $pdf->Output('company_files/contracts/'.$contract, 'F');
        
            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
            $id=DB::getPdo()->lastInsertId();
        }
        else
        {
            $id=$contract->id;
            $contract=$contract->contract;
            $pdf->Output('company_files/contracts/'.$contract, 'F');
        }
        return $id;
        
        exit();
    }
    
    public function coach_contract(Request $request, $contact, $type, $contract=0, $coach)
    {
        //ini_set('memory_limit', '-1');
        //require('fpdf17/fpdf.php');
        //require('fpdi/src/autoload.php');
        
        $courses='';
        $row=DB::select("SELECT * FROM contact_courses WHERE c_id='$contact->id' AND contract_id='$contract->id'");
        if(count($row)!=0)
        { $i=0;
            foreach($row as $r)
            {
                $row2=DB::select("SELECT title FROM courses WHERE id='$r->course_id' LIMIT 1");
                if(count($row2)==0) continue;
                $row2=collect($row2)->first();
                
                if($i++==0)
                $courses.=$row2->title;
                else
                $courses.=', '.$row2->title;
            }
        }
        
        $funding_source='';
        $funding_address='';
        $funding=DB::select("SELECT * FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if(count($funding)==1)
        {
            $funding=collect($funding)->first();
            $funding_source=$funding->name;
            $funding_address=$funding->address;
        }
        
        $contact_name='';
        $contact_address='';
        $contact_phone='';
        $contact_email='';
        $funding=DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if(count($funding)==1)
        {
            $funding=collect($funding)->first();
            $contact_name=$funding->name;
            $contact_address=$funding->door_no.', '.$funding->street_name;
            if($funding->address!='')
            $contact_address.=', '.$funding->address;
            $contact_address.=', '.$funding->city.', '.$funding->zip_code;
            $contact_phone=$funding->phone_no;
            $contact_email=$funding->email;
        }
        
        if($contract->beginning!='0000-00-00')
        {
            $begin=date_format(new DateTime($contract->beginning),'d.m.Y');
            $end=date_format(new DateTime($contract->end),'d.m.Y');
        }
        else
        {
            $begin=date_format(new DateTime($contact->beginning),'d.m.Y');
            $end=date_format(new DateTime($contact->end),'d.m.Y');
        }
        $c_date=date('d.m.Y');
        
        //$pdf = new \setasign\Fpdi\Fpdi();
        $pdf = new \Fpdf('P','mm','A4'); //8.5" x 11" laser form
        $pdf->setTitle('Coach Contract');
	    $pdf->SetDrawColor(172, 172, 172);
	    $pdf->SetTextColor(0, 0, 0);
	    //$pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetMargins(16.35, 16.35, 16.35);
        
        if($request->input('s')=='0') $status=0;
        else $status=1;
        
        $r_id=1;
        $page_height=0;
        $one_section=0;
        $i=0;
        $current_page=$pdf->PageNo();
        $starting_page_no=$pdf->PageNo();
        $end_page_no=$current_page;
        $end_page_height=0;
        
        $pdf->AddPage();
        $pdf->setLeftMargin(8);
        $pdf->setTopMargin(30);
        $pdf->ln(15);
        
        $pdf->SetDrawColor(172, 172, 172);
	    $pdf->SetTextColor(0, 0, 0);
                
	    $pdf->SetFont('Arial','B',15);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Rahmenvertrag'), 0, 0, 'C');
        $pdf->ln(12);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','zwischen'), 0, 0, 'L');
        $pdf->ln(10);
        
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','der NextLevel Akademie, Bundesallee 86, 12161 Berlin'),0,'LR');
        
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','im Folgenden: Auftraggeber'), 0, 0, 'R');
        $pdf->ln(9);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->ln(1);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','und'), 0, 0, 'L');
        
        $pdf->ln(14);
        $address=$contact->door_no.', '.$contact->street_name;
        if($contact->address!='')
        $address.=', '.$contact->address;
        $address.=', '.$contact->city.', '.$contact->zip_code;
        $dob='';
        if($dob!='01-01-1900') $dob=$contact->dob;
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252',$contact->name.', '.$address),0,'LR');
        
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','im Folgenden: Auftragnehmer'), 0, 0, 'R');
        $pdf->ln(4);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->ln(10);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'wird folgender Rahmenvertrag über freie Mitarbeit vereinbart:')),0,'LR');
        $pdf->ln(2);
        
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 1'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Keine Pflicht zur Erteilung und Annahme von Aufträgen'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Der Auftragnehmer erklärt sich grundsätzlich bereit, ab dem '.$contact->start_working.' Aufträge für den Auftraggeber zu den nachfolgenden Vereinbarungen zu übernehmen. Dieser Vertrag verpflichtet allerdings den Auftragnehmer ausdrücklich nicht, einzelne vom Auftraggeber angebotene Aufträge anzunehmen, verpflichtet aber auch den Auf-
traggeber nicht, dem Auftragnehmer solche Aufträge anzubieten. Er regelt allein die Grundsätze für die Geschäftsbeziehung.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 2'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Tätigkeit'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Die Thematik, der zeitliche Umfang, die Terminierung und der Durchführungsort eines Auftrages werden zwischen den Vertragsparteien miteinander einvernehmlich abgestimmt und in einer separaten schriftlichen Vereinbarung festgehalten.<br><br><b>2.</b> Eine solche schriftliche Vereinbarung ist Voraussetzung für das Zustandekommen eines einzelnen Auftrages.<br><br><b>3.</b> Über die im vereinbarten Auftrag genannten Aufgaben inklusive deren Vor- und Nachbereitung hinaus sind keine anderweitigen Nebenarbeiten geschuldet. Insbe-sondere ist der Auftragnehmer nicht verpflichtet, anderweitige Vertretungen durch-zuführen, an Konferenzen teilzunehmen oder an sonstigen zentralen Veranstaltungen des Auftraggebers teilzunehmen.<br><br><b>4.</b> Der Auftragnehmer führt den vereinbarten Auftrag mit der Sorgfalt eines ordentli-chen Kaufmannes in eigener unternehmerischer Verantwortung unter Berücksichti-gung der Interessen des Auftraggebers durch.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 3'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Weisungsfreiheit'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Der Auftragnehmer unterliegt bei der Durchführung eines vereinbarten Auftrages keinem Weisungs- oder Direktionsrechts des Auftraggebers und ist in Bezug auf Zeit, Dauer, Art, Weise und Ort der Ausübung seiner Tätigkeit im Rahmen der Regelungen des § 2 unter Berücksichtigung der Auftragsvereinbarung frei.<br><br><b>2.</b> Er ist frei von Weisungen zur Vorgehensweise zum Aufbau und Ablauf der Auftrags-ausführung. Er ist insbesondere methodisch und didaktisch frei. Die für die Erfüllung seines Auftrages notwendigen Mittel, insbesondere Lehrmittel, wählt er selbstständig aus. Die beim Auftraggeber vorhandenen Mittel, insbesondere Lehrmittel, stehen nach näherer Absprache zur Verfügung.<br><br><b>3.</b> Der Auftragnehmer ist nicht in die Arbeitsorganisation des Auftraggebers einge-bunden.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 4'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Arbeitsaufwand/Keine Höchstpersönlichkeit'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Der Umfang der nach § 2 übertragenen Aufgaben ergibt sich aus der separaten Auftragsvereinbarung. Deren Inhalte sind hinsichtlich der vereinbarten Termine und Zeiten verbindlich. Darüber hinaus unterliegt der Auftragnehmer in der inhaltlichen Ausgestaltung und der zeitlichen Festlegung seiner Tätigkeitszeit keinen Einschrän-kungen.<br><br><b>2.</b> Der Auftragnehmer ist nicht zur höchstpersönlichen Durchführung eines vereinbar-ten Auftrages verpflichtet, sondern kann sich auch der Hilfe von Dritten als Erfüllungs-gehilfen bedienen, wenn er deren persönliche, fachliche und pädagogische Eig-nung zur Erfüllung des Auftrages gegenüber dem Auftraggeber nachweist.<br><br><b>3.</b> Der Auftragnehmer garantiert, dass er während der Laufzeit dieses Vertrages sämt-liche Verpflichtungen des Mindestlohngesetzes, insbesondere die aus diesem Gesetz folgenden Dokumentationspflichten und die Zahlungspflichten gegenüber dem je-weiligen Berechtigten erfüllt.<br><br>Er wird für den Fall, dass er Dritte bei der Erfüllung dieses Vertrages einsetzt, die sich ihrerseits zur Erfüllung ihrer Pflichten Erfüllungsgehilfen bedienen, zusichern lassen, dass die Dritten die Verpflichtungen nach dem Mindestlohngesetz in seiner jeweils gültigen Fassung erfüllen.<br><br>Der Auftragnehmer verpflichtet sich, alle Anfragen des Auftraggebers zur Einhaltung der Bestimmungen des Mindestlohngesetzes wahrheitsgemäß und umfassend zu be-antworten und hierzu vom Auftraggeber angeforderte Unterlagen unverzüglich vor-zunehmen. Er verpflichtet sich insbesondere, dem Auftraggeber auf dessen Anforde-rung die Arbeitszeitaufzeichnungen der zur Erfüllung des Auftrags ggf. eingesetzten Arbeitnehmer sowie die Lohn- und Gehaltsabrechnungen vollständig zur Einsicht-nahme in anonymisierter Form unter Beachtung der datenschutzrechtlichen Grunds-ätze zur Verfügung zu stellen. Er ist ebenso verpflichtet, auf Anforderung vom Auf-traggeber die fristgerechte Zahlung des Mindestlohns nachzuweisen. Für den Fall, dass er sich der Hilfe Dritter bedient, die ihrerseits Erfüllungsgehilfen zur Erfüllung ihrer Aufgaben nach diesem Vertrag einsetzen, ist er verpflichtet, beim Dritten die Einhal-tung des Mindestlohngesetzes entsprechend zu überprüfen und gegenüber dem Auftraggeber auf Anforderung nachzuweisen, dass er diese Überprüfungen vorge-nommen hat und bei den Überprüfungen kein Verstoß gegen das Mindestlohngesetz festgestellt wurde.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 5'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Konkurrenztätigkeit'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Der Auftragnehmer darf ausdrücklich auch für andere Auftraggeber, die im Wett-bewerb mit dem Auftraggeber stehen, tätig sein. Eine vorherige Zustimmung des Auf-traggebers ist ausdrücklich nicht erforderlich.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 6'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Verschwiegenheit/Aufbewahrung'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Der Auftragnehmer verpflichtet sich, über alle ihm während seiner Tätigkeit für den Auftraggeber anvertrauten oder bekannt gewordenen Geschäfts- und Betriebsge-heimnisse und alle ihm bekannt werdenden sonstigen geschäftlichen und betriebli-chen Tatsachen Stillschweigen zu bewahren, soweit er nicht aufgrund zwingender gesetzlicher Vorschriften zur Auskunftserteilung verpflichtet ist. Dies gilt auch über den Fortbestand dieses Vertrages hinaus.<br><br><b>2.</b> Der Auftragnehmer ist ferner verpflichtet, alle ihm zur Verfügung gestellten Ge-schäfts- und Betriebsunterlagen sowie mittels EDV gespeicherte Daten ordnungsge-mäß aufzubewahren und dafür zu sorgen, dass unbefugte Dritte nicht Einsicht neh-men können.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 7'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Rückgabeverpflichtungen'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Die zur Verfügung gestellten Unterlagen und Daten sowie sonstige dem Auftragneh-mer im Rahmen eines einzelnen Auftrages zur Verfügung gestellten Gegenstände sind während der Dauer dieses Vertragsverhältnisses auf Anforderung und nach Be-endigung des Vertragsverhältnisses unverzüglich ohne Aufforderung durch den Auf-traggeber an diesen zurückzugeben. Gleiches gilt für eventuell gefertigte Kopien, Abschriften, Duplikate oder sonstige Vervielfältigungen und Reproduktionen, insbe-sondere im Wege elektronischer Datenverarbeitung. Ein Zurückbehaltungsrecht steht dem Auftragnehmer nicht zu.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 8'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Datenschutz'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Der Auftragnehmer verpflichtet sich, sämtliche datenschutzrechtlichen Bestim-mungen, Gesetze und Verordnungen, insbesondere die Vorschriften zum Sozialda-tenschutz einzuhalten und diese Verpflichtung zur Einhaltung aller datenschutzrecht-lichen Regelungen an etwaige, von ihm eingesetzte Erfüllungsgehilfen nachweisbar weiterzugeben.<br><br><b>2.</b> Er ist gegenüber dem Auftraggeber verpflichtet, von ihm zur Erfüllung dieses Ver-trages eingesetzte Personen entsprechend § 5 BDSG auf die Einhaltung des Daten-geheimnisses zu verpflichten und nur solche Personen im Rahmen der Erfüllung dieses Vertrages einzusetzen, die nachgewiesen auf die Einhaltung des Datengeheimnisses nach § 5 BDSG verpflichtet sind.<br><br><b>3.</b> Die Verpflichtung erfolgt auf Basis der als Anlage 1 beigefügten Verpflichtungser-klärung, die Bestandteil dieses Vertrages ist.<br><br><b>4.</b> Der Auftraggeber hat das Recht, die Einhaltung der hier eingegangenen Ver-pflichtung des Auftragnehmers zu prüfen und die Vorlage von Nachweisen zu ver-langen.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 9'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Honorar'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Der Auftraggeber zahlt an den Auftragnehmer ein Honorar, welches im Zuge der einzelnen Auftragsvereinbarung individuell verhandelt wird.<br><br><b>2.</b> Mit dem vereinbarten Honorar sind alle Aufwände des Auftragnehmers, insbeson-dere Fahrtkosten, Vor- und Nachbereitungsaufwand abgegolten.<br><br><b>3.</b> Ein Honoraranspruch besteht nur für tatsächlich geleistete Tätigkeiten. Im Falle der Verhinderung des Auftragnehmers nicht geleistete Tätigkeiten, z. B. im Falle von Ur-laub, Feiertagen oder Erkrankung, werden nicht vergütet. Gleiches gilt für die even-tuelle freiwillige Teilnahme an Besprechungen mit dem Auftraggeber.<br><br><b>4.</b> Die Auszahlung des Honorars erfolgt nachträglich nach Einreichung einer entspre-chenden Honorarrechnung des Auftragnehmers, aus der sich die Berechnung der Höhe des Honorars nachvollziehbar ergibt.<br><br>Rechnungen stellt der Auftragnehmer jeweils bis zum 5. Kalendertag des auf die Leis-tungserbringung folgenden Monats. Sie sind 25 Tage nach Rechnungseingang beim Auftraggeber zur Zahlung fällig. Die Auszahlung erfolgt durch Überweisung auf das Konto:<br><br>
IBAN: '.$contact->iban.'<br>
BIC: '.$contact->bic.'<br>
Kreditinstitut: '.$contact->bank_name.'<br><br><b>5.</b> Für die Versteuerung der Vergütung hat der Auftragnehmer selbst zu sorgen.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 10'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Leistungsverhinderungen des Auftragnehmers'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Im Falle von Leistungsverhinderungen, unabhängig auf welchem Grund sie beruhen, ist der Auftragnehmer verpflichtet, dem Auftraggeber unverzüglich die Informatio-nen zur Verfügung zu stellen, die notwendig sind, um, soweit erforderlich, die im Rahmen des Auftrages betreuten Teilnehmer betreuen zu können.<br><br>Ausgefallene Leistungen können in Absprache mit dem Auftraggeber nachgeholt werden.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 11'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Befristung des Rahmenvertrages'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Dieser Rahmenvertrag ist unbefristet gültig.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 12'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Beendigung durch Kündigung'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Das Vertragsverhältnis kann sowohl vom Auftragnehmer als auch vom Auftragge-ber jederzeit mit einer Frist von 2 Wochen ordentlich gekündigt werden.<br><br><b>2.</b> Jede Vertragspartei ist darüber hinaus berechtigt, auch einen separat vereinbar-ten Auftrag vorzeitig mit einer Frist von 2 Wochen zu kündigen, sofern im Rahmen die-ses Auftrages nicht schriftlich eine andere Kündigungsfrist vereinbart ist.<br><br><b>3.</b> Das Recht zur außerordentlichen Kündigung mit sofortiger Wirkung bleibt unbe-rührt.<br><br>Der Auftraggeber ist insbesondere berechtigt, den Vertrag und etwaig separat ver-einbarte Aufträge außerordentlich und fristlos zu kündigen, wenn der Auftragnehmer die nach diesem Vertrag bestehenden Verpflichtungen zur Einhaltung des Mindest-lohngesetzes nicht erfüllt.<br><br>Der Auftragnehmer erklärt ausdrücklich,<br><br><b>a)</b> dass er oder sein Unternehmen die Technologie von L. Ron Hubbard nicht anwendet oder verbreitet.<br><b>b)</b> dass er oder sein Unternehmen nicht Mitglied der International Association of Scientologist oder einer anderen Organisation, die nach den Methoden von L. Ron Hubbard arbeitet, ist.<br><b>c)</b> dass er die Methoden von L. Ron Hubbard zur Durchführung von Schulungen, Seminaren, Lehrgängen etc. ablehnt.<br><b>d)</b> dass weder er noch seine Mitarbeiter nach den Methoden von L. Ron Hub-bard geschult wurden oder werden bzw. keine Kurse und/oder Seminare nach der Methode L. Ron Hubbard besuchen.<br><b>e)</b> dass weder er oder seine Mitarbeiter rechtskräftig wegen einer Straftat nach den §§ 171, 174 bis 174c, 176 bis 180a, 181a, 182 bis 184f, 225, 232 bis 233a, 234, 235 oder 236 des Strafgesetzbuchs verurteilt worden sind.<br><br>Bei einem Verstoß gegen eine oder mehrere Erklärungen der Buchstaben a) bis ein-schließlich e) ist der Auftraggeber jederzeit berechtigt, diesen Vertrag und eventuell bereits vereinbarte Aufträge aus wichtigem Grund ohne Einhaltung einer Frist zu kün-digen. Weitergehende Rechte bleiben unberührt.<br><br><b>4.</b> Jede Kündigungserklärung bedarf der Schriftform.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 13'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Haftung des Auftragnehmers'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Sollte der Auftraggeber durch die Durchführung und Abwicklung dieses Vertrages und/oder eines Auftrages, insbesondere dadurch, dass der Auftragnehmer seine sich aus diesem Vertrag oder einem Auftrag ergebenden Pflichten verletzt, Nachteile erleiden, stellte der Auftragnehmer den Auftraggeber von diesen Nachteilen frei.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 14'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Versicherungen'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Der Auftraggeber empfiehlt dem Auftragnehmer zur Absicherung etwaiger Risiken eine eigene Haftpflicht- bzw. Unfallversicherung abzuschließen. Der Auftragnehmer stimmt ausdrücklich zu, dass er für den Unfallversicherungsschutz selbst zu sorgen hat, da ein Unfallversicherungsschutz durch den Auftraggeber nicht besteht. Eine Erstat-tung der zu leistenden Versicherungsprämien durch den Auftraggeber erfolgt nicht.<br><br><b>2.</b> Zwischen den Parteien besteht ferner Einigkeit, dass kein sozialversicherungsrechtli-ches Beschäftigungsverhältnis besteht. Für den Fall der Krankheit, des Alters, der Pfle-gebedürftigkeit und der Beschäftigungslosigkeit wird der Auftragnehmer selbststän-dig vorsorgen.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 15'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Aufhebung etwaig anderer Vereinbarungen'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Mit Abschluss dieses Rahmenvertrages wird bzw. werden eventuell bereits geschlos-sene oder noch bestehende Rahmenverträge über freie Mitarbeit aufgehoben. Hin-sichtlich eventuell noch laufender Aufträge wird der aufgehobene Rahmenvertrag durch diesen Rahmenvertrag mit Abschluss dieses Rahmenvertrages ersetzt.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 16'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Schriftform'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Ergänzungen und Änderungen dieses Vertrages bedürfen zu ihrer Wirksamkeit der Schriftform, es sei denn, sie beruhen auf einer ausdrücklichen oder individuellen Ver-tragsabrede.<br><br><b>2.</b> Auch dieses Formerfordernis kann nur schriftlich außer Kraft gesetzt werden, es sei denn die Aufhebung des Schriftformerfordernisses beruht auf einer ausdrücklichen oder individuellen Vertragsabrede.')),0,'LR');
        
        
        $pdf->ln(2);
        $pdf->SetFont('Arial','B',10.8);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','§ 17'), 0, 0, 'C');
        $pdf->ln(5);
        $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','Salvatorische Klausel'), 0, 0, 'C');
        $pdf->ln(14);
        
        $pdf->SetFont('Arial','',10.8);
        $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'Sollten einzelne Bestimmungen dieses Vertrages ganz oder teilweise rechtsunwirksam sein oder werden, berührt dies nicht die Gültigkeit der übrigen Bestimmungen. Anstel-le des rechtsunwirksamen Teils gilt sodann als vereinbart, was dem in gesetzlich zuläs-siger Weise am nächsten kommt, was die Vertragsparteien vereinbart hätten, wenn ihnen die Unwirksamkeit bekannt gewesen wäre. Dies gilt entsprechend für den Fall, dass dieser Vertrag eine Lücke aufweisen sollte. Beruht die Ungültigkeit auf einer Leis-tungs- oder Zeitbestimmung, so tritt an ihre Stelle das gesetzlich zulässige Maß.')),0,'LR');
        
        $pdf->ln(10);
        $date=date('d-m-Y');
        $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','
Berlin, '.$date.'
'),0,'LR');
        
        $pdf->ln(10);
        $y=$pdf->GetY();
        $image='';
        if(isset($contract->id) AND $contract->signature!='' AND $coach==0)
        $image=$pdf->Image('signatures/'.$contract->signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'








_______________________
NextLevel Akademie
'),0,'LR');
        
        $pdf->setXY('100', $y);
        $image='';
        if(isset($contract->id) AND $contract->signature!='' AND $coach==0)
        $image=$pdf->Image('signatures/'.$contract->signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'








_______________________
Auftragnehmer
'),0,'LR');
        
        //$pdf->Output(); exit();
        
        if(!isset($contract->id))
        {
            $contract=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
            $pdf->Output('company_files/contracts/'.$contract, 'F');
        
            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
            $id=DB::getPdo()->lastInsertId();
        }
        else
        {
            $id=$contract->id;
            $contract=$contract->contract;
            $pdf->Output('company_files/contracts/'.$contract, 'F');
        }
        return $id;
        
        exit();
    }
    
    public function view_contract(Request $request, $id)
    {
        $contract=DB::select("SELECT * FROM contracts WHERE id='$id' LIMIT 1");
        if(count($contract)==0) return redirect('dashboard');
        $contract=collect($contract)->first();
        return view('panel.contract.index', ['title'=>'Contract', 'contract'=>$contract]);
    }
    
    public function save_signature(Request $request)
    {
        $data=array();
        
        if($request->input('id')!='')
        {
            $id=$request->input('id');
            $image=$request->input('image');
            
            $signature=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.png';
            
            $img = str_replace('data:image/png;base64,', '', $image);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            file_put_contents("signatures/".$signature, $fileData);
            //imagejpeg($fileData, "signatures/".$signature);
            
            DB::update("UPDATE contracts SET signature='$signature' WHERE id='$id'");
            $data['success']=1;
        }
        
        return response()->json($data);
    }
    
    public function signature()
    {
        require('fpdf17/fpdf.php');
        require('fpdi/src/autoload.php');

        $pdf =new Fpdi();
        $pdf->AddPage();

        //Set the source PDF file
        $file='4252ftu.pdf';
        $old_file=explode('.', $file);
        $old_file=$old_file[0].'_old.pdf';
        copy("company_files/contracts/".$file, "company_files/contracts/".$old_file);
        $pagecount = $pdf->setSourceFile("company_files/contracts/".$file);
        
        //Import the first page of the file
        $tpl = $pdf->importPage(1);


        //Use this page as template
        // use the imported page and place it at point 20,30 with a width of 170 mm
        $pdf->useTemplate($tpl, 0, 0, 210);
        
        
        //Select Arial italic 8
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY(90, 220);

        $signature='7552hga.png';
        $image = "signatures/".$signature;
        $pdf->Cell(200,14,$pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 120), 0, 0, 'L');
        
        $pdf->output("company_files/contracts/".$file, 'F');
        exit();
        
        return view('signature.index', ['title'=>'signature']);
    }
    
    public function funding_sources(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            
            $delete=addslashes($request->input('delete'));
            
            //track Activity START
            $row=DB::select("SELECT id, name FROM funding_source WHERE id='$delete' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=$row->name;
            \CommonFunctions::instance()->log_activity($request, 'Deleted funding source - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM funding_sources WHERE id='$delete'");
            $request->session()->flash('success', 'Funding source has been deleted successfully.');
            
            return redirect('admin/funding-sources');
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $address=addslashes($request->input('address'));
            
            DB::insert("INSERT INTO funding_sources (name, address, added_by, added_on) VALUES ('$name', '$address', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Created funding source - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Successfully added.');
            return redirect('admin/funding-sources');
        }
        
        $sources=DB::select("SELECT * FROM funding_sources");
        return view('panel.funding_sources.index', ['title'=>'Funding Sources', 'sub_title'=>count($sources).' total funding sources', 'sources'=>$sources]);
    }
    
    public function edit_funding_source(Request $request, $id)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $address=addslashes($request->input('address'));
            
            DB::update("UPDATE funding_sources SET name='$name', address='$address' WHERE id='$id'");
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Updated funding source - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Successfully updated.');
            return redirect('admin/edit-funding-source/'.$id);
        }
        
        $sources=DB::select("SELECT * FROM funding_sources WHERE id='$id' LIMIT 1");
        $source=collect($sources)->first();
        return view('panel.edit_funding_source.index', ['title'=>'Edit Funding Source', 'source'=>$source]);
    }
    
    public function fetch_products(Request $request)
    {
        $data=array();
        $data['success']=0;
        $data['products']='';
        
        $c_id=$request->input('c_id');
        $products=array(); $i=0;
        $row=DB::select("SELECT c_id, p_id FROM contact_products WHERE c_id='$c_id'");
        foreach($row as $r)
        {
                $row22=DB::select("SELECT * FROM products WHERE id='$r->p_id' LIMIT 1");
                if(count($row22)==0) continue;
                $row22=collect($row22)->first();
                $products[$i]['product']=$row22;
                
                $products[$i]['total_cost']=0;
                $products[$i]['total_lessons']=0;
                
                $row2=DB::SELECT("SELECT id, m_id FROM contact_modules WHERE p_id='$r->p_id' AND c_id='$r->c_id'");
                $modules=array(); $j=0;
                foreach($row2 as $r2)
                {
                    $row22=DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                    if(count($row22)==0) continue;
                    $row22=collect($row22)->first();
                    $modules[$j]['module']=$row22;
                
                    $modules[$j]['total_cost']=0;
                    $modules[$j]['total_lessons']=0;
                
                    $row3=DB::SELECT("SELECT id, i_id FROM contact_items WHERE p_id='$r->p_id' AND m_id='$r2->m_id' AND c_id='$r->c_id'");
                    $module_items=array(); $k=0;
                    foreach($row3 as $r3)
                    {
                        $module_items[$k]['course_item']=$r3;
                        
                        $row4=DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                        if(count($row4)==0) continue;
                        $row4=collect($row4)->first();
                        $module_items[$k]['item']=$row4;
                        
                        $products[$i]['total_lessons']+=$row4->lessons;
                        $products[$i]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                        $modules[$j]['total_lessons']+=$row4->lessons;
                        $modules[$j]['total_cost']+=$row4->lessons*$row4->price_lessons;
                    
                        $k++;
                    }
                    $modules[$j]['items']=$module_items;
                    $j++;
                }
            $products[$i]['modules']=$modules;
            
            $i++;
        }
        
        $data['products'].='<ul>';
        
        if(!empty($products)) {
            foreach($products as $p) {
                $p_id=$p['product']->id;
                
                $data['products'].='<li>'.$p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': €'.$p['total_cost'].')</li>
                                                                    
                <ul>';
                
                    if(!empty($p['modules'])) {
                        foreach($p['modules'] as $m) {
                            
                            $data['products'].='<li>'.$m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': €'.$m['total_cost'].')</li>
                                                                        
                            <ul>';
                            
                            
                                if(!empty($m['items'])) {
                                    foreach($m['items'] as $item) {
                                    
                                    $data['products'].='<li>'.$item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.' '.trans('forms.price_lesson').': €'.$item['item']->price_lessons.')</li>';
                                        
                                } }
                            
                                $data['products'].='</ul>';
                                
                        } }
                                                                        
                        $data['products'].='</ul>';
                        $data['products'].='<li style="list-style-type:none; padding-bottom:15px;"></li>';
                
                } }
                $data['products'].='</ul>';
        $data['success']=1;
        
        return response()->json($data);
    }
    
    public function fetch_contracts(Request $request)
    {
        $data=array();
        $data['success']=0;
        $data['contracts']='';
        
        $c_id=$request->input('c_id');
        $row2=DB::select("SELECT * FROM contracts WHERE c_id='$c_id' AND document='0' ORDER BY id DESC");
        if(count($row2)!=0)
        {
            foreach($row2 as $r2)
            {
                if($r2->signature=='') { $signed='<br>'.trans('dashboard.no_signature'); $color='#da624a'; }
                else { $signed='<br>'.trans('dashboard.signed'); $color='green'; }
                
                $created_on=date_format(new DateTime($r2->on_date),'d-m-Y H:i');
                
                $data['contracts'].='
                <tr>
                <td>'.$r2->type.'</td>
                <td><a href="'.url('company_files/contracts/'.$r2->contract).'" target="_blank" style="color: '.$color.';"><i class="fa fa-file-pdf"></i> '.$r2->contract.'</a>'.$signed.'</td>
                <td>'.$created_on.'</td>
                </tr>';
            }
            
        $data['success']=1;
        }
        
        return response()->json($data);
    }
    
    public function fetch_documents(Request $request)
    {
        $data=array();
        $data['success']=0;
        $data['contracts']='';
        
        $c_id=$request->input('c_id');
        $row2=DB::select("SELECT * FROM contracts WHERE c_id='$c_id' AND document='1' ORDER BY id DESC");
        if(count($row2)!=0)
        {
            foreach($row2 as $r2)
            {
                if($r2->signature=='') $signed='<br>Not Signed';
                else $signed='<br>Signed';
                
                $created_on=date_format(new DateTime($r2->on_date),'d-m-Y H:i');
                
                $data['contracts'].='
                <tr>
                <td>'.$r2->type.'</td>
                <td><a href="'.url('company_files/documents/'.$r2->contract).'" target="_blank" style="color: green;"><i class="fa fa-file-pdf"></i> '.$r2->contract.'</a></td>
                <td>'.$created_on.'</td>
                </tr>';
            }
            
        $data['success']=1;
        }
        
        return response()->json($data);
    }
}
