<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Scenario;
use App\Models\SceneMaster;
use App\Models\SceneActor;
use App\Models\SceneActorLabOrder;
use App\Models\SceneActorLabOrderTemplate;
use App\Models\SceneActorLabResultTemplate;
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
      if ($request->scene_lab_automatic_time == "on")
        $request->merge(['scene_lab_automatic_time' => "1"]);
      else
        $request->merge(['scene_lab_automatic_time' => "0"]);
      $scene=SceneMaster::create($request->post());

      if ($request->scenario_id>0)
      {
        foreach (Actor::where('scenario_id',$request->scenario_id)->get() as $actor)
        {
          $sa_age=rand($actor->actor_days_from(),$actor->actor_days_to());

          if ($actor->actor_age_interval==6)  //minutes
            $sa_age = rand($actor->actor_age_from,$actor->actor_age_to).' minutes';
          elseif ($actor->actor_age_interval==5)  //hours
            $sa_age = rand($actor->actor_age_from,$actor->alrt_typector_age_to).' hours';
          else
            $sa_age = rand($actor->actor_days_from(),$actor->actor_days_to()).' days';
          
          if ($actor->actor_age_interval>3)
            $secondDate = new DateTime(date('Y-m-d H:i:s',strtotime($scene->scene_date)));
          else
            $secondDate = new DateTime(date('Y-m-d',strtotime($scene->scene_date)));
          
          $firstDate = new DateTime(date('Y-m-d H:i:s',strtotime($secondDate->format('Y-m-d H:i:s').' - '.$sa_age)));

          $actor_birth_date = $firstDate->format('Y-m-d H:i:s'); 

          $new_SA = SceneActor::create_actor($scene->id,$actor->id,$actor_birth_date,"","",$actor->actor_sex,$actor->actor_incoming_date,$actor->actor_incoming_recalculate,$actor->actor_nn,$actor->actor_role_name,$actor->history_for_actor,$actor->actor_simulation);

          // adding Lab Results for Scene Actor
          foreach ($actor->lab_order_templates as $order_one)
          {
            $new_order = new SceneActorLabOrderTemplate();
            $new_order->scene_actor_id            = $new_SA->id;	
            $new_order->lab_order_template_id	    = $order_one->id;
            $new_order->salot_lrt_minutes_before	= $order_one->lrt_minutes_before;
            $new_order->salo_descript             = $order_one->description_for_leader;
            $new_order->save();

            foreach ($order_one->results as $result_one)
            {
              $new_result = new SceneActorLabResultTemplate();
              $new_result->salot_id             = $new_order->id;
              $new_result->laboratory_test_id   = $result_one->laboratory_test_id;
              $new_result->salr_result          = $result_one->lrtr_result;
              $new_result->salr_resulttxt       = $result_one->lrtr_resulttxt;
              $new_result->salr_addedtext       = $result_one->lrtr_addedtext;
              $new_result->salr_type            = $result_one->lrtr_type;
              $new_result->save();
            }
          }

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
      $ret['diff_sec'] = (strtotime($ret['scene']->scene_date) - strtotime($ret['scene']->scene_relative_date));
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

      if ($request->scene_lab_automatic_time == "on")
        $request->merge(['scene_lab_automatic_time' => "1"]);
      else
        $request->merge(['scene_lab_automatic_time' => "0"]);
      
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
          $ret['diff_sec'] = (strtotime($ret['scene_date']) - strtotime($ret['scene_relative_date']));
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

        case 'lab_order':
          $ret=['body' => SceneActorLabOrder::create_order_form($request->idvalue) ];
          break;

        case 'order_from_template':
          $ret=['body' => SceneActorLabResultTemplate::template_to_order($request->template_id, $request->order_id) ];
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
        case 'order':
          SceneActorLabOrder::update_order_form($request);
          return back()->with('success', 'Powinno się udać...');    
        break;
        default:
          dd('something wrong in updateajax Scene Controller function');
      }

      $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
   
      return response()->json($ret);
    } // emd of public function updateajax
  

}
