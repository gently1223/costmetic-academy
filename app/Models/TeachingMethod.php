<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class TeachingMethod extends Model
{
    protected $table = 'teaching_methods';


    public static function getQuery(){

        return DB::table('module_item_services')
                    ->select('module_item_services.*')
                    ->leftjoin('module_item_module_item_services', 'module_item_module_item_services.mis_id', '=', 'module_item_services.id');

    }
    
}
