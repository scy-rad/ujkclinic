<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scenario;

class ScenarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $ret['scenarios'] = Scenario::all();
      return view('scenario.index', $ret);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('scenario.create',['scenario' => null]);
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
        'scenario_code' => 'required',
        'scenario_name' => 'required',
        'scenario_main_problem' => 'required',
        'scenario_description' => 'required',
        'scenario_for_students' => 'required',
        'scenario_for_leader' => 'required',
        ]);

      Scenario::create($request->post());

      \Illuminate\Support\Facades\Session::flash('success', 'Scenario has been created successfully.'); 

      return redirect()->route('scenario.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Scenario $scenario)
    {
      $ret['actors']    =  $scenario->actors;

      return view('scenario.show',compact('scenario'),$ret);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Scenario $scenario)
    {
      return view('scenario.edit',compact('scenario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scenario $scenario)
    {
      $request->validate([
        'scenario_code' => 'required',
        'scenario_name' => 'required',
        'scenario_main_problem' => 'required',
        'scenario_description' => 'required',
        'scenario_for_students' => 'required',
        'scenario_for_leader' => 'required',
      ]);
    
      $scenario->fill($request->post())->save();

      \Illuminate\Support\Facades\Session::flash('success', 'Scenario has been updated successfully'); 

      $ret['actors']    =  $scenario->actors;
      return view('scenario.show',compact('scenario'),$ret);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scenario $scenario)
    {
      $scenario->delete();

      \Illuminate\Support\Facades\Session::flash('success', 'Scenario has been deleted successfully'); 

      return redirect()->route('scenario.index');
    }
}
