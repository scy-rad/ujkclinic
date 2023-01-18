<?php

namespace App\Http\Controllers;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryTest;
use App\Models\LaboratoryTestNorm;
use App\Models\SceneActor;
use App\Models\SceneActorLabOrder;
use App\Models\SceneActorLabResult;
use App\Models\SceneMaster;
use Illuminate\Http\Request;

class SceneActorLabOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      // $actor=SceneActor::where('id',$request->scene_actor_id)->first();
      $scene=SceneActor::where('id',$request->scene_actor_id)->first()->scene()->first();
      
      // dump($scene);

      $new_order = new SceneActorLabOrder();
      $new_order->scene_actor_id = $request->scene_actor_id;
      $new_order->salo_cito = $request->cito*1;
      $new_order->salo_date_order = $scene->scene_current_time() ;
      // $new_order->salo_date_take = null;
      // $new_order->salo_date_income = null;
      // $new_order->salo_date_accept = null;
      $new_order->salo_descript = '';
      $new_order->save();

      foreach ($request->request as $key => $value)
      {
        if (substr($key,0,4)=='test')
          {            
            $lab=LaboratoryTest::where('laboratory_order_id',$value)->get();
                foreach ($lab as $lab_one)
                {
                  $new_result = new SceneActorLabResult();
                  $new_result->scene_actor_lab_order_id = $new_order->id;
                  $new_result->laboratory_test_id = $lab_one->id;
                  // $new_result->laboratory_test_norm_id = LaboratoryTestNorm::where('laboratory_test_id',$lab_one->id)
                  // ->where('ltn_days_from','<=',$actor=>sa_age)
                  // ->where('ltn_days_to','<=',$actor=<sa_age)
                  // ->first()->id;
                  // ; 
                  // $new_result->salr_result
                  // $new_result->salr_resulttxt
                  // $new_result->salr_addedtext
                  // $new_result->salr_type
                  $new_result->save();
                }
          }
      }

      return back()->with('success', 'Zapisano zlecenie badań laboratoryjnych.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getajax(Request $request)
    {
      $ret=$request->idvalue;
      switch ($request->what)
      {
        case 'lab_results':
          $ret=['success' => 'Dane dla sceny 1 (wpisane ręczne) raczej pobrane prawidłowo :) .','salo_data' => SceneActorLabOrder::get_order_for_ajax($request->idvalue,'html')];  
        break;
        default:
          $ret = ['success' => 'Coś nie pykło... :) .'];
        break;
        
      }
      return response()->json($ret);
    } // end of public function getajax




}
