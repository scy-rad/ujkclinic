@extends('layouts.master')

<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">

@section('content')

@include('layouts.success_error')
<div class="row">

  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-incognito"></i> Aktor dla scenariusza <strong><a href="{{route('scenario.show', $actor->scenario)}}"><i class="bi bi-camera-reels"></i> {{$actor->scenario->scenario_code}} </a></strong>
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
          <p><label>Czy NN:</label><br>
            @if ($actor->actor_nn==1) TAK @else NIE @endif
          </p>
          <p><label>Przesunięcie przyjęcia:</label><br>
            {{$actor->actor_incoming_recalculate}}
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
        Szablony badań laboratoryjnych
      </div>
      <div class="card-body">
        <ul>
          @foreach ($actor->lab_order_templates as $lrt)
            <li><a href="{{route('laboratorynorm.template', $lrt->id)}}"><label class="small text-primary fw-bold">{{$lrt->id}} [{{$lrt->name_of_type()}}]:</label> {{$lrt->description_for_leader}} </a></li>
          @endforeach
        </ul>
      </div>
      <div class="card-footer">
      <span class="btn btn-primary" onClick="javascript:showTemplateEditModal()">dodaj szablon</span>
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


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<?php
$lab_order_template=new App\Models\LabOrderTemplate();
$actor_id=$actor->id;
?>
@include('laboratorynorms.modal_template_edit')


@endsection
