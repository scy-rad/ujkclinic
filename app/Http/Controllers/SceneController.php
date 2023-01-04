<?php

namespace App\Http\Controllers;

use App\Models\SceneMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
      // $request->validate([
      //   'scenario_code' => 'required',
      //   'scenario_name' => 'required',
      //   'scenario_main_problem' => 'required',
      //   'scenario_description' => 'required',
      //   'scenario_for_students' => 'required',
      //   'scenario_for_leader' => 'required',
      //   ]);


      $request->merge(['scene_owner_id' => Auth::user()->id]);
      $request->request->remove('id');

      $scene=SceneMaster::create($request->post());


      \Illuminate\Support\Facades\Session::flash('success', 'Scenario has been created successfully.'); 

      return view('scene.show',[ 'scene' => $scene]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $scene=SceneMaster::where('id',$id)->first();
      
      return view('scene.show',['scene' => $scene]);
    }

    /**
     * Show the form for editing the specified resource.
     *
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

      return view('scene.show',['scene' => $scene]);
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
}
