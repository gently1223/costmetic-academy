<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use DateTime;
use DB;
use Lang;
use setasign\Fpdi\Fpdi;
use NumberFormatter;
use PDF;
use PDFMerger;

class certificate extends Controller
{

    public function create_certificate(Request $request)
    {
        $c_id = $request->post('c_id_certificate');

        $row2 = DB::select("SELECT * FROM contacts WHERE id='$c_id'");
        $row2 = collect($row2)->first();
        $personal_details = array();
        $dates = explode(' - ', $request->date_from_to);
        $template = $request->post('template');
        $an_der_text = $request->post('an_der');
        $template1 = $request->post('template');
        $qualification = $request->post('qualification');
        $sub_qualification = $request->post('sub_qualification');
        $module_name = $request->post('module_name');
        $module_item = $request->post('module_item');
        $contact_name = $request->post('contact_name');
        $from_date = date_format(new DateTime($dates[0]), 'd.m.Y');
        $to_date = date_format(new DateTime($dates[1]), 'd.m.Y');
        $personal_details['template'] = $template . '.jpg';
        $personal_details['qualification'] = $request->post('qualification');
        $personal_details['sub_qualification'] = $request->post('sub_qualification');
        $personal_details['from_date'] = $from_date;
        $personal_details['to_date'] = $to_date;
        $personal_details['full_name'] = $row2->name;
        $personal_details['module_name'] = $module_name;
        $personal_details['module_title'] = $module_name;
        $personal_details['module_items'] = $request->input('module_item');
        
        if ((!isset($an_der_text)) || $an_der_text == '')
            $an_der_text = 'an die Coaching';
        $personal_details['an_der'] = $an_der_text;

        if ($template ==3 || $template == 8) {
            
                $module_title = $request->input('module_title');
                $moduleItems = $request->input('module_items');
             for ($i = 0; $i < count($module_title); $i ++) {
                $moduleTitle = addslashes($module_title[$i]);
                if ($moduleTitle == '')
                    continue;
                $moduleItem = addslashes($moduleItems[$i]);
                $module_items = $moduleItem;
                $lines = explode("\r\n", $module_items);
                /*if (! empty($lines)) {
                    $list = '<ul>';
                    foreach ($lines as $line) {
                        $list .= '<li style="padding-left:30%;padding-right: 10px;">' . trim($line) . '</li>';
                    }
                    $list .= '</ul>';
                }*/

                $modulItems[] = $lines;

                $moduletitle[] = $moduleTitle;
                $moduleTitles = serialize($moduletitle);
                $modulItms = serialize($modulItems);
                $personal_details['module_items'] = $modulItems;
                //$personal_details['module_items1'] = $list;

                $personal_details['module_title'] = $moduletitle;
            }
        } 
        else {
            $module_items = str_replace("<p>", "", $module_item);
            $module_items = str_replace("</p>", "", $module_item);

            $lines = explode("\r\n", $module_item);

            $personal_details['module_title'] = array($module_name);
            $personal_details['module_items'] = $lines;
            $moduleTitles = serialize(array($module_name));
            $modulItms = serialize($lines);
        }

        if ($template == 1)
            $template = 'certificates1';
        else if ($template == 2)
            $template = 'certificates2';
        else if ($template == 3)
            $template = 'certificates3';
        else if ($template == 4)
            $template = 'certificates4';
        else
            $template = 'certificates1';

        $newpdf = PDF::loadView('certificate_templates.' . $template, [
            'personal_details' => $personal_details
        ]);

        $newpdf->setOptions([
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'debugCss' => true
        ]);
        $certificate = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
        $query = DB::insert("insert into certificates (qualifiation, sub_qualification, module_name, module_title, module_items, from_date, to_date, certificate, template, c_id, created_on) values 
          ('$qualification', '$sub_qualification', '$module_name', '$moduleTitles','$modulItms', '$from_date', '$to_date', '$certificate','$template1', '$c_id', NOW())");
        $newpdf->save('company_files/certificates/' . $certificate);

        return redirect()->back()->with('success', 'Certificate Created successfully');
    }

    public function view_certificates(Request $request)
    {
        $id = $request->session()->get('id');

        if ($request->input('delete') != '') {
            $delete = addslashes($request->input('delete'));
            DB::delete("DELETE FROM certificates WHERE id='$delete'");
            $request->session()->flash('success', 'Certificate deleted successfully.');
            return redirect('admin/certificates');
        }

        $certificates = array();
        $i = 0;
        $row = DB::select("SELECT * FROM certificates ORDER BY id DESC");
        foreach ($row as $r) {
            $row2 = DB::select("SELECT * FROM contacts WHERE id='$r->c_id'");
            if (count($row2) == 0)
                continue;
            $row2 = collect($row2)->first();

            $certificates[$i]['cv'] = $r;
            $certificates[$i]['user'] = $row2;

            $i ++;
        }

        return view('panel.certificates.index', [
            'title' => trans('header.certificates'),
            'certificates' => $certificates
        ]);
    }
}
