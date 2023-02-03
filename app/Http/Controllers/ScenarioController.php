<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scenario;
use Illuminate\Support\Facades\Auth;

class ScenarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      // && (!Auth::user()->hasRoleCode('coordinators'))
      )
      return back()->withErrors('błąd wywołania funkcji index kontrolera Scenario. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

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
      if (!Auth::user()->hasRoleCode('technicians'))
        return back()->withErrors('błąd wywołania funkcji create kontrolera Scenario. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');
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
      if (!Auth::user()->hasRoleCode('technicians'))
        return back()->withErrors('błąd wywołania funkcji store kontrolera Scenario. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');
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
      if (!Auth::user()->hasRoleCode('technicians'))
        return back()->withErrors('błąd wywołania funkcji show kontrolera Scenario. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

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
      if (!Auth::user()->hasRoleCode('technicians'))
        return back()->withErrors('błąd wywołania funkcji edit kontrolera Scenario. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

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
      if (!Auth::user()->hasRoleCode('technicians'))
        return back()->withErrors('błąd wywołania funkcji update kontrolera Scenario. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

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
      if (!Auth::user()->hasRoleCode('technicians'))
        return back()->withErrors('błąd wywołania funkcji destroy kontrolera Scenario. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

      $scenario->delete();

      \Illuminate\Support\Facades\Session::flash('success', 'Scenario has been deleted successfully'); 

      return redirect()->route('scenario.index');
    }
}
