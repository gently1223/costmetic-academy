<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use DB;

class products extends Controller
{

    public function p_m_mi_templates(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('delete') != '') {

            $delete = addslashes($request->input('delete'));

            // track Activity START
            $row = DB::select("SELECT id, title FROM p_m_mi_templates WHERE id='$delete' LIMIT 1");
            $row = collect($row)->first();
            $id = $row->id;
            $name = $row->title;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a P/M/MI template - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM p_m_mi_templates WHERE id='$delete'");
            $request->session()->flash('success', 'Template has been deleted successfully.');

            return redirect('admin/p-m-mi-templates');
        }

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $auth_no = addslashes($request->input('auth_no'));

            DB::insert("INSERT INTO p_m_mi_templates (title, auth_no, on_date) VALUES ('$title', '$auth_no', NOW())");
            $id = DB::getPdo()->lastInsertId();

            $p_ids = array();

            if ($request->input('products_selected') != '') {
                $array = explode(',', $request->input('products_selected'));
                foreach ($array as $a) {
                    if (! in_array($a, $p_ids))
                        $p_ids[] = $a;
                }
            }

            if (! empty($p_ids)) {
                foreach ($p_ids as $p) {
                    $flag = 0;
                    DB::insert("INSERT INTO p_m_mi_products (c_id, p_id) VALUES ('$id', '$p')");

                    $m_ids = array();
                    if ($request->input('modules' . $p) != '') {
                        foreach ($request->input('modules' . $p) as $m) {
                            $m_ids[] = $m;
                        }
                    }

                    if ($request->input('modules_selected_' . $p) != '' or ! empty($m_ids)) {
                        $flag = 1;
                        if ($request->input('modules_selected_' . $p) != '') {
                            $m_ids2 = explode(',', $request->input('modules_selected_' . $p));
                            foreach ($m_ids2 as $m) {
                                if (! in_array($m, $m_ids))
                                    $m_ids[] = $m;
                            }
                        }

                        foreach ($m_ids as $m) {
                            $flag2 = 0;
                            DB::insert("INSERT INTO p_m_mi_modules (c_id, p_id, m_id) VALUES ('$id', '$p', '$m')");

                            if (! empty($request->input('items' . $m))) {
                                foreach ($request->input('items' . $m) as $i) {
                                    $lessons = $request->input('lessons' . $i);
                                    $prices = $request->input('prices' . $i);
                                    DB::insert("INSERT INTO p_m_mi_items (c_id, p_id, m_id, i_id, lessons, price_lesson) VALUES ('$id', '$p', '$m', '$i', '$lessons', '$prices')");
                                    $flag2 = 1;
                                }
                            }

                            if ($flag2 == 0)
                                DB::delete("DELETE FROM p_m_mi_modules WHERE c_id='$id' AND p_id='$p' AND m_id='$m'");
                        }
                    }

                    if ($flag == 0)
                        DB::delete("DELETE FROM p_m_mi_products WHERE c_id='$id' AND p_id='$p'");
                }
            }

            return redirect('admin/p-m-mi-templates');
        }

        $data = array();
        $i = 0;
        $row = DB::select("SELECT id, title, on_date, auth_no FROM p_m_mi_templates ORDER BY id DESC");
        foreach ($row as $r) {
            $data[$i]['template'] = $r;

            $data[$i]['lessons'] = 0;
            $data[$i]['total_cost'] = 0;
            $row2 = DB::select("SELECT p_id FROM p_m_mi_products WHERE c_id='$r->id'");
            foreach ($row2 as $r2) {

                $row3 = DB::select("SELECT m_id FROM p_m_mi_modules WHERE c_id='$r->id' AND p_id='$r2->p_id'");
                foreach ($row3 as $r3) {

                    $row4 = DB::select("SELECT i_id, lessons, price_lesson FROM p_m_mi_items WHERE c_id='$r->id' AND p_id='$r2->p_id' AND m_id='$r3->m_id'");
                    foreach ($row4 as $r4) {
                        $data[$i]['lessons'] += $r4->lessons;
                        $data[$i]['total_cost'] += $r4->lessons * $r4->price_lesson;
                    }
                }
            }

            $i ++;
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
        return view('panel.p_m_mi_templates.index', [
            'title' => 'P/M/MI Templates',
            'data' => $data,
            'products' => $products
        ]);
    }

    public function edit_p_m_mi_templates(Request $request, $id)
    {
        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $auth_no = addslashes($request->input('auth_no'));

            DB::update("UPDATE p_m_mi_templates SET title='$title', auth_no='$auth_no' WHERE id='$id'");
            DB::delete("DELETE FROM p_m_mi_products WHERE c_id='$id'");
            DB::delete("DELETE FROM p_m_mi_modules WHERE c_id='$id'");
            DB::delete("DELETE FROM p_m_mi_items WHERE c_id='$id'");

            $p_ids = array();

            if ($request->input('products_selected') != '') {
                $array = explode(',', $request->input('products_selected'));
                foreach ($array as $a) {
                    if (! in_array($a, $p_ids))
                        $p_ids[] = $a;
                }
            }

            if (! empty($p_ids)) {
                foreach ($p_ids as $p) {
                    $flag = 0;
                    DB::insert("INSERT INTO p_m_mi_products (c_id, p_id) VALUES ('$id', '$p')");

                    $m_ids = array();
                    if ($request->input('modules' . $p) != '') {
                        foreach ($request->input('modules' . $p) as $m) {
                            $m_ids[] = $m;
                        }
                    }

                    if ($request->input('modules_selected_' . $p) != '' or ! empty($m_ids)) {
                        $flag = 1;
                        if ($request->input('modules_selected_' . $p) != '') {
                            $m_ids2 = explode(',', $request->input('modules_selected_' . $p));
                            foreach ($m_ids2 as $m) {
                                if (! in_array($m, $m_ids))
                                    $m_ids[] = $m;
                            }
                        }

                        foreach ($m_ids as $m) {
                            $flag2 = 0;
                            DB::insert("INSERT INTO p_m_mi_modules (c_id, p_id, m_id) VALUES ('$id', '$p', '$m')");

                            if (! empty($request->input('items' . $m))) {
                                foreach ($request->input('items' . $m) as $i) {
                                    $lessons = $request->input('lessons' . $i);
                                    $prices = $request->input('prices' . $i);
                                    DB::insert("INSERT INTO p_m_mi_items (c_id, p_id, m_id, i_id, lessons, price_lesson) VALUES ('$id', '$p', '$m', '$i', '$lessons', '$prices')");
                                    $flag2 = 1;
                                }
                            }

                            if ($flag2 == 0)
                                DB::delete("DELETE FROM p_m_mi_modules WHERE c_id='$id' AND p_id='$p' AND m_id='$m'");
                        }
                    }

                    if ($flag == 0)
                        DB::delete("DELETE FROM p_m_mi_products WHERE c_id='$id' AND p_id='$p'");
                }
            }

            return redirect('admin/edit-p-m-mi-template/' . $id);
        }

        $data = array();
        $i = 0;
        $row = DB::select("SELECT * FROM p_m_mi_templates WHERE id='$id'");
        foreach ($row as $r) {
            $data[$i]['template'] = $r;

            $data[$i]['lessons'] = 0;
            $data[$i]['total_cost'] = 0;
            $p_ids = array();
            $p_ids['pids'] = array();
            $row2 = DB::select("SELECT p_id FROM p_m_mi_products WHERE c_id='$r->id'");
            foreach ($row2 as $r2) {
                $p_ids['pids'][] = $r2->p_id;
                $p_ids['mids' . $r2->p_id] = array();

                $p_ids['total_costP' . $r2->p_id] = 0;
                $p_ids['total_lessonsP' . $r2->p_id] = 0;

                $row3 = DB::select("SELECT m_id FROM p_m_mi_modules WHERE c_id='$r->id' AND p_id='$r2->p_id'");
                foreach ($row3 as $r3) {
                    $p_ids['mids' . $r2->p_id][] = $r3->m_id;
                    $p_ids['iids' . $r3->m_id] = array();
                    $p_ids['iid_prices' . $r3->m_id] = array();
                    $p_ids['total_cost' . $r3->m_id] = 0;
                    $p_ids['total_lessons' . $r3->m_id] = 0;
                    $row4 = DB::select("SELECT i_id, lessons, price_lesson FROM p_m_mi_items WHERE c_id='$r->id' AND p_id='$r2->p_id' AND m_id='$r3->m_id'");
                    foreach ($row4 as $r4) {
                        $p_ids['iids' . $r3->m_id][] = $r4->i_id;
                        $p_ids['iid_prices' . $r3->m_id]['price' . $r4->i_id] = $r4->price_lesson;
                        $p_ids['iid_prices' . $r3->m_id]['lessons' . $r4->i_id] = $r4->lessons;

                        $p_ids['total_costP' . $r2->p_id] += $r4->lessons * $r4->price_lesson;
                        $p_ids['total_lessonsP' . $r2->p_id] += $r4->lessons;

                        $p_ids['total_cost' . $r3->m_id] += $r4->lessons * $r4->price_lesson;
                        $p_ids['total_lessons' . $r3->m_id] += $r4->lessons;
                    }
                }
            }
            $data[$i]['p_m_mi'] = $p_ids;

            $i ++;
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
        return view('panel.edit_p_m_mi_template.index', [
            'title' => 'Edit P/M/MI Template',
            'data' => $data,
            'products' => $products
        ]);
    }

    public function index(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('delete') != '') {

            $delete = addslashes($request->input('delete'));

            // track Activity START
            $row = DB::select("SELECT id, title FROM products WHERE id='$delete' LIMIT 1");
            $row = collect($row)->first();
            $id = $row->id;
            $name = $row->title;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a product - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM products WHERE id='$delete'");
            $request->session()->flash('success', 'Product has been deleted successfully.');

            return redirect('admin/products');
        }

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $auth_no = addslashes($request->input('auth_no'));
            $category = addslashes($request->input('category'));
            $period = addslashes($request->input('daterange'));
            $price = addslashes($request->input('price'));
            $max_hours = addslashes($request->input('max_hours'));
            $total_cost = addslashes($request->input('total_cost'));
            $description = addslashes($request->input('description'));

            $dates = explode(' - ', $period);
            $d = explode('/', $dates[0]);
            $period_start = $d[2] . '-' . $d[1] . '-' . $d[0];
            $d = explode('/', $dates[1]);
            $period_end = $d[2] . '-' . $d[1] . '-' . $d[0];

            DB::insert("INSERT INTO products (title, auth_no, category, period_start, period_end, price, max_hours, total_cost, description, added_by, added_on) VALUES ('$title', '$auth_no', '$category', '$period_start', '$period_end', '$price', '$max_hours', '$total_cost', '$description', '$admin_id', NOW())");
            $id = DB::getPdo()->lastInsertId();

            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Created a product - #' . $id . ' ' . $name);
            // track Activity END

            if (! empty($request->input('modules'))) {
                foreach ($request->input('modules') as $m_id) {
                    DB::insert("INSERT INTO product_modules (p_id, m_id) VALUES ('$id', '$m_id')");
                }
            }

            $request->session()->flash('success', 'Product has been added successfully.');
            return redirect('admin/products');
        }

        $products = array();
        $i = 0;
        $row = DB::select("SELECT * FROM products");
        foreach ($row as $r) {
            $products[$i]['product'] = $r;

            $max_hours = 0;
            $products[$i]['total_cost'] = 0;
            $products[$i]['total_hours'] = 0;
            $row2 = DB::SELECT("SELECT id, m_id FROM product_modules WHERE p_id='$r->id'");
            $products[$i]['product_modules'] = 0;
            foreach ($row2 as $r2) {
                $row3 = DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r2->m_id'");
                $max_lessons = 0;
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT lessons, price_lessons FROM module_items WHERE id='$r3->m_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $products[$i]['product_modules'] += 1;
                    $row4 = collect($row4)->first();
                    $products[$i]['total_cost'] += $row4->lessons * $row4->price_lessons;
                    $products[$i]['total_hours'] += $row4->lessons;
                    $max_lessons += $row4->lessons;
                    $max_hours += $row4->lessons;
                }

                $row3 = DB::select("SELECT max_lessons FROM modules WHERE id='$r2->m_id' LIMIT 1");
                if (count($row3) == 1) {
                    $row3 = collect($row3)->first();
                    if ($row3->max_lessons < $max_lessons)
                        DB::update("UPDATE modules SET max_lessons='$max_lessons' WHERE id='$r2->m_id'");
                }
            }

            if ($r->max_hours < $max_hours) {
                DB::update("UPDATE products SET max_hours='$max_hours' WHERE id='$r->id'");
                $r->max_hours = $max_hours;
                $products[$i]['product'] = $r;
            }

            $i ++;
        }

        $categories = DB::select("SELECT id, name FROM product_categories ORDER BY name ASC");
        $modules = array();
        $i = 0;
        $row = DB::select("SELECT id, title, lessons, price_lessons FROM modules ORDER BY title ASC");
        foreach ($row as $r) {
            $modules[$i]['module'] = $r;

            $modules[$i]['lessons'] = 0;
            $modules[$i]['total_cost'] = 0;
            $row3 = DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r->id'");
            foreach ($row3 as $r3) {
                $row4 = DB::SELECT("SELECT lessons, price_lessons FROM module_items WHERE id='$r3->m_id' LIMIT 1");
                if (count($row4) == 0)
                    continue;
                $row4 = collect($row4)->first();
                $modules[$i]['lessons'] += $row4->lessons;
                $modules[$i]['total_cost'] += $row4->lessons * $row4->price_lessons;
            }

            $i ++;
        }
        return view('panel.products.index', [
            'title' => trans('header.all_products'),
            'sub_title' => count($products) . ' total products',
            'products' => $products,
            'categories' => $categories,
            'modules' => $modules
        ]);
    }

    public function edit_product(Request $request, $id)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $auth_no = addslashes($request->input('auth_no'));
            $category = addslashes($request->input('category'));
            $period = addslashes($request->input('daterange'));
            $price = addslashes($request->input('price'));
            $max_hours = addslashes($request->input('max_hours'));
            $total_cost = addslashes($request->input('total_cost'));
            $description = addslashes($request->input('description'));

            $dates = explode(' - ', $period);
            $d = explode('/', $dates[0]);
            $period_start = $d[2] . '-' . $d[1] . '-' . $d[0];
            $d = explode('/', $dates[1]);
            $period_end = $d[2] . '-' . $d[1] . '-' . $d[0];
            // $period_start=date_format(new DateTime($dates[0]),'Y-m-d');
            // $period_end=date_format(new DateTime($dates[1]),'Y-m-d');

            DB::update("UPDATE products SET title='$title', category='$category', period_start='$period_start', period_end='$period_end', price='$price', max_hours='$max_hours', total_cost='$total_cost', description='$description', auth_no='$auth_no' WHERE id='$id'");

            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Updated a product - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM product_modules WHERE p_id='$id'");
            if (! empty($request->input('modules'))) {
                foreach ($request->input('modules') as $m_id) {
                    DB::insert("INSERT INTO product_modules (p_id, m_id) VALUES ('$id', '$m_id')");
                }
            }

            $request->session()->flash('success', 'Product has been updated successfully.');
            return redirect('admin/edit-product/' . $id);
        }

        $products = array();
        $i = 0;
        $row = DB::select("SELECT * FROM products WHERE id='$id' LIMIT 1");
        foreach ($row as $r) {
            $products[$i]['product'] = $r;

            $products[$i]['total_cost'] = 0;
            $products[$i]['lessons'] = 0;
            $modules = array();
            $j = 0;
            $row2 = DB::SELECT("SELECT id, m_id FROM product_modules WHERE p_id='$r->id'");
            $products[$i]['product_modules'] = $row2;
            foreach ($row2 as $r2) {
                $row22 = DB::select("SELECT * FROM modules WHERE id='$r2->m_id'");
                if (count($row22) == 0)
                    continue;
                $row22 = collect($row22)->first();
                $modules[$j]['module'] = $row22;
                $modules[$j]['lessons'] = 0;
                $modules[$j]['total_cost'] = 0;
                $row3 = DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r2->m_id'");
                foreach ($row3 as $r3) {
                    $row4 = DB::SELECT("SELECT lessons, price_lessons FROM module_items WHERE id='$r3->m_id' LIMIT 1");
                    if (count($row4) == 0)
                        continue;
                    $row4 = collect($row4)->first();
                    $products[$i]['lessons'] += $row4->lessons;
                    $products[$i]['total_cost'] += $row4->lessons * $row4->price_lessons;
                    $modules[$j]['lessons'] += $row4->lessons;
                    $modules[$j]['total_cost'] += $row4->lessons * $row4->price_lessons;
                }
                $j ++;
            }
            $products[$i]['modules'] = $modules;

            $i ++;
        }

        $categories = DB::select("SELECT id, name FROM product_categories ORDER BY name ASC");
        $modules = array();
        $i = 0;
        $row = DB::select("SELECT id, title, lessons, price_lessons FROM modules ORDER BY title ASC");
        foreach ($row as $r) {
            $modules[$i]['module'] = $r;

            $modules[$i]['lessons'] = 0;
            $modules[$i]['total_cost'] = 0;
            $row3 = DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r->id'");
            foreach ($row3 as $r3) {
                $row4 = DB::SELECT("SELECT lessons, price_lessons FROM module_items WHERE id='$r3->m_id' LIMIT 1");
                if (count($row4) == 0)
                    continue;
                $row4 = collect($row4)->first();
                $modules[$i]['lessons'] += $row4->lessons;
                $modules[$i]['total_cost'] += $row4->lessons * $row4->price_lessons;
            }

            $i ++;
        }
        return view('panel.edit_product.index', [
            'title' => 'Edit Product',
            'products' => $products,
            'categories' => $categories,
            'modules' => $modules
        ]);
    }

    public function modules(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('delete') != '') {
            $delete = addslashes($request->input('delete'));

            // track Activity START
            $row = DB::select("SELECT id, title FROM modules WHERE id='$delete' LIMIT 1");
            $row = collect($row)->first();
            $id = $row->id;
            $name = $row->title;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a module - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM modules WHERE id='$delete'");
            $request->session()->flash('success', 'Module has been deleted successfully.');

            return redirect('admin/modules');
        }

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $description = addslashes($request->input('description'));
            $lessons = addslashes($request->input('lessons'));
            $price_lesson = addslashes($request->input('price_lesson'));
            $max_lessons = addslashes($request->input('max_lessons'));
            $auth_no = addslashes($request->input('auth_no'));

            DB::insert("INSERT INTO modules (title, description, lessons, price_lessons, max_lessons, auth_no, added_by, added_on) VALUES ('$title', '$description', '$lessons', '$price_lesson', '$max_lessons', '$auth_no', '$admin_id', NOW())");
            $id = DB::getPdo()->lastInsertId();

            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Created a module - #' . $id . ' ' . $name);
            // track Activity END

            if (! empty($request->input('module_items'))) {
                foreach ($request->input('module_items') as $m_id) {
                    DB::insert("INSERT INTO modules_module_items (p_id, m_id) VALUES ('$id', '$m_id')");
                }
            }

            $request->session()->flash('success', 'Module has been added successfully.');
            return redirect('admin/modules');
        }

        $modules = array();
        $i = 0;
        $row = DB::select("SELECT * FROM modules");
        foreach ($row as $r) {
            $modules[$i]['module'] = $r;

            $modules[$i]['total_cost'] = 0;
            $modules[$i]['module_items'] = 0;
            $modules[$i]['lessons'] = 0;
            $row2 = DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r->id'");
            foreach ($row2 as $r2) {
                $row3 = DB::SELECT("SELECT lessons, price_lessons FROM module_items WHERE id='$r2->m_id' LIMIT 1");
                if (count($row3) == 0)
                    continue;
                $modules[$i]['module_items'] += 1;
                $row3 = collect($row3)->first();
                $modules[$i]['total_cost'] += $row3->lessons * $row3->price_lessons;
                $modules[$i]['lessons'] += $row3->lessons;
            }

            $i ++;
        }

        $module_items = DB::select("SELECT id, title, lessons, price_lessons FROM module_items ORDER BY title ASC");
        return view('panel.modules.index', [
            'title' => 'Modules',
            'sub_title' => count($modules) . ' total modules',
            'modules' => $modules,
            'module_items' => $module_items
        ]);
    }

    public function edit_module(Request $request, $id)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $description = addslashes($request->input('description'));
            $lessons = addslashes($request->input('lessons'));
            $price_lessons = addslashes($request->input('price_lesson'));
            $max_lessons = addslashes($request->input('max_lessons'));
            $auth_no = addslashes($request->input('auth_no'));

            DB::insert("UPDATE modules SET title='$title', description='$description', lessons='$lessons', price_lessons='$price_lessons', max_lessons='$max_lessons', auth_no='$auth_no' WHERE id='$id'");
            $id = DB::getPdo()->lastInsertId();

            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Updated a module - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM modules_module_items WHERE p_id='$id'");
            if (! empty($request->input('module_items'))) {
                foreach ($request->input('module_items') as $m_id) {
                    DB::insert("INSERT INTO modules_module_items (p_id, m_id) VALUES ('$id', '$m_id')");
                }
            }

            $request->session()->flash('success', 'Module has been updated successfully.');
            return redirect('admin/edit-module/' . $id);
        }

        $modules = array();
        $i = 0;
        $row = DB::select("SELECT * FROM modules WHERE id='$id' LIMIT 1");
        foreach ($row as $r) {
            $modules[$i]['module'] = $r;

            $modules[$i]['lessons'] = 0;
            $modules[$i]['total_cost'] = 0;
            $row2 = DB::SELECT("SELECT id, m_id FROM modules_module_items WHERE p_id='$r->id'");
            $module_items = array();
            $j = 0;
            foreach ($row2 as $r2) {
                $row3 = DB::SELECT("SELECT * FROM module_items WHERE id='$r2->m_id' LIMIT 1");
                if (count($row3) == 0)
                    continue;
                $row3 = collect($row3)->first();
                $module_items[$j]['item'] = $row3;
                $modules[$i]['total_cost'] += $row3->lessons * $row3->price_lessons;
                $modules[$i]['lessons'] += $row3->lessons;

                $j ++;
            }

            $modules[$i]['module_items'] = $module_items;

            $i ++;
        }

        $module_items = DB::select("SELECT id, title, lessons, price_lessons FROM module_items ORDER BY title ASC");
        return view('panel.edit_module.index', [
            'title' => 'Edit Module',
            'modules' => $modules,
            'module_items' => $module_items
        ]);
    }

    public function module_items(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('delete') != '') {
            $delete = addslashes($request->input('delete'));

            // track Activity START
            $row = DB::select("SELECT id, title FROM module_items WHERE id='$delete' LIMIT 1");
            $row = collect($row)->first();
            $id = $row->id;
            $name = $row->title;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a module item - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM module_items WHERE id='$delete'");
            $request->session()->flash('success', 'Module Item has been deleted successfully.');

            return redirect('admin/module-items');
        }

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $auth_no = addslashes($request->input('auth_no'));
            $description = addslashes($request->input('description'));
            $lessons = addslashes($request->input('lessons'));
            $price_lesson = addslashes($request->input('price_lesson'));

            DB::insert("INSERT INTO module_items (title, auth_no, description, lessons, price_lessons, added_by, added_on) VALUES ('$title', '$auth_no', '$description', '$lessons', '$price_lesson', '$admin_id', NOW())");
            $id = DB::getPdo()->lastInsertId();

            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Created a module item - #' . $id . ' ' . $name);
            // track Activity END

            $request->session()->flash('success', 'Module item has been added successfully.');
            return redirect('admin/module-items');
        }

        $modules = DB::select("SELECT * FROM module_items");
        return view('panel.module_items.index', [
            'title' => 'Module Items',
            'sub_title' => count($modules) . ' total module items',
            'modules' => $modules
        ]);
    }

    public function edit_module_item(Request $request, $id)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $auth_no = addslashes($request->input('auth_no'));
            $description = addslashes($request->input('description'));
            $lessons = addslashes($request->input('lessons'));
            $price_lesson = addslashes($request->input('price_lesson'));

            DB::update("UPDATE module_items SET title='$title', auth_no='$auth_no', description='$description', lessons='$lessons', price_lessons='$price_lesson' WHERE id='$id'");

            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Updated a module item - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM module_item_module_item_services WHERE mi_id='$id'");
            if (! empty($request->input('module_items'))) {
                foreach ($request->input('module_items') as $mis_id) {
                    DB::insert("INSERT INTO module_item_module_item_services (mi_id, mis_id) VALUES ('$id', '$mis_id')");
                }
            }
            
            $request->session()->flash('success', 'Module item has been updated successfully.');
            return redirect('admin/edit-module-item/' . $id);
        }
       
        $modules = array();
        $i = 0;
        $row = DB::select("SELECT * FROM module_items WHERE id='$id' LIMIT 1");
        foreach ($row as $r) {
            $modules[$i]['module'] = $r;
            
            $row2 = DB::SELECT("SELECT id, mis_id FROM module_item_module_item_services WHERE mi_id='$r->id'");
            $module_items = array();
            $j = 0;
            foreach ($row2 as $r2) {
                $row3 = DB::SELECT("SELECT * FROM module_item_services WHERE id='$r2->mis_id' LIMIT 1");
                if (count($row3) == 0)
                    continue;
                    $row3 = collect($row3)->first();
                    $module_items[$j]['item'] = $row3;
                    $j ++;
            }
            
            $modules[$i]['module_item_services'] = $module_items;
            
            $i ++;
        }
        
        
        
        
        $module_item_services = DB::select("SELECT id, title, daily_documentation_text, endreport_documentation_text FROM module_item_services ORDER BY title ASC");
        
        return view('panel.edit_module_item.index', [
            'title' => 'Edit Module Item',
            'modules' => $modules,
            'module_item_services'  => $module_item_services
        ]);
    }

    public function product_categories(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('delete') != '') {
            $delete = addslashes($request->input('delete'));

            // track Activity START
            $row = DB::select("SELECT id, name FROM product_categories WHERE id='$delete' LIMIT 1");
            $row = collect($row)->first();
            $id = $row->id;
            $name = $row->name;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a product category - #' . $id . ' ' . $name);
            // track Activity END

            DB::delete("DELETE FROM product_categories WHERE id='$delete'");
            $request->session()->flash('success', 'Category has been deleted successfully.');

            return redirect('admin/product-categories');
        }

        if ($request->input('name') != '') {
            $name = addslashes($request->input('name'));

            DB::insert("INSERT INTO product_categories (name, added_by, added_on) VALUES ('$name', '$admin_id', NOW())");
            $id = DB::getPdo()->lastInsertId();

            // track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Created a product category - #' . $id . ' ' . $name);
            // track Activity END

            $request->session()->flash('success', 'Category has been added successfully.');
            return redirect('admin/product-categories');
        }

        $categories = DB::select("SELECT * FROM product_categories");
        return view('panel.product_categories.index', [
            'title' => 'Product Categories',
            'sub_title' => count($categories) . ' total prodcut categories',
            'categories' => $categories
        ]);
    }

    public function edit_product_category(Request $request, $id)
    {
        $admin_id = $request->session()->get('admin_id');

        if ($request->input('name') != '') {
            $name = addslashes($request->input('name'));

            DB::update("UPDATE product_categories SET name='$name' WHERE id='$id'");

            // track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Updated a product category - #' . $id . ' ' . $name);
            // track Activity END

            $request->session()->flash('success', 'Category has been updated successfully.');
            return redirect('admin/edit-product-category/' . $id);
        }

        $categories = DB::select("SELECT * FROM product_categories WHERE id='$id' LIMIT 1");
        $category = collect($categories)->first();
        return view('panel.edit_product_category.index', [
            'title' => 'Edit Product Category',
            'category' => $category
        ]);
    }

    public function fetch_products(Request $request)
    {
        $data = array();
        $data['options'] = '';

        $products = DB::select("SELECT id, title FROM products");
        if (! empty($products)) {
            foreach ($products as $product) {
                $data['options'] .= '<option value="' . $product->id . '">' . $product->title . '</option>';
            }
        }

        $data['success'] = 1;
        return response()->json($data);
    }

    public function fetch_funding(Request $request)
    {
        $data = array();
        $data['options'] = '';

        $products = DB::select("SELECT id, name FROM funding_sources");
        if (! empty($products)) {
            foreach ($products as $product) {
                $data['options'] .= '<option value="' . $product->id . '">' . $product->name . '</option>';
            }
        }

        $data['success'] = 1;
        return response()->json($data);
    }

    public function fetch_data_xlsx(Request $request)
    {
        $msg = '';
        $admin_id = $request->session()->get('admin_id');
        $admin_type = $request->session()->get('admin_type');

        $rules = array(
            'file' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        // process the form
        if ($validator->fails()) {
            return Redirect::to('admin/import-data')->withErrors($validator);
        } else {
            try {

                $row = 0;
                $reader_toArray = array();

                $indexs = array(
                    'typ',
                    'kategorie',
                    'name',
                    'bewilligungszeitraum_von',
                    'bewilligungszeitraum_bis',
                    'tagesdoku_text',
                    'abschlussbericht_text',
                    'beschreibung',
                    'massnahmennummer',
                    'maximale_unterrichteinheiten',
                    'unterrichteinheiten',
                    'preis_pro_ue',
                    'obergruppe',

                    // add_on
                    

                );
                if (($handle = fopen($request->file('file'), "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                        if ($row == 0) {

                            $row ++;

                            continue;
                        }

                        $num = count($data);

                        for ($c = 0; $c < $num; $c ++) {

                            $reader_toArray[$row][$indexs[$c]] = $data[$c];
                        }

                        $row ++;
                    }
                    fclose($handle);
                }

                // Run this loop separately for Products, Modules & Module Items

                // Inserting or updating products
                $products_array = array();
                $total_cost = 0;
                foreach ($reader_toArray as $row) {
                    // var_dump($row); exit();
                    $type = $row['typ'];
                    $category = $row['kategorie'];
                    $title = $row['name'];
                    $description = $row['beschreibung'];
                    $auth_no = $row['massnahmennummer'];
                    $max_hours = $row['maximale_unterrichteinheiten'];
                    $lessons = $row['unterrichteinheiten'];
                    $price_lesson = $row['preis_pro_ue'];
                    $period_start = $row['bewilligungszeitraum_von'];
                    $period_end = $row['bewilligungszeitraum_bis'];
                    $parent = $row['obergruppe'];

                    if ($type == 'Product') {
                        if ($period_start != '') {
                            // && $period_end != '') {
                            $d = explode('.', $period_start);
                            if (sizeof($d))
                                $period_start = $d[2] . '-' . $d[1] . '-' . $d[0];
                            else
                                $period_start = '';
                        } else {
                            $period_start = '';
                        }

                        if ($period_end != '') {
                            // && $period_end != '') {
                            $d = explode('.', $period_end);
                            if (sizeof($d))
                                $period_end = $d[2] . '-' . $d[1] . '-' . $d[0];
                            else
                                $period_end = '';
                        } else {
                            $period_end = '';
                        }

                        $check = DB::select("SELECT id FROM products WHERE title='$title' and auth_no='$auth_no'  ORDER BY id DESC LIMIT 1");
                        if (count($check) == 1) {
                            $check = collect($check)->first();
                            $id = $check->id;
                            $products_array[] = $id;
                            DB::update("UPDATE products SET auth_no='$auth_no', category='$category', period_start='$period_start', period_end='$period_end', price='$price_lesson', max_hours='$max_hours', total_cost='$total_cost', description='$description' WHERE id='$id'");
                        } else {
                            DB::insert("INSERT INTO products (title, auth_no, category, period_start, period_end, price, max_hours, total_cost, description, added_by, added_on) VALUES ('$title', '$auth_no', '$category', '$period_start', '$period_end', '$price_lesson', '$max_hours', '$total_cost', '$description', '', NOW())");
                            $id = DB::getPdo()->lastInsertId();
                            $products_array[] = $id;
                        }
                    }
                }

                // Inserting or updating all modules
                $modules_array = array();
                foreach ($reader_toArray as $row) {
                    // var_dump($row); exit();
                    $type = $row['typ'];
                    $category = $row['kategorie'];
                    $title = $row['name'];
                    $description = $row['beschreibung'];
                    $auth_no = $row['massnahmennummer'];
                    $max_hours = $row['maximale_unterrichteinheiten'];
                    $lessons = $row['unterrichteinheiten'];
                    $price_lesson = $row['preis_pro_ue'];
                    $period_start = $row['bewilligungszeitraum_von'];
                    $period_end = $row['bewilligungszeitraum_bis'];
                    $parent = $row['obergruppe'];

                    if ($type == 'Module') {

                        // Check if this module exists for the given obergruppe ($parent)
                        if ($parent != '') {
                            $product_ids = implode(",", $products_array);
                            $p_id = DB::select("SELECT id, max_hours FROM products WHERE title='$parent' and id in (" . $product_ids . ") ORDER BY id DESC LIMIT 1");
                            if (count($p_id) == 1) {
                                $p_id = collect($p_id)->first();
                                $p_id = $p_id->id;

                                // check if the module exists. If yes, check if it belongs to the same parent
                                $check = DB::select("SELECT id FROM modules WHERE title='$title' ORDER BY id DESC LIMIT 1");
                                if (count($check) == 1) {
                                    $check = collect($check)->first();
                                    $m_id = $check->id;

                                    $check2 = DB::select("SELECT id, p_id, m_id FROM product_modules WHERE p_id='$p_id' AND m_id='$m_id' LIMIT 1");
                                    if (count($check2) == 1) {
                                        $pm_record = collect($check2)->first();
                                        $pm_id = $pm_record->id;
                                        $p_id = $pm_record->p_id;
                                        $m_id = $pm_record->m_id;
                                        DB::update("UPDATE modules SET lessons='$lessons', price_lessons='$price_lesson', max_lessons='$max_hours', auth_no='$auth_no', description='$description' WHERE id='$m_id'");
                                        $modules_array[] = $m_id;
                                    } else {
                                        // The module we found doesn't belong to this product. so create a new one
                                        DB::insert("INSERT INTO modules (title, description, lessons, price_lessons, max_lessons, auth_no, added_by, added_on) VALUES ('$title', '$description', '$lessons', '$price_lesson', '$max_hours', '$auth_no', '', NOW())");
                                        $m_id = DB::getPdo()->lastInsertId();
                                        $modules_array[] = $m_id;
                                        DB::insert("INSERT INTO product_modules (p_id, m_id) VALUES ('$p_id', '$m_id')");
                                    }
                                } else {
                                    // create the new module & the product_modules records
                                    DB::insert("INSERT INTO modules (title, description, lessons, price_lessons, max_lessons, auth_no, added_by, added_on) VALUES ('$title', '$description', '$lessons', '$price_lesson', '$max_hours', '$auth_no', '', NOW())");
                                    $m_id = DB::getPdo()->lastInsertId();
                                    $modules_array[] = $m_id;
                                    DB::insert("INSERT INTO product_modules (p_id, m_id) VALUES ('$p_id', '$m_id')");
                                }
                            }
                        }
                    }
                }

                // Inserting or updating all moduleitems
                $moduleitems_array = array();
                foreach ($reader_toArray as $row) {
                    // var_dump($row); exit();
                    $type = $row['typ'];
                    $category = $row['kategorie'];
                    $title = $row['name'];
                    $description = $row['beschreibung'];
                    $auth_no = $row['massnahmennummer'];
                    $max_hours = $row['maximale_unterrichteinheiten'];
                    $lessons = $row['unterrichteinheiten'];
                    $price_lesson = $row['preis_pro_ue'];
                    $period_start = $row['bewilligungszeitraum_von'];
                    $period_end = $row['bewilligungszeitraum_bis'];
                    $parent = $row['obergruppe'];

                    if ($type == 'ModuleItem') {

                        // Check if this module_item exists for the given obergruppe ($parent) module
                        if ($parent != '') {
                            $module_ids = implode(",", $modules_array);
                            $m_id = DB::select("SELECT id FROM modules WHERE title='$parent' and id in (" . $module_ids . ") ORDER BY id DESC LIMIT 1");
                            if (count($m_id) == 1) {
                                $m_id = collect($m_id)->first();
                                $m_id = $m_id->id;

                                // check if the module exists. If yes, check if it belongs to the same parent
                                $check = DB::select("SELECT id FROM module_items WHERE title='$title' ORDER BY id DESC LIMIT 1");
                                if (count($check) == 1) {
                                    $check = collect($check)->first();
                                    $mi_id = $check->id;

                                    $check2 = DB::select("SELECT id, p_id, m_id FROM modules_module_items WHERE p_id='$m_id' AND m_id='$mi_id' LIMIT 1");
                                    if (count($check2) == 1) {
                                        $pm_record = collect($check2)->first();
                                        $pm_id = $pm_record->id;
                                        $m_id = $pm_record->p_id;
                                        $mi_id = $pm_record->m_id;
                                        DB::update("UPDATE module_items SET auth_no='$auth_no', lessons='$lessons', price_lessons='$price_lesson', description='$description' WHERE id='$mi_id'");
                                        $moduleitems_array[] = $mi_id;
                                    } else {
                                        // The module we found doesn't belong to this product. so create a new one
                                        DB::insert("INSERT INTO module_items (title, auth_no, description, lessons, price_lessons, added_by, added_on) VALUES ('$title', '$auth_no', '$description', '$lessons', '$price_lesson', '', NOW())");
                                        $mi_id = DB::getPdo()->lastInsertId();
                                        $moduleitems_array[] = $mi_id;
                                        DB::insert("INSERT INTO modules_module_items (p_id, m_id) VALUES ('$m_id', '$mi_id')");
                                        
                                    }
                                } else {
                                    // create the new module & the product_modules records
                                    DB::insert("INSERT INTO module_items (title, auth_no, description, lessons, price_lessons, added_by, added_on) VALUES ('$title', '$auth_no', '$description', '$lessons', '$price_lesson', '', NOW())");
                                    $mi_id = DB::getPdo()->lastInsertId();
                                    $moduleitems_array[] = $mi_id;
                                    DB::insert("INSERT INTO modules_module_items (p_id, m_id) VALUES ('$m_id', '$mi_id')");
                                    
                                }
                            }
                        }
                    }
                }
                
                // Inserting or updating all moduleitemservices
                foreach ($reader_toArray as $row) {
                    // var_dump($row); exit();
                    $type = $row['typ'];
                    $title = $row['name']; //must be unique
                    $daily_documentation_text = $row['tagesdoku_text']; //daily_documentation_text
                    $endreport_documentation_text = $row['abschlussbericht_text']; //endreport_documentation_text
                    $parent = $row['obergruppe'];
                    
                    if ($type == 'ModuleItemService') {
                        
                        // Check if this module_item_service exists for the given obergruppe ($parent) module_item
                        if ($parent != '') {
                            $moduleitem_ids = implode(",", $moduleitems_array);
                            $mi_id = DB::select("SELECT id FROM module_items WHERE title='$parent' and id in (" . $moduleitem_ids . ") ORDER BY id DESC LIMIT 1");
                            if (count($mi_id) == 1) {
                                $mi_id = collect($mi_id)->first();
                                $mi_id = $mi_id->id;
                                
                                // check if the module_item_service exists. If yes, check if it belongs to the same parent
                                $check = DB::select("SELECT id FROM module_item_services WHERE title='$title' ORDER BY id DESC LIMIT 1");
                                if (count($check) == 1) {
                                    $check = collect($check)->first();
                                    $mis_id = $check->id;
                                    
                                    $check2 = DB::select("SELECT id, mi_id, mis_id FROM module_item_module_item_services WHERE mi_id='$mi_id' AND mis_id='$mis_id' LIMIT 1");
                                    if (count($check2) == 1) {
                                        $pm_record = collect($check2)->first();
                                        $pm_id = $pm_record->id;
                                        $mi_id = $pm_record->mi_id;
                                        $mis_id = $pm_record->mis_id;
                                        DB::update("UPDATE module_item_services SET daily_documentation_text='$daily_documentation_text', endreport_documentation_text='$endreport_documentation_text' WHERE id='$mis_id'");
                                    } else {
                                        // The module we found doesn't belong to this product. so create a new one
                                        DB::insert("INSERT INTO module_item_services (title, daily_documentation_text, endreport_documentation_text, added_by, added_on) VALUES ('$title', '$daily_documentation_text', '$endreport_documentation_text', '', NOW())");
                                        $mis_id = DB::getPdo()->lastInsertId();
                                        
                                        DB::insert("INSERT INTO module_item_module_item_services (mi_id, mis_id) VALUES ('$mi_id', '$mis_id')");
                                    }
                                } else {
                                    // create the new module & the product_modules records
                                    DB::insert("INSERT INTO module_item_services (title, daily_documentation_text, endreport_documentation_text, added_by, added_on) VALUES ('$title', '$daily_documentation_text', '$endreport_documentation_text', '', NOW())");
                                    $mis_id = DB::getPdo()->lastInsertId();
                                    
                                    DB::insert("INSERT INTO module_item_module_item_services (mi_id, mis_id) VALUES ('$mi_id', '$mis_id')");
                                }
                            }
                        }
                    }
                }
                
                $msg .= 'Data has been imported successfully.';
                $request->session()->flash('success', $msg);
                return redirect('admin/products');
            } catch (\Exception $e) {
                // Session::flash('error', $e->getMessage());
                echo $e->getMessage();
                exit();
                return redirect('admin/import-data');
            }
        }

        /*
         * Excel::load('file.xlsx', function ($reader) {
         *
         * });
         * exit();
         */

        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

            $path = $request->file->getRealPath();
            $data = Excel::load($path, function ($reader) {})->get();
            if (! empty($data) && $data->count()) {

                foreach ($data as $key => $value) {
                    $insert[] = [
                        'name' => $value->name,
                        'email' => $value->email,
                        'phone' => $value->phone
                    ];
                }

                if (! empty($insert)) {

                    $insertData = DB::table('students')->insert($insert);
                    if ($insertData) {
                        Session::flash('success', 'Your Data has successfully imported');
                    } else {
                        Session::flash('error', 'Error inserting the data..');
                        return back();
                    }
                }
            }
        }

        $rules = array(
            'file' => 'required',
            'num_records' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        // process the form
        if ($validator->fails()) {
            return Redirect::to('customer-upload')->withErrors($validator);
        } else {
            try {
                Excel::load(Input::file('file'), function ($reader) {

                    foreach ($reader->toArray() as $row) {
                        User::firstOrCreate($row);
                    }
                });

                return redirect(route('users.index'));
            } catch (\Exception $e) {
                // Session::flash('error', $e->getMessage());
                return redirect(route('users.index'));
            }
        }
    }
    
    public function module_item_services(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');
        
        if ($request->input('delete') != '') {
            $delete = addslashes($request->input('delete'));
            
            // track Activity START
            $row = DB::select("SELECT id, title FROM module_item_services WHERE id='$delete' LIMIT 1");
            $row = collect($row)->first();
            $id = $row->id;
            $name = $row->title;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a module item service - #' . $id . ' ' . $name);
            // track Activity END
            
            DB::delete("DELETE FROM module_item_services WHERE id='$delete'");
            $request->session()->flash('success', 'Module Item Leistung has been deleted successfully.');
            
            return redirect('admin/module-item-services');
        }
        
        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $daily_documentation_text = addslashes($request->input('daily_documentation_text'));
            $endreport_documentation_text = addslashes($request->input('endreport_documentation_text'));
            
            
            DB::insert("INSERT INTO module_item_services (title, daily_documentation_text, endreport_documentation_text, added_by, added_on) VALUES ('$title', '$daily_documentation_text', '$endreport_documentation_text', '$admin_id', NOW())");
            $id = DB::getPdo()->lastInsertId();
            
            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Created a module item service - #' . $id . ' ' . $name);
            // track Activity END
            
            $request->session()->flash('success', 'Module item leistung has been added successfully.');
            return redirect('admin/module-item-services');
        }
        
        $module_item_services = DB::select("SELECT * FROM module_item_services");
        return view('panel.module_item_services.index', [
            'title' => 'Module Item Leistungen',
            'sub_title' => count($module_item_services) . ' total module item services',
            'module_item_services' => $module_item_services
        ]);
    }
    
    public function edit_module_item_service(Request $request, $id)
    {
        $admin_id = $request->session()->get('admin_id');
        
        if ($request->input('title') != '') {
            $title = addslashes($request->input('title'));
            $daily_documentation_text = addslashes($request->input('daily_documentation_text'));
            $endreport_documentation_text = addslashes($request->input('endreport_documentation_text'));
            
            DB::update("UPDATE module_item_services SET title='$title', daily_documentation_text='$daily_documentation_text', endreport_documentation_text='$endreport_documentation_text' WHERE id='$id'");
            
            // track Activity START
            $name = $title;
            \CommonFunctions::instance()->log_activity($request, 'Updated a module item service - #' . $id . ' ' . $name);
            // track Activity END
            
            $request->session()->flash('success', 'Module item leistung has been updated successfully.');
            return redirect('admin/edit-module-item-service/' . $id);
        }
        
        $modules = DB::select("SELECT * FROM module_item_services WHERE id='$id' LIMIT 1");
        $item = collect($modules)->first();
        return view('panel.edit_module_item_service.index', [
            'title' => 'Edit Module Item Leistung',
            'item' => $item
        ]);
    }
    
}
