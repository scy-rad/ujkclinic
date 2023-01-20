<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SceneActorLabResultTemplate extends Model
{
  protected $fillable = [
    'salot_id',
    'laboratory_test_id',
    'salr_result',
    'salr_resulttxt',
    'salr_addedtext',
    'salr_type'
    ];


  public function scene_lab_template()
    {
      return $this->hasOne(SceneActorLabOrderTemplate::class, 'id', 'salot_id');
    }
  public function laboratory_test()
    {
      return $this->hasOne(LaboratoryTest::class, 'id', 'laboratory_test_id');
    }

  public function name_of_type()
    {
      switch ($this->lrtr_type)
      {
        case '1': return ''; break;
        case '2': return 'Laboratory error'; break;
        case '3': return 'test unavailable'; break;
      }
    }
  static public function array_of_types()
    {
      $ret[1]['id']=1;
      $ret[1]['value']="wykonano";
      $ret[1]['txt']="";
      $ret[2]['id']=2;
      $ret[2]['value']="błąd";
      $ret[2]['txt']="Laboratory error";
      $ret[3]['id']=3;
      $ret[3]['value']="bad. niedostępne";
      $ret[3]['txt']="Test unavailable";

      return $ret;
     }

     public static function template_to_order($template_id, $order_id)
     {
      $test_tab=SceneActorLabResult::where('scene_actor_lab_order_id',$order_id)->pluck('laboratory_test_id');
      $rety = DB::table('scene_actor_lab_result_templates')
        ->leftJoin('laboratory_tests','scene_actor_lab_result_templates.laboratory_test_id','laboratory_tests.id')
        ->where('salot_id',$template_id)
        ->whereIn('laboratory_test_id',$test_tab)
        ->select('laboratory_test_id', 'lt_decimal_prec', 'salr_resulttxt', 'salr_addedtext', 'salr_type')
        ->addSelect(DB::raw('salr_result/lt_decimal_prec AS salr_result_dec'));

       return $rety->get();
     }
   
}
