@extends('layouts.master')

<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">

@section('content')

@include('layouts.success_error')
<div class="row">

  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
        Aktor dla scenariusza <strong><a href="{{route('scenario.show', $actor->scenario)}}">{{$actor->scenario->scenario_code}} <i class="bi bi-hospital"></i></a></strong>
      </div>
      <div class="card-body">

          <h4><label>nazwa roli:</label><br>{{$actor->actor_role_name}}</h4>

          <p><label>rola:</label><br>
            {{$actor->actor_role_plan->short}}
          </p>
          <p><label>rodzaj aktora:</label><br>
            {{$actor->actor_type->name}}
          </p>
          <p><label>wiek:</label><br>
            {{$actor->actor_age_from}} - {{$actor->actor_age_to}} {{$actor->age_interval_name()}}
          </p>
          <p><label>płeć:</label><br>
            {{$actor->sex_name()}}
          </p>
          <p><label>historia dla aktora:</label><br>
            {!! $actor->history_for_actor !!}
          </p>
          <p><label>opis pozoracji:</label><br>
            {!! $actor->actor_simulation !!}
          </p>

      </div>
      <div class="card-footer">
      <a class="btn btn-primary m-1" href="{{ route('actor.edit',$actor->id) }}">Edytuj</a>
      </div>
    </div>
  </div>


  
  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
        Badania laboratoryjne
      </div>
      <div class="card-body">

        <ul>
          <li><label class="small text-primary fw-bold">wykaz szablonów badań laboratoryjnych:</label><br> </li>
          <li><label class="small text-primary fw-bold">wykaz wykonanych badań laboratoryjnych:</label><br> </li>
        </ul>
      </div>
      <div class="card-footer">
      <a class="btn btn-info m-1" href="#">szczegóły</a>
      </div>
    </div>
  </div>

  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
        Badania diagnostyczne
      </div>
      <div class="card-body">
        <ul>
          <li><label class="small text-primary fw-bold">wykaz wykonanych badań diagnostycznych:</label><br> </li>
          <li><label class="small text-primary fw-bold">wykaz przygotowanych badań diagnostycznych:</label><br> </li>
        </ul>
      </div>
      <div class="card-footer">
      <a class="btn btn-info m-1" href="#">szczegóły</a>
      </div>
    </div>
  </div>

  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
        Załączniki
      </div>
      <div class="card-body">
        <ul>
          <li><label class="small text-primary fw-bold">wykaz załączników:</label><br> (np. szablon do LEEAPa, zdjęcia pozoracji, pliki do druku itp) </li>
        </ul>
      </div>
      <div class="card-footer">
      <a class="btn btn-info m-1" href="#">szczegóły</a>
      </div>
    </div>
  </div>

</div>

@endsection
