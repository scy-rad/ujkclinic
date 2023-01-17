<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SceneActorLabOrder extends Model
{
    use HasFactory;

  public function lab_results() {
    return $this->hasMany(SceneActorLabResult::class);
  }
  public function scene_actor()
    {
      return $this->hasOne(SceneActor::class, 'id', 'scene_actor_id');
    }

  public static function get_ajax_order($id_order,$ret_type)
  {
    $actor  =SceneActorLabOrder::where('id',$id_order)->first()->scene_actor;
    $scene  =$actor->scene;
    $scene_date = $scene->scene_current_time();
    $order = SceneActorLabOrder ::where('id',$id_order)->first();
    // $rety = SceneActorLabResult::where('scene_actor_lab_order_id',$id_order)->with('laboratory_test')->get();
    ;
    $rety = DB::table('scene_actor_lab_results')
      ->leftJoin('scene_actor_lab_orders','scene_actor_lab_order_id','scene_actor_lab_orders.id')
      ->leftJoin('laboratory_tests','scene_actor_lab_results.laboratory_test_id','laboratory_tests.id')
      ->leftJoin('laboratory_test_groups','laboratory_tests.laboratory_test_group_id','laboratory_test_groups.id')
      ->leftJoin('laboratory_test_norms','laboratory_test_norms.laboratory_test_id','laboratory_tests.id')
      ->leftJoin('laboratory_orders','laboratory_tests.laboratory_order_id','laboratory_orders.id')
      ->leftJoin('laboratory_order_groups','laboratory_orders.laboratory_order_group_id','laboratory_order_groups.id')
      ;

    $rety = $rety->leftJoin('scene_actors','scene_actor_id','scene_actors.id');

    $rety = $rety->select('ltg_name', 'log_name', 'lo_name', 'lt_name', 'lt_short', 'ltn_unit', 'ltn_decimal_prec', 'ltn_norm_type', 'salr_date', 'salr_result', 'salr_resulttxt', 'salr_addedtext', 'salr_type');

    if ($actor->sa_actor_sex==2)
    {
      $rety = $rety->addSelect(DB::raw('ltn_norm_m_min AS norm_min, ltn_norm_m_max AS norm_max'));
    }
    if ($actor->sa_actor_sex==3)
    {
      if ($order->is_pregnant)
        $rety = $rety->addSelect(DB::raw('ltn_norm_p_min AS norm_min, ltn_norm_p_max AS norm_max'));
      else  
        $rety = $rety->addSelect(DB::raw('ltn_norm_w_min AS norm_min, ltn_norm_w_max AS norm_max'));
    }
    $rety = $rety->addSelect(DB::raw('laboratory_order_groups.id AS log_id, laboratory_orders.id AS lo_id, laboratory_tests.id AS lt_id'));

    $rety = $rety->addSelect(DB::raw('(CASE WHEN salr_date < "'.$scene_date.'" THEN salr_result ELSE "???" END) AS result_no'));
    $rety = $rety->addSelect(DB::raw('(CASE WHEN salr_date < "'.$scene_date.'" THEN salr_resulttxt ELSE "" END) AS result_txt'));
    $rety = $rety->addSelect(DB::raw('(CASE WHEN salr_date < "'.$scene_date.'" THEN salr_addedtext ELSE "" END) AS result_add'));

    $rety = $rety->where('scene_actor_lab_order_id',$id_order)
      ->where('ltn_days_from','<=','sa_age')
      ->where('ltn_days_to','>=','sa_age')
      ;
    $ret['SceneActor'] = $rety->get();

    $tab=[];
    $xlog=0;
    $xlo=0;
    $curlo=0;
    $i=1;
    foreach ($ret['SceneActor'] as $ret_one)
      {
        if ($xlog!=$ret_one->log_id)
        {
          $xlog=$ret_one->log_id;
          $i++;
          $tab[$i]['type']="head1";
          $tab[$i]['name']=$ret_one->log_name;
        }
        if (($xlo==$ret_one->lo_id) && ($xlo!=$curlo))
        {
          $curlo=$xlo;
          $i++;
          $tab[$i]=$tab[$i-1];
          $tab[$i-1]=[];
          $tab[$i-1]['type']="head2";
          $tab[$i-1]['name']=$ret_one->lo_name;
        }
        $xlo=$ret_one->lo_id;

        $i++;
        switch ($ret_one->salr_type)
        {
          case 1:
            $tab[$i]['type']="result";
            $tab[$i]['name']=$ret_one->lt_name;
            switch ($ret_one->ltn_norm_type)
            {
              case 1 : // mniej niż MAX
                $tab[$i]['norm'] = '< '.$ret_one->norm_max/$ret_one->ltn_decimal_prec;
                break;          
              case 2 : // mniej niż MAX lub równo
                $tab[$i]['norm'] = '≤ '.$ret_one->norm_max/$ret_one->ltn_decimal_prec;
                break; 
              case 3 : // zakres od do 
                $tab[$i]['norm'] = $ret_one->norm_min/$ret_one->ltn_decimal_prec.' ÷ '.$ret_one->norm_max/$ret_one->ltn_decimal_prec;
                break;
              case 4 : 
                $tab[$i]['norm'] = '≥ '.$ret_one->norm_min/$ret_one->ltn_decimal_prec;
                break;
              break;
              case 5 : 
                $tab[$i]['norm'] = '> '.$ret_one->norm_min/$ret_one->ltn_decimal_prec;
              break;
              case 6 : 
                $tab[$i]['norm'] = '';
              break;  
            }
            $tab[$i]['unit'] = $ret_one->ltn_unit;
            if ($ret_one->result_no == (int)$ret_one->result_no)
              $tab[$i]['result'] = number_format($ret_one->result_no/$ret_one->ltn_decimal_prec,strlen($ret_one->ltn_decimal_prec)-1,',',' ');
            else
              $tab[$i]['result'] = $ret_one->result_no;
            $tab[$i]['result_txt'] = $ret_one->result_txt;
            $tab[$i]['result_add'] = $ret_one->result_add;
            if ($ret_one->result_no<$ret_one->norm_min)
              $tab[$i]['result_hl']="L";
            elseif ($ret_one->result_no>$ret_one->norm_max)
              $tab[$i]['result_hl']="H";
            else
              $tab[$i]['result_hl']="";
            break;
          case 2:
          case 3:
            $tab[$i]['type']="no_result";
            $tab[$i]['name']=$ret_one->lt_name;
            $tab[$i]['value']=SceneLabResult::array_of_types()[$ret_one->salr_type]['txt'];
            break;
        }
        // echo $ret_one->log_id.' - '.$ret_one->lo_id,' - '.$ret_one->lt_id.': '.$ret_one->log_name.' -> '.$ret_one->lo_name.' -> '.$ret_one->lt_name.'<br>';
      }

    switch ($ret_type)
    {
      case 'table':
        return $tab;
      case 'html':
        $ret='<table class="table">';
        foreach ($tab as $row_one)
        {
          switch ($row_one['type'])
          {
          case 'head1':
            $ret.='<tr><td class="bg-dark text-secondary h2" colspan="5">'.$row_one['name'].'</td></tr>';
            break;
          case('head2'):
            $ret.='<tr><td class="text-secondary h4" colspan="5">'.$row_one['name'].'</td></tr>';
            break;
          case('result'):
            $ret.='<tr><td><strong>'.$row_one['name'].'</strong></td>';
            $ret.='<td class="text-end fw-bold">'.$row_one['result'].'</td>';
            $ret.='<td class="text-success">'.$row_one['unit'].'</td>';
            $ret.='<td class="text-center fw-bold text-danger">'.$row_one['result_hl'].'</td>';
            $ret.='<td class="text-center">'.$row_one['norm'].'</td>';
            $ret.='</tr>';
            if (strlen($row_one['result_add'])>0)
            {
              $ret.='<tr style="border-top-style: hidden"><td></td>';
              $ret.='<td colspan="4" class="text-warning">'.$row_one['result_add'].'</td>';
              $ret.='</tr>';
            }
            break;
          case('no_result'):
            $ret.='<tr><td><strong>'.$row_one['name'].'</strong></td>';
            $ret.='<td colspan="4" class="text-danger">'.$row_one['value'].'</td>';
            $ret.='</tr>';
            break;
          }
          

        }
        $ret.='</table>';
        return $ret;

      case 'json':
        return json_encode($tab);
      }
  } // end of function get_ajax_order
}
