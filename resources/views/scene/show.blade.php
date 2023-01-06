@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> Scene -> show <span class="text-danger">in progress...</span>
@endsection

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

@include('layouts.success_error')

<!-- clock code part I -->
<div class="row">
  <div class="col-2">
    <div class="bg-primary btn w-100 text-center text-truncate" disabled id="zegar">
      {{date("Y-m-d",strtotime($scene->scene_date))}}
      <h1>{{date("H:i",strtotime($scene->scene_date))}}</h1>
    </div>
  </div>
  <div class="col-2">
  <button class="btn w-100 h-100 btn-success text-truncate" id="change_relative_time" onClick="javascript:change_relative_time({{$scene->id}})"> <h1><span id="min_step">{{$scene->scene_step_minutes}}</span> min.<br><i class="bi bi-fast-forward-fill"></i></h1> </button>
  </div>
  <div class="col-7">
    <h2>{{$scene->scene_code}}: {{$scene->scene_name}}</h2>
  </div>
  <div class="col-1">
    @if (is_null($scene->scene_relative_date))
      <button class="btn w-100 h-100 btn-danger" onClick="javascript:start_scene({{$scene->id}})"> <h1><span id="status_txt"><i class="bi bi-play-btn-fill"></i></span></h1> </button>
    @endif
  </div>
</div>

<input type="hidden" id="relative_min" value="{{$diff_min}}">
<!-- end of clock code part I -->





<div class="card">
    <div class="card-header">
        <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a href="#descript" class="nav-link active" data-bs-toggle="tab">Opis</a>
            </li>
            @if ($scene->scenario_id>0)
            <li class="nav-item">
                <a href="#base_scenario" class="nav-link" data-bs-toggle="tab">Scenariusz bazowy</a>
            </li>
            @endif
            <li class="nav-item">
                <a href="#admin" class="nav-link" data-bs-toggle="tab">Administracja</a>
            </li>
            <li class="nav-item">
                <a href="#nothing" class="nav-link" data-bs-toggle="tab">Zwiń</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="descript">
              <p>
              <label>opis:</label> {!!$scene->scene_scenario_description!!}<br>
              <label>opis dla studentów:</label> {!!$scene->scene_scenario_for_students!!}
              </p>
            </div>
            @if ($scene->scenario_id>0)
            <div class="tab-pane fade" id="base_scenario">
              <p>
              <label>scenario_author_id:</label> {{$base_scenario->scenario_author_id}}<br>
              <label>center_id:</label> {{$base_scenario->center_id}}<br>
              <label>scenario_type_id:</label> {{$base_scenario->scenario_type_id}}<br>
              <label>scenario_name:</label> {{$base_scenario->scenario_name}}<br>
              <label>scenario_code:</label> {{$base_scenario->scenario_code}}<br>
              <label>scenario_main_problem:</label> {{$base_scenario->scenario_main_problem}}<br>
              <label>scenario_description:</label> {!!$base_scenario->scenario_description!!}<br>
              <label>scenario_for_students:</label> {!!$base_scenario->scenario_for_students!!}<br>
              <label>scenario_for_leader:</label> {{$base_scenario->scenario_for_leader}}<br>
              <label>scenario_helpers_for_students:</label> {!!$base_scenario->scenario_helpers_for_students!!}<br>
              <label>scenario_logs_for_students:</label> {!!$base_scenario->scenario_logs_for_students!!}
              <p>
            </div>
            @endif
            
            <div class="tab-pane fade" id="admin">
              <p><label>data początku:</label> {{$scene->scene_date}}<br>
              <label>status:</label> {{$scene->status_name()}}<br>
              <label>reżyser sceny:</label> {{$scene->owner->name}}<br>
              </p>
              @if (!is_null($scene->scene_relative_date))
              <button class="btn btn-lg btn-danger" onClick="javascript:stop_scene({{$scene->id}})"> <h1><span id="status_txt"><i class="bi bi-stop-btn-fill"></i></span></h1> </button>
              @endif

              <button class="btn btn-warning btn-lg" onClick="javascript:showSceneModal()"> <h1><i class="bi bi-hospital"></i> Edytuj scenę</h1> </button>
            </div>

            <div class="tab-pane fade" id="nothing">
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>


@include('scene.modal_scene_master')


@if (!is_null($scene->scene_relative_date))
<!-- clock code part II -->
<script>
  function zegarek()
  {
    var zmienna = $('#relative_min').val();

    var data = new Date(new Date().getTime()+(zmienna*60*1000));

    var godzina = data.getHours();
    var minuta = data.getMinutes();
    var sekunda = data.getSeconds();
    var dzien = data.getDate();
    var dzienN = data.getDay();
    var miesiac = data.getMonth();
    var rok = data.getFullYear();
    
    if (minuta < 10) minuta = "0" + minuta;
    if (sekunda < 10) sekunda = "0" + sekunda;
    
    var dni = new Array("niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota");
    var miesiace = new Array("stycznia", "lutego", "marca", "kwietnia", "maja", "czerwca", "lipca", "sierpnia", "września", "października", "listopada", "grudnia");
    
    var pokazDate = "<p>" + dni[dzienN] + ', ' + dzien + ' ' + miesiace[miesiac] + ' ' + rok + "</p><h1> " + godzina + ':' + minuta + ':' + sekunda + '</h1>';
    document.getElementById("zegar").innerHTML = pokazDate;
    
    setTimeout(zegarek, 1000);            
  }

  window.onload = function() {
    zegarek();
  };
</script>


<script>
  function get_relative_time(idvalue) 
  {
    $.ajax({
      type:'GET',
      url:"{{ route('scene.getajax') }}",
      data:{idvalue:idvalue,what:'relative_time'},
      success:function(data){
          if($.isEmptyObject(data.error)){
            // alert(JSON.stringify(data, null, 4));
            if (data.scene_data.diff_min != $('#relative_min').val())
            {
              $('#relative_min').val(data.scene_data.diff_min);
            }
            if (data.scene_data.scene_step_minutes != $('#min_step').text())
            {
              $('#min_step').text(data.scene_data.scene_step_minutes);
            }
            }else{
              printErrorMsg(data.error);
            }
          }
      });
  }
</script>

<script>
  $(document).ready(function(){
    window.setInterval(function () {
      get_relative_time(1);
    }, 1000);
  });
</script>


<script type="text/javascript">
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  function change_relative_time(idvalue) 
  {
    $('#change_relative_time').hide();
    $.ajax({
        type:'POST',
        url:"{{ route('scene.updateajax') }}",
        data:{
              what: 'relative_time',
              id: idvalue
            },
        success:function(data){
            if($.isEmptyObject(data.error)){
                // alert(JSON.stringify(data, null, 4));
                // alert(data.success);
                // location.reload();
            }else{
                printErrorMsg(data.error);
            }
        }
    });
    setTimeout(function() {
      $('#change_relative_time').show();
    }, 3000);       
  };
</script>  
<!-- end of clock code part II -->

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  function stop_scene(idvalue) 
  {
    $.ajax({
        type:'POST',
        url:"{{ route('scene.updateajax') }}",
        data:{
              what: 'stop_scene',
              id: idvalue
            },
        success:function(data){
            if($.isEmptyObject(data.error)){
                // alert(JSON.stringify(data, null, 4));
                location.reload();
            }else{
                printErrorMsg(data.error);
            }
        }
    });

  };
</script> 

@else
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  function start_scene(idvalue) 
  {
    $.ajax({
        type:'POST',
        url:"{{ route('scene.updateajax') }}",
        data:{
              what: 'start_scene',
              id: idvalue
            },
        success:function(data){
            if($.isEmptyObject(data.error)){
                // alert(JSON.stringify(data, null, 4));
                location.reload();
            }else{
                printErrorMsg(data.error);
            }
        }
    });

  };
</script> 
@endif


@endsection