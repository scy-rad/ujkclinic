<?php

namespace App\Http\Controllers;

use App\Models\LabOrderTemplate;
use App\Models\LabResultTemplate;
use App\Models\LaboratoryTestGroup;
use App\Models\LaboratoryTest;
use App\Models\LaboratoryTestNorm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    if (!Auth::user()->hasRoleCode('technicians'))
      return back()->withErrors('błąd wywołania funkcji index kontrolera LaboratoryNorm. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

    return view('laboratorynorms.index');
  }


  public function get_laboratory_normm_ajax(Request $request)
  {
    if (!Auth::user()->hasRoleCode('technicians'))
      return response()->json(['errors' => 'Nie można pobrać danych. Błąd uprawnień!']);

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
        $ret2 = LaboratoryTest::select('lt_name','lt_decimal_prec','lt_unit')->where('id',$request->idLT)->first()->toArray();
        $ret = array_merge($ret2,$ret1);
        $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','ltn_data' => $ret];
      break;
    }
    return response()->json($ret);
  } // end of public function get_laboratory_normm_ajax

  public function update_laboratory_norm_ajax(Request $request)
  {
    if (!Auth::user()->hasRoleCode('technicians'))
      return response()->json(['errors' => 'Nie można zaktualizować norm. Błąd uprawnień!']);

    switch ($request->table)
    {
      case 'ltg':
        $ret = $request->toArray();

        $validator = Validator::make($request->all(), [
          'ltg_name' => 'required|max:128',
          'ltg_name_en' => 'required|max:128',
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
          'lt_decimal_prec' => 'required|integer',
          'lt_unit' => 'required|max:32',
          'lt_unit_en' => 'required|max:32',
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
  } // emd of public function update_laboratory_norm_ajax


  public function template_show(Request $request,Int $id_lrt)
  {
    if (!Auth::user()->hasRoleCode('technicians'))
      return back()->withErrors('błąd wywołania funkcji template_show kontrolera LaboratoryNorm. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

    $lab_order_template=LabOrderTemplate::where('id',$id_lrt)->first();
    $lab_order_template_results=LabResultTemplate::where('lab_order_template_id',$lab_order_template->id)->get();
    $result_type=LabResultTemplate::array_of_types();
    $actor_id=$lab_order_template->actor->id;

    return view('laboratorynorms.template',compact('lab_order_template'),['lab_order_template_results' => $lab_order_template_results, 'result_type' => $result_type, 'actor_id' => $actor_id]);    
  }

  public function update_laboratory_norm_template_ajax(Request $request)
  { 
    if (!Auth::user()->hasRoleCode('technicians'))
      return response()->json(['errors' => 'Nie można zaktualizować szablonu badań. Błąd uprawnień!']);

        $request->lrtr_sort = 1;
        $ret = $request->toArray();

        if (!is_null($request->lrtr_resultX))
          {
            $request_lrtr_result = str_replace([',',' '],['.',''],$request->lrtr_resultX)*$request->decimal_prec;
            $request->merge(['lrtr_result' => $request_lrtr_result]);
          }

        if ($request->labtype==1)
        {
        $validator = Validator::make($request->all(), [
          'lab_order_template_id' => 'required',
          'laboratory_test_id' => 'required',
          // 'lrtr_result' => 'required',
          ]);
        }
        else
        {
          $validator = Validator::make($request->all(), [
            'lab_order_template_id' => 'required',
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
        if ($request->lab_result_template_id==0)
          LabResultTemplate::create($request->post())->save();
        else
          LabResultTemplate::find($request->lab_result_template_id)->fill($request->post())->save();
        
    $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
        
    return response()->json($ret);
  } // emd of public function template_update_ajax

  public function templateupdate(Request $request)
  {
    if (!Auth::user()->hasRoleCode('technicians'))
      return back()->withErrors('błąd wywołania funkcji templateupdate kontrolera LaboratoryNorm. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');
    
    if ($request->id==0)
     LabOrderTemplate::create($request->post())->save();
    else
      LabOrderTemplate::find($request->id)->fill($request->post())->save();

    return back()->with('success', 'Edycja bądź dodawanie szablonu powiodło się... Możliwe, że tak... Chyba tak... Prawdopodobnie może...');    
  }
  
}
