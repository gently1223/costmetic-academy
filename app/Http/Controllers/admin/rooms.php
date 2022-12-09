<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class rooms extends Controller
{
    public function index(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            $delete=addslashes($request->input('delete'));
            
            //track Activity START
            $row=DB::select("SELECT id, name FROM rooms WHERE id='$delete' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=$row->name;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a room - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM rooms WHERE id='$delete'");
            $request->session()->flash('success', 'Room has been deleted successfully.');
            
            return redirect('admin/rooms');
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $capacity=addslashes($request->input('capacity'));
            $location=addslashes($request->input('location'));
            
            DB::insert("INSERT INTO rooms (name, capacity, location, added_by, added_on) VALUES ('$name', '$capacity', '$location', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Created a room - #'.$id.' '.$name);
            //track Activity END
            
            for($i=0; $i<count($request->input('days')); $i++)
            {
                $day=addslashes($request->input('days')[$i]);
                $from_time=addslashes($request->input('from_time')[$i]);
                $to_time=addslashes($request->input('to_time')[$i]);
                
                DB::insert("INSERT INTO rooms_availability (r_id, day, from_time, to_time) VALUES ('$id', '$day', '$from_time', '$to_time')");
            }
            
            return redirect('admin/rooms');
        }
        
        $rooms=array(); $i=0;
        $row=DB::select("SELECT * FROM rooms");
        foreach($row as $r)
        {
            $rooms[$i]['room']=$r;
            
            $row2=DB::SELECT("SELECT id, name FROM room_locations WHERE id='$r->location' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $rooms[$i]['location']=$row2;
            }
            else $rooms[$i]['location']='NA';
            
            $row2=DB::SELECT("SELECT day, from_time, to_time FROM rooms_availability WHERE r_id='$r->id'");
            $rooms[$i]['availability']=$row2;
            
            DB::update("UPDATE rooms_availability SET capacity='$r->capacity' WHERE r_id='$r->id'");
            
            $i++;
        }
        
        $locations=DB::select("SELECT id, name FROM room_locations");
        return view('panel.rooms.index', ['title'=>'Rooms', 'sub_title'=>count($rooms).' total rooms', 'locations'=>$locations, 'rooms'=>$rooms]);
    }
    
    public function edit_room(Request $request, $id)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            $capacity=addslashes($request->input('capacity'));
            $location=addslashes($request->input('location'));
            
            DB::update("UPDATE rooms SET name='$name', capacity='$capacity', location='$location' WHERE id='$id'");
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Updated a room - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM rooms_availability WHERE r_id='$id'");
            for($i=0; $i<count($request->input('days')); $i++)
            {
                $day=addslashes($request->input('days')[$i]);
                $from_time=addslashes($request->input('from_time')[$i]);
                $to_time=addslashes($request->input('to_time')[$i]);
                
                DB::insert("INSERT INTO rooms_availability (r_id, day, from_time, to_time, capacity) VALUES ('$id', '$day', '$from_time', '$to_time', '$capacity')");
            }
            
            return redirect('admin/edit-room/'.$id);
        }
        
        $rooms=array(); $i=0;
        $row=DB::select("SELECT * FROM rooms WHERE id='$id' LIMIT 1");
        foreach($row as $r)
        {
            $rooms[$i]['room']=$r;
            
            $row2=DB::SELECT("SELECT id, name FROM room_locations WHERE id='$r->location' LIMIT 1");
            if(count($row2)==1)
            {
                $row2=collect($row2)->first();
                $rooms[$i]['location']=$row2;
            }
            else $rooms[$i]['location']='NA';
            
            $row2=DB::SELECT("SELECT day, from_time, to_time FROM rooms_availability WHERE r_id='$r->id'");
            $rooms[$i]['availability']=$row2;
            
            $i++;
        }
        
        $locations=DB::select("SELECT id, name FROM room_locations");
        return view('panel.edit_room.index', ['title'=>'Edit Room', 'locations'=>$locations, 'rooms'=>$rooms]);
    }
    
    public function room_locations(Request $request)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('delete')!='')
        {
            $delete=addslashes($request->input('delete'));
            
            //track Activity START
            $row=DB::select("SELECT id, name FROM room_locations WHERE id='$delete' LIMIT 1");
            $row=collect($row)->first();
            $id=$row->id;
            $name=$row->name;
            \CommonFunctions::instance()->log_activity($request, 'Deleted a room location - #'.$id.' '.$name);
            //track Activity END
            
            DB::delete("DELETE FROM room_locations WHERE id='$delete'");
            $request->session()->flash('success', 'Room location has been deleted successfully.');
            
            return redirect('admin/room-locations');
        }
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            
            DB::insert("INSERT INTO room_locations (name, added_by, added_on) VALUES ('$name', '$admin_id', NOW())");
            $id=DB::getPdo()->lastInsertId();
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Created a room location - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Location has been added successfully.');
            return redirect('admin/room-locations');
        }
        
        $locations=DB::select("SELECT * FROM room_locations");
        return view('panel.room_locations.index', ['title'=>'Room Locations', 'sub_title'=>count($locations).' total room locations', 'locations'=>$locations]);
    }
    
    public function edit_room_location(Request $request, $id)
    {
        $admin_id=$request->session()->get('admin_id');
        
        if($request->input('name')!='')
        {
            $name=addslashes($request->input('name'));
            
            DB::update("UPDATE room_locations SET name='$name' WHERE id='$id'");
            
            //track Activity START
            \CommonFunctions::instance()->log_activity($request, 'Updated a room location - #'.$id.' '.$name);
            //track Activity END
            
            $request->session()->flash('success', 'Location has been updated successfully.');
            return redirect('admin/edit-room-location/'.$id);
        }
        
        $locations=DB::select("SELECT * FROM room_locations WHERE id='$id' LIMIT 1");
        $location=collect($locations)->first();
        return view('panel.edit_room_location.index', ['title'=>'Edit Room Location', 'location'=>$location]);
    }
}
