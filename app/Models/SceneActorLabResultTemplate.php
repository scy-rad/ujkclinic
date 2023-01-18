<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
