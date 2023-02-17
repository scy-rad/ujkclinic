<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\ScenarioConsultationTemplate;
use App\Models\ScenarioConsultationTemplateAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CharacterController extends Controller
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
      return view('character.create',['scenario_id' => $request->scenario_id]);
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
        'character_age_from' => 'required',
        'character_age_to' => 'required',
        'character_age_interval' => 'required',
        'character_sex' => 'required',
        'character_role_plan_id' => 'required',
        'character_role_name' => 'required',
        'character_type_id' => 'required',
        'history_for_actor' => 'required',
        'character_simulation' => 'required'
        ]);

      $character=Character::create($request->post());

      \Illuminate\Support\Facades\Session::flash('success', 'Character has been created successfully.'); 

      return view('character.show',compact('character'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(character $character)
    {
      return view('character.show',compact('character'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(character $character)
    {
      $ret['scenario_id']=$character->scenario_id;
      return view('character.edit',compact('character'),$ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, character $character)
    {
      $request->validate([
        'character_age_from' => 'required',
        'character_age_to' => 'required',
        'character_age_interval' => 'required',
        'character_sex' => 'required',
        'character_role_plan_id' => 'required',
        'character_role_name' => 'required',
        'character_type_id' => 'required',
        'history_for_actor' => 'required',
        'character_simulation' => 'required'
        ]);

      $character->fill($request->post())->save();

      \Illuminate\Support\Facades\Session::flash('success', 'Character has been updated successfully.'); 

      return view('character.show',compact('character'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(character $character)
    {
      $toback=$character->scenario_id;
      $character->delete();

      \Illuminate\Support\Facades\Session::flash('success', 'Character has been deleted successfully'); 

      return redirect()->route('scenario.show',$toback);
    }



    public function scenario_character_get_ajax(Request $request)
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      )
      return response()->json('błąd wywołania funkcji scenario_character_get_ajax kontrolera Character. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)')  ;

      $ret = 'coś nie poszło w scenario_character_get_ajax: '.$request->what;

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
          {
          $ret = ScenarioConsultationTemplate::where('id',$request->idvalue)->first()->toArray();
          foreach (ScenarioConsultationTemplateAttachment::where('sct_id',$request->idvalue)->get() as $attach_one)
            $ret['attachments'][]=$attach_one->toArray();
          }
          
          $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','ret_data' => $ret];
        break;
      }
      return response()->json($ret);


    }

    public function scenario_character_save_ajax(Request $request)
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      )
      return back()->withErrors('błąd wywołania funkcji scenario_character_save_ajax kontrolera Character. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');


      switch ($request->action)
      {
        case 'consultation_template':
          $request->validate([
            'sct_type_details' => 'required',
            'sct_seconds_description' => 'required',
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
              
                // $retSA = SceneActor::create_actor($request->scene_master_id,null,$request->sa_birth_date,$request->sa_PESEL,$request->sa_name,$request->sa_sex,$request->sa_incoming_date,$request->sa_incoming_recalculate,$request->sa_nn,$request->sa_role_name,$request->sa_history_for_actor,$request->sa_simulation);
      
            // SceneActor::create($request->post());
            \Illuminate\Support\Facades\Session::flash('success', 'Scenario Consultation Template has been created probably successfully :) ');
            }
        break;

        case 'pic_file_save':
          if ($request->id > 0)
            $tab=ScenarioConsultationTemplateAttachment::where('id',$request->id)->first();
          else
            $tab=new ScenarioConsultationTemplateAttachment;

          // $request->merge(['scta_file' => $request->scta_file_full]);
          // $tab->fill($request->post())->save();
          $tab->sct_id=$request->sct_id;
          $tab->scta_file=str_replace(env('APP_URL'),'',$request->scta_file_full);
          $tab->save();

          return ['code' => 1, 'success' => 'Dane załącznika raczej zmienione prawidłowo :) .'];
          break;

        case 'pic_descript_save':
          if ($request->id > 0)
            {
            $tab=ScenarioConsultationTemplateAttachment::where('id',$request->id)->first();
            $tab->fill($request->post())->save();  
            return ['code' => 1, 'success' => 'Dane załącznika raczej zmienione prawidłowo :) .'];
            }
          else
          return ['code' => 0, 'success' => 'Dane załącznika NIE zmienione :) .'];
            
          break;
        case 'pic_delete':
          if ($request->id > 0)
            {
            $tab=ScenarioConsultationTemplateAttachment::where('id',$request->id)->first();
            if ($request->delete_approve == 'TAK')
              $tab->delete();  
            return ['code' => 1, 'success' => 'Dane załącznika raczej USUNIĘTE prawidłowo :) .'];
            }
          else
          return ['code' => 0, 'success' => 'Dane załącznika NIE zmienione :) .'];
          
          break;
          
        default:
        \Illuminate\Support\Facades\Session::flash('error', 'Save somthing about Character not done... Sorry... :D ');
      }
      return Redirect::route('character.show',$request->character_id);
    }






}
