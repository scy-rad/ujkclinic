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
    public function name_of_type()
    {
      switch ($this->salr_type)
      {
        case '1': return ''; break;
        case '2': return 'Laboratory error'; break;
        case '3': return 'test unavailable'; break;
      }
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
          $norm_min=$ret->ltn_norm_m_min;
          $norm_max=$ret->ltn_norm_m_max;
        }
      if ($this->lab_order->scene_actor->sa_actor_sex==3) // woman
        if ($this->lab_order->is_pregnant)
          {
            $norm_min=$ret->ltn_norm_p_min;
            $norm_max=$ret->ltn_norm_p_max;
          }
        else
          {
            $norm_min=$ret->ltn_norm_w_min;
            $norm_max=$ret->ltn_norm_w_max;
          }

      $norm_decimal = $ret->laboratory_test->lt_decimal_prec;
      $ret_norm['HL']="";
      
      switch ($ret->ltn_norm_type)
        {
          case 1 : // mniej niż MAX
            $ret_norm['range'] = '< '.number_format($norm_max/$norm_decimal,strlen($norm_decimal)-1,',',' ');
            if ($this->salr_result >= $norm_max)
              $ret_norm['HL']="H";
            break;          
          case 2 : // mniej niż MAX lub równo
            $ret_norm['range'] = '≤ '.number_format($norm_max/$norm_decimal,strlen($norm_decimal)-1,',',' ');
            if ($this->salr_result > $norm_max)
              $ret_norm['HL']="H";
            break; 
          case 3 : // zakres od do 
            $ret_norm['range'] = number_format($norm_min/$norm_decimal,strlen($norm_decimal)-1,',',' ').' ÷ '.number_format($norm_max/$norm_decimal,strlen($norm_decimal)-1,',',' ');
            if ($this->salr_result > $norm_max)
              $ret_norm['HL']="H";
            if ($this->salr_result < $norm_min)
              $ret_norm['HL']="L";
            break;
          case 4 : 
            $ret_norm['range'] = '≥ '.number_format($norm_min/$norm_decimal,strlen($norm_decimal)-1,',',' ');
            if ($this->salr_result < $norm_min)
              $ret_norm['HL']="L";
            break;
          break;
          case 5 : 
            $ret_norm['range'] = '> '.number_format($norm_min/$norm_decimal,strlen($norm_decimal)-1,',',' ');
            if ($this->salr_result <= $norm_min)
              $ret_norm['HL']="L";
          break;
          case 6 : 
            $ret_norm['range'] = '';
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
