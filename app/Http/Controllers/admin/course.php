<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use DB;
use Mail;

class course extends Controller
{

    public static function instance()
    {
        return new course();
    }

    public function __construct()
    {}

    public function regular_courses(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('delete') != '') {
            $delete = addslashes($request->input('delete'));

            // track Activity START
            $row = DB::select("SELECT id, title FROM courses WHERE id='$delete' LIMIT 1");
            $row = collect($row)->first();
            $id = $row->id;
            $name = $row->title;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a course - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM courses WHERE id='$delete'");
            DB::delete("DELETE FROM appointments WHERE course_id='$delete'");
            $request->session()->flash('success', 'Course has been deleted successfully.');

            return redirect('admin/regular-courses');
        }

        $products = array();
        $i = 0;
        $row = DB::select("SELECT * FROM products");
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

        $courses = array();
        $i = 0;
        $row = DB::select("SELECT * FROM courses WHERE type='Regular' ORDER BY id DESC");
        foreach ($row as $r) {
            $courses[$i]['course'] = $r;

            $courses[$i]['coach'] = '';
            $row1 = DB::select("SELECT name, email FROM contacts WHERE id='$r->coach' LIMIT 1");
            if (count($row1) == 1) {
                $row1 = collect($row1)->first();
                $courses[$i]['coach'] = $row1;
            }

            $courses[$i]['total_cost'] = 0;
            $courses[$i]['total_lessons'] = 0;
            $products2 = array();
            $i2 = 0;
            $row1 = DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$r->id'");
            foreach ($row1 as $r1) {
                $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();
                $products2[$i2]['product'] = $row22;

                $products2[$i2]['total_cost'] = 0;
                $products2[$i2]['total_lessons'] = 0;

                $row2 = DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$r->id'");
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

                    $row3 = DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$r->id'");
                    $module_items = array();
                    $k = 0;
                    foreach ($row3 as $r3) {
                        $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                        if (count($row4) == 0)
                            continue;
                        $row4 = collect($row4)->first();
                        $module_items[$k]['item'] = $row4;

                        $lessons = DB::select("SELECT lessons FROM contract_items WHERE course_id='$r->id' AND i_id='$r3->id' LIMIT 1");
                        if (count($lessons) == 1) {
                            $lessons = collect($lessons)->first();
                            $row4->lessons = $lessons->lessons;
                            $lessons = $lessons->lessons;
                            $module_items[$k]['item'] = $row4;
                        } else
                            $lessons = $row4->lessons;

                        $courses[$i]['total_lessons'] += $lessons;
                        $courses[$i]['total_cost'] += $lessons * $row4->price_lessons;

                        $products2[$i2]['total_lessons'] += $lessons;
                        $products2[$i2]['total_cost'] += $lessons * $row4->price_lessons;

                        $modules[$j]['total_lessons'] += $lessons;
                        $modules[$j]['total_cost'] += $lessons * $row4->price_lessons;

                        $k ++;
                    }
                    $modules[$j]['items'] = $module_items;
                    $j ++;
                }
                $products2[$i2]['modules'] = $modules;
                $i2 ++;
            }
            $courses[$i]['products'] = $products2;

            $classes = array();
            $i2 = 0;
            $row1 = DB::SELECT("SELECT * FROM classes WHERE course_id='$r->id'");
            foreach ($row1 as $r1) {
                $classes[$i2]['class'] = $r1;

                $classes[$i2]['room'] = '';
                $row22 = DB::select("SELECT id, name, location FROM rooms WHERE id='$r1->room' LIMIT 1");
                if (count($row22) == 1) {
                    $row22 = collect($row22)->first();
                    $classes[$i2]['room'] = $row22->name;

                    $row22 = DB::select("SELECT id, name FROM room_locations WHERE id='$row22->location' LIMIT 1");
                    if (count($row22) == 1) {
                        $row22 = collect($row22)->first();
                        $classes[$i2]['room'] .= ' (' . $row22->name . ')';
                    }
                }

                $i2 ++;
            }
            $courses[$i]['classes'] = $classes;

            $contracts = array();
            $j = 0;
            $row2 = DB::select("SELECT * FROM contracts WHERE course_id='$r->id' ORDER BY id DESC");
            if (count($row2) != 0) {
                foreach ($row2 as $r2) {
                    // $contracts[$j]['contact']='NA';
                    $row3 = DB::select("SELECT * FROM contacts WHERE id='$r2->c_id' AND type='Student' LIMIT 1");
                    if (count($row3) == 1) {
                        $row3 = collect($row3)->first();
                        $contracts[$j]['contact'] = $row3;
                    } else
                        continue;

                    $row3 = DB::select("SELECT * FROM contracts WHERE id='$r2->id' LIMIT 1");
                    $row3 = collect($row3)->first();
                    $contracts[$j]['contract'] = $row3;

                    $j ++;
                }
            }

            $courses[$i]['students'] = $contracts;

            $dozents = array();
            $j = 0;
            $coaches = explode(';', $r->coaches);
            foreach ($coaches as $coach) {
                $dozents[$j]['contact'] = 'NA';
                $row3 = DB::select("SELECT * FROM contacts WHERE id='$coach' LIMIT 1");
                if (count($row3) == 1) {
                    $row3 = collect($row3)->first();
                    $dozents[$j]['contact'] = $row3;
                }

                $j ++;
            }

            $courses[$i]['dozents'] = $dozents;

            $i ++;
        }

        $rooms = array();
        $i = 0;
        $row = DB::select("SELECT id, name, location FROM rooms");
        foreach ($row as $r) {
            $rooms[$i]['room'] = $r;

            $rooms[$i]['location'] = '';
            $row2 = DB::select("SELECT name FROM room_locations WHERE id='$r->location' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $rooms[$i]['location'] = $row2->name;
            }

            $i ++;
        }

        $coaches = array();
        $i = 0;
        $row = DB::select("SELECT id, name, types FROM contacts WHERE type='Coach' ORDER BY name ASC");
        foreach ($row as $r) {
            $types = explode(',', $r->types);
            if (! in_array('Trainer', $types))
                continue;
            $coaches[$i]['coach'] = $r;

            $i ++;
        }

        $students = array();
        $i = 0;
        $row = DB::select("SELECT id, name, types FROM contacts WHERE type='Student' ORDER BY name ASC");
        foreach ($row as $r) {
            $types = explode(',', $r->types);
            if (! in_array('Student', $types))
                continue;
            $students[$i]['student'] = $r;

            $i ++;
        }
        return view('panel.regular_courses.index', [
            'title' => trans('header.regular_courses'),
            'products' => $products,
            'courses' => $courses,
            'rooms' => $rooms,
            'coaches' => $coaches,
            'students' => $students
        ]);
    }

    public function coaching_courses(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('delete') != '') {
            $delete = addslashes($request->input('delete'));

            // track Activity START
            $row = DB::select("SELECT id, title FROM courses WHERE id='$delete' LIMIT 1");
            $row = collect($row)->first();
            $id = $row->id;
            $name = $row->title;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a course - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM courses WHERE id='$delete'");
            DB::delete("DELETE FROM appointments WHERE course_id='$delete'");
            $request->session()->flash('success', 'Course has been deleted successfully.');

            return redirect('admin/coaching-courses');
        }

        $products = array();
        $i = 0;
        $row = DB::select("SELECT * FROM products");
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

        $courses = array();
        $i = 0;
        $row = DB::select("SELECT * FROM courses WHERE type='Coaching' ORDER BY id DESC");
        foreach ($row as $r) {
            $courses[$i]['course'] = $r;

            $courses[$i]['coach'] = '';
            $row1 = DB::select("SELECT name, email FROM contacts WHERE id='$r->coach' LIMIT 1");
            if (count($row1) == 1) {
                $row1 = collect($row1)->first();
                $courses[$i]['coach'] = $row1;
            }

            $courses[$i]['total_cost'] = 0;
            $courses[$i]['total_lessons'] = 0;
            $products2 = array();
            $i2 = 0;
            $row1 = DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$r->id'");
            foreach ($row1 as $r1) {
                $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();
                $products2[$i2]['product'] = $row22;

                $products2[$i2]['total_cost'] = 0;
                $products2[$i2]['total_lessons'] = 0;

                $row2 = DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$r->id'");
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

                    $row3 = DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$r->id'");
                    $module_items = array();
                    $k = 0;
                    foreach ($row3 as $r3) {
                        $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                        if (count($row4) == 0)
                            continue;
                        $row4 = collect($row4)->first();
                        $module_items[$k]['item'] = $row4;

                        $lessons = DB::select("SELECT lessons FROM contract_items WHERE course_id='$r->id' AND i_id='$r3->id' LIMIT 1");
                        if (count($lessons) == 1) {
                            $lessons = collect($lessons)->first();
                            $row4->lessons = $lessons->lessons;
                            $lessons = $lessons->lessons;
                            $module_items[$k]['item'] = $row4;
                        } else
                            $lessons = $row4->lessons;

                        $courses[$i]['total_lessons'] += $lessons;
                        $courses[$i]['total_cost'] += $lessons * $row4->price_lessons;

                        $products2[$i2]['total_lessons'] += $lessons;
                        $products2[$i2]['total_cost'] += $lessons * $row4->price_lessons;

                        $modules[$j]['total_lessons'] += $lessons;
                        $modules[$j]['total_cost'] += $lessons * $row4->price_lessons;

                        $k ++;
                    }
                    $modules[$j]['items'] = $module_items;
                    $j ++;
                }
                $products2[$i2]['modules'] = $modules;
                $i2 ++;
            }
            $courses[$i]['products'] = $products2;

            $classes = array();
            $i2 = 0;
            $row1 = DB::SELECT("SELECT * FROM classes WHERE course_id='$r->id'");
            foreach ($row1 as $r1) {
                $classes[$i2]['class'] = $r1;

                $classes[$i2]['room'] = '';
                $row22 = DB::select("SELECT id, name, location FROM rooms WHERE id='$r1->room' LIMIT 1");
                if (count($row22) == 1) {
                    $row22 = collect($row22)->first();
                    $classes[$i2]['room'] = $row22->name;

                    $row22 = DB::select("SELECT id, name FROM room_locations WHERE id='$row22->location' LIMIT 1");
                    if (count($row22) == 1) {
                        $row22 = collect($row22)->first();
                        $classes[$i2]['room'] .= ' (' . $row22->name . ')';
                    }
                }

                $i2 ++;
            }
            $courses[$i]['classes'] = $classes;

            $contracts = array();
            $j = 0;
            $row2 = DB::select("SELECT * FROM contracts WHERE course_id='$r->id' ORDER BY id DESC");
            if (count($row2) != 0) {
                foreach ($row2 as $r2) {
                    $row3 = DB::select("SELECT * FROM contracts WHERE id='$r2->id' LIMIT 1");
                    $row3 = collect($row3)->first();
                    $contracts[$j]['contract'] = $row3;

                    $contracts[$j]['contact'] = 'NA';
                    $row3 = DB::select("SELECT * FROM contacts WHERE id='$r2->c_id' LIMIT 1");
                    if (count($row3) == 1) {
                        $row3 = collect($row3)->first();
                        $contracts[$j]['contact'] = $row3;
                    }

                    $j ++;
                }
            }

            $courses[$i]['students'] = $contracts;

            $dozents = array();
            $j = 0;
            $coaches = explode(';', $r->coaches);
            foreach ($coaches as $coach) {
                $dozents[$j]['contact'] = 'NA';
                $row3 = DB::select("SELECT * FROM contacts WHERE id='$coach' LIMIT 1");
                if (count($row3) == 1) {
                    $row3 = collect($row3)->first();
                    $dozents[$j]['contact'] = $row3;

                    $check = DB::select("SELECT id FROM course_offers WHERE course_id='$r->id' AND coach='$coach' LIMIT 1");
                    if (count($check) == 0)
                        DB::insert("INSERT INTO course_offers (course_id, coach, on_date) VALUES ('$r->id', '$coach', NOW())");
                }

                $j ++;
            }

            $courses[$i]['dozents'] = $dozents;

            $i ++;
        }

        $rooms = array();
        $i = 0;
        $row = DB::select("SELECT id, name, location FROM rooms");
        foreach ($row as $r) {
            $rooms[$i]['room'] = $r;

            $rooms[$i]['location'] = '';
            $row2 = DB::select("SELECT name FROM room_locations WHERE id='$r->location' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $rooms[$i]['location'] = $row2->name;
            }

            $i ++;
        }

        $coaches = array();
        $i = 0;
        $row = DB::select("SELECT id, name, types FROM contacts WHERE type='Coach' ORDER BY name ASC");
        foreach ($row as $r) {
            $types = explode(',', $r->types);
            if (! in_array('Coach', $types))
                continue;
            $coaches[$i]['coach'] = $r;

            $i ++;
        }

        $students = array();
        $i = 0;
        $row = DB::select("SELECT id, name, types FROM contacts WHERE type='Student' ORDER BY name ASC");
        foreach ($row as $r) {
            $types = explode(',', $r->types);
            if (! in_array('Coachee', $types))
                continue;
            $students[$i]['student'] = $r;

            $i ++;
        }
        return view('panel.coaching_courses.index', [
            'title' => trans('header.coaching_courses'),
            'products' => $products,
            'courses' => $courses,
            'rooms' => $rooms,
            'coaches' => $coaches,
            'students' => $students
        ]);
    }

    public function has_incomplete_appointments(Request $request, $id){
        $admin_id = $request->session()->get('admin_id');
        
        $course = DB::select("SELECT * FROM courses WHERE id='$id' LIMIT 1");
        $course = collect($course)->first();
        
        $data = array();
        
        if($course->id > 0)  {
            $data = array();
            $data['success'] = 0;
            
            $id = $course->id;
            $app = DB::select("select count(*) record_count from appointments app left outer join attendance att on att.appointment_id = app.id where app.course_id ='$id' and app.type = 2 and att.id is null");
            $app = collect($app)->first();
            
            if ($app->record_count > 0) { // There are appointments without Tagesdoku/attendance
                $data['success'] = 1;
                $data['message'] = 'Incomplete appointments found';
            } else {
                $data['success'] = 2;
                $data['message'] = 'All appointments completed';
            }
            
            $data['id'] = $id;
            $data['success'] = 1;
                
           
        } else {
            $data['success'] = 0;
            $data['message'] = 'Invalid Course';
        }
        return response()->json($data);
    }
    public function coaching_end_report(Request $request, $id){
        $admin_id = $request->session()->get('admin_id');
        
        $course = DB::select("SELECT * FROM courses WHERE id='$id' LIMIT 1");
        $course = collect($course)->first();
        
        $course_product = DB::select("SELECT * FROM course_products WHERE c_id = $course->id");
        $course_product = collect($course_product)->first();

        $product = DB::select("SELECT * FROM products WHERE id = $course_product->p_id");
        $product = collect($product)->first();

        echo json_encode($product);
        exit();
        $data = array();
        
        //DURCHHALTEVERMOEGEN_BELASTBARKEIT BLOCK DATA
        $mi_durchhaltevermoegen_belastbarkeit = env('MI_DURCHHALTEVERMOEGEN_BELASTBARKEIT', 2793);       
        $durch_belast = DB::select("select * from appointments app inner join attendance att on att.appointment_id = app.id
        inner join attendance_additional attaddl on attaddl.attendance_id = att.id
        where app.course_id ='$id' and app.item_id = '$mi_durchhaltevermoegen_belastbarkeit'
        order by app.date desc
        limit 1");
        $durch_belast = collect($durch_belast)->first();
        if(isset($durch_belast)){
            $data['durch_belast_exists'] = 1;
            $data['durch_belast_options'] = $durch_belast->durch_belast_options;
            $data['durch_belast_options_other'] = $durch_belast->durch_belast_options_other;
        }else{
            $data['durch_belast_exists'] = 0;
        }
        
        //MI_WEG_ZIEL_PLANUNG BLOCK DATA
        $mi_weg_ziel_planung = env('MI_WEG_ZIEL_PLANUNG', 2798);
        $wzp = DB::select("select * from appointments app inner join attendance att on att.appointment_id = app.id
        inner join attendance_additional attaddl on attaddl.attendance_id = att.id
        where app.course_id ='$id' and app.item_id = '$mi_weg_ziel_planung'
        order by app.date desc
        limit 1");
        $wzp = collect($wzp)->first();
        if(isset($wzp)){
            $data['weg_ziel_planung_exists'] = 1;
            if(isset($wzp->weg_ziel_planung_plan_a))
                $data['weg_ziel_planung_a'] = $wzp->weg_ziel_planung_plan_a;
            if(isset($wzp->weg_ziel_planung_plan_b))
                $data['weg_ziel_planung_b'] = $wzp->weg_ziel_planung_plan_b;
            if(isset($wzp->weg_ziel_planung_plan_c))
                $data['weg_ziel_planung_c'] = $wzp->weg_ziel_planung_plan_c;
            if(isset($wzp->weg_ziel_planung_plan_d))
                $data['weg_ziel_planung_d'] = $wzp->weg_ziel_planung_plan_d;
            if(isset($wzp->weg_ziel_planung_plan_e))
                $data['weg_ziel_planung_e'] = $wzp->weg_ziel_planung_plan_e;
        }else{
            $data['weg_ziel_planung_exists'] = 0;
        }
        
        //MI_PROFESSIONALE_BEWERBUNGSUNTERLAGEN BLOCK DATA
        $mi_professionale_bewerbungsunterlagen = env('MI_PROFESSIONALE_BEWERBUNGSUNTERLAGEN', 2801);
        $prof_bewerb = DB::select("select * from appointments app inner join attendance att on att.appointment_id = app.id
        inner join attendance_additional attaddl on attaddl.attendance_id = att.id
        where app.course_id ='$id' and app.item_id = '$mi_professionale_bewerbungsunterlagen'
        order by app.date desc
        limit 1");
        $prof_bewerb = collect($prof_bewerb)->first();
        if(isset($prof_bewerb)){
            $data['prof_bewerbung_exists'] = 1;
            if(isset($prof_bewerb->prof_bewerbung_platforms_used))
                $data['prof_bewerbung_platforms_used'] = $prof_bewerb->prof_bewerbung_platforms_used;
            if(isset($prof_bewerb->prof_bewerbung_platforms_used_other))
                $data['prof_bewerbung_platforms_used_other'] = $prof_bewerb->prof_bewerbung_platforms_used_other;
            if(isset($prof_bewerb->prof_bewerbung_mappe))
                $data['prof_bewerbung_mappe'] = $prof_bewerb->prof_bewerbung_mappe;
            
            //CV1-10 should be added here 
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv1_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv1)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv1_to'] = $prof_bewerb->prof_bewerbung_sent_cv1_to;
                    $data['prof_bewerbung_sent_cv1_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv1;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv1_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv1_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it 
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv1_to'] = $prof_bewerb->prof_bewerbung_sent_cv1_to;
                        $data['prof_bewerbung_sent_cv1_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv2_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv2)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv2_to'] = $prof_bewerb->prof_bewerbung_sent_cv2_to;
                    $data['prof_bewerbung_sent_cv2_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv2;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv2_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv2_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv2_to'] = $prof_bewerb->prof_bewerbung_sent_cv2_to;
                        $data['prof_bewerbung_sent_cv2_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv3_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv3)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv3_to'] = $prof_bewerb->prof_bewerbung_sent_cv3_to;
                    $data['prof_bewerbung_sent_cv3_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv3;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv3_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv3_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv3_to'] = $prof_bewerb->prof_bewerbung_sent_cv3_to;
                        $data['prof_bewerbung_sent_cv3_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv4_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv4)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv4_to'] = $prof_bewerb->prof_bewerbung_sent_cv4_to;
                    $data['prof_bewerbung_sent_cv4_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv4;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv4_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv4_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv4_to'] = $prof_bewerb->prof_bewerbung_sent_cv4_to;
                        $data['prof_bewerbung_sent_cv4_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv5_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv5)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv5_to'] = $prof_bewerb->prof_bewerbung_sent_cv5_to;
                    $data['prof_bewerbung_sent_cv5_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv5;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv5_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv5_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv5_to'] = $prof_bewerb->prof_bewerbung_sent_cv5_to;
                        $data['prof_bewerbung_sent_cv5_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv6_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv6)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv6_to'] = $prof_bewerb->prof_bewerbung_sent_cv6_to;
                    $data['prof_bewerbung_sent_cv6_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv6;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv6_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv6_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv6_to'] = $prof_bewerb->prof_bewerbung_sent_cv6_to;
                        $data['prof_bewerbung_sent_cv6_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv7_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv7)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv7_to'] = $prof_bewerb->prof_bewerbung_sent_cv7_to;
                    $data['prof_bewerbung_sent_cv7_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv7;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv7_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv7_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv7_to'] = $prof_bewerb->prof_bewerbung_sent_cv7_to;
                        $data['prof_bewerbung_sent_cv7_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv8_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv8)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv8_to'] = $prof_bewerb->prof_bewerbung_sent_cv8_to;
                    $data['prof_bewerbung_sent_cv8_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv8;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv8_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv8_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv8_to'] = $prof_bewerb->prof_bewerbung_sent_cv8_to;
                        $data['prof_bewerbung_sent_cv8_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv9_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv9)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv9_to'] = $prof_bewerb->prof_bewerbung_sent_cv9_to;
                    $data['prof_bewerbung_sent_cv9_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv9;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv9_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv9_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv9_to'] = $prof_bewerb->prof_bewerbung_sent_cv9_to;
                        $data['prof_bewerbung_sent_cv9_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
            
            if(isset($prof_bewerb->pdf_bewerbung_sent_cv10_to)){
                if(isset($prof_bewerb->pdf_bewerbung_sent_cv10)){
                    //CV was uploaded & sent
                    $data['prof_bewerbung_sent_cv10_to'] = $prof_bewerb->prof_bewerbung_sent_cv10_to;
                    $data['prof_bewerbung_sent_cv10_cv'] = $prof_bewerb->pdf_bewerbung_sent_cv10;
                } else if(isset($prof_bewerb->pdf_bewerbung_sent_cv10_cvs_id))
                {
                    //Added CV was selected
                    $cvs_id = $prof_bewerb->pdf_bewerbung_sent_cv10_cvs_id;
                    //TODO: Retrieve the CV name from cvs table & set it
                    $cvs = CVs::where('id','=',$cvs_id)->get()->first();
                    if(isset($cvs)){
                        $data['prof_bewerbung_sent_cv10_to'] = $prof_bewerb->prof_bewerbung_sent_cv10_to;
                        $data['prof_bewerbung_sent_cv10_cv'] = $prof_bewerb->$cvs->name;
                    }
                }
            }
           
        }else{
            $data['prof_bewerbung_exists'] = 0;
        }
        
        //MI_SELBST_UND_FREMDWAHRNEHMUNG_TEIL_1 BLOCK DATA
        $mi_selbst_und_fremdwahrnehmung = env('MI_SELBST_UND_FREMDWAHRNEHMUNG_TEIL_1', 2792);
        $selbst_und_fremd = DB::select("select * from appointments app inner join attendance att on att.appointment_id = app.id
        inner join attendance_additional attaddl on attaddl.attendance_id = att.id
        where app.course_id ='$id' and app.item_id = '$mi_selbst_und_fremdwahrnehmung'
        order by app.date desc
        limit 1");
        $selbst_und_fremd = collect($selbst_und_fremd)->first();
        if(isset($selbst_und_fremd)){
            $data['selbst_und_fremd_exists'] = 1;
            if(isset($selbst_und_fremd->selbst_fremd_strengths))
                $data['selbst_fremd_strengths'] = $selbst_und_fremd->selbst_fremd_strengths;
            if(isset($selbst_und_fremd->selbst_fremd_weakness))
                $data['selbst_fremd_weakness'] = $selbst_und_fremd->selbst_fremd_weakness;
            if(isset($selbst_und_fremd->selbst_fremd_potential))
                $data['selbst_fremd_potential'] = $selbst_und_fremd->selbst_fremd_potential;
            if(isset($selbst_und_fremd->selbst_fremd_energykiller))
                $data['selbst_fremd_energykiller'] = $selbst_und_fremd->selbst_fremd_energykiller;
            if(isset($selbst_und_fremd->selbst_fremd_energygiver))
                $data['selbst_fremd_energygiver'] = $selbst_und_fremd->selbst_fremd_energygiver;  
            if(isset($selbst_und_fremd->selbst_fremd_ziel_planung))
                $data['selbst_fremd_ziel_planung'] = $selbst_und_fremd->selbst_fremd_ziel_planung;
            if(isset($selbst_und_fremd->selbst_fremd_beruf_persp))
                $data['selbst_fremd_beruf_persp'] = $selbst_und_fremd->selbst_fremd_beruf_persp;               
                
        }else{
            $data['selbst_und_fremd_exists'] = 0;
        }
        
        //MI_MOEGLICHKEITEN_VISIONEN BLOCK DATA
        $mi_moeglichkeiten_visionen = env('MI_MOEGLICHKEITEN_VISIONEN', 2794);
        $mv = DB::select("select * from appointments app inner join attendance att on att.appointment_id = app.id
        inner join attendance_additional attaddl on attaddl.attendance_id = att.id
        where app.course_id ='$id' and app.item_id = '$mi_moeglichkeiten_visionen'
        order by app.date desc
        limit 1");
        $mv = collect($mv)->first();
        if(isset($mv)){
            $data['moeglichkeiten_visionen_exists'] = 1;
            if(isset($mv->moeglich_vision_competence))
                $data['moeglich_vision_competence'] = $mv->moeglich_vision_competence;
            if(isset($mv->moeglich_vision_experience))
                $data['moeglich_vision_experience'] = $mv->moeglich_vision_experience;                     
        }else{
            $data['moeglichkeiten_visionen_exists'] = 0;
        }
        
        //Coaching_verhalten
        $coaching_verhalten = DB::select("SELECT round(avg(vorbildlich),0) vorbildlich, round(avg(sucht_loesungen),0) sucht_loesungen,
round(avg(agiert_entscheidung),0) agiert_entscheidung, round(avg(motiviert_konflikt_solve),0) motiviert_konflikt_solve,
round(avg(motiviert_problem_solve),0) motiviert_problem_solve 
FROM d0352644.attendance_verhalten ver inner join attendance att on att.id = ver.attendance_id
inner join appointments app on app.id = att.appointment_id where app.course_id ='$id';");
        $coaching_verhalten = collect($coaching_verhalten)->first();
        if(isset($coaching_verhalten)){
            $data['coaching_verhalten_exists'] = 1;
            $data['coaching_verhalten_vorbildlich'] = $coaching_verhalten->vorbildlich;
            $data['coaching_verhalten_sucht_loesungen'] = $coaching_verhalten->sucht_loesungen;
            $data['coaching_verhalten_agiert_entscheidung'] = $coaching_verhalten->agiert_entscheidung;
            $data['coaching_verhalten_motiviert_konflikt_solve'] = $coaching_verhalten->motiviert_konflikt_solve;
            $data['coaching_verhalten_motiviert_problem_solve'] = $coaching_verhalten->motiviert_problem_solve;
        }else{
            $data['coaching_verhalten_exists'] = 0;
        }
        
        //TODO: Creating Interface
        /*$pdf = PDF::loadView('pdf.abschlussbericht',$data);
        
        $pdf->setOptions([
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'debugCss' => true
        ]);
        $tagesdokufilename = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.pdf';
        $pdf->save('company_files/tagesdoku/' . $tagesdokufilename);
        $attendance->pdf_url = $tagesdokufilename;
        $attendance->save();
        
        return $pdf->stream();*/
        
        // return response()->json($data);
        return view('panel.edit_absch.index', [
            'title' => 'Edit Abschbussbericht',
            'course' => $course,
        ]);
    }
    public function edit_course(Request $request, $id)
    {
        $admin_id = $request->session()->get('admin_id');

        $course = DB::select("SELECT * FROM courses WHERE id='$id' LIMIT 1");
        $course = collect($course)->first();

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $description = addslashes($request->input('description'));
            $beginning = '';
            $end = '';
            $period = addslashes($request->input('period'));
            if ($period != '') {
                $dates = explode(' - ', $period);
                $beginning = date_format(new DateTime($dates[0]), 'Y-m-d');
            }

            $coaches = '';
            if ($request->input('coaches') != '')
                $coaches = implode(';', $request->input('coaches'));

            DB::update("UPDATE courses SET title='$title', description='$description', beginning='$beginning', coaches='$coaches' WHERE id='$id'");
            $check = DB::select("SELECT id FROM appointments WHERE course_id='$id' AND status='2' LIMIT 1");
            if (count($check) != 0) {
                foreach ($request->input('coaches') as $coach) {
                    $check = DB::select("SELECT id FROM course_offers WHERE coach='$coach' AND course_id='$id' LIMIT 1");
                    if (count($check) == 0) {
                        DB::insert("INSERT INTO course_offers (course_id, coach, on_date) VALUES ('$id', '$coach', NOW())");
                        $coach = DB::select("SELECT name, email FROM contacts WHERE id='$coach' LIMIT 1");
                        $coach = collect($coach)->first();

                        $course = DB::select("SELECT id, title FROM courses WHERE id='$id' LIMIT 1");
                        $course = collect($course)->first();

                        // send email alert to dozent START
                        $name = $coach->name;
                        $email = $coach->email;
                        $from = env('MAIL_USERNAME');
                        $title = 'New course offer';
                        $title_url = 'View and Accept';
                        $url = url('course-offers');
                        $text = 'You have a new offer for course: <b>' . $course->title . '</b>. Login and accept now.';
                        $data2 = array(
                            'email' => $email,
                            'from' => $from,
                            'name' => $name,
                            'title' => $title,
                            'title_url' => $title_url,
                            'url' => $url,
                            'text' => $text
                        );
                        Mail::send('emails.notification', $data2, function ($message) use ($email, $from, $name, $title) {
                            $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                            $message->to($email);
                            $message->subject($title);
                        });
                        // send email alert to dozent END

                        $request->session()->flash('success', 'Appointments are sent to <b>' . $coach->name . '</b>');
                    }
                }
            }
            if ($course->type == 'Coaching')
                return redirect('admin/coaching-courses');
            else if ($course->type == 'Regular')
                return redirect('admin/regular-courses');
        }

        $coaches = array();
        $i = 0;
        $row = DB::select("SELECT id, name, types FROM contacts WHERE type='Coach' ORDER BY name ASC");
        foreach ($row as $r) {
            $coaches[$i]['coach'] = $r;

            $i ++;
        }

        $title = $course->title;
        return view('panel.edit_course.index', [
            'title' => $title,
            'coaches' => $coaches,
            'course' => $course
        ]);
    }

    public function course_appointments(Request $request, $course_id)
    {
        $exec_msg = '';
        ini_set('memory_limit', '-1');
        require ('fpdf17/fpdf.php');

        $course = DB::select("SELECT * FROM courses WHERE id='$course_id' LIMIT 1");
        $course = collect($course)->first();
        if ($course->coaches == '') {
            $request->session()->flash('error', 'No dozent added to the course.');
            return redirect('admin/course-appointments/' . $course->id);
        }
        $coaches = explode(';', $course->coaches);

        $lecturers = array();
        $i = 0;
        foreach ($coaches as $coach) {
            $coach_data = DB::select("SELECT id, name, email FROM contacts WHERE id='$coach' LIMIT 1");
            if (count($coach_data) == 0)
                continue;
            $coach_data = collect($coach_data)->first();
            $lecturers[$i]['coach'] = $coach_data;

            $i ++;
        }

        if ($request->input('send') == '1') {
            //$exec_msg .= 'send is set to 1<br/>';
            $toinvite_appointments = DB::select("SELECT distinct dozents FROM appointments WHERE course_id='$course_id' AND status='0'");
            $dozents_all = array();
            foreach ($toinvite_appointments as $r) {
                if ($r->dozents != '') {
                    $dozts = explode(';', $r->dozents);
                    foreach ($dozts as $d) {
                        if (! in_array($d, $dozents_all))
                            $dozents_all[] = $d;
                    }
                }
            }
            //$exec_msg .= 'dozents: ' . json_encode($dozents_all) . '<br/>';

            //status = 1 = accepted
            //status = 0 = created
            //status = 2 = sent
            //status = 3 = deleted (after sent)
            //status = 4 = rejected
            //status = 5 = changed thru admin
            DB::update("UPDATE appointments SET status='2' WHERE course_id='$course_id' AND status='0'");

            $contract_type = addslashes($course->title . ' - Course Contract');

            // $coaches=array();
            // if(sizeof($dozents_all) > 0) $coaches=explode(';', $dozents_all);
            foreach ($dozents_all as $coach) {
                $coach_data = DB::select("SELECT id, name, email FROM contacts WHERE id='$coach' LIMIT 1");
                if (count($coach_data) == 0)
                    continue;
                $coach_data = collect($coach_data)->first();

                $check = DB::select("SELECT id FROM course_offers WHERE course_id='$course->id' AND coach='$coach' LIMIT 1");
                if (count($check) == 0) {
                    DB::insert("INSERT INTO course_offers (course_id, coach, on_date) VALUES ('$course->id', '$coach', NOW())");

                    // create contract START
                    /*
                     * $contact=DB::select("SELECT * FROM contacts WHERE id='$coach' LIMIT 1");
                     * $contact=collect($contact)->first();
                     *
                     * $contract=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
                     * DB::insert("INSERT INTO contracts (c_id, contract, course_id, type, on_date, beginning, end, professional_qualifications, elective_qualifications, installments, consultation_date, job_title, student, phase1_begin, phase1_end, phase2_begin, phase2_end, test1_begin, test1_end, test2_begin, test2_end) VALUES ('$coach', '$contract', '$course->id', '$contract_type', NOW(), '$course->beginning', '$course->end', '', '', '', '', '', '', '', '', '', '', '', '', '', '')");
                     * $c_id=DB::getPdo()->lastInsertId();
                     * $contract=DB::select("SELECT * FROM contracts WHERE id='$c_id' LIMIT 1");
                     * $contract=collect($contract)->first();
                     *
                     * $c_id=\Contracts::instance()->course_contract($request, $contact, $contract_type, $contract, $coach);
                     */
                    // create contract END

                    // send email alert to dozent START
                    $name = $coach_data->name;
                    $email = $coach_data->email;
                    $from = env('MAIL_USERNAME');
                    $title = 'New course offer';
                    $title_url = 'View and Accept';
                    $url = url('course-offers');
                    $text = 'You have a new offer for course: <b>' . $course->title . '</b>. Login and accept now.';
                    $data2 = array(
                        'email' => $email,
                        'from' => $from,
                        'name' => $name,
                        'title' => $title,
                        'title_url' => $title_url,
                        'url' => $url,
                        'text' => $text
                    );
                    $exec_msg .= 'Email sent to coach ' . $email . ' <br/>';
                    Mail::send('emails.notification', $data2, function ($message) use ($email, $from, $name, $title) {
                        $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                        $message->to($email);
                        $message->subject($title);
                    });
                    // send email alert to dozent END
                }
            }
            $exec_msg .= 'Email sent to coaches <br/>';
            $request->session()->flash('success', $exec_msg . 'Appointments sent successfully to coaches.');

            return redirect('admin/course-appointments/' . $course->id);
        }

        if ($request->input('froms') != '') {
            $exec_msg .= 'Entering froms if block <br/>';
            $mis = '';
            $mis = $request->input('mis');
            $dozents = '';
            if ($request->input('coaches') != '')
                $dozents = implode(';', $request->input('coaches'));

            DB::update("UPDATE courses SET mis='$mis', dozents='$dozents' WHERE id='$course_id'");
            $exec_msg .= 'Updated mis, ' . $mis . ' dozents in courses <br/>';

            $course = DB::select("SELECT * FROM courses WHERE id='$course_id' LIMIT 1");
            $course = collect($course)->first();

            $beginning = '';
            $end = '';
            $period = addslashes($request->input('appointments_period'));
            if ($period != '') {
                $dates = explode(' - ', $period);
                $beginning = date_format(new DateTime($dates[0]), 'Y-m-d');
                $end = date_format(new DateTime($dates[1]), 'Y-m-d');
            }

            $classes_id = $request->input('classes_id');
            $classes = $request->input('classes');
            $froms = $request->input('froms');
            $tos = $request->input('tos');
            $ues = $request->input('ues');
            $breaks = $request->input('breaks');
            $notes = $request->input('notes');
            $rooms = $request->input('rooms');
            $doppelBuchung = ($request->input('doppelBuchung') !== null) ? $request->input('doppelBuchung') : "0";

            $row = DB::select("SELECT id FROM classes WHERE course_id='$course_id'");
            foreach ($row as $r) {
                if (! in_array($r->id, $classes_id))
                    DB::delete("DELETE FROM classes WHERE id='$r->id'");
            }
            $exec_msg .= 'Updated classes in lines 740 <br/>';

            for ($i = 0; $i < count($froms); $i ++) {
                if (isset($classes_id[$i]))
                    $id = $classes_id[$i];
                else
                    $id = '0';

                // $class=$classes[$i];
                $class = '';
                $day = '';
                if ($request->input('days')[$i] != '') {
                    $day = $request->input('days')[$i];
                }
                $from = $froms[$i];
                $to = '';
                $ue = $ues[$i];
                $break = $breaks[$i];
                $note = $notes[$i];
                $room = $rooms[$i];
                if ($room == "automatic")
                    $room = '';
                $mis = '';

                if ($id == '' or $id == '0')
                    DB::insert("INSERT INTO classes (course_id, name, day, fromm, ue, breaks, notes, room, beginning, end, mis,doppel_buchung) VALUES ('$course_id', '$class', '$day', '$from', '$ue', '$break', '$note', '$room', '$beginning', '$end', '$mis', '$doppelBuchung')");
                else {
                    DB::update("UPDATE classes SET name='$class', day='$day', fromm='$from', ue='$ue', breaks='$break', notes='$note', room='$room', beginning='$beginning', end='$end', mis='$mis', doppel_buchung='$doppelBuchung' WHERE id='$id'");
                }
                $exec_msg .= 'Inserted new classes <br/>';
            }

            // DB::delete("DELETE FROM appointments WHERE course_id='$course->id'");
            $exec_msg .= 'Calling create appointments for the course' . $course->id . ' <br/>';
            $response = $this->create_appointments($request, $course);
            $exec_msg .= $response;
            $exec_msg .= 'Finished create appointments <br/>';
            DB::update("UPDATE courses SET mis=NULL, dozents=NULL WHERE id='$course_id'");
            DB::update("UPDATE classes SET doppel_buchung=0 WHERE course_id='$course_id'");

            // DB::update("UPDATE courses SET mis='' WHERE id='$course_id'");

            //$request->session()->flash('success', $exec_msg . 'Appointments created successfully.');
            $request->session()->flash('success', 'Appointments created successfully.');

            return redirect('admin/course-appointments/' . $course->id);
            // return view('panel.course_appointments.index', ['title'=>$course->title.' | Appointments', 'course'=>$course, 'classes'=>$classes, 'rooms'=>$rooms, 'appointments'=>$appointments, 'total_students'=>$total_students, 'courses'=>$courses, 'lecturers'=>$lecturers]);
            return;
        }

        if ($request->input('contract_id') != '') {
            $contract_id = $request->input('contract_id');
            $contract = DB::select("SELECT * FROM contracts WHERE id='$contract_id' LIMIT 1");
            $contract = collect($contract)->first();

            $data = \Contacts::instance()->create_timetable_appointments($request, $contract->c_id, $contract->type, $contract, $contract->coach);
            return $data;
        }

        $classes = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT * FROM classes WHERE course_id='$course_id'");
        foreach ($row1 as $r1) {
            $classes[$i2]['class'] = $r1;

            $classes[$i2]['room'] = '';
            $row22 = DB::select("SELECT id, name, location FROM rooms WHERE id='$r1->room' LIMIT 1");
            if (count($row22) == 1) {
                $row22 = collect($row22)->first();
                $classes[$i2]['room'] = $row22->name;

                $row22 = DB::select("SELECT id, name FROM room_locations WHERE id='$row22->location' LIMIT 1");
                if (count($row22) == 1) {
                    $row22 = collect($row22)->first();
                    $classes[$i2]['room'] .= ' (' . $row22->name . ')';
                }
            }

            $i2 ++;
        }

        $rooms = array();
        $i = 0;
        $row = DB::select("SELECT id, name, location, capacity FROM rooms");
        foreach ($row as $r) {
            $rooms[$i]['room'] = $r;

            $rooms[$i]['location'] = '';
            $rooms[$i]['days'] = '';
            $row2 = DB::select("SELECT name FROM room_locations WHERE id='$r->location' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $rooms[$i]['location'] = $row2->name;
            }
            $row2 = DB::select("SELECT day FROM rooms_availability WHERE r_id='$r->id'");
            if (count($row2) != 0) {
                $i2 = 0;
                foreach ($row2 as $r2) {
                    if ($i2 ++ == 0)
                        $rooms[$i]['days'] = $r2->day;
                    else
                        $rooms[$i]['days'] .= ',' . $r2->day;
                }
            }

            $i ++;
        }

        $appointments = array();
        $added = array();
        $row = DB::select("SELECT * FROM appointments WHERE course_id='$course->id' /*AND status!='3'*/ AND type='2' ORDER BY date ASC");
        foreach ($row as $r) {
            $app = $r->course_id . ' - ' . $r->date . ' - ' . $r->time . ' - ' . $r->time_end . ' - ' . $r->room;
            if (! in_array($app, $added))
                $added[] = $app;
            else
                continue;

            $appointments[$i]['appointment'] = $r;

            $appointments[$i]['room'] = '';
            $appointments[$i]['location'] = '';

            $row2 = DB::select("SELECT name, location FROM rooms WHERE id='$r->room' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $appointments[$i]['room'] = $row2->name;

                $row2 = DB::select("SELECT name FROM room_locations WHERE id='$row2->location' LIMIT 1");
                if (count($row2) == 1) {
                    $row2 = collect($row2)->first();
                    $appointments[$i]['location'] = $row2->name;
                }
            }

            $appointments[$i]['coach'] = '';
            $row2 = DB::select("SELECT name, email FROM contacts WHERE id='$r->contact' LIMIT 1");
            if (count($row2) == 1) {
                $row2 = collect($row2)->first();
                $appointments[$i]['coach'] = $row2->name . '<!--<p style="color:#777;">' . $row2->email . '</p>-->';
            }

            $appointments[$i]['dozents'] = '';
            if ($r->dozents != "") {
                $row2 = DB::select("SELECT name FROM contacts WHERE id in (" . str_replace(";", ",", $r->dozents) . ") LIMIT 1");
                $dozents = "";
                foreach ($row2 as $r3) {
                    $dozents .= $r3->name . ', ';
                }
                $dozents = substr_replace($dozents, "", - 2);
                $appointments[$i]['dozents'] = $dozents;
            }

            $i ++;
        }

        // get all p/m/mi or the course
        $courses = array();
        $i = 0;
        $courses[$i]['total_cost'] = 0;
        $courses[$i]['total_lessons'] = 0;
        $products2 = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$course_id'");
        foreach ($row1 as $r1) {
            $row22 = DB::select("SELECT * FROM products WHERE id='$r1->p_id' LIMIT 1");
            if (count($row22) == 0)
                continue;
            $row22 = collect($row22)->first();
            $products2[$i2]['product'] = $row22;

            $products2[$i2]['total_cost'] = 0;
            $products2[$i2]['total_lessons'] = 0;

            $row2 = DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$course_id'");
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

                $row3 = DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$course_id'");
                $module_items = array();
                $k = 0;
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->i_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $row4 = collect($row4)->first();
                    // Check if this module item exists in Appointments. If the UE is fully booked, then do not add this MI
                    // if the UE is not fully booked, then the MI should be added, but lessons should be adjusted
                    $apptrow = DB::SELECT("SELECT sum(ue) ue FROM appointments WHERE status != 3 and course_id ='$course_id' AND item_id='$r3->i_id' LIMIT 1");
                    $apptlesson = 0;
                    if (count($apptrow) > 0) {
                        $apptrow = collect($apptrow)->first();
                        $apptlesson = $apptrow->ue;
                    }
                    if ($apptlesson >= $row4->lessons)
                        continue;
                    else
                        $row4->lessons -= $apptlesson;

                    $module_items[$k]['item'] = $row4;

                    $lessons = DB::select("SELECT lessons FROM contract_items WHERE course_id='$course_id' AND i_id='$r3->id' LIMIT 1");
                    if (count($lessons) == 1) {
                        $lessons = collect($lessons)->first();
                        $row4->lessons = $lessons->lessons;

                        $apptrow = DB::SELECT("SELECT sum(ue) ue FROM appointments WHERE status != 3 and course_id ='$course_id' AND item_id='$r3->i_id' LIMIT 1");
                        $apptlesson = 0;
                        if (count($apptrow) > 0) {
                            $apptrow = collect($apptrow)->first();
                            $apptlesson = $apptrow->ue;
                        }
                        if ($apptlesson >= $row4->lessons)
                            continue;
                        else
                            $row->lessons -= $apptlesson;

                        $lessons = $lessons->lessons;
                        $module_items[$k]['item'] = $row4;
                    } else
                        $lessons = $row4->lessons;

                    $courses[$i]['total_lessons'] += $lessons;
                    $courses[$i]['total_cost'] += $lessons * $row4->price_lessons;

                    $products2[$i2]['total_lessons'] += $lessons;
                    $products2[$i2]['total_cost'] += $lessons * $row4->price_lessons;

                    $modules[$j]['total_lessons'] += $lessons;
                    $modules[$j]['total_cost'] += $lessons * $row4->price_lessons;

                    $k ++;
                }
                $modules[$j]['items'] = $module_items;
                $j ++;
            }
            $products2[$i2]['modules'] = $modules;
            $i2 ++;
        }
        $courses[$i]['products'] = $products2;

        $students = DB::select("SELECT id FROM contracts WHERE course_id='$course_id'");
        $total_students = count($students);

        return view('panel.course_appointments.index', [
            'title' => $course->title . ' | Appointments',
            'course' => $course,
            'classes' => $classes,
            'rooms' => $rooms,
            'appointments' => $appointments,
            'total_students' => $total_students,
            'courses' => $courses,
            'lecturers' => $lecturers
        ]);
    }

    public function create_appointments(Request $request, $course)
    {
        $course = DB::select("SELECT * FROM courses WHERE id='$course->id' LIMIT 1");
        $course = collect($course)->first();

        $dozents = $course->dozents;

        $exec_msg = '';
        $classes = array();
        $i2 = 0;
        $row1 = DB::SELECT("SELECT * FROM classes WHERE course_id='$course->id'");
        // if room is assigned, update the room name
        foreach ($row1 as $r1) {
            $exec_msg .= "Performing room name update for all rooms found";
            $classes[$i2]['class'] = $r1;

            $beginning = $r1->beginning;
            $end = $r1->end;

            $classes[$i2]['room'] = '';
            $row22 = DB::select("SELECT id, name, location FROM rooms WHERE id='$r1->room' LIMIT 1");
            if (count($row22) == 1) {
                $exec_msg .= "Do room name update for room " . $r1->room;
                $row22 = collect($row22)->first();
                $classes[$i2]['room'] = $row22->name;

                $row22 = DB::select("SELECT id, name FROM room_locations WHERE id='$row22->location' LIMIT 1");
                if (count($row22) == 1) {
                    $row22 = collect($row22)->first();
                    $classes[$i2]['room'] .= ' (' . $row22->name . ')';
                }
            }

            $i2 ++;
        }
        $exec_msg .= " room name update done";

        // Find the total participants count
        // below logic is wrong. Dozent will be always just 1, although multiple dozents may be assigned to the course
        // Students count should be calculated based on respective MI
        $participants = 0;
        if ($course->coaches != '') {
            $c2 = array();
            $c2 = explode(';', $course->coaches);
            // $participants+=count($c2); We should not consider all the dozent. Only the accepting dozent will take the class
            $participants = 1;
            // echo count($c2); exit();
        }
        if ($course->students != '') {
            $c2 = array();
            $c2 = explode(';', $course->students);
            $stu = array();
            foreach ($c2 as $c) {
                if (! in_array($c, $stu))
                    $stu[] = $c;
            }
            $stu_c = implode(';', $stu);
            DB::update("UPDATE courses SET students='$stu_c' WHERE id='$course->id'");
            $c2 = $stu;
            $participants += count($c2);
            // echo count($c2); echo ' - '.$course->students; exit();
        }
        $exec_msg .= "Total Participants are " . $participants;

        // This is the total hours of the course
        $total_hours = 0;
        $row = DB::select("SELECT p_id, m_id, i_id FROM course_items WHERE c_id='$course->id'");
        foreach ($row as $r) {
            $row2 = DB::select("SELECT id, title, lessons FROM module_items WHERE id='$r->i_id' LIMIT 1");
            $row2 = collect($row2)->first();
            $total_hours += $row2->lessons;
        }
        $exec_msg .= "Total hours is " . $total_hours;

        $count = round($total_hours / 4);
        // Retrieve existing appoints (type = 3= deleted)
        $check = DB::select("SELECT id, status FROM appointments WHERE course_id='$course->id' AND status='3'");
        $count += count($check) + 150; // Ushaib: Why do u add 150 here?

        $days = array();
        $i = 0;
        $days_filter = '';
        $day_hours = array();
        // get all available days for the course
        if (! empty($classes)) {
            foreach ($classes as $class) {
                $days2 = explode(';', $class['class']->day);
                $time = date_format(new DateTime($class['class']->fromm), 'H:i');
                $timestamp = strtotime($time) + ($class['class']->ue * 45 * 60);
                $time_end = date('H:i', $timestamp);
                $class_id = $class['class']->id;
                DB::update("UPDATE classes SET too='$time_end' WHERE id='$class_id'");
                // $time_end=date_format(new DateTime($time_end),'H:i');
                $max_hours = 0;
                $time1 = strtotime($time);
                $time2 = strtotime($time_end);
                $max_hours = round(abs($time2 - $time1) / 3600, 2);

                foreach ($days2 as $dd2) {
                    if (! in_array($dd2, $days)) {
                        $days[] = $dd2;
                        if ($i ++ != 0)
                            $days_filter .= ',';

                        $day_hours[$dd2]['room'] = $class['class']->room;
                        $day_hours[$dd2]['mis'] = explode(';', $class['class']->mis);
                        $day_hours[$dd2]['hours'] = $max_hours;
                        $day_hours[$dd2]['time_start'] = $time;
                        $day_hours[$dd2]['time_end'] = $time_end;
                        $day_hours[$dd2]['doppel_buchung'] = $class['class']->doppel_buchung;
                        $day_hours[$dd2]['break'] = $class['class']->breaks;

                        if ($dd2 == 'Monday')
                            $days_filter .= 'MO';
                        else if ($dd2 == 'Tuesday')
                            $days_filter .= 'TU';
                        else if ($dd2 == 'Wednesday')
                            $days_filter .= 'WE';
                        else if ($dd2 == 'Thursday')
                            $days_filter .= 'TH';
                        else if ($dd2 == 'Friday')
                            $days_filter .= 'FR';
                        else if ($dd2 == 'Saturday')
                            $days_filter .= 'SA';
                        else if ($dd2 == 'Sunday')
                            $days_filter .= 'SU';
                    }
                }
            }
        }
        // Finished retrieving the dates for the selected days
        $exec_msg .= "//Finished retrieving the dates for the selected days";
        // $exec_msg .= json_encode($day_hours);

        // get all available dates for the days between beginning and end
        $app_dates = array();
        $app_dates2 = array();
        $startDate = new \DateTime($beginning);
        // $until=$course->end;
        $until = date_format(new DateTime($end), 'Y-m-d');
        $rule = new \Recurr\Rule('FREQ=WEEKLY;BYDAY=' . $days_filter, $startDate);

        $transformer = new \Recurr\Transformer\ArrayTransformer();

        $transformerConfig = new \Recurr\Transformer\ArrayTransformerConfig();
        $transformerConfig->enableLastDayOfMonthFix();
        $transformer->setConfig($transformerConfig);

        $t_date = date('Y-m-d');
        $constraint = new \Recurr\Transformer\Constraint\BeforeConstraint(new \DateTime($end . ' 00:00:00'), true);
        $results = $transformer->transform($rule, $constraint, null);

        $exec_msg .= json_encode($results);

        foreach ($results as $result) {
            $start = $result->getStart();
            $date = $start->format('Y-m-d');
            // $app_dates[$date]=array();
            $start_time = $start->format('H:i');
            $day = date_format(new DateTime($date), 'l');

            $check = DB::select("SELECT id FROM holidays WHERE (beginning<='$date' AND end>='$date') LIMIT 1");
            if (count($check) == 1)
                continue;

            $room = $day_hours[$day]['room'];
            $hours = $day_hours[$day]['hours'];
            $break = $day_hours[$day]['break'];
            $time_start = $day_hours[$day]['time_start'];
            $time_end = $day_hours[$day]['time_end'];
            $doppelBuchung = $day_hours[$day]['doppel_buchung'];

            if ($room == "") {
                // echo "SELECT r_id FROM rooms_availability WHERE day='$day' AND (from_time>='$time_start' AND (to_time<='$time_end' OR to_time>='$time_end')) LIMIT 1"; exit();
                $room_avl = DB::select("SELECT r_id FROM rooms_availability WHERE day='$day' AND ((from_time>='$time_start' OR from_time<='$time_start') AND to_time>='$time_end') AND capacity>='$participants' ORDER BY capacity ASC");
                if (count($room_avl) == 0) {
                    // echo "SELECT r_id FROM rooms_availability WHERE day='$day' AND ((from_time>='$time_start' OR from_time<='$time_start') AND to_time>='$time_end') AND capacity>='$participants' ORDER BY capacity ASC"; exit();
                    $request->session()->flash('error', 'No room available on ' . $day . ' from ' . $time_start . ' to ' . $time_end . ' for the capacity ' . $participants);
                    return redirect('admin/course-appointments/' . $course->id);
                }
                $room = 0;
                foreach ($room_avl as $check_room) {
                    // echo $check_room->id.'<br>';
                    // check if there is no appointment for the room
                    $check = DB::select("SELECT id FROM appointments WHERE status != 3 AND room='$check_room->r_id' AND date='$date' AND ((time>='$time_start' AND time_end<='$time_end') OR (time>='$time_start' AND time='$time_end') OR (time<='$time_start' AND time_end='$time_end') OR (time<='$time_start' AND time_end>'$time_start')) LIMIT 1");
                    if (count($check) == 0) {
                        $room = $check_room->r_id;
                        $exec_msg .= "Room " . $room . ' has been selected';
                        break;
                    }
                } // exit();
                if ($room == 0) {
                    /*
                     * $request->session()->flash('error', ' x No room available on '.$day.' from '.$time_start.' to '.$time_end . ' for the capacity ' . $participants);
                     * return redirect('admin/course-appointments/'.$course->id);
                     */
                    $request->session()->flash('error', 'No room available on ' . $date . ' from ' . $time_start . ' to ' . $time_end . ' for the capacity ' . $participants);
                    $exec_msg .= 'No room available on ' . $date . ' from ' . $time_start . ' to ' . $time_end . ' for the capacity ' . $participants;
                }
            }
            // $room_avl=collect($room_avl)->first();
            // $room=$room_avl->r_id;

            // remove the break from the total time available for the day
            $app_dates2[$date] = $time_start . ' - ' . $time_end . ' - ' . $break . ' - ' . $room . ' - ' . $doppelBuchung;

            $timestamp = strtotime($time_end) - $break * 60;
            $time_end = date('H:i', $timestamp);

            // get all available time slots for appointments of 45 minutes each
            for ($i = 1; $i <= $hours; $i ++) {
                $timestamp = strtotime($time_start) + 45 * 60;
                $time = date('H:i', $timestamp);

                if ($time > $time_end)
                    break;

                $app_dates[] = $date . ' ; ' . $time_start . ' - ' . $time . ' ; ' . $room;

                $time_start = $time;
            }

            // echo $date.'<< <br>';
        }

        // assign appointments for each availale day using max hours
        /*
         * foreach($app_dates as $slot)
         * {
         * //$day=date_format(new DateTime($date),'l');
         * //$hours=$day_hours[$day];
         *
         * //echo $slot.'<br>';
         * }
         */

        $exec_msg .= 'get all course items and create appointments for approval by coach';
        $app_time_start = '';
        $app_time_end = '';
        $coaches = explode(';', $course->dozents);
        $j = 0;
        $course_mis = array();
        if ($course->mis != '')
            $course_mis = explode(';', $course->mis);
        $row = DB::select("SELECT p_id, m_id, i_id FROM course_items WHERE c_id='$course->id'");
        foreach ($row as $r) {
            if (! in_array($r->i_id, $course_mis))
                continue;
            $row2 = DB::select("SELECT id, title FROM modules WHERE id='$r->m_id' LIMIT 1");
            $row2 = collect($row2)->first();
            $module_name = $row2->title;

            $row2 = DB::select("SELECT id, title, lessons FROM module_items WHERE id='$r->i_id' LIMIT 1");
            $row2 = collect($row2)->first();
            $lessons = $row2->lessons;

            $check = DB::select("SELECT ue FROM appointments WHERE status != 3 AND course_id='$course->id' AND product_id='$r->p_id' AND module_id='$r->m_id' AND item_id='$r->i_id'");
            foreach ($check as $ch) {
                $lessons -= $ch->ue;
            }
            if ($lessons <= 0)
                continue;
            $exec_msg .= "Left over UE for MI: " . $r->i_id . ' is ' . $lessons;

            $ue = 0;
            $exec_msg .= 'Lessons: ' . $lessons . '<br><br>';

            for ($i = 1; $i <= $lessons; $i ++) {
                // echo $i.'<br>';
                $old_i = $i;
                $ue = 0;
                foreach ($app_dates2 as $date => $time_period) {
                    if ($i > $lessons)
                        break;
                    $exec_msg .= 'Date: ' . $date . '<br>';
                    $exec_msg .= 'Time Period: ' . $time_period . '<br><br>'; // continue;
                    $data2 = explode(' - ', $time_period);
                    $time = $data2[0];
                    $time_end = $data2[1]; // echo $time_end.'<br>';
                    $break = $data2[2];
                    // if(!isset($data2[3])) { echo 'Time Period: '.$time_period.'<br><br>'; exit(); }
                    $room = $data2[3];
                    $doppelBuchung = $data2[4];

                    $app_time_start = $time;
                    $time_start = $time;
                    for (; $i <= $lessons; $i ++) {
                        // echo '$i='.$i.'<< DATE LOOP<br>';
                        $timestamp = strtotime($time_start) + 45 * 60;
                        $time_end2 = date('H:i', $timestamp);
                        // echo $time_end2.' - ';
                        if ($time_end2 >= $time_end) {
                            unset($app_dates2[$date]);
                        }

                        if ($time_end2 > $time_end) {
                            // $app_time_start=''; $app_time_end='';
                            $i --;
                            $timestamp = strtotime($time_start) - 45 * 60;
                            $time_end2 = date('H:i', $timestamp);
                            break;
                        }

                        $app_time_end = $time_end2;
                        $ue += 1;

                        $time_start = $app_time_end;
                        if ($time_start < $time_end)
                            $app_dates2[$date] = $time_start . ' - ' . $time_end . ' - ' . $break . ' - ' . $room;
                    }

                    // }
                    // exit();
                    if ($app_time_start == '' or $app_time_end == '')
                        continue;

                    $timestamp = strtotime($app_time_end) + ($break * 60);
                    $app_time_end = date('H:i', $timestamp);

                    // echo 'Create Appointment: '.$app_time_start.' - '.$app_time_end.'<br><br>';
                    // check if appointment already exists for the course on same date and time
                    if ($doppelBuchung == "0") {
                        $check = DB::select("SELECT id, status FROM appointments WHERE status != 3 AND course_id='$course->id' AND date='$date' AND ((time>='$app_time_start' AND time_end<='$app_time_end') OR (time>='$app_time_start' AND time_end>='$app_time_end')) LIMIT 1");

                        // ((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time_end>='$time_end') OR (time='$time' OR time_end='$time_end'))
                        // ('$time' BETWEEN time AND time_end) OR ('$time_end' BETWEEN time AND time_end)
                        if (count($check) == 1) {
                            $check = collect($check)->first();
                            if ($check->status == 3) {
                                unset($app_dates2[$date]);
                                $j ++;
                                $i ++;
                                // echo 'DELETED DATE > '.$date.' - '.$old_i.'<br><br>';
                                // $i=$old_i;
                                $ue = 0;
                                continue;
                                // break;
                            } else {
                                unset($app_dates2[$date]);
                                $j ++;
                                $i ++;
                                $ue = 0;
                                continue;
                                // break;
                            }
                        }
                    } else
                        $exec_msg .= "Doppelbuchung is set to 1";

                    $title = $module_name . ' > ' . $row2->title;
                    $exec_msg .= "Creating appointment in table ";
                    if ($room > 0)
                    {
                        //Find all the students of the course, product, m, mi - '$course->id', '$r->p_id', '$r->m_id', '$r->i_id'
                        $appt_form = $request->input('appointment_form');
                        if($appt_form == 'Please Select')
                            $appt_form = 'Unknown';
                        DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, type, ue, dozents, appointment_form) VALUES ('0', '$room', '$title', '', '0', '$date', '$app_time_start', '$app_time_end', '0', NOW(), '0', '0', '$course->id', '$r->p_id', '$r->m_id', '$r->i_id', '0', '2', '$ue', '$dozents','$appt_form')");
                    }
                    break;
                }
            }

            // exit();
        }
        return $exec_msg;
        /*
         * $app_time_start=''; $app_time_end='';
         * $coaches=explode(';', $course->coaches); $j=0;
         * $row=DB::select("SELECT p_id, m_id, i_id FROM course_items WHERE c_id='$course->id'");
         * foreach($row as $r)
         * {
         * $row2=DB::select("SELECT id, title FROM modules WHERE id='$r->m_id' LIMIT 1");
         * $row2=collect($row2)->first();
         * $module_name=$row2->title;
         *
         * $row2=DB::select("SELECT id, title, lessons FROM module_items WHERE id='$r->i_id' LIMIT 1");
         * $row2=collect($row2)->first();
         * $lessons=$row2->lessons;
         * $ue=0;
         * //echo 'Lessons: '.$lessons.'<br><br>';
         *
         * for($i=1; $i<=$lessons; $i++)
         * {
         * //echo $i.'<br>';
         * $old_i=$i;
         * $ue=0;
         * foreach($app_dates2 as $date=>$time_period)
         * {
         * if($i>$lessons) break;
         * //echo 'Date: '.$date.'<br>';
         * //echo 'Time Period: '.$time_period.'<br><br>'; //continue;
         * $data2=explode(' - ', $time_period);
         * $time=$data2[0];
         * $time_end=$data2[1]; //echo $time_end.'<br>';
         * $break=$data2[2];
         *
         * $app_time_start=$time;
         * $time_start=$time;
         * for(; $i<=$lessons; $i++)
         * {
         * //echo '$i='.$i.'<< DATE LOOP<br>';
         * $timestamp = strtotime($time_start) + 45*60;
         * $time_end2 = date('H:i', $timestamp);
         * //echo $time_end2.' - ';
         * if($time_end2>=$time_end)
         * {
         * unset($app_dates2[$date]);
         * }
         *
         * if($time_end2>$time_end)
         * {
         * //$app_time_start=''; $app_time_end='';
         * $i--;
         * $timestamp = strtotime($time_start) - 45*60;
         * $time_end2 = date('H:i', $timestamp);
         * break;
         * }
         *
         * $app_time_end=$time_end2;
         * $ue+=1;
         *
         * $time_start=$app_time_end;
         * if($time_start<$time_end)
         * $app_dates2[$date]=$time_start.' - '.$time_end.' - '.$break;
         * }
         *
         * //}
         * //exit();
         * if($app_time_start=='' OR $app_time_end=='') continue;
         *
         * $timestamp = strtotime($app_time_end) + ($break*60);
         * $app_time_end = date('H:i', $timestamp);
         *
         * //echo 'Create Appointment: '.$app_time_start.' - '.$app_time_end.'<br><br>';
         * //check if appointment already exists for the course on same date and time
         * $check=DB::select("SELECT id, status FROM appointments WHERE course_id='$course->id' AND date='$date' AND ((time>='$app_time_start' AND time_end<='$app_time_end') OR (time>='$app_time_start' AND time_end>='$app_time_end')) LIMIT 1");
         * //((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time_end>='$time_end') OR (time='$time' OR time_end='$time_end'))
         * //('$time' BETWEEN time AND time_end) OR ('$time_end' BETWEEN time AND time_end)
         * if(count($check)==1)
         * {
         * $check=collect($check)->first();
         * if($check->status==3)
         * {
         * unset($app_dates2[$date]);
         * $j++;
         * //echo 'DELETED DATE > '.$date.' - '.$old_i.'<br><br>';
         * //$i=$old_i;
         * $ue=0;
         * continue;
         * //break;
         * }
         * else
         * {
         * unset($app_dates2[$date]);
         * $j++; //$i++;
         * //echo 'ANOTHER APPOINTMENT > '.$date.' - '.$old_i.'<br><br>';
         * /*$check=DB::select("SELECT id, status FROM appointments WHERE course_id='$course->id' AND date='$date' AND product_id='$r->p_id' AND module_id='$r->m_id' AND item_id='$r->i_id' AND time='$app_time_start' AND time_end='$app_time_end' LIMIT 1");
         * if(count($check)==0)
         * {
         * $ue2=0;
         * $check=DB::select("SELECT id, ue FROM appointments WHERE course_id='$course->id' AND product_id='$r->p_id' AND module_id='$r->m_id' AND item_id='$r->i_id' AND status!='3'");
         * foreach($check as $ch2)
         * {
         * $ue2+=$ch2->ue;
         * }
         * if($ue2<$lessons)
         * $i=$old_i;
         * }*-/
         * $ue=0;
         * continue;
         * //break;
         * }
         * }
         *
         * $title=$module_name.' > '.$row2->title;
         * DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, type, ue) VALUES ('0', '$room', '$title', '', '0', '$date', '$app_time_start', '$app_time_end', '0', NOW(), '0', '0', '$course->id', '$r->p_id', '$r->m_id', '$r->i_id', '0', '2', '$ue')");
         * break;
         * }
         * }
         * //exit();
         *
         * //create appointment for each lesson
         * /*for($i=1; $i<=$lessons; $i++)
         * {
         * //echo $row2->title.' - ';
         * if(isset($app_dates[$j]))
         * {
         * $data2=explode(' ; ',$app_dates[$j]);
         * $date=$data2[0];
         * $room=$data2[2];
         * $data2=explode(' - ', $data2[1]);
         * $time=$data2[0];
         * $time_end=$data2[1];
         *
         * //check if appointment already exists for the course on same date and time
         * $check=DB::select("SELECT id, status FROM appointments WHERE course_id='$course->id' AND date='$date' AND ((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time_end>='$time_end')) LIMIT 1");
         * //((time>='$time' AND time_end<='$time_end') OR (time>='$time' AND time_end>='$time_end') OR (time='$time' OR time_end='$time_end'))
         * //('$time' BETWEEN time AND time_end) OR ('$time_end' BETWEEN time AND time_end)
         * if(count($check)==1)
         * {
         * $check=collect($check)->first();
         * if($check->status==3)
         * {
         * $j++;
         * continue;
         * }
         * else
         * {
         * $j++; $i++;
         * continue;
         * }
         * }
         *
         * //foreach($coaches as $coach)
         * //{
         * DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, type) VALUES ('0', '$room', '$row2->title', '', '0', '$date', '$time', '$time_end', '0', NOW(), '0', '0', '$course->id', '$r->p_id', '$r->m_id', '$r->i_id', '0', '2')");
         * //}
         *
         * $j++;
         * }
         * //echo '<br>';
         *
         * }*-/
         * }
         */

        // Above Insert code is repeated. So commenting it.
        /*
         * $check=DB::select("SELECT id, status, ue, product_id, module_id, item_id FROM appointments WHERE course_id='$course->id' AND status='3'");
         * foreach($check as $ch)
         * {
         * $row2=DB::select("SELECT id, title FROM modules WHERE id='$ch->module_id' LIMIT 1");
         * $row2=collect($row2)->first();
         * $module_name=$row2->title;
         *
         * $row2=DB::select("SELECT id, title, lessons FROM module_items WHERE id='$ch->item_id' LIMIT 1");
         * $row2=collect($row2)->first();
         * $lessons=$row2->lessons;
         * $ue=0;
         *
         * $check2=DB::select("SELECT ue FROM appointments WHERE course_id='$course->id' AND status!='3' AND product_id='$ch->product_id' AND module_id='$ch->module_id' AND item_id='$ch->item_id'");
         * $ue2=0;
         * foreach($check2 as $ch2)
         * {
         * $ue2+=$ch2->ue;
         * }
         *
         * if($ue2>=$lessons) continue;
         * $lessons=$lessons-$ue2;
         *
         * for($i=1; $i<=$lessons; $i++)
         * {
         * //echo $i.'<br>';
         * $old_i=$i;
         * $ue=0;
         * foreach($app_dates2 as $date=>$time_period)
         * {
         * if($i>$lessons) break;
         * //echo 'Date: '.$date.'<br>';
         * //echo 'Time Period: '.$time_period.'<br><br>'; //continue;
         * $data2=explode(' - ', $time_period);
         * $time=$data2[0];
         * $time_end=$data2[1]; //echo $time_end.'<br>';
         * $break=$data2[2];
         *
         * $app_time_start=$time;
         * $time_start=$time;
         * for(; $i<=$lessons; $i++)
         * {
         * //echo '$i='.$i.'<< DATE LOOP<br>';
         * $timestamp = strtotime($time_start) + 45*60;
         * $time_end2 = date('H:i', $timestamp);
         * //echo $time_end2.' - ';
         * if($time_end2>=$time_end)
         * {
         * unset($app_dates2[$date]);
         * }
         *
         * if($time_end2>$time_end)
         * {
         * //$app_time_start=''; $app_time_end='';
         * $i--;
         * $timestamp = strtotime($time_start) - 45*60;
         * $time_end2 = date('H:i', $timestamp);
         * break;
         * }
         *
         * $app_time_end=$time_end2;
         * $ue+=1;
         *
         * $time_start=$app_time_end;
         * if($time_start<$time_end)
         * $app_dates2[$date]=$time_start.' - '.$time_end.' - '.$break;
         * }
         *
         * //}
         * //exit();
         * if($app_time_start=='' OR $app_time_end=='') continue;
         *
         * $timestamp = strtotime($app_time_end) + ($break*60);
         * $app_time_end = date('H:i', $timestamp);
         *
         * //echo 'Create Appointment: '.$app_time_start.' - '.$app_time_end.'<br><br>';
         * //check if appointment already exists for the course on same date and time
         * $check=DB::select("SELECT id, status FROM appointments WHERE course_id='$course->id' AND date='$date' AND ((time>='$app_time_start' AND time_end<='$app_time_end') OR (time>='$app_time_start' AND time_end>='$app_time_end')) LIMIT 1");
         * //('$time' BETWEEN time AND time_end) OR ('$time_end' BETWEEN time AND time_end)
         * if(count($check)==1)
         * {
         * $check=collect($check)->first();
         * if($check->status==3)
         * {
         * unset($app_dates2[$date]);
         * $j++;
         * //echo 'DELETED DATE > '.$date.' - '.$old_i.'<br><br>';
         * $i=$old_i;
         * $ue=0;
         * continue;
         * //break;
         * }
         * else
         * {
         * unset($app_dates2[$date]);
         * $j++; //$i++;
         * //echo 'ANOTHER APPOINTMENT > '.$date.' - '.$old_i.'<br><br>';
         * $ue=0;
         * $i=$old_i;
         * continue;
         * //break;
         * }
         * }
         *
         * $title=$module_name.' > '.$row2->title;
         * DB::insert("INSERT INTO appointments (contact, room, title, description, recurring, date, time, time_end, added_by, added_on, parent, contract_id, course_id, product_id, module_id, item_id, status, type, ue) VALUES ('0', '$room', '$title', '', '0', '$date', '$app_time_start', '$app_time_end', '0', NOW(), '0', '0', '$course->id', '$ch->product_id', '$ch->module_id', '$ch->item_id', '0', '2', '$ue')");
         * break;
         * }
         * }
         * }
         * //exit();
         */
    }

    public function generate_appointments(Request $request)
    {
        $data = array();
        $data['success'] = 0;
        if ($request->input('contract_id') != '') {
            $contract_id = $request->input('contract_id');
            $contract = DB::select("SELECT * FROM contracts WHERE id='$contract_id' LIMIT 1");
            $contract = collect($contract)->first();

            $data = \Contacts::instance()->create_timetable_appointments($request, $contract->c_id, $contract->type, $contract, $contract->coach);
            return $data;
        }

        return response()->json($data);
    }

    public function delete_appointment(Request $request)
    {
        $data = array();
        $data['success'] = 0;
        if ($request->input('id') != '') {
            $id = $request->input('id');
            $app = DB::select("SELECT date, time, title, time_end, course_id, room, status, contact FROM appointments WHERE id='$id'");
            $app = collect($app)->first();

            if (($app->status == 0 || $app->status==4) || $app->contact == 0) { //Sent or Rejected can be permanently deleted
                DB::delete("DELETE FROM appointments WHERE id='$id'");
            } else {
                DB::update("UPDATE appointments SET status='3' WHERE id='$id'"); //Appointment is marked as cancelled
                DB::update("UPDATE appointments SET status='3' WHERE date='$app->date' AND title = '$app->title' AND time='$app->time' AND time_end='$app->time_end' AND course_id='$app->course_id' AND room='$app->room'");
            }

            $data['id'] = $id;
            $data['success'] = 1;
        }

        return response()->json($data);
    }

    public function manage_courses(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('delete') != '') {
            $id = addslashes($request->input('delete'));
            $type = addslashes($request->input('type'));

            DB::delete("DELETE FROM courses WHERE id='$id'");
            DB::delete("DELETE FROM appointments WHERE course_id='$id'");
            if ($type == 'Regular')
                return redirect('admin/regular-courses');
            else
                return redirect('admin/coaching-courses');
        }

        if ($request->input('title') != '') {
            $type = addslashes($request->input('type'));
            $title = addslashes($request->input('title'));
            $description = addslashes($request->input('description'));
            $coach = addslashes($request->input('coach'));
            $beginning = '';
            $end = '';
            $period = addslashes($request->input('period'));
            if ($period != '') {
                $dates = explode(' - ', $period);
                $beginning = date_format(new DateTime($dates[0]), 'Y-m-d');
            }

            $coaches = '';
            if ($request->input('coaches') != '')
                $coaches = implode(';', $request->input('coaches'));
            $students = '';
            if ($request->input('students') != '')
                $students = implode(';', $request->input('students'));

            DB::insert("INSERT INTO courses (title, description, added_by, added_on, coach, type, beginning, end, coaches, students) VALUES ('$title', '$description', '$admin_id', NOW(), '$coach', '$type', '$beginning', '$end', '$coaches', '$students')");
            $id = DB::getPdo()->lastInsertId();
            $c = $id;

            if ($type == 'Coaching') {
                $course = DB::select("SELECT id, title FROM courses WHERE id='$id' LIMIT 1");
                $course = collect($course)->first();
                foreach ($request->input('coaches') as $coach) {
                    $coach_data = DB::select("SELECT id, name, email FROM contacts WHERE id='$coach' LIMIT 1");
                    if (count($coach_data) == 0)
                        continue;
                    $coach_data = collect($coach_data)->first();

                    $check = DB::select("SELECT id FROM course_offers WHERE course_id='$course->id' AND coach='$coach' LIMIT 1");
                    if (count($check) == 0) {
                        DB::insert("INSERT INTO course_offers (course_id, coach, on_date) VALUES ('$course->id', '$coach', NOW())");

                        // send email alert to dozent START
                        $name = $coach_data->name;
                        $email = $coach_data->email;
                        $from = env('MAIL_USERNAME');
                        $title = 'New course offer';
                        $title_url = 'View and Accept';
                        $url = url('course-offers');
                        $text = 'You have a new offer for course: <b>' . $course->title . '</b>. Login and accept now.';
                        $data2 = array(
                            'email' => $email,
                            'from' => $from,
                            'name' => $name,
                            'title' => $title,
                            'title_url' => $title_url,
                            'url' => $url,
                            'text' => $text
                        );
                        Mail::send('emails.notification', $data2, function ($message) use ($email, $from, $name, $title) {
                            $message->from('info@nextlevel-akademie.de', 'NextLevel Akademie');
                            $message->to($email);
                            $message->subject($title);
                        });
                        // send email alert to dozent END
                    }
                }
            }

            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Created a course - #' . $id . ' ' . $name);
            // track Activity END

            $products_added = array();
            if ($request->input('students') != '') {
                foreach ($request->input('students') as $student) {
                    $row = DB::select("SELECT c_id, p_id FROM contact_products WHERE c_id='$student'");
                    foreach ($row as $r) {
                        $row22 = DB::select("SELECT * FROM products WHERE id='$r->p_id' LIMIT 1");
                        if (count($row22) == 0)
                            continue;
                        $row22 = collect($row22)->first();

                        if (in_array($r->p_id, $products_added))
                            continue;
                        $products_added[] = $r->p_id;

                        DB::insert("INSERT INTO course_products (c_id, p_id) VALUES ('$c', '$r->p_id')");

                        $row2 = DB::SELECT("SELECT id, m_id FROM product_modules WHERE p_id='$r->p_id'");
                        $modules = array();
                        $j = 0;
                        foreach ($row2 as $r2) {
                            $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->m_id' LIMIT 1");
                            if (count($row22) == 0)
                                continue;
                            $row22 = collect($row22)->first();

                            DB::insert("INSERT INTO course_modules (c_id, p_id, m_id) VALUES ('$c', '$r->p_id', '$row22->id')");

                            $row3 = DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r2->m_id'");
                            $module_items = array();
                            $k = 0;
                            foreach ($row3 as $r3) {
                                $row4 = DB::SELECT("SELECT * FROM module_items WHERE id='$r3->m_id' LIMIT 1");
                                if (count($row4) == 0)
                                    continue;
                                $row4 = collect($row4)->first();

                                DB::insert("INSERT INTO course_items (c_id, p_id, m_id, i_id) VALUES ('$c', '$r->p_id', '$r2->m_id', '$r3->m_id')");
                            }
                        }
                    }
                }
            }

            /*
             * if(!empty($request->input('products')))
             * {
             * foreach($request->input('products') as $p)
             * {
             * DB::insert("INSERT INTO course_products (c_id, p_id) VALUES ('$id', '$p')");
             *
             * if(!empty($request->input('modules'.$p)))
             * {
             * foreach($request->input('modules'.$p) as $m)
             * {
             * DB::insert("INSERT INTO course_modules (c_id, p_id, m_id) VALUES ('$id', '$p', '$m')");
             *
             * if(!empty($request->input('items'.$p)))
             * {
             * foreach($request->input('items'.$p) as $i)
             * {
             * DB::insert("INSERT INTO course_items (c_id, p_id, m_id, i_id) VALUES ('$id', '$p', '$m', '$i')");
             *
             * $lessons=$request->input('lessons'.$i);
             * DB::insert("INSERT INTO course_lessons (course_id, i_id, lessons) VALUES ('$c', '$i', '$lessons')");
             * }
             * }
             * }
             * }
             * }
             * }
             */

            if (! empty($request->input('classes'))) {
                $classes = $request->input('classes');
                $days = $request->input('days');
                $froms = $request->input('froms');
                $tos = $request->input('tos');
                $days = $request->input('days');
                $notes = $request->input('notes');
                $rooms = $request->input('rooms');
                for ($i = 0; $i < count($classes); $i ++) {
                    $class = addslashes($classes[$i]);
                    $from = addslashes($froms[$i]);
                    $to = addslashes($tos[$i]);
                    $day = addslashes($days[$i]);
                    $note = addslashes($notes[$i]);
                    $room = addslashes($rooms[$i]);

                    DB::insert("INSERT INTO classes (course_id, name, day, fromm, too, notes, room) VALUES ('$id' ,'$class', '$day', '$from', '$to', '$note', '$room')");
                }
            }

            $contract_type = 'Education Contract for Student';
            /*
             * if($request->input('students')!='')
             * {
             * foreach($request->input('students') as $student)
             * {
             * $contract=rand(pow(10, 4-1), pow(10, 4)-1).substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3).'.pdf';
             * DB::insert("INSERT INTO contracts (c_id, contract, type, coach, on_date, beginning, end) VALUES ('$student', '$contract', '$contract_type', '$coach', NOW(), '$beginning', '$end')");
             * $c_id=DB::getPdo()->lastInsertId();
             * $contract=DB::select("SELECT * FROM contracts WHERE id='$c_id' LIMIT 1");
             * $contract=collect($contract)->first();
             *
             * DB::delete("DELETE FROM contact_courses WHERE c_id='$student' AND contract_id='$c_id'");
             *
             * $course=DB::select("SELECT coach FROM courses WHERE id='$c' LIMIT 1");
             * $course=collect($course)->first();
             *
             * DB::insert("INSERT INTO contact_courses (c_id, course_id, contract_id) VALUES ('$student', '$c', '$c_id')");
             * $id2=DB::getPdo()->lastInsertId();
             *
             * $row1=DB::SELECT("SELECT id, p_id FROM course_products WHERE c_id='$c'");
             * foreach($row1 as $r1)
             * {
             *
             * $row2=DB::SELECT("SELECT id, m_id FROM course_modules WHERE p_id='$r1->p_id' AND c_id='$c'");
             * foreach($row2 as $r2)
             * {
             *
             * $row3=DB::SELECT("SELECT id, i_id FROM course_items WHERE m_id='$r2->m_id' AND c_id='$c'");
             * $module_items=array(); $k=0;
             * foreach($row3 as $r3)
             * {
             * $lessons=$request->input('lessons'.$r3->i_id);
             * //echo $lessons;
             * DB::insert("INSERT INTO contract_lessons (c_id, course_id, contract_id, i_id, lessons) VALUES ('$student', '$c', '$c_id', '$r3->id', '$lessons')");
             * }
             * }
             * }
             *
             * //$c_id=\Contacts::instance()->create_contract($request, $contract->c_id, $type, $contract, $coach);
             *
             * //\Contacts::instance()->create_timetable_appointments($request, $contract->c_id, $contract->type, $contract, $contract->coach);
             * }
             * }
             */

            if ($type == 'Regular')
                return redirect('admin/regular-courses');
            else
                return redirect('admin/coaching-courses');
        }
    }
}
