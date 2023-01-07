<?php
  // scene_master_id
  // actor_id
  // sa_incoming_date
  // sa_incoming_recalculate
  // sa_main_book
  // sa_name
  // sa_birth_date
  // sa_PESEL
  // sa_actor_sex  // 2 - mężczyzna,  3 - kobieta
  // sa_actor_nn
  // sa_actor_role_name
  // sa_history_for_actor
  // sa_actor_simulation
?>


<div class="modal fade" id="SceneActor" tabindex="-2" aria-labelledby="SceneActorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="SceneActorTitle">Edycja aktora </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">


          <form action="{{ route('scene.actor_save_ajax') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <input type="hidden" name="scene_master_id" value="{{$scene->id}}">
            <input type="hidden" id="actor_id" name="id" value="">
            

            <div class="row mb-3">
              <div class="col-5">
                <label for="sa_incoming_date" class="form-label">data rejestracji:</label>
                <input type="datetime-local" id="sa_incoming_date" name="sa_incoming_date" class="form-control" placeholder="data rejestracji" value="">
              </div>
              <div class="col-3">
                <label for="sa_incoming_recalculate" class="form-label">przes. czasu:</label>
                <input type="text" id="sa_incoming_recalculate" name="sa_incoming_recalculate" class="form-control" placeholder="przesunięcie czasu" value="0">
              </div>
              <div class="col-4">
                <label for="sa_main_book" class="form-label">nr księgi głównej:</label>
                <input type="text" id="sa_main_book" name="sa_main_book" class="form-control" placeholder="nr księgi głównej" value="">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-4">
              <label for="sa_actor_sex" class="form-label">płeć:</label>
                <select id="sa_actor_sex" name="sa_actor_sex" class="form-select">
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
                <label for="sa_actor_nn" class="form-label">czy NN:</label>
                <input type="text" id="sa_actor_nn" name="sa_actor_nn" class="form-control" placeholder="czy NN" value="0">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="sa_actor_role_name" class="form-label">nazwa roli:</label>
                <input type="text" id="sa_actor_role_name" name="sa_actor_role_name" class="form-control" placeholder="nazwa roli" value="">
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
                <label for="sa_actor_simulation" class="form-label">charakteryzacja aktora:</label>
                <textarea id="sa_actor_simulation" name="sa_actor_simulation" class="form-control"></textarea>
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
  function showActorModal(idvalue)
  {
    $.ajax({
            type:'GET',
            url:"{{ route('scene.getajax') }}",
            data:{idvalue:idvalue,what:'actor'},
            success:function(data){
                if($.isEmptyObject(data.error)){
                  // alert(JSON.stringify(data, null, 4));
                  $('#SceneActorTitle').html('Edycja aktora: '+data.scene_data.id);
                  $('#actor_id').val(data.scene_data.id);
                  $('#sa_incoming_date').val(data.scene_data.sa_incoming_date);
                  $('#sa_incoming_recalculate').val(data.scene_data.sa_incoming_recalculate);
                  $('#sa_main_book').val(data.scene_data.sa_main_book);
                  $('#sa_name').val(data.scene_data.sa_name);
                  $('#sa_birth_date').val(data.scene_data.sa_birth_date);
                  $('#sa_PESEL').val(data.scene_data.sa_PESEL);
                  $('#sa_actor_nn').val(data.scene_data.sa_actor_nn);
                  $('#sa_actor_role_name').val(data.scene_data.sa_actor_role_name);

                  $('#sa_history_for_actor').val(data.scene_data.sa_history_for_actor);
                  $('#sa_actor_simulation').val(data.scene_data.sa_actor_simulation);

                  
                  }else{
                    printErrorMsg(data.error);
                  }
                }
            });

    $('#SceneActor').modal('show');
  }
</script>
