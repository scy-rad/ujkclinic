<!-- clock code part I -->
<div class="row mb-3">
  <div class="col-3">
    <div class="bg-primary btn w-100 h-100 text-center text-truncate" disabled id="zegar">
      {{date("Y-m-d",strtotime($sceneactor->scene->scene_date))}}
      <h1>{{date("H:i",strtotime($sceneactor->scene->scene_date))}}</h1>
    </div>
  </div>
  <div class="col-3">
    @if (!(is_null($sceneactor->scene->scene_relative_date)))
      <button class="btn w-100 h-100 btn-success text-truncate" id="change_relative_time" onClick="javascript:change_relative_time({{$sceneactor->scene->id}})"> <h1><span id="min_step">{{$sceneactor->scene->scene_step_minutes}}</span> min.<br><i class="bi bi-fast-forward-fill"></i></h1> </button>
    @endif
  </div>
  <div class="col-3">
    <div class="bg-info btn w-100 h-100 text-center text-truncate" disabled id="stopwatch">
      <span >odliczanie <br>zatrzymane</span>
    </div>
  </div>
  <div class="col-3">
      <a class="text-decoration-none" href="{{ route('scene.show',$sceneactor->scene->id) }}">
        <div class="card bg-primary text-white text-truncate">
          <div class="card-body text-center">
            <h1 class="card-title"><i class="bi bi-hospital"></i> {{$sceneactor->scene->scene_code}}</h5>
            <p class="card-text">{{$sceneactor->scene->scene_name}}</p>
          </div>
        </div>
      </a>
  </div>
</div>