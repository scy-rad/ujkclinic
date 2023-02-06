<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\ScenarioConsultationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ActorController extends Controller
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
    public function create(Request $request)
    {
      return view('actor.create',['scenario_id' => $request->scenario_id]);
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
        'actor_age_from' => 'required',
        'actor_age_to' => 'required',
        'actor_age_interval' => 'required',
        'actor_sex' => 'required',
        'actor_role_plan_id' => 'required',
        'actor_role_name' => 'required',
        'actor_type_id' => 'required',
        'history_for_actor' => 'required',
        'actor_simulation' => 'required'
        ]);

      $actor=Actor::create($request->post());

      \Illuminate\Support\Facades\Session::flash('success', 'Actor has been created successfully.'); 

      return view('actor.show',compact('actor'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show(actor $actor)
    {
      return view('actor.show',compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function edit(actor $actor)
    {
      $ret['scenario_id']=$actor->scenario_id;
      return view('actor.edit',compact('actor'),$ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, actor $actor)
    {
      $request->validate([
        'actor_age_from' => 'required',
        'actor_age_to' => 'required',
        'actor_age_interval' => 'required',
        'actor_sex' => 'required',
        'actor_role_plan_id' => 'required',
        'actor_role_name' => 'required',
        'actor_type_id' => 'required',
        'history_for_actor' => 'required',
        'actor_simulation' => 'required'
        ]);

      $actor->fill($request->post())->save();

      \Illuminate\Support\Facades\Session::flash('success', 'Actor has been updated successfully.'); 

      return view('actor.show',compact('actor'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy(actor $actor)
    {
      $toback=$actor->scenario_id;
      $actor->delete();

      \Illuminate\Support\Facades\Session::flash('success', 'Actor has been deleted successfully'); 

      return redirect()->route('scenario.show',$toback);
    }



    public function scenario_actor_get_ajax(Request $request)
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      )
      return response()->json('błąd wywołania funkcji scenario_actor_get_ajax kontrolera Actor. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)')  ;

      $ret = 'coś nie poszło w scenario_actor_get_ajax: '.$request->what;

      switch ($request->what)
      {
        case 'consultation':
          if ($request->idvalue==0)
          {
            $ret = new ScenarioConsultationTemplate;
            $ret->sct_seconds_description=0;
            $ret=$ret->toArray();
          }
          else
          $ret = ScenarioConsultationTemplate::where('id',$request->idvalue)->first()->toArray();
          
          $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','ret_data' => $ret];
        break;
        
      }
      return response()->json($ret);


    }

    public function scenario_actor_save_ajax(Request $request)
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      )
      return back()->withErrors('błąd wywołania funkcji scenario_actorsave_ajax kontrolera Actor. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');


      switch ($request->action)
      {
        case 'consultation_template':
          $request->validate([
            'sct_type_details' => 'required',
            'sct_seconds_description' => 'required',
            'sct_reason' => 'required',
            // 'sct_verbal_attach' => 'required',
            'sct_description' => 'required',
            ]);

          if ($request->id > 0)
            {
              $tab=ScenarioConsultationTemplate::where('id',$request->id)->first();
              $tab->fill($request->post())->save();  
              \Illuminate\Support\Facades\Session::flash('success', 'Scenario Consultation Template has been updated probably successfully :) ');    
            }
            else
            {
              $tab=new ScenarioConsultationTemplate;
              $tab->fill($request->post())->save();  
              
                // $retSA = SceneActor::create_actor($request->scene_master_id,null,$request->sa_birth_date,$request->sa_PESEL,$request->sa_name,$request->sa_actor_sex,$request->sa_incoming_date,$request->sa_incoming_recalculate,$request->sa_actor_nn,$request->sa_actor_role_name,$request->sa_history_for_actor,$request->sa_actor_simulation);
      
            // SceneActor::create($request->post());
            \Illuminate\Support\Facades\Session::flash('success', 'Scenario Consultation Template has been created probably successfully :) ');
            }
        break;
        
        default:
        \Illuminate\Support\Facades\Session::flash('error', 'Save somthing about Actor not done... Sorry... :D ');
      }
      return Redirect::route('actor.show',$request->actor_id);
    }






}
