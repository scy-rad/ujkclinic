<?php

namespace App\Http\Controllers;

use App\Models\SceneActor;
use App\Models\SceneActorConsultation;
use App\Models\SceneActorConsultationAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SceneActorConsultationController extends Controller
{

  public function consultation_get_ajax(Request $request)
  {
    if ((!Auth::user()->hasRoleCode('technicians'))
    )
    return response()->json('błąd wywołania funkcji consultation_get_ajax kontrolera Character. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)')  ;

    $ret = 'coś nie poszło w consultation_get_ajax: '.$request->what;

    switch ($request->what)
    {
      case 'get_consultation':
        if ($request->idvalue==0)
        {
          $ret = new SceneActorConsultation();
          $ret->sac_seconds_description=0;
          $ret=$ret->toArray();
        }
        else
        {
        $ret = SceneActorConsultation::where('id',$request->idvalue)->with('consultation_type')->first()->toArray();
        foreach (SceneActorConsultationAttachment::where('sac_id',$request->idvalue)->get() as $attach_one)
          $ret['attachments'][]=$attach_one->toArray();
        }
        $ret['parent']='sceneactor';
        
        $ret = ['success' => 'Dane raczej pobrane prawidłowo :) .','ret_data' => $ret];
      break;
    }
    return response()->json($ret);


  }

  public function consultation_save_ajax(Request $request)
  {
    if ((!Auth::user()->hasRoleCode('technicians'))
    )
    return back()->withErrors('błąd wywołania funkcji consultation_save_ajax kontrolera Character. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

    switch ($request->action)
    {
      case 'consultation_order':
        $request->validate([
          'sac_type_details' => 'required',
          'sac_reason' => 'required'
          ]);

        if ($request->consultation_id > 0)
          \Illuminate\Support\Facades\Session::flash('error', 'You can\'t reorder consultation  :D ');

        $tab=new SceneActorConsultation;
        $tab->scene_actor_id = $request->scene_actor_id;
        $tab->cont_id = $request->cont_id;
        $tab->sac_type_details = $request->sac_type_details;
        $tab->sac_reason = $request->sac_reason;
        $tab->sac_date_order = SceneActor::where('id',$request->scene_actor_id)->first()->scene->scene_current_time();
        $tab->save();
        \Illuminate\Support\Facades\Session::flash('success', 'Consultation for Scene Actor has been ordered probably successfully :) ');

        return Redirect::route('sceneactor.show',$request->scene_actor_id);
      break;
        
      default:
        \Illuminate\Support\Facades\Session::flash('error', 'Save somthing about SceneActorConsultation not done... Sorry... :D ');
    }
  }



}
