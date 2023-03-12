<?php

namespace App\Http\Controllers;

use App\Models\MedicalCenterVisitCard;
use App\Models\MedicalForm;
use App\Models\MedicalFormType;
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
      $ret['diff_sec'] = (strtotime($ret['sceneactor']->scene->scene_date) - strtotime($ret['sceneactor']->scene->scene_relative_date));

      if ($ret['sceneactor']->scene->scene_type->scene_type_code=='medical_center')
      {
        if ($ret['sceneactor']->mc_visit_cards->count()==0)
        {
          $ret['view_action']='start_visit_required';
          // $ret['view_action']='start_visit_optional';
          $ret['mcvc_id']="0";
        }
        else
        {
          if (is_null($ret['sceneactor']->mc_visit_cards->last()->mcvc_end))
          {
            $ret['view_action']='visit_in_progress';
            $ret['mcvc_id']=$ret['sceneactor']->mc_visit_cards->last()->id;
          }
          else
          {
            $ret['view_action']='visit_ending';
            $ret['mcvc_id']=$ret['sceneactor']->mc_visit_cards->last()->id; // make active last visit
          }
        }
      }

      return view('sceneactor.'.$ret['sceneactor']->scene->scene_type->scene_type_blade,$ret);
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


    public function character_scene_save_ajax(Request $request)
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      // && (!Auth::user()->hasRoleCode('coordinators'))
      )
      return back()->withErrors('błąd wywołania funkcji character_scene_ajax_update kontrolera Scene. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

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
          $retSA = SceneActor::create_actor($request->scene_master_id,null,$request->sa_birth_date,$request->sa_PESEL,$request->sa_name,$request->sa_sex,$request->sa_incoming_date,$request->sa_incoming_recalculate,$request->sa_nn,$request->sa_role_name,$request->sa_history_for_actor,$request->sa_simulation);

      // SceneActor::create($request->post());
      \Illuminate\Support\Facades\Session::flash('success', 'Scene actor has been created probably successfully :) ');
      }
      
      return Redirect::route('scene.show',$request->scene_master_id);
    }


    public function medical_form_get_ajax(Request $request)
    {
      if ((!Auth::user()->hasRoleCode('technicians'))
      )
      return response()->json('błąd wywołania funkcji medical_form_get_ajax kontrolera Character. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

      $curr_sceneactor=SceneActor::where('id',$request->scene_actor_id)->first();

      switch ($request->save_action)
      {
        case 'show_visit':
          $curr_form=MedicalCenterVisitCard::where('id',$request->mcvc_id)->first();
          $ret_form= file_get_contents('../resources/views/medicalforms/s__visit.php');

          $ret_form=str_replace('#mcvc_id#',$curr_form->id,$ret_form);
          $ret_form=str_replace('#mcvc_begin#',$curr_form->mcvc_begin,$ret_form);
          $ret_form=str_replace('#mcvc_end#',$curr_form->mcvc_end,$ret_form);
          $ret_form=str_replace('#mcvc_medical_history#',$curr_form->mcvc_medical_history,$ret_form);
          $ret_form=str_replace('#mcvc_medical_examination#',$curr_form->mcvc_medical_examination,$ret_form);
          $ret_form=str_replace('#mcvc_medical_orders#',$curr_form->mcvc_medical_orders,$ret_form);
          $ret_form=str_replace('#mcvc_comments#',$curr_form->mcvc_comments,$ret_form);
          // $ret_form=str_replace('#mf_date_1#',$curr_form->mf_date_1,$ret_form);
          // $ret_form=str_replace('#mf_string_1#',$curr_form->mf_string_1,$ret_form);
          // $ret_form=str_replace('#mf_text_1#',$curr_form->mf_text_1,$ret_form);

          $ret['head'] = 'karta wizyty lekarskiej';
          $ret_txt = 'get show_visit success';

          break;

        case 'edit_visit':
          if ($request->mcvc_id==0)
          {
            $curr_form=new MedicalCenterVisitCard();
            $curr_form->mf_date_1 = $curr_sceneactor->scene->scene_current_time();
          }
          else
            $curr_form=MedicalCenterVisitCard::where('id',$request->mcvc_id)->first();

          $ret_form= file_get_contents('../resources/views/medicalforms/e__visit.php');

          $ret_form=str_replace('#mcvc_id#',$curr_form->id,$ret_form);
          $ret_form=str_replace('#mcvc_begin#',$curr_form->mcvc_begin,$ret_form);
          $ret_form=str_replace('#mcvc_end#',$curr_form->mcvc_end,$ret_form);
          $ret_form=str_replace('#mcvc_medical_history#',$curr_form->mcvc_medical_history,$ret_form);
          $ret_form=str_replace('#mcvc_medical_examination#',$curr_form->mcvc_medical_examination,$ret_form);
          $ret_form=str_replace('#mcvc_medical_orders#',$curr_form->mcvc_medical_orders,$ret_form);
          $ret_form=str_replace('#mcvc_comments#',$curr_form->mcvc_comments,$ret_form);
          // $ret_form=str_replace('#mf_date_1#',$curr_form->mf_date_1,$ret_form);
          // $ret_form=str_replace('#mf_string_1#',$curr_form->mf_string_1,$ret_form);
          // $ret_form=str_replace('#mf_text_1#',$curr_form->mf_text_1,$ret_form);

          $ret['head'] = 'karta wizyty lekarskiej';
          $ret_txt = 'get show_visit success';

          break;

        case 'show_form':
          $curr_form=MedicalForm::where('id',$request->medical_form_id)->first();
          $curr_form_type=$curr_form->form_type;

          $ret_form= file_get_contents('../resources/views/medicalforms/'.$curr_form_type->mft_show_skeleton);

          $ret_form=str_replace('#mf_date_1#',$curr_form->mf_date_1,$ret_form);
          $ret_form=str_replace('#mf_string_1#',$curr_form->mf_string_1,$ret_form);
          $ret_form=str_replace('#mf_text_1#',$curr_form->mf_text_1,$ret_form);

          $ret['head'] = $curr_form_type->form_familly->mff_name.' '.$curr_form_type->mft_name;

          $ret_txt = 'get show_form success';

          break;

        case 'edit_form':
            $curr_form=new MedicalForm();
            $curr_form_type=MedicalFormType::where('id',$request->medical_form_type_id)->first();

            $curr_form->mf_date_1 = 'data bieżąca...';

            $ret_form= file_get_contents('../resources/views/medicalforms/'.$curr_form_type->mft_edit_skeleton);

            $ret_form=str_replace('#mf_date_1#',$curr_form->mf_date_1,$ret_form);
            $ret_form=str_replace('#mf_string_1#',$curr_form->mf_string_1,$ret_form);
            $ret_form=str_replace('#mf_text_1#',$curr_form->mf_text_1,$ret_form);
  
            $ret['head'] = $curr_form_type->form_familly->mff_name.' '.$curr_form_type->mft_name;

            $ret_txt = 'get edit_form success';

            break;

        default:
          dd('something wrong in medical_form_get_ajax',$request);
      }

      $ret = ['success' => $ret_txt, 'ret_form' => $ret_form, 'ret_data' => $ret];

      return response()->json($ret);
    }


    public function medical_form_save_ajax(Request $request)
    {
      if (!Auth::user()->hasRoleCode('technicians'))
      return back()->withErrors('błąd wywołania funkcji character_scene_ajax_update kontrolera Scene. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

      switch ($request->save_action)
      {
        case 'begin_visit':
          $visit = new MedicalCenterVisitCard();
          $visit->scene_actor_id = $request->scene_actor_id;
          $visit->mcvc_begin = SceneActor::where('id',$request->scene_actor_id)->first()->scene->scene_current_time();
          $visit->save();
          $ret_txt = 'Wizyta rozpoczęta.';
          
          break;

        case 'end_visit':
          $visit = MedicalCenterVisitCard::where('id',$request->mcvc_id)->first();
          $visit->mcvc_end = SceneActor::where('id',$request->scene_actor_id)->first()->scene->scene_current_time();
          $visit->save();
          $ret_txt = 'Zamknięto wizytę.';
          
          break;

        case 'edit_visit':
          $visit = MedicalCenterVisitCard::where('id',$request->mcvc_id)->first();
          $visit->fill($request->post())->save();
          $ret_txt = 'Zapisano zmiany w dokumentacji wizyty.';
          
          break;

        case 'edit_form':
          if ($request->id > 0)
          {
            $medicalform=MedicalForm::where('id',$request->id)->first();
            $medicalform->fill($request->post())->save();  
            $ret_txt = 'Medical Form has been updated probably successfully :) ';    
          }
          else
          {
            $request->merge(['mf_date_1' => SceneActor::where('id',$request->scene_actor_id)->first()->scene->scene_current_time()]);

            MedicalForm::create($request->post());
            $ret_txt = 'Medical Form has been created probably successfully :) ';
          }

          break;

        default:
          $ret_txt = 'Medical Form zapisany poprawnie.';
          dd('something wrong in medical_form_save_ajax',$request);
      }

      return back()->with('success', $ret_txt);
    }

}
