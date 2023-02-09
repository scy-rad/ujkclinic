<?php
  // scene_master_id
  // character_id
  // sa_incoming_date
  // sa_incoming_recalculate
  // sa_main_book
  // sa_name
  // sa_birth_date
  // sa_PESEL
  // sa_sex  // 2 - mężczyzna,  3 - kobieta
  // sa_nn
  // sa_role_name
  // sa_history_for_actor
  // sa_simulation
?>


<div class="modal fade" id="SceneActor" tabindex="-2" aria-labelledby="SceneActorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="float-start">
          <h5 class="float-start modal-title" id="SceneActorTitle">Edycja aktora</h5>
        </div>
        <div style="margin: 0 auto">

        </div>
        <div class="float-end">
          <button class="btn btn-outline-success ms-10 float-end" onClick="javascript:proposeCharacter()">generuj</button>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      <div class="modal-body">


          <form action="{{ route('sceneactor.scene_actor_save_ajax') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <input type="hidden" name="scene_master_id" value="{{$scene->id}}">
            <input type="hidden" id="character_id" name="id" value="">
            

            <div class="row mb-3">
              <div class="col-5">
                <input type="hidden" id="sa_incoming_date_start" value="0">
                <label for="sa_incoming_date" class="form-label">data rejestracji:</label>
                <input type="datetime-local" id="sa_incoming_date" name="sa_incoming_date" class="form-control" placeholder="data rejestracji" value="">
              </div>
              <div class="col-3">
                <label for="sa_incoming_recalculate" class="form-label">przes. czasu:</label>
                <input type="text" id="sa_incoming_recalculate" name="sa_incoming_recalculate" class="form-control" placeholder="przesunięcie czasu" value="">
              </div>
              <div class="col-4">
                <label for="sa_main_book" class="form-label">nr księgi głównej:</label>
                <input type="text" id="sa_main_book" name="sa_main_book" class="form-control" placeholder="nr księgi głównej" value="">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-4">
              <input type="hidden" id="sa_sex_start" value="0">
              <label for="sa_sex" class="form-label">płeć:</label>
                <select id="sa_sex" name="sa_sex" class="form-select">
                  <option value="2">mężczyzna</option>
                  <option value="3">kobieta</option>
                </select>
              </div>
              <div class="col-8">
                <label for="sa_name" class="form-label">Imię i nazwisko:</label>
                <input type="text" id="sa_name" name="sa_name" class="form-control" placeholder="Imię i nazwisko" value="">
              </div>

            </div>
            <div class="row mb-3">
              <div class="col-5">
                <label for="sa_birth_date" class="form-label">data urodzenia:</label>
                <input type="datetime-local" id="sa_birth_date" name="sa_birth_date" class="form-control" placeholder="data urodzenia" value="">
              </div>
              <div class="col-5">
                <label for="sa_PESEL" class="form-label">PESEL:</label>
                <input type="text" id="sa_PESEL" name="sa_PESEL" class="form-control" placeholder="nr PESEL" value="">
              </div>
              <div class="col-2">
                <label for="sa_nn" class="form-label">czy NN:</label>
                <input type="text" id="sa_nn" name="sa_nn" class="form-control" placeholder="czy NN" value="0">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="sa_role_name" class="form-label">nazwa roli:</label>
                <input type="text" id="sa_role_name" name="sa_role_name" class="form-control" placeholder="nazwa roli" value="">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="sa_history_for_actor" class="form-label">Historia aktora:</label>
                <textarea id="sa_history_for_actor" name="sa_history_for_actor" class="form-control" placeholder="Historia aktora"></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="sa_simulation" class="form-label">charakteryzacja aktora:</label>
                <textarea id="sa_simulation" name="sa_simulation" class="form-control"></textarea>
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="submit" class="btn btn-success btn-submit btn-tmpl-edit">Potwierdź</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function showCharacterModal(idvalue)
  {
    $.ajax({
            type:'GET',
            url:"{{ route('scene.get_scene_ajax') }}",
            data:{idvalue:idvalue,what:'character'},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  // alert(JSON.stringify(data, null, 4));
                  if (data.scene_data.sa_sex>0)
                  {
                    $('#SceneActorTitle').html('Edycja aktora: '+data.scene_data.id);
                    $('#character_id').val(data.scene_data.id);
                    $('#sa_incoming_date').val(data.scene_data.sa_incoming_date);
                    $('#sa_incoming_recalculate').val(data.scene_data.sa_incoming_recalculate);
                    $('#sa_main_book').val(data.scene_data.sa_main_book);
                    $('#sa_name').val(data.scene_data.sa_name);
                    $('#sa_birth_date').val(data.scene_data.sa_birth_date);
                    $('#sa_birth_date_start').val(data.scene_data.sa_birth_date);
                    $('#sa_PESEL').val(data.scene_data.sa_PESEL);
                    $('#sa_sex').val(data.scene_data.sa_sex);
                    $('#sa_sex_start').val(data.scene_data.sa_sex);
                    $('#sa_nn').val(data.scene_data.sa_nn);                  
                    $('#sa_role_name').val(data.scene_data.sa_role_name);
                    $('#sa_history_for_actor').val(data.scene_data.sa_history_for_actor);
                    $('#sa_simulation').val(data.scene_data.sa_simulation);
                  }
                  else
                  {
                    $('#SceneActorTitle').html('Dodawanie aktora');
                    $('#character_id').val(data.scene_data.id);
                    $('#sa_incoming_date').val(data.scene_data.sa_incoming_date);
                    $('#sa_incoming_recalculate').val(0);
                    $('#sa_main_book').val(data.scene_data.sa_main_book);
                    $('#sa_name').val(data.scene_data.sa_name);
                    $('#sa_birth_date').val(data.scene_data.sa_birth_date);
                    $('#sa_birth_date_start').val(data.scene_data.sa_birth_date);
                    $('#sa_PESEL').val(data.scene_data.sa_PESEL);
                    // $('#sa_sex').val(data.scene_data.sa_sex);
                    $('#sa_sex_start').val(data.scene_data.sa_sex);
                    $('#sa_nn').val(0);                  
                    $('#sa_role_name').val(data.scene_data.sa_role_name);
                    $('#sa_history_for_actor').val(data.scene_data.sa_history_for_actor);
                    $('#sa_simulation').val(data.scene_data.sa_simulation);
                  }
                }
                else
                {
                  printErrorMsg(data.error);
                }
              }
            });

    $('#SceneActor').modal('show');
  }

  function proposeCharacter()
  {
    $.ajax({
            type:'GET',
            url:"{{ route('scene.get_scene_ajax') }}",
            data:{character_sex:$('#sa_sex').val(),
              birth_date:$('#sa_birth_date').val(),
              what:'character_propose'},
            success:function(data){
                if($.isEmptyObject(data.error)){
                  // alert(JSON.stringify(data, null, 4));
                  $('#sa_PESEL').val(data.PESEL);
                  $('#sa_name').val(data.name);
                  }else{
                    printErrorMsg(data.error);
                  }
                }
            });
  }
</script>
