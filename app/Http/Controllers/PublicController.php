<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;
use Mail;
use App\Models\Attendance;
use App\Models\AttendanceAdditional;
use App\Models\AttendanceVerhalten;
use App\Models\Appointment;
use App\Models\Module;
use App\Models\ModuleItems;
use App\Models\ModuleItemServices;
use App\Models\Contact;
use App\Models\ModuleItemModuleItemServices;
use App\Models\TeachingMethod;
use PDF;
use PDFMerger;


class PublicController extends Controller
{

   public function tagesdokuStudent($id=""){
    $id = base64_decode($id);

        $attendance = Attendance::find($id);
        $attendance_additional = AttendanceAdditional::where('attendance_id','=',$attendance->id)->get()->first();
        $attendance_verhalten = AttendanceVerhalten::where('attendance_id','=',$attendance->id)->get()->first();
        $appointment = Appointment::find($attendance->appointment_id);
        $module_item = ModuleItems::find($appointment->item_id);
        $module_item_services = ModuleItemServices::getQuery()->where('module_item_module_item_services.mi_id','=',$appointment->item_id)->get();
        $data['appointment'] = $appointment;
        $data['module'] = Module::find($appointment->module_id);
        $data['module_item'] = $module_item;
        $data['module_item_services'] = $module_item_services;
        $data['coachee'] = Contact::select('id','name')->where('id','=',$attendance->student_id)->get()->first();
        $data['coach'] = Contact::select('id','name')->where('id','=',$attendance->teacher_id)->get()->first();
        $data['next_appointment'] = Appointment::where('course_id','=',$appointment->course_id)->where('date','>',$appointment->date)->where('status','=',1)->get()->first();
        $data['teaching_method_all'] = TeachingMethod::get();
        $data['attendance'] = $attendance;
        $data['attendance_verhalten'] = $attendance_verhalten;
        $data['attendance_additional'] = $attendance_additional;
        
        return view('tagesdoku_student',$data);
   }


   public function tagesdokuStudentStore(){

       $obj = Attendance::find(request()->input('id'));

       if (!empty(request()->input('sign2'))) {
            $signature2 = rand(pow(10, 4 - 1), pow(10, 4) - 1) . substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 3) . '.png';
            $img = str_replace('data:image/png;base64,', '', request()->input('sign2'));
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            if (file_put_contents("signatures/" . $signature2, $fileData)) {
               $obj->student_signature = $signature2;
            }
        }

        $obj->save();

        \UserAppointments::instance()->generateTagesdoku($obj->id);
        return redirect()->back();
   }


   

    
}
