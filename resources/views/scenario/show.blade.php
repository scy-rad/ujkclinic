@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> Scenario -> show
@endsection

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

@include('layouts.success_error')
<div class="row">
  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
        Szczegóły scenariusza <strong><i class="bi bi-camera-reels"></i> {{$scenario->scenario_code}}</strong>
      </div>
      <div class="card-body">

          <h4><label>nazwa scenariusza:</label><br>{{$scenario->scenario_name}}</h4>
      
          <p class="card-text"><label>autor scenariusza:</label><br>
              @isset($scenario->author)
                {{$scenario->author->name}}
              @else
                nieokreślony
              @endisset
          </p>
          <p><label>scenariusz dla kierunku:</label><br>
                {{$scenario->center->center_direct}}
          </p>
          <p><label>miejsce i typ scenariusza:</label><br>
                {{$scenario->scene_type->scene_type_name}} / {{$scenario->scenario_type->name}}
          </p>
          <p><label>główny problem:</label><br>
                {!!$scenario->scenario_main_problem!!}
          </p>
          <p><label>opis:</label><br>
                {!!$scenario->scenario_description!!}
          </p>
          <p><label>opis dla studentów:</label><br>
                {!!$scenario->scenario_for_students!!}
          </p>
          <p><label>opis dla instruktora:</label><br>
                {!!$scenario->scenario_for_leader!!}
          </p>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-auto">
              <a class="btn btn-primary m-1" href="{{ route('scenario.edit',$scenario->id) }}"><i class="bi bi-camera-reels"></i> Edytuj</a>
          </div>
          <div class="col-auto">
            <a class="btn btn-success m-1" href="{{ route('character.create',['scenario_id' => $scenario->id]) }}"><i class="bi bi-incognito"></i> Dodaj aktora</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if (!(is_null($characters)))
  @foreach ($characters as $character_one)
  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-incognito"></i> Postać dla scenariusza <strong>{{$scenario->scenario_code}}</strong>
      </div>
      <div class="card-body">

        <h4><label>nazwa roli:</label><br>{{$character_one->character_role_name}}</h4>

        <p><label>rola:</label><br>
          {{$character_one->character_role_plan->short}}
        </p>
        <p><label>rodzaj postaci:</label><br>
          {{$character_one->character_type->name}}
        </p>
        <p><label>wiek:</label><br>
          {{$character_one->character_age_from}} - {{$character_one->character_age_to}} {{$character_one->age_interval_name()}}
        </p>
        <p><label>płeć:</label><br>
          {{$character_one->sex_name()}}
        </p>
        <p><label>historia dla aktora:</label><br>
          {!! $character_one->history_for_actor !!}
        </p>
        <p><label>opis pozoracji:</label><br>
          {!! $character_one->character_simulation !!}
        </p>
        <label>szablony:</label>
        <ul>
          @if ($character_one->lab_order_templates->count()>0)
            <li><label class="small text-primary fw-bold">badań laboratoryjnych:</label> {{$character_one->lab_order_templates->count()}} </li>
          @endif
          @if ($character_one->consultation_templates->count()>0)
            <li><label class="small text-primary fw-bold">konsultacji/diagnostyki:</label> {{$character_one->consultation_templates->count()}} </li>
          @endif
        </ul>

        <ul><label>DODATKI DO ZROBIENIA:</label>
          <li><label class="small text-primary fw-bold">wykaz załączników:</label><br> (np. szablon do LEEAPa, zdjęcia pozoracji, pliki do druku itp) </li>
        </ul>
      </div>
      <div class="card-footer">
      <a class="btn btn-info m-1" href="{{ route('character.show',$character_one->id) }}"><i class="bi bi-incognito"></i> Pokaż</a>
      </div>
    </div>
  </div>
  @endforeach
  @endif
  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
        Wykaz sprzętu dla scenariusza <strong>{{$scenario->scenario_code}}</strong>
      </div>
      <div class="card-body">
        <ul>
          <li>...</li>
          <li>...</li>
        </ul>
      </div>
      <div class="card-footer">
      <button type="submit" class="btn btn-info">pokaż szczegóły</button>
      </div>
    </div>
  </div>
</div>
<button class="btn btn-warning btn-lg" onClick="javascript:showSceneModal()"> <h1><i class="bi bi-hospital"></i> Stwórz scenę</h1> </button>


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<?php
 $scene= new App\Models\SceneMaster();
 $scene->scenario_id=$scenario->id;
 $scene->scene_type_id=$scenario->scene_type_id;
 $scene->scene_scenario_description=$scenario->scenario_description;
 $scene->scene_scenario_for_students=$scenario->scenario_for_students;
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
