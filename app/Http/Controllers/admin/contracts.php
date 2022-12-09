<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use Mail;
use DB;
use setasign\Fpdi\Fpdi;
use NumberFormatter;
use PDF;
use PDFMerger;

class contracts extends Controller
{

    public static function instance()
    {
        return new contracts();
    }

    public function __construct()
    {}

    public function internship_contract(Request $request, $contact, $type, $contract = 0, $coach = 0)
    {
        // ini_set('memory_limit', '-1');
        // require('fpdf17/fpdf.php');
        // require('fpdi/src/autoload.php');
        $contact_name = '';
        $contact_address = '';
        $contact_phone = '';
        $contact_email = '';
        $funding = DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $contact_name = $funding->name;
            $contact_address = $funding->door_no . ', ' . $funding->street_name;
            if ($funding->address != '')
                $contact_address .= ', ' . $funding->address;
            $contact_address .= ', ' . $funding->city . ', ' . $funding->zip_code;
            $contact_phone = $funding->phone_no;
            $contact_email = $funding->email;
        }

        $job_title = $contract->job_title;
        $internship_company_name = $contract->internship_company_name;
        $internship_company_mainaddress = $contract->internship_company_mainaddress;
        $internship_company_worklocation = $contract->internship_company_worklocation;
        $internship_company_telephone = $contract->internship_company_telephone;
        $internship_company_email = $contract->internship_company_email;
        $internship_company_contact = $contract->internship_company_contact;

        $student = '';
        $row = DB::select("SELECT id, name FROM contacts WHERE id='$contract->student' LIMIT 1");
        if (count($row) == 1) {
            $row = collect($row)->first();
            $student = $row->name;
        }

        $phase1_begin = date_format(new DateTime($contract->phase1_begin), 'd.m.Y');
        $phase1_end = date_format(new DateTime($contract->phase1_end), 'd.m.Y');
        $phase2_begin = date_format(new DateTime($contract->phase2_begin), 'd.m.Y');
        $phase2_end = date_format(new DateTime($contract->phase2_end), 'd.m.Y');
        $test1_begin = date_format(new DateTime($contract->test1_begin), 'd.m.Y');
        $test1_end = date_format(new DateTime($contract->test1_end), 'd.m.Y');
        $test2_begin = date_format(new DateTime($contract->test2_begin), 'd.m.Y');
        $test2_end = date_format(new DateTime($contract->test2_end), 'd.m.Y');
        $beginning = date_format(new DateTime($contract->beginning), 'd.m.Y');
        $end = date_format(new DateTime($contract->end), 'd.m.Y');

        $c_date = date('d.m.Y');

        $personal_details = array();
        $contract_details = array();

        $personal_details['full_name'] = $contact->name;
        $contract_details['job_title'] = $job_title;
        $contract_details['internship_company_name'] = $internship_company_name;
        $contract_details['internship_company_mainaddress'] = $internship_company_mainaddress;
        $contract_details['internship_company_worklocation'] = $internship_company_worklocation;
        $contract_details['internship_company_telephone'] = $internship_company_telephone;
        $contract_details['internship_company_email'] = $internship_company_email;
        $contract_details['internship_company_contact'] = $internship_company_contact;
        $contract_details['phase1'] = $phase1_begin . ' - ' . $phase1_end;
        $contract_details['phase2'] = $phase2_begin . ' - ' . $phase2_end;
        $contract_details['test1'] = $test1_begin . ' - ' . $test1_end;
        $contract_details['test2'] = $test2_begin . ' - ' . $test2_end;
        $contract_details['period'] = $beginning . ' - ' . $end;

        if (! isset($contract->id)) {
            $contract_details['signature'] = "";
        } else {
            $contract_details['signature'] = $contract->signature;
        }

        $newpdf = PDF::loadView('contract_templates.cooperation_contract_for_student', [
            'personal_details' => $personal_details,
            'contract_details' => $contract_details
        ]);
        $newpdf->setPaper('A4', 'portrait');
        $newpdf->setOptions([
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'debugCss' => true
        ]);

        if (! isset($contract->id)) {
            $contract = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
            $newpdf->save('company_files/contracts/' . $contract);

            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
            $id = DB::getPdo()->lastInsertId();
        } else {
            $id = $contract->id;
            $contract = $contract->contract;
            $newpdf->save('company_files/contracts/' . $contract);
        }

        return $id;
    }

    function console_log($output, $with_script_tags = true)
    {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

    public function extended_contract(Request $request, $contact, $type, $contract = 0, $coach = 0)
    {
        // console_log("starting extended contract template");
        // ini_set('memory_limit', '-1');
        // require('fpdf17/fpdf.php');
        // require('fpdi/src/autoload.php');
        $courses = '';
        $total_lessons = 0;
        $total_costs = 0;
        $products2 = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT id, p_id, auth_no FROM contract_products WHERE contract_id='$contract->id'");
        $auth_no = '';
        foreach ($row1 as $r1) {
            $auth_no = $r1->auth_no;
            $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
            if (count($row22) == 0)
                continue;
            $row22 = collect($row22)->first();

            $row21 = DB::SELECT("SELECT id, m_id FROM contract_modules WHERE p_id='$r1->p_id' AND contract_id='$contract->id'");
            $modules = array();
            $j = 0;
            foreach ($row21 as $r2) {
                $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();

                $row3 = DB::SELECT("SELECT id, i_id, lessons, price_lesson FROM contract_items WHERE m_id='$r2->m_id' AND contract_id='$contract->id'");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $row4 = collect($row4)->first();

                    $total_lessons += $r3->lessons;
                    $total_costs += $r3->lessons * $r3->price_lesson;

                    $k ++;
                }
                $j ++;
            }
            $i2 ++;
        }

        // console_log("1");

        $total_costs_main = $total_costs;
        $total_costs2 = number_format($total_costs, 2, '.', '');
        $total_costs = explode('.', $total_costs2)[0];
        $decimal = explode('.', $total_costs2)[1];
        $f = new NumberFormatter("de", NumberFormatter::SPELLOUT);
        $total_costs_words_whole = $f->format($total_costs);
        $decimal_words = $f->format($decimal);

        $total_costs_words_whole = substr_replace($total_costs_words_whole, strtoupper(substr($total_costs_words_whole, 0, 1)), 0, 1);
        $decimal_words = substr_replace($decimal_words, strtoupper(substr($decimal_words, 0, 1)), 0, 1);
        $total_costs_words = $total_costs_words_whole . ' Euro und ' . $decimal_words . ' Cent';
        // $total_costs_words = substr_replace($total_costs_words, strtoupper(substr($total_costs_words, 0, 1)), 0, 1);
        $total_costs_words = preg_replace('~\x{00AD}~u', '', $total_costs_words);

        $row2 = DB::select("SELECT title FROM courses WHERE id='$contract->course_id' LIMIT 1");
        $row2 = collect($row2)->first();
        $courses = $row2->title;

        if ($contract->installments == '0' || $contract->installments == '')
            $installments = 1;
        else
            $installments = $contract->installments;
        $installment_price = $total_costs_main / $installments;
        $consultation_date = date_format(new DateTime($contract->consultation_date), 'd.m.Y');

        $installments_line = '';
        if ($installments > 1)
            $installments_line = 'Die Gebühren teilen sich in ' . $installments . ' monatliche Teilzahlungen in Höhe von ' . $installment_price . ' € pro Monat.';

        $funding_source = '';
        $funding_address = '';
        $funding = DB::select("SELECT * FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $funding_source = $funding->name;
            $funding_address = $funding->address;
        }

        $contact_name = '';
        $contact_address = '';
        $contact_phone = '';
        $contact_email = '';
        $funding = DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $contact_name = $funding->name;
            $contact_address = $funding->street_name . ' ' . $funding->door_no;
            $contact_address .= ', ' . $funding->zip_code . ' ' . $funding->city;

            if ($funding->address != '')
                $contact_address = $funding->address;

            $contact_phone = $funding->phone_no;
            $contact_email = $funding->email;
        }

        if ($contract->beginning != '0000-00-00') {
            $begin = date_format(new DateTime($contract->beginning), 'd.m.Y');
            $end = date_format(new DateTime($contract->end), 'd.m.Y');
        } else {
            $begin = date_format(new DateTime($contact->beginning), 'd.m.Y');
            $end = date_format(new DateTime($contact->end), 'd.m.Y');
        }
        $c_date = date('d.m.Y');

        /*
         * Create the $data object with all the details required
         * $pdf = PDF::loadView('cv_templates.'.$template, ['title'=> '', 'attachment_name'=>$attachment_name, 'experience'=>$experience, 'education'=>$education, 'personal_details'=>$personal_details, 'languages'=>$languages, 'skills'=>$skills, 'hobby'=>$hobby]);
         * $pdf->setOptions(['dpi' => 96, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'debugCss' => true]);
         * $pdf_name=rand(pow(10, 4-1), pow(10, 4)-1).'.pdf';
         * $pdf->save('company_files/cvs/'.$pdf_name);
         *
         * if($row->attachment!='')
         * {
         * $pdf = new PDFMerger();
         * $pdf->addPDF('company_files/cvs/'.$pdf_name, 'all');
         * $pdf->addPDF('company_files/attachments/'.$row->attachment, 'all');
         *
         * $pathForTheMergedPdf = 'company_files/cvs/'.$pdf_name;
         * $pdf->merge('file', $pathForTheMergedPdf);
         * }
         *
         */

        // console_log("2");

        $personal_details = array();
        $contract_details = array();
        $contract_details['total_cost'] = $total_costs_words;
        $personal_details['full_name'] = $contact->name;

        if ($contact->address != '')
            $address = $contact->address;
        else {
            $address = $contact->street_name . ' ' . $contact->door_no;
            $address .= ', ' . $contact->zip_code . '  ' . $contact->city;
        }

        if ($contact->parent_address != '')
            $parent_address = $contact->parent_address;
        else {
            $parent_address = $contact->parent_street_name . ' ' . $contact->parent_door_no;
            $parent_address .= ', ' . $contact->parent_zip_code . ' ' . $contact->parent_city;
        }

        $personal_details['dob'] = $contact->dob;
        $personal_details['address'] = $address;
        $personal_details['phone'] = $contact->phone_no;
        $personal_details['email'] = $contact->email;

        $personal_details['parent_name'] = $contact->name;
        $personal_details['parent_address'] = $parent_address;
        
        $personal_details['funding_source'] = $funding_source;
        $personal_details['funding_source_address'] = $funding_address;
        $personal_details['funding_source_name'] = $contact_name;
        $personal_details['funding_source_phone'] = $contact_phone;
        $personal_details['funding_source_email'] = $contact_email;

        $professional_qualifications = array();
        if ($contract->professional_qualifications != '')
            $professional_qualifications = explode(';', $contract->professional_qualifications);
        $elective_qualifications = array();
        if ($contract->elective_qualifications != '')
            $elective_qualifications = explode(';', $contract->elective_qualifications);

        $qualifications = '';
        foreach ($professional_qualifications as $qual) {
            $qualifications .= $qual . ', ';
        }
        $qualifications = substr($qualifications, 0, strlen($qualifications) - 2);

        $e_qualifications = '';
        foreach ($elective_qualifications as $qual) {
            $e_qualifications .= '<tr><td> - </td><td>' . $qual . '</td></tr>';
        }

        $contract_details['lehrgang'] = $contract->lehrgang;
        $contract_details['auth_no'] = $auth_no;
        $contract_details['total_amount_words'] = $total_costs_words;
        $contract_details['begin'] = $begin;
        $contract_details['end'] = $end;
        $contract_details['customer_no'] = $contact->customer_no;
        $contract_details['elective_qualification'] = $e_qualifications;
        if (! isset($contract->id)) {
            $contract_details['signature'] = "";
        } else {
            $contract_details['signature'] = $contract->signature;
        }

        // console_log("3");

        $newpdf = PDF::loadView('contract_templates.education_contract_for_student', [
            'personal_details' => $personal_details,
            'contract_details' => $contract_details
        ]);
        $newpdf->setPaper('A4', 'portrait');
        $newpdf->setOptions([
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'debugCss' => true
        ]);

        // console_log("4");

        if (! isset($contract->id)) {
            $contract = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
            $newpdf->save('company_files/contracts/' . $contract);
            // console_log("5.1");
            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
            $id = DB::getPdo()->lastInsertId();
        } else {
            $id = $contract->id;
            $contract = $contract->contract;
            $newpdf->save('company_files/contracts/' . $contract);
            // console_log("5.2");
        }
        // console_log("6");

        /*
         * //Add AGB & Hausordnung
         * $pdfMerge = new PDFMerger();
         * $pdfMerge->addPDF('company_files/contracts/'.$contract, 'all');
         * //$pdfMerge->addPDF('assets/contract_attachments/hausordnung.pdf', 'all');
         * //$pdfMerge->addPDF('assets/contract_attachments/agb.pdf', 'all');
         * $pathForTheMergedPdf = 'company_files/contracts/'.$contract;
         * $pdfMerge->merge('file', $pathForTheMergedPdf);
         */
        return $id;
    }

    public function amendments_contract(Request $request, $contact, $type, $contract = 0, $coach = 0)
    {
        // ini_set('memory_limit', '-1');
        // require('fpdf17/fpdf.php');
        // require('fpdi/src/autoload.php');
        $courses = '';
        $total_lessons = 0;
        $total_costs = 0;
        $products2 = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT id, p_id FROM contract_products WHERE contract_id='$contract->id'");
        foreach ($row1 as $r1) {
            $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
            if (count($row22) == 0)
                continue;
            $row22 = collect($row22)->first();

            $row21 = DB::SELECT("SELECT id, m_id FROM contract_modules WHERE p_id='$r1->p_id' AND contract_id='$contract->id'");
            $modules = array();
            $j = 0;
            foreach ($row21 as $r2) {
                $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();

                $row3 = DB::SELECT("SELECT id, i_id, lessons, price_lesson FROM contract_items WHERE m_id='$r2->m_id' AND contract_id='$contract->id'");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $row4 = collect($row4)->first();

                    $total_lessons += $r3->lessons;
                    $total_costs += $r3->lessons * $r3->price_lesson;

                    $k ++;
                }
                $j ++;
            }
            $i2 ++;
        }

        $total_costs_main = $total_costs;
        $total_costs2 = number_format($total_costs, 2, '.', '');
        $total_costs = explode('.', $total_costs2)[0];
        $decimal = explode('.', $total_costs2)[1];
        $f = new NumberFormatter("de", NumberFormatter::SPELLOUT);
        $total_costs_words_whole = $f->format($total_costs);
        $decimal_words = $f->format($decimal);

        $total_costs_words_whole = substr_replace($total_costs_words_whole, strtoupper(substr($total_costs_words_whole, 0, 1)), 0, 1);
        $decimal_words = substr_replace($decimal_words, strtoupper(substr($decimal_words, 0, 1)), 0, 1);
        $total_costs_words = $total_costs_words_whole . ' Euro und ' . $decimal_words . ' Cent';
        // $total_costs_words = substr_replace($total_costs_words, strtoupper(substr($total_costs_words, 0, 1)), 0, 1);
        $total_costs_words = preg_replace('~\x{00AD}~u', '', $total_costs_words);

        $row2 = DB::select("SELECT title FROM courses WHERE id='$contract->course_id' LIMIT 1");
        if (count($row2) == 1) {
            $row2 = collect($row2)->first();
            $courses = $row2->title;
        }

        if ($contract->installments == '0')
            $installments = 1;
        else
            $installments = $contract->installments;
        $installment_price = $total_costs_main / $installments;
        $consultation_date = date_format(new DateTime($contract->consultation_date), 'd.m.Y');

        $installments_line = '';
        if ($installments > 1)
            $installments_line = 'Die Gebühren teilen sich in ' . $installments . ' monatliche Teilzahlungen in Höhe von ' . $installment_price . ' € pro Monat.';

        $funding_source = '';
        $funding_address = '';
        $funding = DB::select("SELECT * FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $funding_source = $funding->name;
            $funding_address = $funding->address;
        }

        $contact_name = '';
        $contact_address = '';
        $contact_phone = '';
        $contact_email = '';
        $funding = DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $contact_name = $funding->name;
            $contact_address = $funding->door_no . ', ' . $funding->street_name;
            if ($funding->address != '')
                $contact_address .= ', ' . $funding->address;
            $contact_address .= ', ' . $funding->city . ', ' . $funding->zip_code;
            $contact_phone = $funding->phone_no;
            $contact_email = $funding->email;
        }

        if ($contract->beginning != '0000-00-00') {
            $begin = date_format(new DateTime($contract->beginning), 'd.m.Y');
            $end = date_format(new DateTime($contract->end), 'd.m.Y');
        } else {
            $begin = date_format(new DateTime($contact->beginning), 'd.m.Y');
            $end = date_format(new DateTime($contact->end), 'd.m.Y');
        }
        $c_date = date('d.m.Y');

        // $pdf = new \setasign\Fpdi\Fpdi();
        $pdf = new \Fpdf('P', 'mm', 'A4'); // 8.5" x 11" laser form
        $pdf->AddFont('GOTHIC', 'I', 'GOTHICI.php');
        $pdf->AddFont('GOTHIC', '', 'GOTHIC.php');
        $pdf->AddFont('GOTHIC', 'BI', 'GOTHICBI.php');
        $pdf->AddFont('GOTHIC', 'B', 'GOTHICB.php');
        $pdf->setTitle('Contract');
        $pdf->SetDrawColor(172, 172, 172);
        $pdf->SetTextColor(0, 0, 0);
        // $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetMargins(16.35, 16.35, 16.35);

        if ($request->input('s') == '0')
            $status = 0;
        else
            $status = 1;

        $r_id = 1;
        $page_height = 0;
        $one_section = 0;
        $i = 0;
        $current_page = $pdf->PageNo();
        $starting_page_no = $pdf->PageNo();
        $end_page_no = $current_page;
        $end_page_height = 0;

        $pdf->AddPage();
        $pdf->setLeftMargin(8);
        $pdf->setTopMargin(30);
        $pdf->ln(15);

        $pdf->SetDrawColor(172, 172, 172);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('GOTHIC', 'B', 15);
        $pdf->Cell(190, 14, iconv('UTF-8', 'windows-1252', 'Zusatzvereinbarung zum Umschulungsvertrag'), 0, 0, 'C');
        $pdf->ln(9);

        $pdf->SetFont('GOTHIC', '', 10.8);
        $pdf->Cell(190, 14, iconv('UTF-8', 'windows-1252', 'Zwischen'), 0, 0, 'L');
        $pdf->ln(14);

        $pdf->MultiCell(190, 4, iconv('UTF-8', 'windows-1252', 'Nextlevel Akademie
Bundesallee 86
12161 Berlin
vertreten durch: Frau Gülhan Dündar (Geschäftsführung)
(nachstehend NLA genannt)'), 0, 'LR');

        $pdf->ln(1);
        $pdf->Cell(190, 14, iconv('UTF-8', 'windows-1252', 'und'), 0, 0, 'L');

        $pdf->ln(14);
        $address = $contact->door_no . ', ' . $contact->street_name;
        if ($contact->address != '')
            $address .= ', ' . $contact->address;
        $address .= ', ' . $contact->city . ', ' . $contact->zip_code;
        $dob = '';

        $parent_address = '';
        if ($contact->parent_door_no != '')
            $parent_address = $contact->parent_door_no . ', ' . $contact->parent_street_name;
        if ($contact->parent_address != '')
            $parent_address .= ', ' . $contact->parent_address;
        if ($contact->parent_city != '')
            $parent_address .= ', ' . $contact->parent_city . ', ' . $contact->parent_zip_code;
        $parent_dob = '';
        if ($parent_dob != '01-01-1900')
            $dob = $contact->parent_dob;

        $pdf->MultiCell(190, 4, iconv('UTF-8', 'windows-1252', 'Name, Vorname:            ' . $contact->name . '
Geburtsdatum(-ort):       ' . $dob . '
Anschrift/PLZ/Ort:            ' . $address . '
Telefon/Handy:               ' . $contact->phone_no . '
E-Mail       :                       ' . $contact->email . '
Gesetzlicher Vertreter:

Fördergeldgeber:            ' . $funding_source . '
Ansprechpartner:            ' . $contact_name . '
Anschrift/PLZ/Ort:            ' . $contact_address . '
Telefon/Durchwahl:        ' . $contact_phone . '
E-Mail       :                        ' . $contact_email . '
'), 0, 'LR');

        $t_date = new DateTime('today');
        $driver_age = date_diff(date_create($dob), $t_date)->y;

        $pdf->ln(4);
        $pdf->MultiCell(190, 4, $pdf->writeHTML(iconv('UTF-8', 'windows-1252', 'wird nachfolgende Zusatzvereinbarung ergänzend zum Umschulungsvertrag vom _________ vereinbart.')), 0, 'LR');

        $professional_qualifications = array();
        if ($contract->professional_qualifications != '')
            $professional_qualifications = explode(';', $contract->professional_qualifications);
        $elective_qualifications = array();
        if ($contract->elective_qualifications != '')
            $elective_qualifications = explode(';', $contract->elective_qualifications);

        $qualifications = '';
        foreach ($professional_qualifications as $qual) {
            $qualifications .= '• ' . $qual . '<br> ';
        }

        $e_qualifications = '';
        foreach ($elective_qualifications as $qual) {
            $e_qualifications .= '• ' . $qual . '<br> ';
        }

        $pdf->ln(4);
        $pdf->MultiCell(190, 4, $pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1. Fehlzeiten des Teilnehmers (m/w)<br><br></b>1.1 Soweit Fehlzeiten des Teilnehmers (m/w) dessen Zulassung zur Abschlussprüfung und damit den erfolgreichen Abschluss der Ausbildung gefährden, weist die NLA den Teilnehmer (m/w) darauf hin. Einen Anspruch des Teilnehmers (m/w) gegen die NLA auf die Hinweiserteilung besteht nicht. Die NLA orientiert sich bei der Hinweiserteilung an den jeweils aktuellen Richtlinien der Industrie- und Handelskammer Berlin zur Prüfungszulassung.<br><br>1.2 Im Falle von unentschuldigten Fehlzeiten oder soweit für die Fehlzeiten Gründe angegeben werden, die ein Fernbleiben von der Ausbildung nicht entschuldigen oder rechtfertigen, behält sich die NLA zudem vor, den Teilnehmer (m/w) abzumahnen.<br><br>1.3 Die Vertragsparteien stellen insoweit klar, dass die Zulassung zur IHK-Prüfung im Anschluss an die außerbetriebliche Umschulungsmaßnahme auf der Grundlage des § 45 Absatz 2 Satz 3 Berufsbildungsgesetz (Externen-Prüfungen) erfolgt. Danach ist allein die Teilnahme an einer Umschulungsmaßnahme mit ihrer stark verkürzten Ausbildungszeit, für die Prüfungszulassung nicht ausreichend. Hinzukommen muss entweder die Erstausbildung in einem anderen Beruf oder Berufstätigkeit. Die Zeiten der Berufstätigkeit und der Umschulung zusammengenommen sollen die Regelausbildungszeit des betreffenden Berufes nicht unterschreiten. Bei der außerbetrieblichen Umschulung handelt es sich um einen Bildungsgang, der insbesondere durch eine starke Verkürzung der Ausbildungszeit gegenüber der Regelausbildungszeit des jeweiligen Ausbildungsberufes gekennzeichnet ist. Die Zulassung zur Prüfung setzt deshalb voraus, dass sowohl die theoretischen als auch die praktischen Ausbildungsinhalte entsprechend dem Umschulungsplan tatsächlich vermittelt werden konnten. Insofern wird die Zulassungsentscheidung auch in ganz wesentlichem Maße durch die Fehlzeit des Teilnehmers (m/w) beeinflusst. Die Zulassung kann also nur dann erfolgen, wenn der Teilnehmer (m/w) den Umschulungslehrgang ohne wesentliche Fehlzeiten durchlaufen hat. Mit der Prüfungsanmeldung muss eine Übersicht der individuellen Fehlzeiten des Teilnehmers (m/w) eingereicht werden.<br><br>1.4 Die Vertragsparteien stellen weiterhin klar, dass die Industrie- und Handelskammer Berlin gegenwärtig davon ausgeht, dass Fehlzeiten bis zu 10% der Gesamtdauer der Maßnahme für die Prüfungszulassung unschädlich sind. Wird vom Teilnehmer (m/w) diese Grenze überschritten, so muss vom Teilnehmer (m/w) dargelegt werden, dass trotzdem das Umschulungsziel erreicht worden ist. Dabei sind nach der Industrie- und Handelskammer Berlin gegenwärtig folgende Fälle zu unterscheiden:<br><br>1.4.1 Bei Fehlzeiten von mehr als 10 %, aber weniger als 20 % der Gesamtmaßnahme muss vom Teilnehmer (m/w) dargelegt werden, dass aufgrund des individuellen Leistungs-und Ausbildungsstandes trotz der erheblichen zeitlichen Lücken das Gesamtziel der Maßnahme noch erreicht worden ist. Eine entsprechende Bescheinigung ist mit der Annahme zur Prüfung vorzulegen. Die Industrie- und Handelskammer Berlin behält sich insofern vor zusätzliche Unterlagen anzufordern.<br><br>1.4.2Übersteigt der Umfang der Fehlzeiten 20 % der Gesamtmaßnahme ist zunächst vom Grundsatz her immer zu vermuten, dass das Umschulungsziel nicht erreicht werden konnte. Sollte der Teilnehmer (m/w) dennoch die Auffassung vertreten werden, dass die Zulassung zur Prüfung gerechtfertigt ist, so muss vom Teilnehmer (m/w) detailliert nachgewiesen werden, welche Unterrichts- bzw. Praxisgebiete durch die Fehlzeiten betroffen waren und wie jeweils die so entstandenen Lücken ausgeglichen worden sind. Entsprechende Nachweise müssen vom Teilnehmer (m/w) mit der Anmeldung zur Abschlussprüfung bei der IHK vorgelegt werden.<br><br><b>2. Zusatzqualifizierung</b><br><br>2.1. Zusätzlich zu den durch die Ausbildungs- und Prüfungsordnung vorgeschriebenen Lehrinhalten bietet NLA dem Teilnehmer (m/w) im Rahmen der fachtheoretischen Ausbildungsphase zusätzliche Qualifizierungen u.a. in den Bereichen: Mode, Schnitte, Design, , Verkaufstraining, Einzelcoaching, Kassenschein, Bewerbungstraining an.<br><br>2.2. Die diesbezüglichen Schulungsphasen finden zusätzlich zum bzw. getrennt vom regulären nach der Ausbildungsordnung vorgeschriebenen fachtheoretischen Unterricht statt. Hat der Teilnehmer (m/w) eine der benannten zusätzlichen Qualifizierungen durchlaufen, erhält er als Nachweis ein entsprechendes Zertifikat von der NLA.<br><br>2.3 Die zusätzlichen Qualifizierungen sind für den Teilnehmer (m/w) kostenlos und fakultativ. Nach der Entscheidung des Teilnehmers (m/w) für einen oder mehrere fakultative Zusatzqualifizierungen sind die diesbezüglichen Schulungsphasen für den Teilnehmer (m/w) verpflichtender Unterricht.<br><br>2.4 Im Falle, dass die Ausbildung und/oder der Unterhalt des Teilnehmers (m/w) über einen Sozialleistungsträger/Fördergeldgeber finanziert werden, sind Verpflichtungen des Teilnehmers (m/w) gegenüber diesem vorrangig. Dies betrifft insbesondere die Verfügbarkeit des Teilnehmers (m/w) im Rahmen der Arbeitsvermittlung sowie dessen Mitwirkungspflichten gegenüber dem und die Wahrnehmung von Terminen beim Sozialleistungsträger/Fördergeldgeber. Soweit der Teilnehmer (m/w) Schulungszeiten im Rahmen der Zusatzqualifizierung aufgrund solcher vorrangiger Verpflichtungen versäumt, wird diesem die Gelegenheit gegeben, die versäumten Unterrichtszeiten nachzuholen.<br><br>2.5 Die Kosten und Aufwendungen für die Zusatzqualifizierungen werden von der NLA vorfinanziert. Die Vertragsparteien stellen insoweit klar, dass die Kosten und Aufwendungen für die Zusatzqualifizierungen nicht vom Fördergeldgeber finanziert werden. Das Kooperationsunternehmen, in welchem der Teilnehmer (m/w) seine fachpraktische Ausbildungsphase durchläuft, leistet bei entsprechender Vereinbarung im Kooperationsvertrag der NLA eine Aufwandsbeteiligung. Diese dient dem teilweisen Ausgleich für die Kosten und Aufwendungen der NLA zur Durchführung der zusätzlichen Qualifizierung. Dies betrifft insbesondere den Einsatz von Personal, Schulungsmaterialien, Räumlichkeiten sowie sonstige erforderliche Aufwendungen. Die Vertragsparteien stellen insofern klar, dass diese Aufwandsbeteiligung des Kooperationsunternehmens keine Vergütung des Teilnehmers (m/w) für etwaige Leistungen im Rahmen der fachpraktischen Ausbildungsphase im Kooperationsunternehmen oder sonstiges Einkommen der Teilnehmers (m/w) darstellt. Die Aufwandsbeteiligung findet ihre Rechtsgrundlage allein und ausschließlich in dem Vertragsverhältnis zwischen NLA und dem Kooperationsunternehmen und hat keinerlei Auswirkungen zu Gunsten oder zu Lasten des Teilnehmers (m/w).<br><br><b>3. fachpraktische Ausbildungsphase</b><br><br>3.1. Die Vertragsparteien stellen klar, dass die fachpraktische Ausbildungsphase im Kooperationsunternehmen ein echtes Praktikum ist, welches nach der Ausbildungsordnung einen zwingend vorgeschriebenen begleitenden Praxisteil darstellt und Voraussetzung für die Zulassung der Teilnehmer (m/w) zur IHK-Abschlussprüfung ist.<br><br>3.2. Für den Teilnehmer (m/w) besteht grundsätzlich kein arbeitsrechtlicher oder ausbildungsrechtlicher Vergütungsanspruch gegen das Kooperationsunternehmen. Eine individuelle Vergütungsvereinbarung kann zwischen dem Kooperationsunternehmen und dem Teilnehmer (m/w) vereinbart werden, soweit eine solche individuelle Regelung dem Umschulungsvertrag, der vorliegenden Zusatzvereinbarung und dem Kooperationsvertrag (NLA/Kooperationsunternehmen) nicht zuwiderläuft.<br><br><b>4. Umschulungsvertrag</b><br><br>Die im Umschulungsvertrag getroffenen Vereinbarungen zwischen dem Teilnehmer (m/w) und der NLA bestehen unverändert fort. Die vorliegende Zusatzvereinbarung ergänzt den Umschulungsvertrag.')), 0, 'LR');

        $pdf->addPage();

        $date = date('d.m.Y');
        $pdf->MultiCell(190, 4, iconv('UTF-8', 'windows-1252', '
Berlin, den ' . $date . '
'), 0, 'LR');

        $pdf->ln(10);
        $y = $pdf->GetY();
        $image = '';
        if (isset($contract->id) and $contract->signature != '')
            $image = $pdf->Image('signatures/' . $contract->signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90, 4, iconv('UTF-8', 'windows-1252', $image . '








_______________________
(schulische/r Auszubildende/r)
'), 0, 'LR');

        $pdf->setXY('100', $y);
        $image = '';
        if (isset($contract->id) and $contract->coach_signature != '')
            $image = $pdf->Image('signatures/' . $contract->coach_signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90, 4, iconv('UTF-8', 'windows-1252', $image . '








_______________________
(ggf. gesetzlicher Vertreter)
'), 0, 'LR');

        $pdf->ln(10);
        $image = '';
        $pdf->MultiCell(90, 4, iconv('UTF-8', 'windows-1252', $image . '








_______________________
(Nextlevel Akademie)
'), 0, 'LR');

        // $pdf->Output(); exit();

        if (! isset($contract->id)) {
            $contract = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
            $pdf->Output('company_files/contracts/' . $contract, 'F');

            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
            $id = DB::getPdo()->lastInsertId();
        } else {
            $id = $contract->id;
            $contract = $contract->contract;
            $pdf->Output('company_files/contracts/' . $contract, 'F');
        }
        return $id;

        exit();
    }

    public function retraining_contract(Request $request, $contact, $type, $contract = 0, $coach = 0)
    {
        // ini_set('memory_limit', '-1');
        // require('fpdf17/fpdf.php');
        // require('fpdi/src/autoload.php');
        $courses = '';
        $total_lessons = 0;
        $total_costs = 0;
        $products2 = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT id, p_id, auth_no FROM contract_products WHERE contract_id='$contract->id'");
        $auth_no = '';
        foreach ($row1 as $r1) {
            $auth_no = $r1->auth_no;
            $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
            if (count($row22) == 0)
                continue;
            $row22 = collect($row22)->first();

            $row21 = DB::SELECT("SELECT id, m_id FROM contract_modules WHERE p_id='$r1->p_id' AND contract_id='$contract->id'");
            $modules = array();
            $j = 0;
            foreach ($row21 as $r2) {
                $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();

                $row3 = DB::SELECT("SELECT id, i_id, lessons, price_lesson FROM contract_items WHERE m_id='$r2->m_id' AND contract_id='$contract->id'");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $row4 = collect($row4)->first();

                    $total_lessons += $r3->lessons;
                    $total_costs += $r3->lessons * $r3->price_lesson;

                    $k ++;
                }
                $j ++;
            }
            $i2 ++;
        }

        $total_costs_main = $total_costs;

        // $total_costs2=number_format($total_costs, 2);
        $total_costs2 = number_format($total_costs, 2, '.', '');
        $total_costs = explode('.', $total_costs2)[0];
        $decimal = explode('.', $total_costs2)[1];
        $f = new NumberFormatter("de", NumberFormatter::SPELLOUT);
        $total_costs_words_whole = $f->format($total_costs);
        $decimal_words = $f->format($decimal);

        $total_costs_words_whole = substr_replace($total_costs_words_whole, strtoupper(substr($total_costs_words_whole, 0, 1)), 0, 1);
        $decimal_words = substr_replace($decimal_words, strtoupper(substr($decimal_words, 0, 1)), 0, 1);
        $total_costs_words = $total_costs_words_whole . ' Euro und ' . $decimal_words . ' Cent';
        // $total_costs_words = substr_replace($total_costs_words, strtoupper(substr($total_costs_words, 0, 1)), 0, 1);
        $total_costs_words = preg_replace('~\x{00AD}~u', '', $total_costs_words);

        $row2 = DB::select("SELECT title FROM courses WHERE id='$contract->course_id' LIMIT 1");
        if (count($row2) == 1) {
            $row2 = collect($row2)->first();
            $courses = $row2->title;
        }

        if ($contract->installments == '0')
            $installments = 1;
        else
            $installments = $contract->installments;
        $installment_price = $total_costs_main / $installments;
        $consultation_date = date_format(new DateTime($contract->consultation_date), 'd.m.Y');

        $installments_line = '';
        if ($installments > 1)
            $installments_line = 'Die Gebühren teilen sich in ' . $installments . ' monatliche Teilzahlungen in Höhe von ' . $installment_price . ' € pro Monat.';

        $funding_source = '';
        $funding_address = '';
        $funding = DB::select("SELECT * FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $funding_source = $funding->name;
            $funding_address = $funding->address;
        }

        $contact_name = '';
        $contact_address = '';
        $contact_phone = '';
        $contact_email = '';
        $funding = DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $contact_name = $funding->name;
            $contact_address = $funding->street_name . ' ' . $funding->door_no . ', ';
            $contact_address .= $funding->zip_code . ' ' . $funding->city;

            if ($funding->address != '')
                $contact_address = $funding->address;

            $contact_phone = $funding->phone_no;
            $contact_email = $funding->email;
        }

        if ($contract->beginning != '0000-00-00') {
            $begin = date_format(new DateTime($contract->beginning), 'd.m.Y');
            $end = date_format(new DateTime($contract->end), 'd.m.Y');
        } else {
            $begin = date_format(new DateTime($contact->beginning), 'd.m.Y');
            $end = date_format(new DateTime($contact->end), 'd.m.Y');
        }
        $c_date = date('d.m.Y');

        $personal_details = array();
        $contract_details = array();
        $contract_details['total_cost'] = $total_costs_words;
        $personal_details['full_name'] = $contact->name;

        if ($contact->address != '')
            $address = $contact->address;
        else {
            $address = $contact->street_name . ' ' . $contact->door_no;
            $address .= ', ' . $contact->zip_code . '  ' . $contact->city;
        }

        if ($contact->parent_address != '')
            $parent_address = $contact->parent_address;
        else {
            $parent_address = $contact->parent_street_name . ' ' . $contact->parent_door_no;
            $parent_address .= ', ' . $contact->parent_zip_code . ' ' . $contact->parent_city;
        }

        $professional_qualifications = array();
        if ($contract->professional_qualifications != '')
            $professional_qualifications = explode(';', $contract->professional_qualifications);
        $elective_qualifications = array();
        if ($contract->elective_qualifications != '')
            $elective_qualifications = explode(';', $contract->elective_qualifications);

        $qualifications = '';
        foreach ($professional_qualifications as $qual) {
            $qualifications .= $qual . ', ';
        }
        $qualifications = substr($qualifications, 0, strlen($qualifications) - 2);

        $e_qualifications = '';
        foreach ($elective_qualifications as $qual) {
            $e_qualifications .= '<tr><td> - </td><td>' . $qual . '</td></tr>';
        }

        $personal_details['dob'] = $contact->dob;
        $personal_details['address'] = $address;
        $personal_details['phone'] = $contact->phone_no;
        $personal_details['email'] = $contact->email;

        $personal_details['parent_name'] = $contact->name;
        $personal_details['parent_address'] = $parent_address;
        $personal_details['funding_source'] = $funding_source;
        $personal_details['funding_source_address'] = $funding_address;
        $personal_details['funding_source_name'] = $contact_name;
        $personal_details['funding_source_phone'] = $contact_phone;
        $personal_details['funding_source_email'] = $contact_email;

        $contract_details['lehrgang'] = $qualifications;
        $contract_details['auth_no'] = $auth_no;
        $contract_details['total_amount_words'] = $total_costs_words;
        $contract_details['begin'] = $begin;
        $contract_details['end'] = $end;
        $contract_details['customer_no'] = $contact->customer_no;
        $contract_details['elective_qualification'] = $e_qualifications;
        if (! isset($contract->id)) {
            $contract_details['signature'] = "";
        } else {
            $contract_details['signature'] = $contract->signature;
        }

        $newpdf = PDF::loadView('contract_templates.retraining_contract_for_student', [
            'personal_details' => $personal_details,
            'contract_details' => $contract_details
        ]);
        $newpdf->setPaper('A4', 'portrait');
        $newpdf->setOptions([
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'debugCss' => true
        ]);

         if (! isset($contract->id)) {
             $contract = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
             $newpdf->save('company_files/contracts/' . $contract);
             // console_log("5.1");
             DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
             $id = DB::getPdo()->lastInsertId();
         } else {
             $id = $contract->id;
             $contract = $contract->contract;
             $newpdf->save('company_files/contracts/' . $contract);
             // console_log("5.2");
         }

        /*
         * //Add AGB & Hausordnung
         * $pdfMerge = new PDFMerger();
         * $pdfMerge->addPDF('company_files/contracts/'.$contract, 'all');
         * //$pdfMerge->addPDF('assets/contract_attachments/hausordnung.pdf', 'all');
         * //$pdfMerge->addPDF('assets/contract_attachments/agb.pdf', 'all');
         * $pathForTheMergedPdf = 'company_files/contracts/'.$contract;
         * $pdfMerge->merge('file', $pathForTheMergedPdf);
         */

        return $id;

        exit();
    }

    public function private_jobsearch_contract(Request $request, $contact, $type, $contract = 0, $coach = 0)
    {
        // ini_set('memory_limit', '-1');
        // require('fpdf17/fpdf.php');
        // require('fpdi/src/autoload.php');
        $courses = '';
        $total_lessons = 0;
        $total_costs = 0;
        $products2 = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT id, p_id FROM contract_products WHERE contract_id='$contract->id'");
        foreach ($row1 as $r1) {
            $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
            if (count($row22) == 0)
                continue;
            $row22 = collect($row22)->first();

            $row21 = DB::SELECT("SELECT id, m_id FROM contract_modules WHERE p_id='$r1->p_id' AND contract_id='$contract->id'");
            $modules = array();
            $j = 0;
            foreach ($row21 as $r2) {
                $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();

                $row3 = DB::SELECT("SELECT id, i_id, lessons, price_lesson FROM contract_items WHERE m_id='$r2->m_id' AND contract_id='$contract->id'");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $row4 = collect($row4)->first();

                    $total_lessons += $r3->lessons;
                    $total_costs += $r3->lessons * $r3->price_lesson;

                    $k ++;
                }
                $j ++;
            }
            $i2 ++;
        }

        $total_costs_main = $total_costs;
        $total_costs2 = number_format($total_costs, 2, '.', '');
        $total_costs = explode('.', $total_costs2)[0];
        $decimal = explode('.', $total_costs2)[1];
        $f = new NumberFormatter("de", NumberFormatter::SPELLOUT);
        $total_costs_words_whole = $f->format($total_costs);
        $decimal_words = $f->format($decimal);

        $total_costs_words_whole = substr_replace($total_costs_words_whole, strtoupper(substr($total_costs_words_whole, 0, 1)), 0, 1);
        $decimal_words = substr_replace($decimal_words, strtoupper(substr($decimal_words, 0, 1)), 0, 1);
        $total_costs_words = $total_costs_words_whole . ' Euro und ' . $decimal_words . ' Cent';
        // $total_costs_words = substr_replace($total_costs_words, strtoupper(substr($total_costs_words, 0, 1)), 0, 1);
        $total_costs_words = preg_replace('~\x{00AD}~u', '', $total_costs_words);

        $row2 = DB::select("SELECT title FROM courses WHERE id='$contract->course_id' LIMIT 1");
        if (count($row2) == 1) {
            $row2 = collect($row2)->first();
            $courses = $row2->title;
        }

        if ($contract->installments == '0')
            $installments = 1;
        else
            $installments = $contract->installments;
        $installment_price = $total_costs_main / $installments;
        $consultation_date = date_format(new DateTime($contract->consultation_date), 'd.m.Y');

        $installments_line = '';
        if ($installments > 1)
            $installments_line = 'Die Gebühren teilen sich in ' . $installments . ' monatliche Teilzahlungen in Höhe von ' . $installment_price . ' € pro Monat.';

        $funding_source = '';
        $funding_address = '';
        $funding = DB::select("SELECT * FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $funding_source = $funding->name;
            $funding_address = $funding->address;
        }

        $contact_name = '';
        $contact_address = '';
        $contact_phone = '';
        $contact_email = '';
        $funding = DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $contact_name = $funding->name;
            $contact_address = $funding->door_no . ', ' . $funding->street_name;
            if ($funding->address != '')
                $contact_address .= ', ' . $funding->address;
            $contact_address .= ', ' . $funding->city . ', ' . $funding->zip_code;
            $contact_phone = $funding->phone_no;
            $contact_email = $funding->email;
        }

        if ($contract->beginning != '0000-00-00') {
            $begin = date_format(new DateTime($contract->beginning), 'd.m.Y');
            $end = date_format(new DateTime($contract->end), 'd.m.Y');
        } else {
            $begin = date_format(new DateTime($contact->beginning), 'd.m.Y');
            $end = date_format(new DateTime($contact->end), 'd.m.Y');
        }
        $c_date = date('d.m.Y');

        // $pdf = new \setasign\Fpdi\Fpdi();
        $pdf = new \Fpdf('P', 'mm', 'A4'); // 8.5" x 11" laser form
        $pdf->AddFont('GOTHIC', 'I', 'GOTHICI.php');
        $pdf->AddFont('GOTHIC', '', 'GOTHIC.php');
        $pdf->AddFont('GOTHIC', 'BI', 'GOTHICBI.php');
        $pdf->AddFont('GOTHIC', 'B', 'GOTHICB.php');
        $pdf->setTitle('Contract');
        $pdf->SetDrawColor(172, 172, 172);
        $pdf->SetTextColor(0, 0, 0);
        // $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetMargins(16.35, 16.35, 16.35);

        if ($request->input('s') == '0')
            $status = 0;
        else
            $status = 1;

        $r_id = 1;
        $page_height = 0;
        $one_section = 0;
        $i = 0;
        $current_page = $pdf->PageNo();
        $starting_page_no = $pdf->PageNo();
        $end_page_no = $current_page;
        $end_page_height = 0;

        $pdf->AddPage();
        $pdf->setLeftMargin(8);
        $pdf->setTopMargin(30);
        $pdf->ln(15);

        $pdf->SetDrawColor(172, 172, 172);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('GOTHIC', 'B', 15);
        $pdf->Cell(190, 14, iconv('UTF-8', 'windows-1252', 'Arbeitsvermittlungsvertrag'), 0, 0, 'C');
        $pdf->ln(9);

        $pdf->SetFont('GOTHIC', '', 10.8);
        $pdf->Cell(190, 14, iconv('UTF-8', 'windows-1252', 'Zwischen'), 0, 0, 'L');
        $pdf->ln(14);

        $pdf->MultiCell(190, 4, iconv('UTF-8', 'windows-1252', 'Nextlevel Akademie
Bundesallee 86
12161 Berlin
vertreten durch: Frau Gülhan Dündar (Geschäftsführung)
(nachstehend NLA genannt)'), 0, 'LR');

        $pdf->ln(1);
        $pdf->Cell(190, 14, iconv('UTF-8', 'windows-1252', 'und'), 0, 0, 'L');

        $pdf->ln(14);
        $address = $contact->door_no . ', ' . $contact->street_name;
        if ($contact->address != '')
            $address .= ', ' . $contact->address;
        $address .= ', ' . $contact->city . ', ' . $contact->zip_code;
        $dob = '';

        $parent_address = '';
        if ($contact->parent_door_no != '')
            $parent_address = $contact->parent_door_no . ', ' . $contact->parent_street_name;
        if ($contact->parent_address != '')
            $parent_address .= ', ' . $contact->parent_address;
        if ($contact->parent_city != '')
            $parent_address .= ', ' . $contact->parent_city . ', ' . $contact->parent_zip_code;
        $parent_dob = '';
        if ($parent_dob != '01-01-1900')
            $dob = $contact->parent_dob;

        $pdf->MultiCell(190, 4, iconv('UTF-8', 'windows-1252', $contact->name . '
geb.:                         ' . $dob . '
Anschrift:                   ' . $address . '
Telefon/Handy:        ' . $contact->phone_no . '
E-Mail       :                ' . $contact->email . '

Fördergeldgeber:           ' . $funding_source . '
Ansprechpartner:           ' . $contact_name . '
Anschrift/PLZ/Ort:           ' . $contact_address . '
Telefon/Durchwahl:       ' . $contact_phone . '
E-Mail       :                       ' . $contact_email . '
'), 0, 'LR');

        $t_date = new DateTime('today');
        $driver_age = date_diff(date_create($dob), $t_date)->y;

        $pdf->ln(4);
        $pdf->MultiCell(190, 4, $pdf->writeHTML(iconv('UTF-8', 'windows-1252', '-als Arbeitsuchende/r- (in Folge: &quot;Arbeitssuchender&quot;)')), 0, 'LR');

        $professional_qualifications = array();
        if ($contract->professional_qualifications != '')
            $professional_qualifications = explode(';', $contract->professional_qualifications);
        $elective_qualifications = array();
        if ($contract->elective_qualifications != '')
            $elective_qualifications = explode(';', $contract->elective_qualifications);

        $qualifications = '';
        foreach ($professional_qualifications as $qual) {
            $qualifications .= '• ' . $qual . '<br> ';
        }

        $e_qualifications = '';
        foreach ($elective_qualifications as $qual) {
            $e_qualifications .= '• ' . $qual . '<br> ';
        }

        $pdf->ln(4);
        $pdf->MultiCell(190, 4, $pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>§ 1 Gegenstand<br><br></b>Gegenstand dieses Vertrages ist die Arbeitsvermittlung in eine sozialversicherungspflichtige Beschäftigung sowie die Arbeitsmarkt- und Berufsberatung.<br>(Wir vermitteln keine Mini- und Ferienjobs.)<br><br><b>§ 2 Beginn und Dauer</b><br><br>(1) Das Vertragsverhältnis beginnt am ' . $begin . ' und wird unbefristet geschlossen.<br><br>(2) Die Vertragsparteien können diesen Vertrag jederzeit ohne Angabe von Gründen und ohne Wahrung von Fristen kündigen. Die Kündigung muss in Textform (schriftlich, Fax, E-Mail) erfolgen.<br><br>(3) Die Kündigung ist unwirksam, wenn innerhalb einer Nachlaufzeit von 12 Monaten nach Beendigung dieses Vertrages aufgrund der Vermittlungstätigkeit des Arbeitsvermittlers es zu einer Einstellung beim vermittelten Arbeitgeber kommt.<br>(Damit sichern wir ab, dass Sie nicht nach der Kündigung doch die von uns vermittelte Stelle annehmen und wir &quot;in die Röhre gucken&quot;)<br><br><b>§ 3 Honorar</b><br><br>Als Honorar für die erfolgreiche Vermittlung werden 2.000,00 EURO (in Worten: zweitausend EURO) brutto zwischen Arbeitsvermittler und Arbeitsuchendem für den Arbeitsvermittler vereinbart. Hat der Arbeitssuchende am Tag der Vermittlung einen gültigen Vermittlungsgutschein seines Leistungsträgers zur Förderung der Arbeitsaufnahme, dann übernimmt dieser Leistungsträger das Vermittlungshonorareinschließlich aller Kosten. Beläuft sich der Vermittlungsgutschein zum Zeitpunkt der Vermittlung über einen anderen Betrag, gilt dieser als vereinbart.<br>(Es kommen keine Kosten auf Sie zu!)<br><br><b>§ 4 Rechte des Arbeitsuchenden</b><br><br>Der Arbeitsuchende kann weitere Vermittler mit der Suche nach einer Arbeitsstelle beauftragen. (Kein Exklusivvertrag)<br>Der Arbeitsuchende hat das Recht, Arbeitsangebote abzulehnen.<br>(Keine Zwangsarbeit)<br><br><b>§ 5 Pflichten des Arbeitsuchenden</b><br><br>Der Arbeitsuchende verpflichtet sich, bei Ablauf des Vermittlungsgutscheins während der Vertragslaufzeitselbstständig einen neuen Vermittlungsgutschein zu beantragen (Einfach bei Ablauf die Servicenummer Ihres Leistungsträgers anrufen und einen neuen Vermittlungsgutschein beantragen. Mit telefonischer Antragstellung gilt der Schein als vorhanden) sowie dem Vermittler unverzüglich nach erfolgreicher Vermittlung den Vermittlungsgutschein im Original herauszugeben.<br>(Sie unterzeichnen einen von uns vermittelten Arbeitsvertrag und senden dann gleich das Original des Vermittlungsgutscheines an uns.)<br>Bei Ungültigkeit des Vermittlungsgutscheines, insbesondere durch Ende des Leistungsbezuges von Arbeitslosengeld I oder II, ist sofort der Arbeitsvermittler zu informieren.<br><b>§ 6 Datenschutz</b><br><br>Der Arbeitsuchende erklärt sich mit der Speicherung sowie Weitergabe seiner Daten zum Zwecke der Arbeitsvermittlung durch den Arbeitsvermittler an Dritte (also an geeignete Arbeitgeber oder andere Arbeitsvermittler) einverstanden.<br>Der Arbeitssuchende gestattet dem Arbeitsvermittler nach Abschluss der Vermittlungstätigkeit die fachgerechte Vernichtung der Bewerbungsunterlagen entsprechend den Datenschutzbestimmungen.<br>Personenbezogene Daten werden nach Ablauf der Aufbewahrungsfristen vollständig gelöscht.')), 0, 'LR');

        $pdf->ln(10);

        $date = date('d.m.Y');
        $pdf->MultiCell(190, 4, iconv('UTF-8', 'windows-1252', '
Berlin, den ' . $date . '
'), 0, 'LR');

        $pdf->ln(10);
        $y = $pdf->GetY();
        $image = '';
        if (isset($contract->id) and $contract->signature != '')
            $image = $pdf->Image('signatures/' . $contract->signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90, 4, iconv('UTF-8', 'windows-1252', $image . '








_______________________
Arbeitsvermittler
'), 0, 'LR');

        $pdf->setXY('100', $y);
        $image = '';
        if (isset($contract->id) and $contract->coach_signature != '')
            $image = $pdf->Image('signatures/' . $contract->coach_signature, $pdf->GetX(), $pdf->GetY(), 70);
        $pdf->MultiCell(90, 4, iconv('UTF-8', 'windows-1252', $image . '








_______________________
Arbeitsuchender
'), 0, 'LR');

        // $pdf->Output(); exit();

        if (! isset($contract->id)) {
            $contract = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
            $pdf->Output('company_files/contracts/' . $contract, 'F');

            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
            $id = DB::getPdo()->lastInsertId();
        } else {
            $id = $contract->id;
            $contract = $contract->contract;
            $pdf->Output('company_files/contracts/' . $contract, 'F');
        }
        return $id;

        exit();
    }

    public function course_contract(Request $request, $contact, $type, $contract = 0, $coach = 0)
    {
        // ini_set('memory_limit', '-1');
        // require('fpdf17/fpdf.php');
        // require('fpdi/src/autoload.php');
        $courses = '';
        $total_lessons = 0;
        $total_costs = 0;
        $m_items = '<br>';
        $products2 = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT id, p_id FROM contract_products WHERE contract_id='$contract->id'");
        foreach ($row1 as $r1) {
            $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
            if (count($row22) == 0)
                continue;
            $row22 = collect($row22)->first();

            $row21 = DB::SELECT("SELECT id, m_id FROM contract_modules WHERE p_id='$r1->p_id' AND contract_id='$contract->id'");
            $modules = array();
            $j = 0;
            foreach ($row21 as $r2) {
                $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();

                $row3 = DB::SELECT("SELECT id, i_id, lessons, price_lesson FROM contract_items WHERE m_id='$r2->m_id' AND contract_id='$contract->id'");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $row4 = collect($row4)->first();

                    $total_lessons += $r3->lessons;
                    $total_costs += $r3->lessons * $r3->price_lesson;

                    $k ++;
                }
                $j ++;
            }
            $i2 ++;
        }

        $m2 = array();
        $appointments = DB::select("SELECT title, ue, date FROM appointments WHERE course_id='$contract->course_id' AND contact='$coach' AND status='1' ORDER BY date ASC");
        foreach ($appointments as $appointment) {
            if (! isset($m2[$appointment->title]))
                $m2[$appointment->title] = $appointment->ue;
            else
                $m2[$appointment->title] += $appointment->ue;

            $end = date_format(new DateTime($appointment->date), 'd.m.Y');
        }

        foreach ($m2 as $m => $t) {
            $m_items .= '• ' . $m . ' (UE: ' . $t . ')<br>';
        }

        $total_costs_main = $total_costs;
        $total_costs2 = number_format($total_costs, 2, '.', '');
        $total_costs = explode('.', $total_costs2)[0];
        $decimal = explode('.', $total_costs2)[1];
        $f = new NumberFormatter("de", NumberFormatter::SPELLOUT);
        $total_costs_words_whole = $f->format($total_costs);
        $decimal_words = $f->format($decimal);

        $total_costs_words_whole = substr_replace($total_costs_words_whole, strtoupper(substr($total_costs_words_whole, 0, 1)), 0, 1);
        $decimal_words = substr_replace($decimal_words, strtoupper(substr($decimal_words, 0, 1)), 0, 1);
        $total_costs_words = $total_costs_words_whole . ' Euro und ' . $decimal_words . ' Cent';
        // $total_costs_words = substr_replace($total_costs_words, strtoupper(substr($total_costs_words, 0, 1)), 0, 1);
        $total_costs_words = preg_replace('~\x{00AD}~u', '', $total_costs_words);

        $row2 = DB::select("SELECT title FROM courses WHERE id='$contract->course_id' LIMIT 1");
        if (count($row2) == 1) {
            $row2 = collect($row2)->first();
            $courses = $row2->title;
        }

        if ($contract->installments == '0')
            $installments = 1;
        else
            $installments = $contract->installments;
        $installment_price = $total_costs_main / $installments;
        $consultation_date = date_format(new DateTime($contract->consultation_date), 'd.m.Y');

        $installments_line = '';
        if ($installments > 1)
            $installments_line = 'Die Gebühren teilen sich in ' . $installments . ' monatliche Teilzahlungen in Höhe von ' . $installment_price . ' € pro Monat.';

        $funding_source = '';
        $funding_address = '';
        $funding = DB::select("SELECT * FROM funding_sources WHERE id='$contact->funding_source' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $funding_source = $funding->name;
            $funding_address = $funding->address;
        }

        $contact_name = '';
        $contact_address = '';
        $contact_phone = '';
        $contact_email = '';
        $funding = DB::select("SELECT * FROM contacts WHERE id='$contact->contact_person' LIMIT 1");
        if (count($funding) == 1) {
            $funding = collect($funding)->first();
            $contact_name = $funding->name;
            if ($funding->address != '')
                $contact_address = $funding->address;
            else {
                $contact_address = $funding->street_name . ' ' . $funding->door_no;

                $contact_address .= ', ' . $funding->zip_code . ' ' . $funding->city;
            }
            $contact_phone = $funding->phone_no;
            $contact_email = $funding->email;
        }

        if ($contract->beginning != '0000-00-00') {
            $begin = date_format(new DateTime($contract->beginning), 'd.m.Y');
            // $end=date_format(new DateTime($contract->end),'d.m.Y');
        } else {
            $begin = date_format(new DateTime($contact->beginning), 'd.m.Y');
            // $end=date_format(new DateTime($contact->end),'d.m.Y');
        }
        $c_date = date('d.m.Y');

        $personal_details = array();
        $contract_details = array();
        $contract_details['begin_date'] = $c_date;
        $contract_details['iban'] = $contact->iban;
        $contract_details['bic'] = $contact->bic;
        $contract_details['bank_name'] = $contact->bank_name;
        if (isset($contract->id)) {
            $contract_details['coach_signature'] = $contract->coach_signature;
        } else {
            $contract_details['coach_signature'] = "";
        }

        $personal_details['full_name'] = $contact->name;
        $personal_details['salutation'] = ($contact->gender == "Male" ? "Herr" : "Frau");
        $personal_details['address'] = $contact_address;

        $contract_details['m_items'] = $m_items;
        $contract_details['begin'] = $begin;
        $contract_details['end'] = $end;

        // $pdf = new \setasign\Fpdi\Fpdi();
        
          $pdf = new \Fpdf('P','mm','A4'); //8.5" x 11" laser form
          $pdf->AddFont('GOTHIC','I','GOTHICI.php');
          $pdf->AddFont('GOTHIC','','GOTHIC.php');
          $pdf->AddFont('GOTHIC','BI','GOTHICBI.php');
          $pdf->AddFont('GOTHIC','B','GOTHICB.php');
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
         
          $pdf->SetFont('GOTHIC','',10.8);
          $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','zwischen'), 0, 0, 'L');
          $pdf->ln(15);
         
          $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','der NextLevel Akademie, Bundesallee 86, 12161 Berlin'),0,'LR');
         
          $pdf->SetFont('GOTHIC','B',10.8);
          $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','im Folgenden: Auftraggeber'), 0, 0, 'R');
          $pdf->ln(9);
         
          $pdf->SetFont('GOTHIC','',10.8);
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
         
          $pdf->SetFont('GOTHIC','B',10.8);
          $pdf->Cell(190,14,iconv('UTF-8', 'windows-1252','im Folgenden: Auftragnehmer'), 0, 0, 'R');
          $pdf->ln(4);
         
          $pdf->ln(14);
         
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
          $pdf->MultiCell(190,4,$pdf->writeHTML(iconv('UTF-8', 'windows-1252', '<b>1.</b> Auftragsinhalt:<br><br>Der Auftragnehmer wird für den Auftraggeber im Rahmen des Aufbau-/Ausbildungs-/Umschulungslehrgang als freier Dozent/Trainer für Mode-/Parfümeriefachverkäufer/in, Kaufmann/frau im Einzelhandel, Drogist/in mit Zulassung zur IHK Externenprüfung vom Auftraggeber gebucht. Die Lehrinhalte beinhalten die Thematiken '.$m_items.'<br><br><b>2.</b> Dieser Lehrauftrag ist befristet für die Zeit vom '.$begin.' bis '.$end.'<br><br><b>3.</b> Als Ort und Zeit für den Lehrauftrag sind vereinbart:<br><br>Zeit: je nach vereinbartem Einzeltermin (Bestätigung per Mail/Kalenderausdruck) 08.30 – 15.30 Uhr (8 UE/Tag) inkl. Vor-/Nachbereitung_<br><br>Ort: NextLevel Akademie, Bundesallee 86, 12161 Berlin<br><br><b>4.</b> Die Parteien haben sich über folgende Thematik des Lehrauftrags verständigt. Im Rahmen dieser Thematik ist der Auftragnehmer in der Erfüllung des Lehrauftrages an den IHK Rahmenlehrplan gebunden (s. Anhang). Der Auftragnehmer verpflichtet sich, sich über die aktuellen Lehrpläne der IHK selbstständig zu informieren.<br><br>Ziel für o.g. Maßnahmen ist die Wissensvermittlung um die IHK Abschlussprüfung erfolgreich zu bestehen.<br><br><b>5.</b> Das Honorar pro tatsächlich nachgewiesenem Unterrichtstag beträgt 170 €/Tag. Ein Unterrichtstag wird mit 8 Unterrichtseinheiten berechnet. Als Abrechnungseinheit ist eine Unterrichtseinheit zu 45 Minuten definiert. Mit dem vereinbarten Honorar sind alle Aufwände des Auftragnehmers, insbesondere Fahrtkosten, Vor- und Nachbereitungsaufwand, abgegolten.<br><br>Der Auftrag umfasst folgende Aufgaben, die Anteilig das Honorar bestimmen. Sollten ein oder mehrere Auftragsteile nicht bearbeitet werden, verringert sich das Honorar entsprechend.<br><br><b>a.</b> Unterrichtsvorbereitung / Nachbereitung (10%=17Euro)<br><b>b.</b> Unterrichtsdurchführung im Fachgebiet mit an die Schüler angepasster Methodenvielfalt (60%=102Euro)<br><b>c.</b> Pro Lernfeld und Teilnehmer müssen folgende Noten vergeben werden: 1 Klausur, 1 mündliche Note, 1 benoteter Test oder Projektarbeit, Selbstlerntage müssen immer bewertet werden. (10%=17Euro)<br><b>d.</b> Ausführliche, dem Lernfeld und jeweiligen Block zugeordnete Unterrichtsdokumentation im digitalen Klassenbuch edupage. (10%=17Euro)<br><b>e.</b> Individuelle Teilnehmerdokumentation bei besonderen Ereignissen (Gespräche, Beschwerden, Auffälliges Verhalten) (10%=17Euro)<br><br><b>7.</b> Ansprechpartner für die Mitteilung von Leistungsverhinderungen sind Susann Böldicke und Katja Moewe telefonisch unter 030/896 400 64 oder per Mail info@nextlevel-akademie.de<br><br><b>8.</b> Aller beiderseitigen Ansprüche aus diesem Vertrag mit Ausnahme von Ansprüchen, die aus der Verletzung des Lebens, des Körpers und der Gesundheit sowie aus vorsätzlichen oder grob fahrlässigen Pflichtverletzungen resultieren, müssen innerhalb von drei Monaten nach Fälligkeit schriftlich geltend gemacht werden. Der Fristlauf beginnt nicht, bevor der Gläubiger von den den Anspruch begründenden Umständen Kenntnis erlangt hat oder ohne grobe Fahrlässigkeit hätte erlangen müssen. Wird ein Anspruch nicht formgemäß innerhalb der Fristen geltend gemacht, so führt dies zu seinem endgültigen Erlöschen.<br><br><b>9.</b> Im Übrigen gelten die Regelungen des Rahmenvertrages.')),0,'LR');
         
          $pdf->ln(10);
         
          $date=date('d.m.Y');
          $pdf->MultiCell(190,4,iconv('UTF-8', 'windows-1252','
          Berlin, den '.$date.'
          '),0,'LR');
         
          $pdf->ln(10);
          $y=$pdf->GetY();
          $image='';
          if(isset($contract->id) AND $contract->coach_signature!='')
          $image=$pdf->Image('signatures/'.$contract->coach_signature, $pdf->GetX(), $pdf->GetY(), 70);
          $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'
         
         
         
         
         
         
         
         
          _______________________
          NextLevel Akademie
          '),0,'LR');
         
          $pdf->setXY('100', $y);
          $image='';
          if(isset($contract->id) AND $contract->signature!='')
          $image=$pdf->Image('signatures/'.$contract->signature, $pdf->GetX(), $pdf->GetY(), 70);
          $pdf->MultiCell(90,4,iconv('UTF-8', 'windows-1252',$image.'
         
         
         
         
         
         
         
         
          _______________________
          Auftragnehmer
          '),0,'LR');
         
          //$pdf->Output(); exit();
         
        if (! isset($contract->id)) {
           $contract = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
           $pdf->Output('company_files/contracts/' . $contract, 'F');
            DB::insert("INSERT INTO contracts (c_id, contract, type, on_date) VALUES ('$contact->id', '$contract', '$type', NOW())");
           $id = DB::getPdo()->lastInsertId();
       } else {
            $id = $contract->id;
            $contract = $contract->contract;
            $pdf->Output('company_files/contracts/' . $contract, 'F');
        }
        return $id;

        exit();
    }
}
