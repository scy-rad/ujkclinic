<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\SceneActor;
use Illuminate\Http\Request;
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

      Actor::create($request->post());

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




    public function actor_scene_save_ajax(Request $request)
    {
      $request->validate([
        'scene_master_id' => 'required',
        'sa_birth_date' => 'required'
        ]);

      if ($request->id > 0)
      {
        $SceneActor=SceneActor::where('id',$request->id)->first();
        $SceneActor->fill($request->post())->save();  
        \Illuminate\Support\Facades\Session::flash('success', 'Scene actor has been updated probably successfully :) ');    
      }
      else
      {
      SceneActor::create($request->post());
      \Illuminate\Support\Facades\Session::flash('success', 'Scene actor has been created probably successfully :) ');
      }
      
      return Redirect::route('scene.show',$request->scene_master_id);
    }


}
