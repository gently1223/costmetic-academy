<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Mail;
use DB;
use setasign\Fpdi\Fpdi;
use NumberFormatter;
use PDF;
use PDFMerger;

class offers extends Controller
{

    public static function instance()
    {
        return new contacts();
    }

    public function __construct()
    {}

    private function get_recommendation_pmi_treeview()
    {}

    public function get_pmi_treeview(Request $request)
    {
        $exec_msg = '';
        $products2 = array();
        $i2 = 0;
        if ($request->input('contact_id') != '') {
            $contact_id = $request->input('contact_id');
            if ($contact_id > 0) {
                $products = DB::SELECT("SELECT * FROM contact_products inner join products on products.id = contact_products.p_id where c_id = '$contact_id'");
                if (count($products) > 0) {
                    foreach ($products as $r1) {
                        $products2[$i2]['product'] = $r1;

                        $products2[$i2]['total_cost'] = 0;
                        $products2[$i2]['total_lessons'] = 0;

                        /* Return all the modules with atleast 1 UE in it's MIs */
                        $row2 = DB::SELECT("SELECT m.* FROM modules m inner join contact_modules pm on pm.c_id = '$contact_id' and pm.m_id = m.id where pm.p_id = '$r1->id'");
                        $modules = array();
                        $j = 0;
                        foreach ($row2 as $r2) {
                            $modules[$j]['module'] = $r2;

                            $modules[$j]['total_cost'] = 0;
                            $modules[$j]['total_lessons'] = 0;

                            // $row3 = DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$course_id'");
                            $row3 = DB::SELECT(" select mi.id, mi.title, mi.description, mmi.c_id, mmi.p_id, mmi.m_id, mmi.lessons, mmi.price from module_items mi inner join contact_items mmi on mmi.c_id = '$contact_id' and mi.id = mmi.i_id where mmi.m_id = '$r2->id' AND mmi.p_id= '$r1->id'");
                            $module_items = array();
                            $k = 0;
                            foreach ($row3 as $r3) {
                                $module_items[$k]['item'] = $r3;

                                $lessons = $r3->lessons;

                                $products2[$i2]['total_lessons'] += $lessons;
                                $products2[$i2]['total_cost'] += $lessons * $r3->price;

                                $modules[$j]['total_lessons'] += $lessons;
                                $modules[$j]['total_cost'] += $lessons * $r3->price;

                                $k ++;
                            }
                            $modules[$j]['items'] = $module_items;
                            $j ++;
                        }
                        $products2[$i2]['modules'] = $modules;
                        $i2 ++;
                    }

                    $treeview = view('offers.treeview', [
                        'products' => $products2
                    ])->render();

                    return response()->json([
                        'success' => true,
                        'message' => 'success',
                        'treeview' => $treeview
                    ]);
                }
            }
        }
        // TODO: Check if the contact has any PMI assigned. If yes, return that. Otherwise
        // return the available ones
        // if (count($check) == 1) {
        // get all p/m/mi
        $products = DB::SELECT("SELECT * FROM products where category like '%coaching%'");

        foreach ($products as $r1) {
            $products2[$i2]['product'] = $r1;

            $products2[$i2]['total_cost'] = 0;
            $products2[$i2]['total_lessons'] = 0;

            /* Return all the modules with atleast 1 UE in it's MIs */
            $row2 = DB::SELECT("SELECT m.* FROM modules m inner join product_modules pm on pm.m_id = m.id where pm.p_id = '$r1->id'");
            $modules = array();
            $j = 0;
            foreach ($row2 as $r2) {
                $modules[$j]['module'] = $r2;

                $modules[$j]['total_cost'] = 0;
                $modules[$j]['total_lessons'] = 0;

                // $row3 = DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$course_id'");
                $row3 = DB::SELECT(" select mi.id, mi.title, mi.description, mmi.p_id, mmi.m_id, mi.lessons, mi.price_lessons price  from module_items mi inner join modules_module_items mmi on mmi.m_id = mi.id where mmi.p_id= '$r2->id'");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $module_items[$k]['item'] = $r3;

                    $lessons = $r3->lessons;

                    $products2[$i2]['total_lessons'] += $lessons;
                    $products2[$i2]['total_cost'] += $lessons * $r3->price;

                    $modules[$j]['total_lessons'] += $lessons;
                    $modules[$j]['total_cost'] += $lessons * $r3->price;

                    $k ++;
                }
                $modules[$j]['items'] = $module_items;
                $j ++;
            }
            $products2[$i2]['modules'] = $modules;
            $i2 ++;
        }

        $treeview = view('offers.treeview', [
            'products' => $products2
        ])->render();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'treeview' => $treeview
        ]);
    }

    public function manage_offer(Request $request)
    {
        if ($request->input('studentname') != '') {

            $regular = $request->regularquali; // for regular qualification
            $qual = '';
            if ($regular != '') {
                $i = 0;

                $qual = \DB::table('regular_qualification')->select('*')
                    ->where('id', $regular)
                    ->get();
            }
            $regularaddon_val = '';
            $addon = array();
            $extr = array();
            $textarr = array();
            $regblk = array();
            $rgblk = '';
            $rgg = array();
            $rgblkk = '';
            if ($request->regularquali == '1' && $request->divblkget1 != '') {
                $rgblkk = $request->divblkget1;
                $quaalblk = $request->divblkget1;
                foreach ($rgblkk as $value) {
                    $rgblk .= $value . ',';
                }
                $rgblk = rtrim($rgblk, ',');
            }
            if ($request->regularquali == '2' && $request->divblkget2 != '') {
                $rgblkk = $request->divblkget2;
                foreach ($request->divblkget2 as $value) {
                    $rgblk .= $value . ',';
                }
                $rgblk = rtrim($rgblk, ',');
            }
            if ($request->regularquali == '3' && $request->divblkget3 != '') {
                $rgblkk = $request->divblkget3;
                foreach ($request->divblkget3 as $value) {
                    $rgblk .= $value . ',';
                }
                $rgblk = rtrim($rgblk, ',');
            }

            $regular_add = $request->regularaddon; // regular addon
            if ($regular_add != '') {
                foreach ($regular_add as $reg) {
                    $addon[] = $reg;
                    $regularaddon_val .= $reg . ',';
                }
                $regularaddon_val = rtrim($regularaddon_val, ',');
            }
            $regulartextblk_val = '';
            $regular_text = $request->regulartexts; // regular textblock
            if ($regular_text != '') {

                $j = 0;
                foreach ($regular_text as $reg) {
                    $j ++;
                    $regulartextblk_val .= $reg . ',';
                    $textarr[$j]['id'][] = $reg;
                    $textt = \DB::table('regular_textblocks')->select('*')
                        ->where('id', $reg)
                        ->get();
                    $textarr[$j]['texts'][] = $textt[0]->textblock;
                }
                $regulartextblk_val = rtrim($regulartextblk_val, ',');
            }
            $regularextra = '';
            $regular_extraa = $request->regularextra; // regular textblock
            if ($regular_extraa != '') {

                foreach ($regular_extraa as $reg) {
                    $regularextra .= $reg . ',';
                    $extr[] = $reg;
                }
                $regularextra = rtrim($regularextra, ',');
            }

            $expert_ad = \DB::table('contacts')->select('*')
                ->where('id', $request->expertadv)
                ->get();
            if ($expert_ad[0]->funding_source != '' && $expert_ad[0]->funding_source > 0) {
                $funding_source = \DB::table('funding_sources')->select('*')
                    ->where('id', $expert_ad[0]->funding_source)
                    ->get();
            }
            $stdname = \DB::table('contacts')->select('*')
                ->where('id', $request->studentname)
                ->get();
            $sigg = \DB::table('users')->select('id', 'username', 'email', 'signature')
                ->where('id', $request->signature)
                ->get();
            $qualification = '';
            $qualificationid = '';
            if ($qual != '') {
                $qualification = $qual[0]->qualification;
                $qualificationid = $qual[0]->id;
            }
            $jobcenter_name = '';
            if (isset($funding_source) && isset($funding_source[0]))
                $jobcenter_name = $funding_source[0]->name;
            $prodarr = '';
            $modarr = '';
            $itemsarr = '';
            $starr = '';

            if (! empty($request->products)) {
                $prodarr = $request->products;
            }
            if (! empty($request->modules)) {
                $modarr = $request->modules;
            }
            $total_less = 0;
            if (! empty($request->items)) {
                $itemsarr = $request->items;
                foreach ($itemsarr as $key => $value) {
                    $pp = "lessons" . $value;
                    $cc = $request->$pp;
                    $total_less += $cc;
                }
            }

            if (! empty($request->staticblk)) {

                $starr = $request->staticblk;
            }

            $data = [
                'expert_advisor' => $expert_ad[0]->name,
                'street' => $expert_ad[0]->street_name,
                'door_no' => $expert_ad[0]->door_no,
                'zip' => $expert_ad[0]->zip_code,
                'city' => $expert_ad[0]->city,
                'jobcenter_name' => $jobcenter_name,
                'studentno' => $request->studentname,
                'studname' => $stdname[0]->name,
                'consult_date' => $request->due_date,
                'begin_date' => $request->begin_date,
                'consultation_mode' => $request->consultmode,
                'qualification' => $qualification,
                'qualificationid' => $qualificationid,
                'addon' => $addon,
                'textt' => $textarr,
                'extr' => $extr,
                'signature' => $sigg[0]->signature,
                'quaalblk' => $rgblkk,
                'test_desc' => $request->description,
                'prodarr' => $prodarr,
                'modarr' => $modarr,
                'itemsarr' => $itemsarr,
                'starr' => $starr,
                'total_less' => $total_less
            ];
            error_reporting(0);
            header('Content-Type: text/html; charset=utf-8');
            if ($request->offtype == 1) {
                $pdf = PDF::loadView('offers.pdf', $data);
            }
            if ($request->offtype == 2) {
                $pdf = PDF::loadView('offers.coaching', $data);
            }

            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'dpi' => 106,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'debugCss' => true
            ]);
            // $pdf->AddPage();
            $name = 'Offer-' . $this->random_string(10) . date('d-m-Y');
            // return $pdf->stream('document.pdf');
            $pdf->save('company_files/offers/' . $name . '.pdf');
            // Storage::disk('uploads2')->put('/offers/'.$name.'.pdf', $pdf->output());
            $insert_id = DB::table('offers')->insertGetId([
                'student_id' => $request->studentname,
                'expertadvisor' => $request->expertadv,
                'type' => $request->offtype,
                'description' => $request->description,
                'consultation_date' => $request->due_date,
                'consultation_mode' => $request->consultmode,
                'begin_date' => $request->begin_date,
                'regular_qualification' => $qualificationid,
                'regular_addon' => $regularaddon_val,
                'regular_textblock' => $regulartextblk_val,
                'regular_extra_qual' => $regularextra,
                'created_at' => new \DateTime(),
                'pdf_name' => $name . '.pdf',
                'signature_id' => $request->signature,
                'qual_blk' => $rgblk
            ]);

            $contacts_id = \DB::table('offers')->select('contacts.*', 'offers.*')
                ->leftJoin('contacts', 'offers.expertadvisor', '=', 'contacts.id')
                ->where('offers.id', $insert_id)
                ->get();
            foreach ($prodarr as $product) {

                DB::table('offer_products')->insert([
                    'c_id' => $contacts_id[0]->id,
                    'p_id' => $product,
                    'offer_id' => $insert_id
                ]);
            }
            foreach ($modarr as $module) {
                $pr_id = \DB::table('product_modules')->select('*')
                    ->where('m_id', $module)
                    ->get();

                DB::table('offer_modules')->insert([
                    'c_id' => $contacts_id[0]->id,
                    'p_id' => $pr_id[0]->p_id,
                    'm_id' => $module,
                    'offer_id' => $insert_id
                ]);
            }
            foreach ($itemsarr as $item) {

                $module_id = \DB::table('modules_module_items')->select('*')
                    ->where('m_id', $item)
                    ->get();
                $pr_id = \DB::table('product_modules')->select('*')
                    ->where('m_id', $module_id[0]->p_id)
                    ->get();
                $lessons = $request->input('lessons' . $item);
                $price = $request->input('prices' . $item);
                DB::table('offer_items')->insert([
                    'c_id' => $contacts_id[0]->id,
                    'p_id' => $pr_id[0]->p_id,
                    'm_id' => $module_id[0]->p_id,
                    'i_id' => $item,
                    'offer_id' => $insert_id,
                    'lessons' => $lessons,
                    'price_lesson' => $price
                ]);
            }
        }
        $data['title'] = "Manage Offers";
        $p_m_mi_templates = DB::select("SELECT id, title FROM p_m_mi_templates ORDER BY title ASC");
        $courses_kg = DB::select("SELECT * FROM courses WHERE type='Regular' ORDER BY title ASC");
        $courses_coaching = DB::select("SELECT * FROM courses WHERE type='Coaching' ORDER BY title ASC");
        
        $data['students'] = \DB::table('contacts')->select('id', 'name')
            ->where('type', 'Student')
            ->orderBy('name', 'asc')
            ->get();
        $data['expertadv'] = \DB::table('contacts')->select('id', 'name')
            ->where('type', 'Expert Advisor')
            ->orderBy('name', 'asc')
            ->get();

        $data['p_m_mi_templates'] =$p_m_mi_templates;
        $data['courses_kg'] =$courses_kg;
        $data['courses_coaching'] =$courses_coaching;
        $data['regular_qualifications'] = \DB::table('regular_qualification')->get();
        $data['regular_addon'] = \DB::table('regular_addon')->get();

        // $data['addon_column']= \DB::table('regular_addon')->pluck('regular_main');
        $data['regular_textblocks'] = \DB::table('regular_textblocks')->select('id', 'textblock')->get();
        $data['regular_extra'] = \DB::table('regular_extraqualifications')->select('id', 'extra_text', 'corporation_partner', 'text_main_id')->get();
        $data['signature'] = \DB::table('users')->select('id', 'username', 'email', 'signature')->get();
        $data['offers'] = \DB::table('offers')->select('offers.id as offid', 'contacts.*', 'offers.*')
            ->leftJoin('contacts', 'offers.student_id', '=', 'contacts.id')
            ->orderBy('offers.created_at', 'desc')
            ->get();
        // print_r( $data['offers']);
        // exit;
        if ($request->input('delete') != '') {
            $delete = $request->input('delete');
            DB::delete("DELETE FROM offers WHERE id='$delete'");
            DB::delete("DELETE FROM offer_products WHERE offer_id='$delete'");
            DB::delete("DELETE FROM offer_modules WHERE offer_id='$delete'");
            DB::delete("DELETE FROM offer_items WHERE offer_id='$delete'");
            $request->session()->flash('success', 'Offer has been deleted successfully.');

            return redirect('admin/manage_offer');
        }
        if ($request->input('mail_pdf') != '') {
            $off_id = $request->input('mail_pdf');

            $data['off'] = \DB::table('offers')->select('contacts.*', 'offers.*')
                ->leftJoin('contacts', 'offers.expertadvisor', '=', 'contacts.id')
                ->where('offers.id', $off_id)
                ->get();

            $file_name = $data['off'][0]->pdf_name;
            $expert_email = $data['off'][0]->email;
            $emails = [
                'umailango235@gmail.com','info@nextlevel-akademie.de',
                $expert_email
            ];
            $file_to_attach = url('company_files/offers/' . $file_name);

            $data = array(
                'email' => 'info@nextlevel-akademie.de',
                'first_name' => 'NextLevel Akademie',
                'from' => 'info@nextlevel-akademie.de',
                'from_name' => 'NextLevel Akadamie',
                'attachment' => $file_to_attach,
                'to' => $emails
            );

            Mail::send('offers.email', $data, function ($message) use ($data) {
                $message->to($data['to'])
                    ->from('info@nextlevel-akademie.de', 'Test')
                    ->subject('Welcome!');
                $message->attach($data['attachment']);
            });

            $request->session()->flash('success', 'Email has been sent successfully.');

            return redirect('admin/manage_offer');
        }
        $qualblk1 = \DB::table('quali_textblocks')->select('*')
            ->where('qual_id', 1)
            ->get();
        $qualblk2 = \DB::table('quali_textblocks')->select('*')
            ->where('qual_id', 2)
            ->get();
        $qualblk3 = \DB::table('quali_textblocks')->select('*')
            ->where('qual_id', 3)
            ->get();

        $data['qual_blk1'] = $qualblk1;
        $data['qual_blk2'] = $qualblk2;
        $data['qual_blk3'] = $qualblk3;
        return view('offers/index', $data);
    }

    public function random_string($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i ++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

      public function get_pmi_treeview2(Request $request)
    {


        $exec_msg = '';
        $products2 = array();
        $i2 = 0;
        $products = DB::SELECT("SELECT * FROM products where category like '%coaching%'");

        foreach ($products as $r1) {
            $products2[$i2]['product'] = $r1;

            $products2[$i2]['total_cost'] = 0;
            $products2[$i2]['total_lessons'] = 0;

            /* Return all the modules with atleast 1 UE in it's MIs */
            $row2 = DB::SELECT("SELECT m.* FROM modules m inner join product_modules pm on pm.m_id = m.id where pm.p_id = '$r1->id'");
            $modules = array();
            $j = 0;
            foreach ($row2 as $r2) {
                $modules[$j]['module'] = $r2;

                $modules[$j]['total_cost'] = 0;
                $modules[$j]['total_lessons'] = 0;

                // $row3 = DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$course_id'");
                $row3 = DB::SELECT(" select mi.id, mi.title, mi.description, mmi.p_id, mmi.m_id, mi.lessons, mi.price_lessons price  from module_items mi inner join modules_module_items mmi on mmi.m_id = mi.id where mmi.p_id= '$r2->id'");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $module_items[$k]['item'] = $r3;

                    $lessons = $r3->lessons;

                    $products2[$i2]['total_lessons'] += $lessons;
                    $products2[$i2]['total_cost'] += $lessons * $r3->price;

                    $modules[$j]['total_lessons'] += $lessons;
                    $modules[$j]['total_cost'] += $lessons * $r3->price;

                    $k ++;
                }
                $modules[$j]['items'] = $module_items;
                $j ++;
            }
            $products2[$i2]['modules'] = $modules;
            $i2 ++;
        }
        $treeview = view('offers.treeview', [
            'products' => $products2
        ])->render();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'treeview' => $treeview
        ]);
    }

}
