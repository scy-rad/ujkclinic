@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> Scene -> index <span class="text-danger">in progress...</span>
@endsection

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
@endsection

@section('content')
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <h1>{{ __('Scenes') }}</h1>
    </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="#" id="your-darkmode-button-id">{{ __('Change theme') }}</a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
      </ul>
  </div>
</nav>


@include('layouts.success_error')


<div class="row">

  @foreach ($scenes as $scene)
    <div class="col-sm-2 p-2">
      <a class="text-decoration-none" href="{{ route('scene.show',$scene->id) }}">
        <div class="card bg-primary text-white text-truncate">
          <div class="card-body text-center">
            <h1 class="card-title"><i class="bi bi-hospital"></i> {{$scene->scene_code}}</h1>
            <p class="card-text">{{$scene->scene_name}}</p>
          </div>
          <div class="card-footer m-0 p-0 text-end">
          {{$scene->owner->name}}
          </div>
        </div>
      </a>
    </div>
  @endforeach

  @if (Auth::user()->hasRoleCode('technicians')) 
    <div class="col-sm-2 p-2">
      <a class="text-decoration-none" onClick="javascript:showSceneModal()" href="#">
        <div class="card bg-warning text-black text-truncate">
          <div class="card-body text-center">
            <h1 class="card-title"><i class="bi bi-hospital"></i> </h1>
            <p class="card-text fw-bold">stwórz scenę</p>
            <!--a href="#" class="btn btn-primary">Go somewhere</a-->
          </div>
          <div class="card-footer m-0 p-0 text-end">
          {{Auth::user()->name}}
          </div>
        </div>
      </a>
    </div>
  @endif

  </div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<?php
 $scene= new App\Models\SceneMaster();
 $scene->scene_date=date("Y-m-d H:i");
 $scene_params = App\Models\SceneParam::all()->first();
 $scene->scene_lab_take_seconds_from     = $scene_params->lab_take_seconds_from;
 $scene->scene_lab_take_seconds_to       = $scene_params->lab_take_seconds_to;
 $scene->scene_lab_delivery_seconds_from = $scene_params->lab_delivery_seconds_from;
 $scene->scene_lab_delivery_seconds_to   = $scene_params->lab_delivery_seconds_to;
 $scene->scene_lab_automatic_time        = 1;
 ?>
@include('scene.modal_scene_master')

@endsection
