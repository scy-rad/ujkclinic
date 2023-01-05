<?php
// id
// scene_owner_id
// scene_relative_date
// scene_relative_id
// $scene->id=0;
 ?>


<div class="modal fade" id="SceneModal" tabindex="-1" aria-labelledby="SceneModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="SceneModalTitle">Edycja sceny {{$scene->id}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($scene->id>0)
          <form action="{{ route('scene.update',$scene->id)}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" required="required" value="{{$scene->id}}">
            <span class="text-danger">akcja PUT - update - >0</span>
            {{ method_field('PUT') }}
        @else
          <form action="{{ route('scene.store')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" required="required" value="">
            <span class="text-danger">akcja POST - store - =0</span>
        @endif
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="mb-3">

            <input type="hidden" name="scenario_id" value="{{$scene->scenario_id}}">
            <div class="row mb-3">
              <div class="col-4">
                <label for="scene_code" class="form-label">kod:</label>
                <input type="text" name="scene_code" class="form-control" placeholder="Kod sceny" value="{{$scene->scene_code}}">
              </div>
              <div class="col-8">
                <label for="scene_name" class="form-label">nazwa:</label>
                <input type="text" name="scene_name" class="form-control" placeholder="Nazwa sceny" value="{{$scene->scene_name}}">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-5">
                <label for="scene_date" class="form-label">data akcji:</label>
                <input type="datetime-local" name="scene_date" class="form-control" placeholder="data akcji" value="{{$scene->scene_date}}">
              </div>
              <div class="col-3">
                <label for="scene_step_minutes" class="form-label">Krok (min):</label>
                <input type="number" step="1" min="0" name="scene_step_minutes" class="form-control" placeholder="Krok czasu" value="{{$scene->scene_step_minutes*1}}">
              </div>
              <div class="col-4">
              <label for="scene_status" class="form-label">status:</label>
                <select name="scene_status" class="form-select">
                  <option value="1" @if ($scene->scene_status==1) checked="checked" @endif>robocza</option>
                  <option value="2" @if ($scene->scene_status==2) checked="checked" @endif>aktywna</option>
                  <option value="3" @if ($scene->scene_status==3) checked="checked" @endif>zatrzymana</option>
                  <option value="4" @if ($scene->scene_status==4) checked="checked" @endif>zakończona</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="scene_scenario_description" class="form-label">Opis scenariusza:</label>
                <textarea name="scene_scenario_description" class="form-control">{!!$scene->scene_scenario_description!!}</textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="scene_scenario_for_students" class="form-label">Opis dla studenta:</label>
                <textarea name="scene_scenario_for_students" class="form-control">{!!$scene->scene_scenario_for_students!!}</textarea>
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
  function showSceneModal()
  {
    $('#SceneModal').modal('show');
  }
</script>
