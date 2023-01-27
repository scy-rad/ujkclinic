<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SceneActorLabOrder extends Model
{
    use HasFactory;

  public function lab_results() 
  {
    return $this->hasMany(SceneActorLabResult::class);
  }

  public function scene_actor()
    {
      return $this->hasOne(SceneActor::class, 'id', 'scene_actor_id');
    }
  public function laboratory_test()
    {
      return $this->hasOne(LaboratoryTest::class, 'id', 'laboratory_test_id');
    }

  public static function get_order_for_ajax($id_order,$ret_type)
  {
    $scene_actor  =SceneActorLabOrder::where('id',$id_order)->first()->scene_actor;
    $scene  =$scene_actor->scene;
    $scene_date = $scene->scene_current_time();
    $order = SceneActorLabOrder ::where('id',$id_order)->first();
    
    /*

        TO DELETE IT

    // $rety = SceneActorLabResult/*::where('scene_actor_lab_order_id',$id_order)->with('laboratory_test')->get();
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
                $tab[$i]['norm'] = '< '.$ret_one->norm_max/$ret_one->lt_decimal_prec;
                break;          
              case 2 : // mniej niż MAX lub równo
                $tab[$i]['norm'] = '≤ '.$ret_one->norm_max/$ret_one->lt_decimal_prec;
                break; 
              case 3 : // zakres od do 
                $tab[$i]['norm'] = $ret_one->norm_min/$ret_one->lt_decimal_prec.' ÷ '.$ret_one->norm_max/$ret_one->lt_decimal_prec;
                break;
              case 4 : 
                $tab[$i]['norm'] = '≥ '.$ret_one->norm_min/$ret_one->lt_decimal_prec;
                break;
              break;
              case 5 : 
                $tab[$i]['norm'] = '> '.$ret_one->norm_min/$ret_one->lt_decimal_prec;
              break;
              case 6 : 
                $tab[$i]['norm'] = '';
              break;  
            }
            $tab[$i]['unit'] = $ret_one->lt_unit;
            if ($ret_one->result_no == (int)$ret_one->result_no)
              $tab[$i]['result'] = number_format($ret_one->result_no/$ret_one->lt_decimal_prec,strlen($ret_one->lt_decimal_prec)-1,',',' ');
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
*/
    switch ($ret_type)
    {
      case 'table':
        return 'something wrong in SceneActorLabOrder';
      case 'html':
        $scene_actor  =SceneActorLabOrder::where('id',$id_order)->first()->scene_actor;
        $scene  =$scene_actor->scene;
        $scene_date = $scene->scene_current_time();
        $order = SceneActorLabOrder::where('id',$id_order)->first();
    
        $ret='<div class="row">';
        $ret.='<div class="col-5">';
        $ret.='<span class="h5">Laboratorium Analiz Medycznych</span><br><span class="h6">UJK Clinic Medical</span><br><span class="small">mail: laboratorium@dudek.net.pl</span>';
        $ret.='</div>';
        $ret.='<div class="col-3">';
        $ret.='</div>';
        $ret.='<div class="col-4 text-end">';
        $ret.='<label>nr zlecenia:</label> '.date("z/i",strtotime($order->salo_date_order)).'/'.$order->id.'<br>';
        $ret.='<label>zlecono:</label> '.$order->salo_date_order.'<br>';
        $ret.='<label>pobrano:</label> '.$order->salo_date_take.'<br>';
        $ret.='<label>dostarczono:</label> '.$order->salo_date_delivery.'<br>';
        $ret.='</div>';
        $ret.='</div>';


        $ret.='<table class="table">';
        $order_group_id=0;
        $order_id=0;
        $suborder='';
        // $result_one->salr_log_sort
        // $result_one->salr_lo_sort
        foreach ($order->lab_results as $result_one)
        {
          if ($order_group_id!=$result_one->laboratory_test->laboratory_order->laboratory_order_group_id)
            {
              $order_group_id=$result_one->laboratory_test->laboratory_order->laboratory_order_group_id;
              $ret.='<tr><td class="bg-dark text-secondary h2" colspan="5">'.$result_one->laboratory_test->laboratory_order->laboratory_order_group->log_name.'</td></tr>';
            }
          if ($result_one->laboratory_test->laboratory_order->laboratory_tests->count()>1) 
          {
            $suborder=' - ';
            if ($order_id!=$result_one->laboratory_test->laboratory_order->id)
            {
              $ret.='<tr><td class="text-secondary h4" colspan="5">'.$result_one->laboratory_test->laboratory_order->lo_name.'</td></tr>';
              $order_id=$result_one->laboratory_test->laboratory_order->id;
            }
          }
          
          $ret.='<tr><td>'.$suborder.$result_one->laboratory_test->lt_name.'</td>';
          $suborder='';
          if ($result_one->salr_type>1)
            $ret.='<td></td><td colspan="3" class="text-danger">'.$result_one->name_of_type().'</td>';
          elseif (is_null($result_one->salr_date))
            $ret.= '<td></td><td></td><td class="text-warning">???</td><td></td>';
          elseif ($result_one->salr_date>$scene_date)
            $ret.= '<td></td><td></td><td class="text-warning">???</td><td></td>';
          elseif ($result_one->laboratory_test->lt_result_type==2)
                $ret.='<td></td><td></td><td colspan="2">'.$result_one->salr_resulttxt.'</td>';
          else
          {
            $ret.='<td>'.$result_one->laboratory_norm()['range'].'</td>';
            $ret.='<td class="text-danger fw-bold">'.$result_one->laboratory_norm()['HL'].'</td>';
            $ret.='<td>'.number_format($result_one->salr_result/$result_one->laboratory_test->lt_decimal_prec,strlen($result_one->laboratory_test->lt_decimal_prec)-1,',',' ').'</td>';
            $ret.='<td>'.$result_one->laboratory_test->lt_unit.'</td>';
          }
          $ret.="</tr>";

        }

        $ret.="</table>";

        $ret.='<div class="row"><div class="col-8">';
        $ret.='<label>data autoryzacji wyniku:</label> ';
        if ( (is_null($order->salo_date_accept)) || ($order->salo_date_accept>$scene_date) )
          $ret.='<span class="text-danger">no authorization</span>';
        else
          $ret.=$order->salo_date_accept;
        $ret.='</div>';
        $ret.='<div class="col-4 text-end"><label>data wydruku:</label> '.$scene_date.'</div></div>';
        
        if (!( (is_null($order->salo_date_accept)) || ($order->salo_date_accept>$scene_date) ))
          $ret.='<label>wynik autoryzował:</label> diagnosta laboratoryjny <strong>mgr '.$order->salo_diagnostician.'</strong><br>';
        
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
          else
            $ret.=' <label>zatwierdzono:</label> '.$order->salo_date_accept;
     

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
    $order_sort=0;
    $order_group_sort=0;
    $suborder='';
    foreach ($order->lab_results as $result_one)
    {
    if ($order_group_sort != $result_one->salr_log_sort)
    {
      $ret.='<tr><td colspan="6" class="text-secondary h5">'.$result_one->laboratory_test->laboratory_order->laboratory_order_group->log_name.'</td></tr>';
      $order_group_sort = $result_one->salr_log_sort;
    }
    if ($result_one->laboratory_test->laboratory_order->laboratory_tests->count()>1)
    {
      $suborder=' - ';
      if ($order_sort!=$result_one->salr_lo_sort)
      {
        $ret.='<tr><td class="text-secondary" colspan="6">'.$result_one->laboratory_test->laboratory_order->lo_name.'</td></tr>';
        $order_sort = $result_one->salr_lo_sort;
      }
    }
    $ret.='<tr>';
    $ret.='<td>'."".'</td>';
    $ret.='<td>'.$suborder.$result_one->laboratory_test->lt_name.'</td>';
    $suborder='';
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
    $ret.='<td>'.$result_one->laboratory_test->lt_unit.'</td>';
    $ret.='<td class="text-success text-center">'.$result_one->laboratory_norm()['range'].'</td>';
    
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
    $ret.='<td>';
    if ($scene_actor->scene->scene_current_time()<$result_one->salr_date)
    {
      $ret.=floor((strtotime($result_one->salr_date)-strtotime($scene_actor->scene->scene_current_time()))/3600).' h ';
      $ret.=floor(((strtotime($result_one->salr_date)-strtotime($scene_actor->scene->scene_current_time()))%3600)/60).' min. ';
      
    }
    $ret.='</td>';
    $ret.='</tr>';
    }
    $ret.='<tr><td></td>';
    $ret.='<td colspan="4"><div class="form-check form-switch mt-3">';

    if (is_null($order->salo_date_accept))
      $ret.='<label for="accept" class="form-check-label">: zatwierdź wyniki</label>';
    else                  
      $ret.='<label for="accept" class="form-check-label">: wyniki zatwierdzone</label>';
    $ret.='<input class="form-check-input" type="checkbox" name="accept" checked>
              </div></td>';
    $ret.='<td colspan="2"><div class="form-check form-switch mt-3">
                <label for="change_stat" class="form-check-label">: automatycznie zmień statusy</label>';
    if (is_null($order->salo_date_delivery))
      $ret.='<input class="form-check-input" type="checkbox" name="change_stat" checked>';
    else
      $ret.='<input class="form-check-input" type="checkbox" name="change_stat">';
    $ret.='</div></td>';
    $ret.='</tr>';
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
        $order=SceneActorLabOrder::where('id',$request->id)->first();
        $scene=$order->scene_actor->scene;
        $last_date=$scene->scene_date;

        $ret = $request->toArray();
        foreach ($ret as $key => $value)
        {
          if (substr($key,0,5) == 'salr-')
          {
            $value=str_replace([',',' '],['.',''],$value);
            $change=SceneActorLabResult::where('id',substr($key,5,10))->first();
            if ($value=='')
            {
              $change->salr_result=null;
              if ($change->salr_type==1) $change->salr_type=3; // Test unavailable
            }
            else
            {
              $change->salr_result=$value*$change->laboratory_norm_row()->laboratory_test->lt_decimal_prec;
              if ($change->salr_type==3) $change->salr_type=1; // Test done
            }
            $change->save();
          }
          elseif (substr($key,0,5) == 'rtxt-')
          {
            $change=SceneActorLabResult::where('id',substr($key,5,10))->first();
            $change->salr_resulttxt=$value;
            if ( ($change->salr_type == 3) && ($value != '') ) 
              $change->salr_type=1; // Test done
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
            
            if (!(isset($request->change_stat)))
              $change->salr_type=$value;  // zmiany były wprowadzone, ale trzeba je wycofać

            if ($order->salo_cito)
              $change->salr_date=date('Y-m-d H:i:s',strtotime($order->salo_date_delivery.' + '.$change->laboratory_norm_row()->laboratory_test->lt_time_cito.' minutes'));
            else
              $change->salr_date=date('Y-m-d H:i:s',strtotime($order->salo_date_delivery.' + '.$change->laboratory_norm_row()->laboratory_test->lt_time.' minutes'));
            $change->save();

            if ( ($last_date<$change->salr_date) && ($change->salr_type == 1) )
                $last_date=$change->salr_date;
    
          }
        }
        
      if ($scene->scene_lab_automatic_time)
        if ( (!is_null($order->salo_date_take)) && (is_null($order->salo_date_delivery)) )
        {
          $order->salo_date_delivery = date('Y-m-d H:i:s',strtotime($order->salo_date_take.' + '.rand($scene->scene_lab_delivery_seconds_from,$scene->scene_lab_delivery_seconds_to).' seconds'));
          $order->save();
        }
      if ((isset($request->accept)))
        {
          $order->salo_date_accept = date('Y-m-d H:i:s',strtotime($last_date.' + 45 seconds'));
          $order->save();
        }

    $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
        
    return response()->json($ret);
  } // end of function update_order_form

}
