<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTemplateResult extends Model
{
  protected $fillable = [
    'lab_template_id',
    'laboratory_test_id',	
    'lrtr_result',
    'lrtr_resulttxt',
    'lrtr_addedtext',	
    'lrtr_type',	
    'lrtr_sort',
  ];


  public function template()
    {
      return $this->hasOne(LabTemplate::class, 'id', 'lab_template_id');
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