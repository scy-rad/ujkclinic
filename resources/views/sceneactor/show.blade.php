@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> SceneActor -> show <span class="text-danger">in progress...</span>
@endsection

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

@include('layouts.success_error')


<!-- clock code part I -->
<div class="row mb-3">
  <div class="col-2">
    <div class="bg-primary btn w-100 text-center text-truncate" disabled id="zegar">
      {{date("Y-m-d",strtotime($sceneactor->scene->scene_date))}}
      <h1>{{date("H:i",strtotime($sceneactor->scene->scene_date))}}</h1>
    </div>
  </div>
  <div class="col-2">
  <button class="btn w-100 h-100 btn-success text-truncate" id="change_relative_time" onClick="javascript:change_relative_time({{$sceneactor->scene->id}})"> <h1><span id="min_step">{{$sceneactor->scene->scene_step_minutes}}</span> min.<br><i class="bi bi-fast-forward-fill"></i></h1> </button>
  </div>
  <div class="col-7">
    <h2>{{$sceneactor->scene->scene_code}}: {{$sceneactor->scene->scene_name}}</h2>
  </div>
  <div class="col-1">
    @if (is_null($sceneactor->scene->scene_relative_date))
      <button class="btn w-100 h-100 btn-danger" onClick="javascript:start_scene({{$sceneactor->scene->id}})"> <h1><span id="status_txt"><i class="bi bi-play-btn-fill"></i></span></h1> </button>
    @endif
  </div>
</div>

<input type="hidden" id="relative_sec" value="{{$diff_sec}}">
<!-- end of clock code part I -->

<div class="row">
  <div class="col-2">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-file-person"></i>
        <h2>{{$sceneactor->sa_name}}</h2>
      </div>
      <p>
        <label>nr KG:</label> {{$sceneactor->sa_main_book}}<br>
        <label>wiek:</label> {{$sceneactor->sa_age_txt}}<br>
        <label>PESEL:</label> {{$sceneactor->sa_PESEL}}<br>
        <label>data prz.:</label> {{$sceneactor->sa_incoming_date}}<br>
        <i class="bi bi-hospital"></i> <a href="{{ route('scene.show',$sceneactor->scene->id) }}">{{$sceneactor->scene->scene_code}}: {{$sceneactor->scene->scene_name}} </a>

      </p>
    </div>
  </div>
  <div class="col-2">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-eyedropper"></i> 
      Badania Laboratoryjne
      </div>
        <ul>
          @foreach ($laborders as $order_one)
            <li onClick="javascript:showLabResultModal({{$order_one->id}})">{{$order_one->id}}: {{$order_one->salo_date_order}}

            @if (is_null($order_one->salo_date_take))
              <i class="bi bi-bookmark"></i>
            @endif
            @if (is_null($order_one->salo_date_delivery))
              <i class="bi bi-bookmark"></i>
            @endif
            @if (is_null($order_one->salo_date_accept))
              <i class="bi bi-bookmark"></i>
            @else
              @if ($order_one->salo_date_accept>$sceneactor->scene->scene_current_time())
                <i class="bi bi-bookmark-fill text-warning"></i>
              @else
                <i class="bi bi-bookmark-fill text-success"></i>
              @endif
            @endif

            </li>
          @endforeach
        </ul>
      <div class="card-footer">
        <button class="btn btn-warning btn-sm col-12" onClick="javascript:showLabOrderModal()"> <i class="bi bi-eyedropper"></i> dodaj </button>
      </div>
    </div>
  </div>

  <div class="col-2">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-camera-video"></i> 
      Badania Diagnostyczne
      </div>
      xyz
      <div class="card-footer">
      <i class="bi bi-camera-video"></i> 
      Dodaj
      </div>
    </div>
  </div>

  <div class="col-2">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-card-list"></i> 
      Dok. medyczna
      </div>
      xyz
      <div class="card-footer">
      <i class="bi bi-card-list"></i> 
      Dodaj
      </div>
    </div>
  </div>


</div>



<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>


@include('sceneactor.modal_lab_order')
@include('sceneactor.modal_lab_results')

@if (!is_null($sceneactor->scene->scene_relative_date))
<!-- clock code part II -->
<script>
  function zegarek()
  {
    var zmienna = $('#relative_sec').val();

    var data = new Date(new Date().getTime()+(zmienna*1000-3600000)); //- 3600000: hand changing timezone

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
            if (data.scene_data.diff_sec != $('#relative_sec').val())
            {
              $('#relative_sec').val(data.scene_data.diff_sec);
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
      get_relative_time({{$sceneactor->scene->id}});
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

</script> 

@endif


@endsection
