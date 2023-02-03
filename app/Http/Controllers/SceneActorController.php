<?php

namespace App\Http\Controllers;

use App\Models\SceneActor;
use App\Models\SceneActorLabOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SceneActorController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $ret['sceneactor']=SceneActor::where('id',$id)->first();
      $ret['laborders']=SceneActorLabOrder::where('scene_actor_id',$id)->get();
      $ret['diff_sec'] = (strtotime($ret['sceneactor']->scene->scene_date) - strtotime($ret['sceneactor']->scene->scene_relative_date));
      return view('sceneactor.show',$ret);
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
    public function update(Request $request, SceneActor $sceneactor)
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      // && (!Auth::user()->hasRoleCode('coordinators'))
      )
      return back()->withErrors('błąd wywołania funkcji update kontrolera SceneActor. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

      switch ($request->action)
        {
          case 'registry':
            
            $sceneactor->sa_incoming_date=$sceneactor->scene->scene_current_time();
            $sceneactor->save();

            return back()->with('success', 'Aktor przyjęty na scenę.');
            break;

          default:
          dd($request->action,$id);
        }
dd('nic');
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






    public function actor_scene_save_ajax(Request $request)
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      // && (!Auth::user()->hasRoleCode('coordinators'))
      )
      return back()->withErrors('błąd wywołania funkcji actor_scene_ajax_update kontrolera Scene. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

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
          $retSA = SceneActor::create_actor($request->scene_master_id,null,$request->sa_birth_date,$request->sa_PESEL,$request->sa_name,$request->sa_actor_sex,$request->sa_incoming_date,$request->sa_incoming_recalculate,$request->sa_actor_nn,$request->sa_actor_role_name,$request->sa_history_for_actor,$request->sa_actor_simulation);

      // SceneActor::create($request->post());
      \Illuminate\Support\Facades\Session::flash('success', 'Scene actor has been created probably successfully :) ');
      }
      
      return Redirect::route('scene.show',$request->scene_master_id);
    }



}
