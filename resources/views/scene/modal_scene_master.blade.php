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
      <h5 class="modal-title" id="SceneModalTitle">@if ($scene->id>0) Edycja sceny {{$scene->id}} @else Tworzenie sceny @endif</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($scene->id>0)
          <form action="{{ route('scene.update',$scene->id)}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" required="required" value="{{$scene->id}}">
            {{ method_field('PUT') }}
        @else
          <form action="{{ route('scene.store')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" required="required" value="">
        @endif
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
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
                <input type="datetime" name="scene_date" class="form-control" placeholder="data akcji" value="{{$scene->scene_date}}">
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
              <div class="col-3">
                <label for="scene_lab_take_seconds_from" class="form-label">pobranie od (s):</label>
                <input type="number" step="5" min="0" max="300" name="scene_lab_take_seconds_from" class="form-control" placeholder="ilość sekund od zlecenie do pobrania" value="{{$scene->scene_lab_take_seconds_from}}">
              </div>
              <div class="col-3">
                <label for="scene_lab_take_seconds_to" class="form-label">pobranie do (s):</label>
                <input type="number" step="5" min="0" max="300" name="scene_lab_take_seconds_to" class="form-control" placeholder="ilość sekund od zlecenie do pobrania" value="{{$scene->scene_lab_take_seconds_to}}">
              </div>
              <div class="col-3">
                <label for="scene_lab_delivery_seconds_from" class="form-label">dostarcz. od (s):</label>
                <input type="number" step="5" min="0" max="600" name="scene_lab_delivery_seconds_from" class="form-control" placeholder="ilość sekund od pobrania do przekaznia do laboratorium" value="{{$scene->scene_lab_delivery_seconds_from}}">
              </div>
              <div class="col-3">
                <label for="scene_lab_take_seconds_to" class="form-label">dostarcz. do (s):</label>
                <input type="number" step="5" min="0" max="720" name="scene_lab_delivery_seconds_to" class="form-control" placeholder="ilość sekund od pobrania do przekaznia do laboratorium" value="{{$scene->scene_lab_delivery_seconds_to}}">
              </div>
              <div class="col-12">
                <div class="form-check form-switch">
                  <label for="scene_lab_automatic_time" class="form-check-label">: zastosuj czasy automatycznie</label>
                  <input class="form-check-input" type="checkbox" name="scene_lab_automatic_time"@if ($scene->scene_lab_automatic_time==1) checked @endif>
                </div>
              </div>
            </div>
            
            <div class="row mb-3">
              <div class="col-12">
                <label for="scene_scenario_description" class="form-label">Opis sceny:</label>
                <textarea name="scene_scenario_description" class="form-control" placeholder="Napisz informacje dla prowadzącego">{!!$scene->scene_scenario_description!!}</textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="scene_scenario_for_students" class="form-label">Opis dla studenta:</label>
                <textarea name="scene_scenario_for_students" class="form-control" placeholder="Informacje dla studentów przed rozpoczęciem scenariusza">{!!$scene->scene_scenario_for_students!!}</textarea>
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
