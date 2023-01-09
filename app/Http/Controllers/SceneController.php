<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Scenario;
use App\Models\SceneMaster;
use App\Models\SceneActor;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SceneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $scenes=SceneMaster::all();

      return view('scene.index',[ 'scenes' => $scenes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'scene_code' => 'required',
        'scene_name' => 'required',
        'scene_scenario_description' => 'required',
        'scene_scenario_for_students' => 'required',
        ]);

      $request->merge(['scene_owner_id' => Auth::user()->id]);
      $request->request->remove('id');
// dd(Actor::where('scenario_id',$request->scenario_id)->get());
      $scene=SceneMaster::create($request->post());

      if ($request->scenario_id>0)
      {
        foreach (Actor::where('scenario_id',$request->scenario_id)->get() as $actor)
        {
          $retSA = SceneActor::create_actor($scene->id,$actor->id,"","","",$actor->actor_age_from,$actor->actor_age_to,$actor->actor_sex,$actor->actor_incoming_date,$actor->actor_incoming_recalculate,$actor->actor_nn,$actor->actor_role_name,$actor->history_for_actor,$actor->actor_simulation);
        }
      }

      \Illuminate\Support\Facades\Session::flash('success', 'Scenario has been created successfully.'); 

      return Redirect::route('scene.show',$scene->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $ret['scene']=SceneMaster::where('id',$id)->first();
      $ret['base_scenario']=Scenario::where('id',$ret['scene']->scenario_id)->first();
      $ret['diff_min'] = round((strtotime($ret['scene']->scene_date) - strtotime($ret['scene']->scene_relative_date)) / 60,0);
      $ret['actors']=SceneActor::where('scene_master_id',$id)->get();
      return view('scene.show',$ret);
    }

    /**
     * Show the form for editing the specified resource.
     *scene.show
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      dd('edit');
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
      $scene=SceneMaster::where('id',$id)->first();
      
      $scene->fill($request->post())->save();

      return Redirect::route('scene.show',$scene->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      dd('destroy');
    }



    public function getajax(Request $request)
    {
      $ret=$request->idvalue;
      switch ($request->what)
      {
        case 'relative_time':
          $ret = SceneMaster::select('scene_date','scene_relative_date','scene_relative_id','scene_step_minutes')->where('id',$request->idvalue)->first()->toArray();
          $ret['diff_min'] = round((strtotime($ret['scene_date']) - strtotime($ret['scene_relative_date'])) / 60,0);
          $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','scene_data' => $ret];
        break;
        
        case 'actor':
          if ($request->idvalue==0)
            {
              $ret = new SceneActor();
              // $ret->sa_incoming_date = date('Y-m-d H:i');
              $ret = $ret->toArray();
            }
          else
            $ret = SceneActor::where('id',$request->idvalue)->first()->toArray();
          $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','scene_data' => $ret];
        break;

        case 'actor_propose':
          $ret=json_decode(SceneActor::random_actor($request->birth_date,$request->actor_sex),true);
          // $ret = ['success' => 'Dane raczej wygenerowane prawidłowo :) .','scene_data' => $ret];  
        break;
      }
      return response()->json($ret);
    } // end of public function getajax

    public function updateajax(Request $request)
    {
      $ret = $request->toArray(); 

      switch ($request->what)
      {
        case 'relative_time':
          $scene = SceneMaster::where('id',$request->id)->first();
          $scene->scene_relative_date = date('Y-m-d H:i:s', strtotime($scene->scene_relative_date.'-'.$scene->scene_step_minutes.' minutes')); 
          $scene->save();

          $ret['scene']=$scene->toArray();
          $ret['step'] = SceneMaster::where('id',$request->id)->first()->scene_step_minutes;
        break;
        case 'start_scene':
          $scene = SceneMaster::where('id',$request->id)->first();
          $scene->scene_relative_date = date('Y-m-d H:i:s'); 
          $scene->save();
        break;
        case 'stop_scene':
          $scene = SceneMaster::where('id',$request->id)->first();
          $scene->scene_relative_date = null; 
          $scene->save();
        break;
      }

      $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
   
      return response()->json($ret);
    } // emd of public function updateajax
  

}
