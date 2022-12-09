<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class meta_data extends Controller
{
    public function documents(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            
            $delete=addslashes($request->input('delete'));
            
            //track Activity START
            $row=DB::select("SELECT id, name FROM document_types WHERE id='$delete' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=$row->name;
            \CommonFunctions::instance()->log_activity($request, 'Deleted document type - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM document_types WHERE id='$delete'");
            $request->session()->flash('success', 'Document type has been deleted successfully.');
            
            return redirect('admin/documents');
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            
            DB::insert("INSERT INTO document_types (name, added_by, added_on) VALUES ('$name', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Added document type - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Successfully added.');
            return redirect('admin/documents');
        }
        
        $documents=DB::select("SELECT * FROM document_types");
        return view('panel.documents.index', ['title'=>trans('header.document_types'), 'sub_title'=>count($documents).' total document types', 'documents'=>$documents]);
    }
    
    public function edit_document_type(Request $request, $id)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            
            DB::update("UPDATE document_types SET name='$name' WHERE id='$id'");
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Updated document type - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Updated successfully.');
            return redirect('admin/documents');
        }
        
        $categories=DB::select("SELECT * FROM document_types WHERE id='$id' LIMIT 1");
        $category=collect($categories)->first();
        return view('panel.edit_document_type.index', ['title'=>'Edit Document Type', 'category'=>$category]);
    }
    
    public function referral_sources(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            
            $delete=addslashes($request->input('delete'));
            
            //track Activity START
            $row=DB::select("SELECT id, name FROM referral_sources WHERE id='$delete' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=$row->name;
            \CommonFunctions::instance()->log_activity($request, 'Deleted referral source - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM referral_sources WHERE id='$delete'");
            $request->session()->flash('success', 'Referral source has been deleted successfully.');
            
            return redirect('admin/referral-sources');
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            
            DB::insert("INSERT INTO referral_sources (name, added_by, added_on) VALUES ('$name', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Added referral source - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Successfully added.');
            return redirect('admin/referral-sources');
        }
        
        $sources=DB::select("SELECT * FROM referral_sources");
        return view('panel.referral_sources.index', ['title'=>trans('header.referral_sources'), 'sub_title'=>count($sources).' total referral sources', 'sources'=>$sources]);
    }
    
    public function calendar_categories(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            $delete=addslashes($request->input('delete'));
            
            //track Activity START
            $row=DB::select("SELECT id, name FROM calendar_categories WHERE id='$delete' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=$row->name;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a calendar category - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM calendar_categories WHERE id='$delete'");
            $request->session()->flash('success', 'Calendar category has been deleted successfully.');
            
            return redirect('admin/calendar-categories');
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $color=addslashes($request->input('color'));
            
            DB::insert("INSERT INTO calendar_categories (name, color, added_by, added_on) VALUES ('$name', '$color', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Created a calendar category - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Category has been added successfully.');
            return redirect('admin/calendar-categories');
        }
        
        $categories=DB::select("SELECT * FROM calendar_categories");
        return view('panel.calendar_categories.index', ['title'=>trans('header.calendar_categories'), 'sub_title'=>count($categories).' total calendar categories', 'categories'=>$categories]);
    }
    
    public function edit_calendar_category(Request $request, $id)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $color=addslashes($request->input('color'));
            
            DB::update("UPDATE calendar_categories SET name='$name', color='$color' WHERE id='$id'");
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Updated calendar category - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Category has been updated successfully.');
            return redirect('admin/edit-calendar-category/'.$id);
        }
        
        $categories=DB::select("SELECT * FROM calendar_categories WHERE id='$id' LIMIT 1");
        $category=collect($categories)->first();
        return view('panel.edit_calendar_category.index', ['title'=>'Edit calendar category', 'category'=>$category]);
    }
    
    public function teaching_methods(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            
            $delete=addslashes($request->input('delete'));
            
            //track Activity START
            $row=DB::select("SELECT id, name FROM teaching_methods WHERE id='$delete' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=$row->name;
            \CommonFunctions::instance()->log_activity($request, 'Deleted teaching method - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM teaching_methods WHERE id='$delete'");
            $request->session()->flash('success', 'Teaching Method has been deleted successfully.');
            
            return redirect('admin/teaching-methods');
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            
            DB::insert("INSERT INTO teaching_methods (name, added_by, added_on) VALUES ('$name', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Added teaching method - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Successfully added.');
            return redirect('admin/teaching-methods');
        }
        
        $teaching_methods=DB::select("SELECT * FROM teaching_methods");
        return view('panel.teaching_methods.index', ['title'=>trans('header.teaching_methods'), 'sub_title'=>count($teaching_methods).' total teaching methods', 'teaching_methods'=>$teaching_methods]);
    }
    
    public function edit_teaching_method(Request $request, $id)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            
            DB::update("UPDATE teaching_methods SET name='$name' WHERE id='$id'");
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Updated teaching method - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Updated successfully.');
            return redirect('admin/teaching-methods');
        }
        
        $teaching_method=DB::select("SELECT * FROM teaching_methods WHERE id='$id' LIMIT 1");
        $category=collect($teaching_method)->first();
        return view('panel.edit_teaching_method.index', ['title'=>'Edit Teaching Method', 'category'=>$category]);
    }
}
