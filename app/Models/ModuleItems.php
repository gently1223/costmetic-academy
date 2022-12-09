<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class ModuleItems extends Model
{
    protected $table = 'module_items';


    public static function getQuery(){

        DB::table('module_items')
                    ->select('customer_questionnaire.*',
                    'questionnaire_requester.name as requester_name',
                    'questionnaire_requester.image as requester_image',
                    'questionnaire_coordinator.name as coordinator_name',
                    'questionnaire_coordinator.image as coordinator_image',
                    'supervisor.name as supervisor_name',
                    'supervisor.image as supervisor_image',
                    'staff.name as staff_name',
                    'staff.image as staff_image',
                    'country.name_en as country_name',
                    'governorate.name_en as governorate_name',
                    'district.name_en as district_name',
                    'house_visit.hv_question_1',
                    'work_visit.wv_question_1',
                    'house_visit.hv_question_1 as house_customer_name',
                    'work_visit.wv_question_1 as work_customer_name',
                    'house_visit.hv_question_2 as house_adderss',
                    'work_visit.wv_question_5 as work_adderss',
                    'house_visit.hv_question_5 as house_phone',
                    'work_visit.wv_question_4 as work_phone',
                    'house_visit.hv_question_6 as house_mobile',
                    'work_visit.wv_question_3 as work_mobile')
                    ->leftjoin('modules_module_items', 'customer_questionnaire.requester_id', '=', 'questionnaire_requester.id');

    }
    
}
