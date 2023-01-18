<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SceneActorLabResult extends Model
{
    use HasFactory;

    public function lab_order()
    {
      return $this->hasOne(SceneActorLabOrder::class, 'id', 'scene_actor_lab_order_id');
    }
    public function laboratory_test()
    {
      return $this->hasOne(LaboratoryTest::class, 'id', 'laboratory_test_id');
    }
    public function laboratory_norm()
    {
      $ret=$this->laboratory_test->laboratory_test_norms
          ->where('ltn_days_from','<=',$this->lab_order->scene_actor->sa_age)
          ->where('ltn_days_to','>=',$this->lab_order->scene_actor->sa_age)
          ->first()
          ;
      if ($this->lab_order->scene_actor->sa_actor_sex==2) // man
        { 
          $norm_min=number_format($ret->ltn_norm_m_min/$ret->ltn_decimal_prec,strlen($ret->ltn_decimal_prec)-1,',',' ');
          $norm_max=number_format($ret->ltn_norm_m_max/$ret->ltn_decimal_prec,strlen($ret->ltn_decimal_prec)-1,',',' ');
        }
      if ($this->lab_order->scene_actor->sa_actor_sex==3) // woman
        if ($this->lab_order->is_pregnant)
          { 
            $norm_min=number_format($ret->ltn_norm_p_min/$ret->ltn_decimal_prec,strlen($ret->ltn_decimal_prec)-1,',',' ');
            $norm_max=number_format($ret->ltn_norm_p_max/$ret->ltn_decimal_prec,strlen($ret->ltn_decimal_prec)-1,',',' ');
          }
        else
          { 
            $norm_min=number_format($ret->ltn_norm_w_min/$ret->ltn_decimal_prec,strlen($ret->ltn_decimal_prec)-1,',',' ');
            $norm_max=number_format($ret->ltn_norm_w_max/$ret->ltn_decimal_prec,strlen($ret->ltn_decimal_prec)-1,',',' ');
          }
      
      switch ($ret->ltn_norm_type)
        {
          case 1 : // mniej niż MAX
            $ret_norm = '< '.$norm_max;
            break;          
          case 2 : // mniej niż MAX lub równo
            $ret_norm = '≤ '.$norm_max;
            break; 
          case 3 : // zakres od do 
            $ret_norm = $norm_min.' ÷ '.$norm_max;
            break;
          case 4 : 
            $ret_norm = '≥ '.$norm_min;
            break;
          break;
          case 5 : 
            $ret_norm = '> '.$norm_min;
          break;
          case 6 : 
            $ret_norm = '';
          break;  
        }
      return $ret_norm;
    } // enc of public function laboratory_norm()

    public function laboratory_norm_row()
    {
      return $this->laboratory_test->laboratory_test_norms
              ->where('ltn_days_from','<=',$this->lab_order->scene_actor->sa_age)
              ->where('ltn_days_to','>=',$this->lab_order->scene_actor->sa_age)
              // ->get()
              ->first()
              ;
    } // end of public function laboratory_norm_row()

}
