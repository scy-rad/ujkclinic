<?php

namespace App\Http\Controllers;

use App\Models\LabTemplate;
use App\Models\LabTemplateResult;
use App\Models\LaboratoryTestGroup;
use App\Models\LaboratoryTest;
use App\Models\LaboratoryTestNorm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratoryNormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
  {
    return view('laboratorynorms.index');
  }


  public function getajax(Request $request)
  {
    switch ($request->table)
    {
      case 'ltg':
        if ($request->idvalue==0)
          $ret=[];
        else
          $ret = LaboratoryTestGroup::where('id',$request->idvalue)->first()->toArray();
        $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','ltg_data' => $ret];
      break;

      case 'lt':
        if ($request->idvalue==0)
          $ret1=[];
        else
          $ret1 = LaboratoryTest::where('id',$request->idvalue)->first()->toArray();
        $ret2 = LaboratoryTestGroup::select('ltg_name')->where('id',$request->idLTG)->first()->toArray();
        $ret = array_merge($ret2,$ret1);
        $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','lt_data' => $ret];
      break;

      case 'ltn':
        if ($request->idvalue==0)
          $ret1=[];
        else
          $ret1 = LaboratoryTestNorm::where('id',$request->idvalue)->first()->toArray();
        $ret2 = LaboratoryTest::select('lt_name')->where('id',$request->idLT)->first()->toArray();
        $ret = array_merge($ret2,$ret1);
        $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','ltn_data' => $ret];
      break;
    }
    return response()->json($ret);
  } // end of public function getajax

  public function updateajax(Request $request)
  {
    switch ($request->table)
    {
      case 'ltg':
        $ret = $request->toArray();

        $validator = Validator::make($request->all(), [
          'ltg_name' => 'required|max:128',
          'ltg_name_en' => 'required|max:128',
          'ltg_levels_count' => 'required|digits_between:1,2',
          'ltg_sort' => 'required|digits_between:1,2',
          ]);

        if ($validator->fails())
        {
          return response()->json([
              'error' => $validator->errors()->all()
          ]);
        }
        if ($request->id==0)
          LaboratoryTestGroup::create($request->post())->save();
        else
          LaboratoryTestGroup::find($request->id)->fill($request->post())->save();
      break;

      case 'lt':
        $ret = $request->toArray();

        $validator = Validator::make($request->all(), [
          'lt_name' => 'required|max:128',
          'lt_name_en' => 'required|max:128',
          'lt_short' => 'required|max:16',
          'lt_short_en' => 'required|max:16',
          'lt_level' => 'required|digits_between:1,2',
          'lt_sort' => 'required|digits_between:1,2',
          'lt_time' => 'required|integer',
          'lt_coast' => 'required|integer',
          'lt_time_cito' => 'required|integer',
          'lt_coast_cito' => 'required|integer'
          ]);

        if ($validator->fails())
        {
          return response()->json([
              'error' => $validator->errors()->all()
          ]);
        }
        if ($request->id>0)
          LaboratoryTest::find($request->id)->fill($request->post())->save();
        else
          LaboratoryTest::create($request->post())->save();
      break;

      case 'ltn':
        $ret = $request->toArray();

        $validator = Validator::make($request->all(), [
          'ltn_days_from' => 'required|integer',
          'ltn_days_to' => 'required|integer',
          'ltn_norm_type' => 'required|digits_between:1,1',
          'ltn_norm_m_min' => 'required|integer',
          'ltn_norm_m_max' => 'required|integer',
          'ltn_norm_w_min' => 'required|integer',
          'ltn_norm_w_max' => 'required|integer',
          'ltn_norm_p_min' => 'required|integer',
          'ltn_norm_p_max' => 'required|integer',
          'ltn_decimal_prec' => 'required|integer',
          'ltn_unit' => 'required|max:32',
          'ltn_unit_en' => 'required|max:32',
          ]);

        if ($validator->fails())
        {
          return response()->json([
              'error' => $validator->errors()->all()
          ]);
        }
        if ($request->id>0)
          LaboratoryTestNorm::find($request->id)->fill($request->post())->save();
        else
          LaboratoryTestNorm::create($request->post())->save();
      break;
    }
        
    $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
        
    return response()->json($ret);
  } // emd of public function updateajax


  public function template_show(Request $request,Int $id_lrt)
  {
    $labtemplate=LabTemplate::where('id',$id_lrt)->first();
    $labtemplate_results=LabTemplateResult::where('lab_template_id',$labtemplate->id)->get();
    $result_type=LabTemplateResult::array_of_types();
    $actor_id=$labtemplate->actor->id;

    return view('laboratorynorms.template',compact('labtemplate'),['labtemplate_results' => $labtemplate_results, 'result_type' => $result_type, 'actor_id' => $actor_id]);    
  }

  public function templateupdateajax(Request $request)
  {
        $request->lrtr_sort = 1;
        $ret = $request->toArray();

        if (!is_null($request->lrtr_resultX))
          {
            $request_lrtr_result = str_replace(',','.',$request->lrtr_resultX)*$request->decimal_prec;
            $request->merge(['lrtr_result' => $request_lrtr_result]);
          }

        if ($request->labtype==1)
        {
        $validator = Validator::make($request->all(), [
          'lab_template_id' => 'required',
          'laboratory_test_id' => 'required',
          // 'lrtr_result' => 'required',
          ]);
        }
        else
        {
          $validator = Validator::make($request->all(), [
            'lab_template_id' => 'required',
            'laboratory_test_id' => 'required',
            // 'lrtr_resulttxt' => 'required',
            ]);
          }

        if ($validator->fails())
        {
          return response()->json([
              'error' => $validator->errors()->all()
          ]);
        }
        if ($request->lab_template_result_id==0)
          LabTemplateResult::create($request->post())->save();
        else
          LabTemplateResult::find($request->lab_template_result_id)->fill($request->post())->save();
        
    $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
        
    return response()->json($ret);
  } // emd of public function template_update_ajax

  public function templateupdate(Request $request)
  {
    
    if ($request->id==0)
     LabTemplate::create($request->post())->save();
    else
      LabTemplate::find($request->id)->fill($request->post())->save();

    return back()->with('success', 'Edycja bądź dodawanie szablonu powiodło się... Możliwe, że tak... Chyba tak... Prawdopodobnie może...');    
  }
  
}
