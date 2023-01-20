<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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

  public static function get_order_for_ajax($id_order,$ret_type)
  {
    $scene_actor  =SceneActorLabOrder::where('id',$id_order)->first()->scene_actor;
    $scene  =$scene_actor->scene;
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

    $rety = $rety->select('ltg_name', 'log_name', 'lo_name', 'lt_name', 'lt_short', 'lt_unit', 'lt_decimal_prec', 'ltn_norm_type', 'salr_date', 'salr_result', 'salr_resulttxt', 'salr_addedtext', 'salr_type');

    if ($scene_actor->sa_actor_sex==2)
    {
      $rety = $rety->addSelect(DB::raw('ltn_norm_m_min AS norm_min, ltn_norm_m_max AS norm_max'));
    }
    if ($scene_actor->sa_actor_sex==3)
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
                $tab[$i]['norm'] = '< '.$ret_one->norm_max/$ret_one->laboratory_test->lt_decimal_prec;
                break;          
              case 2 : // mniej niż MAX lub równo
                $tab[$i]['norm'] = '≤ '.$ret_one->norm_max/$ret_one->laboratory_test->lt_decimal_prec;
                break; 
              case 3 : // zakres od do 
                $tab[$i]['norm'] = $ret_one->norm_min/$ret_one->laboratory_test->lt_decimal_prec.' ÷ '.$ret_one->norm_max/$ret_one->laboratory_test->lt_decimal_prec;
                break;
              case 4 : 
                $tab[$i]['norm'] = '≥ '.$ret_one->norm_min/$ret_one->laboratory_test->lt_decimal_prec;
                break;
              break;
              case 5 : 
                $tab[$i]['norm'] = '> '.$ret_one->norm_min/$ret_one->laboratory_test->lt_decimal_prec;
              break;
              case 6 : 
                $tab[$i]['norm'] = '';
              break;  
            }
            $tab[$i]['unit'] = $ret_one->ltn_unit;
            if ($ret_one->result_no == (int)$ret_one->result_no)
              $tab[$i]['result'] = number_format($ret_one->result_no/$ret_one->laboratory_test->lt_decimal_prec,strlen($ret_one->laboratory_test->lt_decimal_prec)-1,',',' ');
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
            $tab[$i]['value']=SceneActorLabResultTemplate::array_of_types()[$ret_one->salr_type]['txt'];
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
  } // end of function get_order_for_ajax

  public static function create_order_form($id_order)
  {
    $scene_actor  =SceneActorLabOrder::where('id',$id_order)->first()->scene_actor;
    
    // $scene_date = $scene->scene_current_time();
    $order = SceneActorLabOrder ::where('id',$id_order)->first();
    $result_types=LabResultTemplate::array_of_types();

    $ret='<p><label>pacjent:</label> '.$scene_actor->sa_name.' <label>wiek:</label> '.$scene_actor->sa_age_txt.' <label>PESEL:</label> '.$scene_actor->sa_PESEL.' - ';
    $ret.='<label>data zlecenia:</label> '.$order->salo_date_order;
    if (is_null($order->salo_date_take))
      $ret.='<span class="text-danger"> - materiał nie pobrany</span>';
      elseif (is_null($order->salo_date_delivery))
        $ret.='<span class="text-danger"> - materiał nie dostarczony</span>';
        elseif (is_null($order->salo_date_accept))
          $ret.='<span class="text-danger"> - wyniki nie zatwierdzone</span>';

    $ret.='<div class="input-group mb-3">';
    $ret.='<select id="template_id" class="form-select">'; 
      foreach ($scene_actor->scene_actor_lab_order_templates as $template_one)
      {
        $ret.='<option value='.$template_one->id;
        $ret.='>'.$template_one->salo_descript.'</option>';
      }
    $ret.='</select>';

    $ret.='<button class="btn btn-outline-secondary" type="button" id="button-feel" onClick="javascript:fill_results()">zastosuj</button>
      </div>';
    $ret.='<form action="'.route('scene.updateajax').'" method="post" enctype="multipart/form-data">';
    $ret.='<input type="hidden" name="what" value="order">';
    $ret.='<input type="hidden" id="order_id" name="id" value="'.$order->id.'">';
    $ret.=csrf_field();
    $ret.='<table class="mb-3">';
    foreach ($order->lab_results as $result_one)
    {
    $ret.='<tr>';
    $ret.='<td>'.$result_one->id.'</td>';
    $ret.='<td>'.$result_one->laboratory_test->lt_name.'</td>';
    $ret.='<td><input id="lt-'.$result_one->laboratory_test->id.'" name="salr-'.$result_one->id.'" placeholder="wpisz wartość" ';
    if ($result_one->laboratory_test->lt_result_type == 2)
        $ret.='type="hidden" value="';
    else
      $ret.='type="text" value="';
    if (!is_null($result_one->salr_result)) 
      $ret.=$result_one->salr_result/$result_one->laboratory_test->lt_decimal_prec;
    $ret.='">';
    $ret.='<input id="lttxt-'.$result_one->laboratory_test->id.'" name="rtxt-'.$result_one->id.'" placeholder="opisz wynik" ';
    if ($result_one->laboratory_test->lt_result_type == 1)
        $ret.='type="hidden"';
    else
      $ret.='type="text"';
    $ret.=' value="'.$result_one->salr_resulttxt.'">';
    $ret.='</td>';
    $ret.='<td>'.$result_one->laboratory_test->laboratory_test_norms->first()->ltn_unit.'</td>';
    $ret.='<td class="text-success text-center">'.$result_one->laboratory_norm().'</td>';
    
    $ret.='<td><input id="ltadd-'.$result_one->laboratory_test->id.'" name="addt-'.$result_one->id.'" type="text" value="'.$result_one->salr_addedtext.'"></td>';
    $ret.='<td>';
    $ret.='<select id="lttyp-'.$result_one->laboratory_test->id.'" name="type-'.$result_one->id.'" class="form-select">'; 
      foreach ($result_types as $type_one)
      {
        $ret.='<option value='.$type_one['id'];
        if ($type_one['id'] == $result_one->salr_type)
          $ret.=' selected="selected"';
        $ret.='>'.$type_one['value'].'</option>';
      }
    $ret.='</select>';
    $ret.='</td>';
    
    }
    $ret.='</table>';

    $ret.='<button type="submit" class="col-4 m-2 btn btn-success btn-submit btn-ltg">Zapisz</button>
    <button type="button" class="col-4 m-2 float-end btn btn-secondary" onClick="javascript:clear_extra_body()">anuluj??</button>';
    $ret.='</form>';

    $ret.='
    <script>
    function fill_results()
    {
      var e = document.getElementById("template_id");
      var template_id = e.value;
      var text = e.options[e.selectedIndex].text;
      var order_id = document.getElementById("order_id").value;
      $.ajax({
        type:"GET",
        url:"'.route('scene.getajax').'",
        data:{template_id:template_id,what:"order_from_template",order_id:order_id},
        success:function(data){
          if($.isEmptyObject(data.error))
          {
            for (var row_one of data.body) 
              {
                document.getElementById("lt-"+row_one.laboratory_test_id).value=row_one.salr_result_dec*1;
                document.getElementById("ltadd-"+row_one.laboratory_test_id).value=row_one.salr_addedtext;
                document.getElementById("lttxt-"+row_one.laboratory_test_id).value=row_one.salr_resulttxt;
                $("#lttyp-"+row_one.laboratory_test_id).val(row_one.salr_type);
              }
            }
            else
            {
              printErrorMsg(data.error);
            }
          }
        });
    }
    </script>';

    return $ret;
  } // end of function create_order_form($id_order)

  public static function update_order_form(Request $request)
  {
        $ret = $request->toArray();
        foreach ($ret as $key => $value)
        {
          if (substr($key,0,5) == 'salr-')
          {
            $value=str_replace([',',' '],['.',''],$value);
            $change=SceneActorLabResult::where('id',substr($key,5,10))->first();
            if ($value=='')
              $change->salr_result=null;
            else
              $change->salr_result=$value*$change->laboratory_norm_row()->laboratory_test->lt_decimal_prec;
            $change->save();
          }
          if (substr($key,0,5) == 'rtxt-')
          {
            $change=SceneActorLabResult::where('id',substr($key,5,10))->first();
            $change->salr_resulttxt=$value;
            $change->save();
          }

          elseif (substr($key,0,5) == 'addt-')
          {
            $change=SceneActorLabResult::where('id',substr($key,5,10))->first();
            $change->salr_addedtext=$value;
            $change->save();
          }
          elseif (substr($key,0,5) == 'type-')
          {
            $change=SceneActorLabResult::where('id',substr($key,5,10))->first();
            $change->salr_type=$value;
            $change->save();
          }
        }

    $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
        
    return response()->json($ret);
  } // end of function update_order_form

}
