<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SceneActorConsultation extends Model
{
  public function scene_actor()
  {
    return $this->hasOne(SceneActor::class, 'id', 'scene_actor_id');
  }
  public function attachments() 
  {
    return $this->hasMany(SceneActorConsultationAttachment::class);
  }
  public function consultation_type()
    {
      return $this->hasOne(ConsultationType::class, 'id', 'cont_id');
    }





public static function create_consultation_form($id_order)
  {
    $scene_actor  =SceneActorConsultation::where('id',$id_order)->first()->scene_actor;
    
    $consultation = SceneActorConsultation ::where('id',$id_order)->first();

    $ret='<p><label>pacjent:</label> '.$scene_actor->sa_name.' <label>wiek:</label> '.$scene_actor->sa_age_txt.' <label>PESEL:</label> '.$scene_actor->sa_PESEL.', <label>zlecono:</label> '.$consultation->sac_date_order.' <br> ';

    $ret.='<div class="row mb-3"><!-- row 1 -->';
    $ret.='<div class="col-8">';
    // $ret.='<form action="'.route('scene.update_scene_ajax').'" method="post" enctype="multipart/form-data">';
    $ret.=csrf_field();
    $ret.='<input type="hidden" name="consultation_id" value="'.$consultation->id.'">';
    $ret.='<input type="hidden" name="what" value="consultation_from_template">';
    $ret.=' <div class="input-group">';
    $ret.='<select id="template_id" class="form-select">'; 
            foreach ($scene_actor->character_template->consultation_templates as $template_one)
            {
              $ret.='<option value='.$template_one->id;
              $ret.='>'.$template_one->sct_name.'</option>';
            }
    $ret.='</select>
            <button class="btn btn-outline-secondary" type="button" onClick="javascript:from_template()">wypełnij</button>
            </div>';
    // $ret.='</form>';
    $ret.='</div>';
    $ret.='<div class="col-2">
          <button class="btn btn-outline-primary col-12" type="button" onClick="javascript:showTimeEditModal()">edytuj czasy</button>
          </div>';
    if ($consultation->sac_date_descript==null)
    {
      $ret.='<div class="col-2">';
      $ret.='<form action="'.route('scene.update_scene_ajax').'" method="post" enctype="multipart/form-data">';
      $ret.=csrf_field();
      $ret.='<input type="hidden" name="consultation_id" id="consultation_id" value="'.$consultation->id.'">';
      $ret.='<input type="hidden" name="scene_actor_id" id="scene_actor_id" value="'.$scene_actor->id.'">';
      $ret.='<input type="hidden" name="what" value="consultation_fill_time">';
      $ret.='<button type="submit" class="btn btn-outline-success btn-submit col-12">wykonaj/ opisz</button>';
      $ret.='</form>';
      $ret.='</div>';
    }
    elseif  ($consultation->sac_date_descript>$scene_actor->scene->scene_current_time())
    {
      $ret.='<div class="col-2">';
      $ret.='<form action="'.route('scene.update_scene_ajax').'" method="post" enctype="multipart/form-data">';
      $ret.=csrf_field();
      $ret.='<input type="hidden" name="consultation_id" id="consultation_id" value="'.$consultation->id.'">';
      $ret.='<input type="hidden" name="scene_actor_id" id="scene_actor_id" value="'.$scene_actor->id.'">';
      $ret.='<input type="hidden" name="what" value="consultation_current_time">';
      $ret.='<button type="submit" class="btn btn-outline-success btn-submit col-12">opisz teraz</button>';
      $ret.='</form>';
      $ret.='</div>';
    }
    $ret.='</div><!-- row 1 -->';

    $ret.='<form action="'.route('scene.update_scene_ajax').'" method="post" enctype="multipart/form-data">';
    $ret.=csrf_field();
    $ret.='<div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
          </div>';

    $ret.='<input type="hidden" name="consultation_id" id="consultation_id" value="'.$consultation->id.'">';
    $ret.='<input type="hidden" name="scene_actor_id" id="scene_actor_id" value="'.$scene_actor->id.'">';
    $ret.='<input type="hidden" name="what" value="consultation">';

    $ret.='<div class="row mb-3">';
    $ret.='<div class="col-2">
            <label for="cont_id" class="form-label">Zlecenie na:</label>
            <select name="cont_id" id="cont_id" class="form-select">';
              foreach (ConsultationType::all() as $type_one)
              $ret.='<option value="'.$type_one->id.'">'.$type_one->cont_name.'</option>';

              $ret.='</select>
          </div>';
    $ret.='<div class="col-6">
            <label for="sac_type_details" class="form-label">szczegóły (jaką/jakie-czego):</label>
            <input type="text" name="sac_type_details" id="sac_type_details" class="form-control" placeholder="szczegóły rodzaju zlecenia" value="'.$consultation->sac_type_details.'">
          </div>';
    $ret.='<div class="col-2">
            <label for="sac_date_visit" class="form-label">wykonano:</label>
            <br><p>'.$consultation->sac_date_visit.'</p>
          </div>';
    $ret.='<div class="col-2">
            <label for="sac_date_descript" class="form-label">opisano:</label>
            <br>'.$consultation->sac_date_descript.'
          </div>';
    $ret.='</div>';


    $ret.='<div class="col-12">
            <label for="sac_reason" class="form-label">powód:</label>
            <textarea name="sac_reason" id="sac_reason" class="form-control">'.$consultation->sac_reason.'</textarea>
          </div>';

    $ret.='<div class="row mb-0">
            <label class="form-label">załączniki:</label>
          </div>';

    $ret.='<div class="row mb-3" id="ConsultationAttachments">';

      $value_last="";
    // foreach ($consultation->attachments as $attach_one)
    foreach (SceneActorConsultationAttachment::where('sac_id',$consultation->id)->get() as $attach_one)
    {
      $ret.='<div class="card col-3">';
      $ret.='<img class="card-img-top" id="saca_file_'.$attach_one->id.'" src="'.$attach_one->saca_file.'" alt="'.$attach_one->saca_name.'">';
      $ret.='<div class="card-body p-0">';
      $ret.='<p class="card-text" id="saca_name_'.$attach_one->id.'">'.$attach_one->saca_name.'</p>';
      $ret.='<span class="btn btn-sm btn-primary" onClick="javascript:open_flmngr('.$attach_one->id.',\''.$attach_one->saca_file.'\',\''.$attach_one->saca_name.'\')"><i class="bi bi-pencil-square"></i> fot</span> ';
      $ret.='<span class="btn btn-sm btn-primary" onClick="javascript:pic_descrip('.$attach_one->id.')"><i class="bi bi-pencil-square"></i> txt</span> ';
      $ret.='<span class="btn btn-sm btn-danger" onClick="javascript:inc_delete('.$attach_one->id.',\'character_attachment\')"><i class="bi bi-trash"></i></span>';
      $ret.='</div>';
      $ret.='</div>';
      $value_last = $attach_one->saca_file;
    }
      $ret.='<div class="card col-3">';
      $ret.='<img class="card-img-top" id="saca_file_0" src="" alt="...">';
      $ret.='<div class="card-body p-0">';
      $ret.='<span class="btn btn-sm btn-primary" onClick="javascript:open_flmngr(0,\''.$value_last.'\',\''.'\')"><i class="bi bi-plus-square"></i> fot</span> &nbsp; ';
      $ret.='</div>';
      $ret.='</div>';
      $ret.='<input type="hidden" id="sub_id">';
      $ret.='<input type="hidden" id="new_image">';

    $ret.='</div>';

    $ret.='<div class="row mb-3">
            <div class="col-12">
              <label for="sac_verbal_attach" class="form-label">opis słowny (przed opisem pisemnym):</label>
              <textarea name="sac_verbal_attach" id="sac_verbal_attach" class="form-control">'.$consultation->sac_verbal_attach.'</textarea>
            </div>
            <div class="col-12">
              <label for="sac_description" class="form-label">opis:</label>
              <textarea name="sac_description" id="sac_description" class="form-control">'.$consultation->sac_description.'</textarea>
            </div>
          </div>';

    $ret.='<div class="row mb-3">
            <div class="col-4">
              <button type="submit" class="btn btn-success btn-submit btn-tmpl-save">Potwierdź</button>
            </div>
            <div class="col-4 text-center">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
            <div class="col-4 text-end" id="for_delete">
            </div>
          </div>';

    $ret.='</form>';


    $ret.='<div class="modal fade" id="ConsultationTimeEditModal" tabindex="-1" aria-labelledby="ConsultationTimeEditModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">';
              $ret.='<div class="modal-header">
                      <h5 class="modal-title" id="ConsultationTimeEditModalTitle">Edytuj czasy</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>  <!-- modal-header -->';
              $ret.='<div class="modal-body">';
                    $ret.='<form action="'.route('scene.update_scene_ajax').'" method="post" enctype="multipart/form-data">
                        '.csrf_field().'
                      <div class="alert alert-danger print-error-msg" style="display:none">
                          <ul></ul>
                      </div>
                        <input type="hidden" name="consultation_id" value="'.$consultation->id.'">
                        <input type="hidden" name="what" value="consultation_time">';
                      $ret.='<div class="row mb-3">';
                        $ret.='<div class="col-4">
                          <label for="sac_date_order" class="form-label">zlecono:</label>
                          <input type="datetime-local" name="sac_date_order" id="sac_date_order" class="form-control" placeholder="data badania" value="'.$consultation->sac_date_order.'">
                          </div>';
                        $ret.='<div class="col-4">
                          <label for="sac_date_visit" class="form-label">wykonano:</label>
                          <input type="datetime-local" name="sac_date_visit" id="sac_date_visit" class="form-control" placeholder="data badania" value="'.$consultation->sac_date_visit.'">
                          </div>';
                        $ret.='<div class="col-4">
                            <label for="sac_date_descript" class="form-label">opiano:</label>
                            <input type="datetime-local" name="sac_date_descript" id="sac_date_descript" class="form-control" placeholder="Ilość sekund do opisu" value="'.$consultation->sac_date_descript.'">
                          </div>';
                      $ret.='</div>';
                      $ret.='<div class="row mb-3">
                              <div class="col-4">
                                <button type="submit" class="btn btn-success btn-submit">Potwierdź</button>
                              </div>
                              <div class="col-4 text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
                              </div>
                            </div>';
                    $ret.='</form>';
              $ret.='</div> <!-- modal-body -->';
    $ret.='   </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
          </div> <!-- modal fade -->';


    $ret.='<div class="modal fade" id="TextSubModal" tabindex="-1" aria-labelledby="TextSubModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="TextSubModalTitle">Edycja tekstu</h5>
                  <button type="button" class="btn-close" onClick="javascript:$(\'#TextSubModal\').modal(\'hide\')" aria-label="Close"></button>
                </div>  <!-- modal-header -->
                <div class="modal-body">

                      <div class="alert alert-danger print-error-msg" style="display:none">
                          <ul></ul>
                      </div>
                        <input type="hidden" name="id" id="id_subtxt" value="">
                      <div class="row mb-3">
                        <div class="col-12">
                          <label for="saca_name" class="form-label">nazwa zdjęcia:</label>
                          <input type="text" name="saca_name" id="saca_name" class="form-control" placeholder="opis zdjęcia" value="">
                        </div>
                      </div>
                      <div class="mb-3 text-center">
                        <button type="button" class="btn btn-success" onClick="javascript:consultation_fdescript_save()">Potwierdź</button>
                        <button type="button" class="btn btn-secondary" onClick="javascript:$(\'#TextSubModal\').modal(\'hide\')">zamknij</button>
                      </div>

                </div> <!-- modal-body -->
              </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
          </div> <!-- modal fade -->';


    $ret.='<div class="modal fade" id="IncDeleteModal" tabindex="-1" aria-labelledby="IncDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="IncDeleteModalTitle">Usuń coś tam...</h5>
                  <button type="button" class="btn-close" onClick="javascript:$(\'#IncDeleteModal\').modal(\'hide\')" aria-label="Close"></button>
                </div>  <!-- modal-header -->
                <div class="modal-body">
                      <div class="alert alert-danger print-error-msg" style="display:none">
                          <ul></ul>
                      </div>
                        <input type="hidden" name="id" id="id_inc_delete" value="">
                        <input type="hidden" name="target" id="target_inc_delete" value="">
                      <div class="row mb-3">
                        <div class="col-12">
                          <label for="inc_delete_yes" class="form-label">na pewno chcesz usunąć? [TAK]</label>
                          <input type="text" name="inc_delete_yes" id="inc_delete_yes" class="form-control" placeholder="napisz TAK, żeby usunąć..." value="">
                        </div>
                      </div>
                      <div class="mb-3 text-center">
                        <button type="button" class="btn btn-success" onClick="javascript:do_delete_inc()">Potwierdź</button>
                        <button type="button" class="btn btn-secondary" onClick="javascript:$(\'#IncDeleteModal\').modal(\'hide\')">zamknij</button>
                      </div>
                </div> <!-- modal-body -->
              </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
          </div> <!-- modal fade -->';

    $ret.='
    <script>

    function showTimeEditModal()
    {
      $(\'#ConsultationTimeEditModal\').modal(\'show\');
    }

    function open_flmngr(id,catalog,file)
    {
      $(\'#sub_id\').val(id);
      $(\'#new_image\').val(\'\');
  
      window.open(\'/file-manager/fm-button?leftPath=look\', \'fm\', \'width=1400,height=800\');
    }

    //  function fmSetLink($url) {
    //  document.getElementById(\'sub_id\').value = $url;
    //  }
    function fmSetLink($url) {
      $.ajax({
          type:\'POST\',
          url:"'.route('scene.update_scene_ajax').'",
          data:{
                what: \'consultation_file_save\',
                id: document.getElementById(\'sub_id\').value,
                consultation_id: '.$consultation->id.',
                saca_file_full: $url
              },
          success:function(data){
            // if(data.code==1)
            //   {
            //     $(\'#TextSubModal\').modal(\'hide\');
            //     if (document.getElementById(\'sub_id\').value>0)
            //     {
            //       // alert(JSON.stringify(data, null, 4));
            //       document.getElementById(\'new_image\').value = $url;
            //       document.getElementById(\'saca_file_\'+$(\'#sub_id\').val()).src = $url;
            //     }
            //     else
            //     {
            //       location.reload();
            //     }
            //   }
            // else
            //   {
            //     alert(JSON.stringify(data, null, 4));
            //     console.log(JSON.stringify(data, null, 4));
            //     alert(\'coś poszło nie tak przy zapisywaniu załącznika ...\');
            //   }
            if ($(\'#sub_id\').val() == 0)
              fill_extra_body('.$consultation->id.',\'consultation\');
            else
            {
              document.getElementById(\'new_image\').value = $url;
              document.getElementById(\'saca_file_\'+$(\'#sub_id\').val()).src = $url;
            }
          }
      });
  
    }


    function pic_descrip(id)
    {
      document.getElementById(\'id_subtxt\').value = id;
      document.getElementById(\'saca_name\').value = document.getElementById(\'saca_name_\'+id).innerHTML;
      
      $(\'#TextSubModal\').modal(\'show\');
    }

    function consultation_fdescript_save()
    {
      id = document.getElementById(\'id_subtxt\').value;
      descript = document.getElementById(\'saca_name\').value;
  
      $.ajax({
          type:\'POST\',
          url:"'.route('scene.update_scene_ajax').'",
          data:{
                what: \'consultation_fdescript_save\',
                id: document.getElementById(\'id_subtxt\').value,
                consultation_id: '.$consultation->id.',
                saca_name: document.getElementById(\'saca_name\').value          
              },
          success:function(data){
            // if(data.code==1)
            //   {
            //     $(\'#TextSubModal\').modal(\'hide\');
            //       // alert(JSON.stringify(data, null, 4));
            //       document.getElementById(\'saca_name_\'+id).innerHTML = descript;
            //   }
            // else
            //   {
            //     alert(JSON.stringify(data, null, 4));
            //     // alert(\'coś poszło nie tak z zapisem opisu załącznika...\');
            //   }
            $(\'#TextSubModal\').modal(\'hide\');
            document.getElementById(\'saca_name_\'+id).innerHTML = descript;
          }
      });
      
    }


    function inc_delete(id,what)
    {
      document.getElementById(\'id_inc_delete\').value = id;
      document.getElementById(\'target_inc_delete\').value = what;
      
      document.getElementById(\'inc_delete_yes\').value = \'\';
      if (what ==\'character_attachment\')
          $(\'#IncDeleteModalTitle\').html(\'Usuń załącznik: \'+id);
      else if (what ==\'character_consultation\')
        $(\'#IncDeleteModalTitle\').html(\'Usuń konsultację/diagnostykę: \'+id);
      else
        $(\'#IncDeleteModalTitle\').html(\'Mogę źle zrozumieć o co Ci chodzi... : \'+id);
  
      $(\'#IncDeleteModal\').modal(\'show\');
    }
    
    function do_delete_inc()
    {
      id = document.getElementById(\'id_inc_delete\').value;
      descript = document.getElementById(\'inc_delete_yes\').value;
  
      if (document.getElementById(\'inc_delete_yes\').value == \'TAK\')
      {
        $.ajax({
            type:\'POST\',
            url:"'.route('scene.update_scene_ajax').'",
            data:{
                  what: \'inc_delete\',
                  target: document.getElementById(\'target_inc_delete\').value,
                  id: document.getElementById(\'id_inc_delete\').value,
                  consultation_id: '.$consultation->id.',
                  delete_approve: document.getElementById(\'inc_delete_yes\').value          
                },
            success:function(data){
              // if(data.code==1)
              //   {
              //     $(\'#IncDeleteModal\').modal(\'hide\');
              //     if (document.getElementById(\'target_inc_delete\').value == \'character_attachment\')
              //       showConsultationTemplateModal(document.getElementById(\'sct_id\').value);
              //     else
              //       location.reload();
              //   }
              // else
              //   {
              //     alert(\'coś poszło nie tak z usuwaniem...\');
              //   }
              $(\'#IncDeleteModal\').modal(\'hide\');
              fill_extra_body('.$consultation->id.',\'consultation\');
            }
        });
      }
    }
  

    
    function from_template()
    {
        $.ajax({
            type:\'POST\',
            url:"'.route('scene.update_scene_ajax').'",
            data:{
                  what: \'consultation_from_template\',
                  template_id: $(\'#template_id\').find(":selected").val(),
                  consultation_id: '.$consultation->id.',
                },
            success:function(data){
              // if(data.code==1)
              //   {
              //     fill_extra_body('.$consultation->id.',\'consultation\');
              //   }
              // else
              //   {
              //     alert(\'coś poszło nie tak z usuwaniem...\');
              //   }
              fill_extra_body('.$consultation->id.',\'consultation\');
            }
        });
    }

    </script>
    

    <script>
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html(\'\');
        $(".print-error-msg").css(\'display\',\'block\');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append(\'<li>\'+value+\'</li>\');
        });
    }
    </script>
    
    ';

    return $ret;
  } // end of function create_consultation_form($id_order)

  public static function update_consultation_form(Request $request)
  {

    if ((!Auth::user()->hasRoleCode('technicians'))
    )
    return back()->withErrors('błąd wywołania funkcji update_consultation_form modelu SceneActorConsultation. Aby wykonać to działanie musisz być KIMŚ INNYM, niestety... :)');

    if ($request->consultation_id == 0)
      return back()->withErrors('You can\'t edit non exist consultation  :D ');
  
    switch ($request->what)
    {
      case 'consultation':
        
        $tab=SceneActorConsultation::where('id',$request->consultation_id)->first();
        $tab->cont_id = $request->cont_id;
        $tab->sac_type_details = $request->sac_type_details;
        $tab->sac_reason = $request->sac_reason;
        $tab->sac_verbal_attach = $request->sac_verbal_attach;
        $tab->sac_description = $request->sac_description;
        
        $tab->save();
        \Illuminate\Support\Facades\Session::flash('success', 'Consultation for Scene Actor has been edited probably successfully :) ');    

        $ret = $request;
        $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
        
        return response()->json($ret);
      break;

      case 'consultation_time':
  
        $tab=SceneActorConsultation::where('id',$request->consultation_id)->first();
        $tab->sac_date_order = $request->sac_date_order;
        $tab->sac_date_visit = $request->sac_date_visit;
        $tab->sac_date_descript = $request->sac_date_descript;        
        $tab->save();
        \Illuminate\Support\Facades\Session::flash('success', 'Time in Consultation for Scene Actor has been edited probably successfully :) ');    

        $ret = $request;
        $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];
        
        return response()->json($ret);
      break;
      case 'consultation_fill_time':
  
        $tab=SceneActorConsultation::where('id',$request->consultation_id)->first();
        if ($tab->sac_date_visit == null)
          $tab->sac_date_visit = $tab->scene_actor->scene->scene_current_time();
        elseif ($tab->sac_date_descript == null)
          {
          if ($tab->sac_date_visit > $tab->scene_actor->scene->scene_current_time())
            $tab->sac_date_visit = $tab->scene_actor->scene->scene_current_time();
          $tab->sac_date_descript = $tab->scene_actor->scene->scene_current_time();
          }
        $tab->save();
        \Illuminate\Support\Facades\Session::flash('success', 'Time in Consultation for Scene Actor has been created probably successfully :) ');    

        $ret = $request;
        $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];

        return response()->json($ret);
      break;

      case 'consultation_current_time':
  
        $tab=SceneActorConsultation::where('id',$request->consultation_id)->first();
        $tab->sac_date_descript = $tab->scene_actor->scene->scene_current_time();
        if ($tab->sac_date_visit > $tab->scene_actor->scene->scene_current_time())
          $tab->sac_date_visit = $tab->scene_actor->scene->scene_current_time();

        $tab->save();
        \Illuminate\Support\Facades\Session::flash('success', 'Time in Consultation for Scene Actor has been changed to now probably successfully :) ');    

        $ret = $request;
        $ret = ['success' => 'Dane raczej zapisane prawidłowo :) .','table' => $ret];

        return response()->json($ret);
      break;

      case 'consultation_file_save':
        Log::info('Pułapka SD  id : ['.$request->id.'].');       
        Log::info('Pułapka SD  consultation_id : ['.$request->consultation_id.'].');       
        Log::info('Pułapka SD  saca_file_full : ['.$request->saca_file_full.'].');       
        if ($request->id > 0)
          $tab=SceneActorConsultationAttachment::where('id',$request->id)->first();
        else
          $tab=new SceneActorConsultationAttachment;

        $tab->sac_id=$request->consultation_id;
        $tab->saca_type='picture';
        $tab->saca_date=SceneActorConsultation::where('id',$request->consultation_id)->first()->sac_date_visit;
        if ($tab->saca_date == null)
          $tab->saca_date=SceneActorConsultation::where('id',$request->consultation_id)->first()->scene_actor->scene->scene_current_time();
        $tab->saca_file=str_replace(env('APP_URL'),'',$request->saca_file_full);
        $tab->save();

        $ret = $request;
        $ret = ['success' => 'Dane załącznika raczej zmienione prawidłowo :) .', 'code' => 1, 'table' => $ret ];
        return response()->json($ret);
      break;

      case 'consultation_fdescript_save':
        if ($request->id > 0)
          {
          $tab=SceneActorConsultationAttachment::where('id',$request->id)->first();
          $tab->saca_name = $request->saca_name;
          $tab->save();  
          return ['code' => 1, 'success' => 'Dane załącznika - opis - raczej zmienione prawidłowo :) .'];
          }
        else
        return ['code' => 0, 'success' => 'Dane załącznika NIE zmienione :) .'];
      break;

      case 'inc_delete':
        if ($request->id > 0)
          {
            if ($request->target == 'character_attachment')
              {
              $tab=SceneActorConsultationAttachment::where('id',$request->id)->first();
              if ($request->delete_approve == 'TAK')
                $tab->delete();
              return ['code' => 1, 'success' => 'Załącznik konsultacji raczej USUNIĘTE prawidłowo :) .'];
              }
            elseif ($request->target == 'character_consultation')
              {
              $tab=SceneActorConsultation::where('id',$request->id)->first();
              if ($request->delete_approve == 'TAK')
                $tab->delete();
              return ['code' => 1, 'success' => 'Konsultacja raczej USUNIĘTA prawidłowo :) .'];
              }
            else
              return ['code' => 0, 'success' => 'Błędny kod usunięcia :( .'];    
          }
        else
          return ['code' => 0, 'success' => 'Dane załącznika NIE zmienione :( .'];
        
      break;

      case 'consultation_from_template':

        $from_fill = ScenarioConsultationTemplate::where('id',$request->template_id)->first();
        $to_fill = SceneActorConsultation::where('id',$request->consultation_id)->first();
        $to_fill->sac_verbal_attach = $from_fill->sct_verbal_attach;
        $to_fill->sac_description   = $from_fill->sct_description;
        if ($to_fill->sac_date_visit!=null)
          $to_fill->sac_date_descript  = date('Y-m-d H:i:s',strtotime($to_fill->sac_date_visit.' + '.$from_fill->sct_seconds_description.' seconds'));
        $to_fill->save();

        SceneActorConsultationAttachment::where('sac_id',$request->consultation_id)->delete();
        

        $attach_from = ScenarioConsultationTemplateAttachment::where('sct_id',$request->template_id)->get();
        
        foreach ($attach_from as $attach_one)
        {
        $attach_to=new SceneActorConsultationAttachment();
        $attach_to->sac_id = $to_fill->id;
        $attach_to->saca_file = $attach_one->scta_file;
        $attach_to->saca_name = $attach_one->scta_name;

        if ($attach_to->saca_date == null)
          $attach_to->saca_date=date('Y-m-d H:i:s',strtotime($to_fill->sac_date_visit.' + '.$attach_one->scta_seconds_attachment.' seconds'));
        
        $attach_to->save();
    
        }

        return ['code' => 0, 'success' => 'Dane przepisane z szablonu (chyba)... .'];

       break;

      default:
        dd($request);
    }
  }

}