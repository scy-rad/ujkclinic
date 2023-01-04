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
          <p><label>typ scenariusza:</label><br>
                {{$scenario->type->name}}
          </p>
          <p><label>główny problem:</label><br>
                {{$scenario->scenario_main_problem}}
          </p>
          <p><label>opis:</label><br>
                {{$scenario->scenario_description}}
          </p>
          <p><label>opis dla studentów:</label><br>
                {{$scenario->scenario_for_students}}
          </p>
          <p><label>opis dla instruktora:</label><br>
                {{$scenario->scenario_for_leader}}
          </p>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-auto">
              <a class="btn btn-primary m-1" href="{{ route('scenario.edit',$scenario->id) }}"><i class="bi bi-camera-reels"></i> Edytuj</a>
          </div>
          <div class="col-auto">
            <a class="btn btn-success m-1" href="{{ route('actor.create',['scenario_id' => $scenario->id]) }}"><i class="bi bi-incognito"></i> Dodaj aktora</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if (!(is_null($actors)))
  @foreach ($actors as $actor_one)
  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-incognito"></i> Aktor dla scenariusza <strong>{{$scenario->scenario_code}}</strong>
      </div>
      <div class="card-body">

          <h4><label>nazwa roli:</label><br>{{$actor_one->actor_role_name}}</h4>

          <p><label>rola:</label><br>
            {{$actor_one->actor_role_plan->short}}
          </p>
          <p><label>rodzaj aktora:</label><br>
            {{$actor_one->actor_type->name}}
          </p>
          <p><label>wiek:</label><br>
            {{$actor_one->actor_age_from}} - {{$actor_one->actor_age_to}} {{$actor_one->age_interval_name()}}
          </p>
          <p><label>płeć:</label><br>
            {{$actor_one->sex_name()}}
          </p>
          <p><label>historia dla aktora:</label><br>
            {!! $actor_one->history_for_actor !!}
          </p>
          <p><label>opis pozoracji:</label><br>
            {!! $actor_one->actor_simulation !!}
          </p>
        <ul>DODATKI:
          @if ($actor_one->lab_templates->count()>0)
          <li><label class="small text-primary fw-bold">szablony badań laboratoryjnych:</label> {{$actor_one->lab_templates->count()}} </li>
          @endif
        </ul>

        <ul>DODATKI DO ZROBIENIA:
          <li><label class="small text-primary fw-bold">wykaz szablonów badań laboratoryjnych:</label><br> </li>
          <li><label class="small text-primary fw-bold">wykaz załączników:</label><br> (np. szablon do LEEAPa, zdjęcia pozoracji, pliki do druku itp) </li>
        </ul>
      </div>
      <div class="card-footer">
      <a class="btn btn-info m-1" href="{{ route('actor.show',$actor_one->id) }}"><i class="bi bi-incognito"></i> Pokaż</a>
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
 $scene->scene_scenario_description=$scenario->scenario_description;
 $scene->scene_scenario_for_students=$scenario->scenario_for_students;
 ?>
@include('scene.modal_scene_master')

@endsection
