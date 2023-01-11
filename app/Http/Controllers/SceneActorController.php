<?php

namespace App\Http\Controllers;

use App\Models\SceneActor;
use Illuminate\Http\Request;

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
      switch ($request->action)
        {
          case 'registry':
           
            $diff= (strtotime(date('Y-m-d H:i:s'))  + (strtotime($sceneactor->scene->scene_date) - strtotime($sceneactor->scene->scene_relative_date) ) );
            
            $sceneactor->sa_incoming_date=date('Y-m-d H:i:s',$diff);
            $sceneactor->save();
            // dd(date('Y-m-d H:i:s',$diff));
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
