@extends('layouts.master')

@section('add_styles')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
@endsection



@section('content')

@include('layouts.success_error')
<div class="row">

  <div class="col-4 p-2">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-incognito"></i> Postać dla scenariusza <strong><a href="{{route('scenario.show', $character->scenario)}}"><i class="bi bi-camera-reels"></i> {{$character->scenario->scenario_code}} </a></strong>
      </div>
      <div class="card-body">

          <h4><label>nazwa roli:</label><br>{{$character->character_role_name}}</h4>

          <p><label>rola:</label><br>
            {{$character->character_role_plan->short}}
          </p>
          <p><label>rodzaj postaci:</label><br>
            {{$character->character_type->name}}
          </p>
          <p><label>wiek:</label><br>
            {{$character->character_age_from}} - {{$character->character_age_to}} {{$character->age_interval_name()}}
          </p>
          <p><label>płeć:</label><br>
            {{$character->sex_name()}}
          </p>
          <p><label>Czy NN:</label><br>
            @if ($character->character_nn==1) TAK @else NIE @endif
          </p>
          <p><label>Przesunięcie przyjęcia:</label><br>
            {{$character->character_incoming_recalculate}}
          </p>
          
          <p><label>historia dla aktora:</label><br>
            {!! $character->history_for_actor !!}
          </p>
          <p><label>opis pozoracji:</label><br>
            {!! $character->character_simulation !!}
          </p>

      </div>
      <div class="card-footer">
      <a class="btn btn-primary m-1" href="{{ route('character.edit',$character->id) }}">Edytuj</a>
      </div>
    </div>
  </div>


  
  <div class="col-3 p-2">
    <div class="card">
      <div class="card-header">
        Szablony badań laboratoryjnych
      </div>
      <div class="card-body">
        <ul>
          @foreach ($character->lab_order_templates as $lrt)
            <li><a href="{{route('laboratorynorm.template', $lrt->id)}}"><label class="small text-primary fw-bold">{{$lrt->id}} [{{$lrt->name_of_type()}}]:</label> {{$lrt->description_for_leader}} </a></li>
          @endforeach
        </ul>
      </div>
      <div class="card-footer">
      <span class="btn btn-primary" onClick="javascript:showTemplateEditModal()">dodaj szablon</span>
      </div>
    </div>
  </div>

  <div class="col-3 p-2">
    <div class="card">
      <div class="card-header">
        Konsultacje/Diagnostyka
      </div>
      <div class="card-body">
        <ul>
        @foreach ($character->consultation_templates as $consultation_one)
          <li onClick="javascript:showConsultationTemplateModal({{$consultation_one->id}})">{{$consultation_one->consultation_type->sctt_name}} {{$consultation_one->sct_type_details}} </li>
        @endforeach
        </ul>
      </div>
      <div class="card-footer">
      <span class="btn btn-primary" onClick="javascript:showConsultationTemplateModal()">dodaj szablon</span>
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
$lab_order_template->lrt_sort=1;
$character_id=$character->id;
?>

@include('character.modal_consultation_template')

@include('laboratorynorms.modal_template_edit')


@endsection
