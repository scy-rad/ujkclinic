@extends('layouts.master')

@section('title', "Edycja szablonu badań")


@section('module_info')
<i class="bi bi-badge-8k"></i> Laboratorynorms -> template
@endsection

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
@include('layouts.success_error')

<div class="card">
  <div class="card-header">
    Edycja szablonu badań laboratoryjnych
  </div>
  <div class="card-body">

    <h1></h1>

    <h4><label>dla scenariusza:</label> {{$labtemplate->actor->scenario->scenario_name}}<br>
    <label>dla aktora:</label><a class="text-decoration-none" href="{{ route('actor.show',$labtemplate->actor->id) }}"> <i class="bi bi-incognito"></i> {{$labtemplate->actor->actor_role_name}} </a> </h4>
    <span class="btn btn-outline-success" onClick="javascript:showTemplateEditModal()">Edytuj szablon badań laboratoryjnych</span>
    <p>
    <label>płeć:</label> {{$labtemplate->actor->sex_name()}} <br>
    <label>wiek:</label> {{$labtemplate->actor->actor_age_from}} - {{$labtemplate->actor->actor_age_to}} {{$labtemplate->actor->age_interval_name}}<br>
    <label>rodzaj szablonu:</label> {{$labtemplate->name_of_type()}}<br>
    <label>cofnięcie w czasie badań o min.:</label> {{$labtemplate->calculate_time()}}<br>
    <label>kolejność:</label> {{$labtemplate->lrt_sort}}<br>
    <label>opis dla instruktora:</label>
    </p>
    <p>{!!$labtemplate->description_for_leader!!}</p>

  </div>
</div>


<?php     $lang="pl"; ?>
<table class="table table-striped" style="width:100%">
        <tbody>

  @foreach(App\Models\LaboratoryTestGroup::all()->sortBy('ltg_sort') as $test_one)
          <tr>
          <td colspan="8" class="bg-success">
          {{$test_one->ltg_name}}
</td>
</tr>

        @foreach(App\Models\LaboratoryTest::where('laboratory_test_group_id',$test_one->id)->get() as $lab_test_row)
            <?php 
            $normy=App\Models\LaboratoryTestNorm::where('laboratory_test_id',$lab_test_row->id)->where('ltn_days_from','<=',$labtemplate->actor->actor_days_to())->Where('ltn_days_to','>=',$labtemplate->actor->actor_days_from())->get();
            $count=$normy->count();
            // dump($lab_test_row);
            $next=""; ?>
            <tr>
              @if ($normy->count()>1)
                <td rowspan="{{$normy->count()}}">
              @else
                <td>
              @endif
          
                @if ($lang=="pl") {{$lab_test_row->lt_name}} @endif
                @if ($lang=="en") {{$lab_test_row->lt_name_en}} @endif
              </td>
  
              @if ($normy->count()>1)
                <td rowspan="{{$normy->count()}}">
              @else
                <td>
              @endif
              </td>

              @if ($normy->count()>1)
                <td rowspan="{{$normy->count()}}">
              @else
                <td>
              @endif
              
              @if ($lang=="pl") {{$lab_test_row->lt_short}} @endif
              @if ($lang=="en") {{$lab_test_row->lt_short_en}} @endif
              </td>
              <?php $next=""; ?>
                @foreach($normy as $test_three)
                {!!$next!!}
                
                  <td>
                  @if ($normy->count()>1)
                    {{$test_three->write_range()}}
                  @endif
                  </td>
                  <td>
                    {{$test_three->write_norm()}}
                  </td>
                  <td>
                    @if ($lang=="pl") {{$test_three->ltn_unit}} @endif
                    @if ($lang=="en") {{$test_three->ltn_unit_en}} @endif
                  </td>

                  <?php $next="</tr><tr>"; ?>
                @endforeach 
                <?php if ($test_three->get_from_template($labtemplate->id)['id']>0) {$hid=""; $but="edytuj"; $butclass="btn-outline-success";} else {$hid="d-none"; $but="dodaj"; $butclass="btn-outline-primary bg-warning";} ?>

                <td>
                    <h3 class="{{$hid}}">
                        @if ($lab_test_row->lt_result_type==1)
                        <span id="result_{{$lab_test_row->id}}">{{intval($test_three->get_from_template($labtemplate->id)['lrtr_result'])/$test_three->ltn_decimal_prec}}</span>
                        @else
                        <span id="result_{{$lab_test_row->id}}">{{$test_three->get_from_template($labtemplate->id)['lrtr_resulttxt']}}</span>
                        @endif
                    </h3>
                  <span class="text-danger {{$hid}}" id="addedtext_{{$lab_test_row->id}}">{{$test_three->get_from_template($labtemplate->id)['lrtr_addedtext']}}</span>

                  <?php 
                  $idx = $test_three->get_from_template($labtemplate->id)['lrtr_type'];
                  ?>

                  <span class="d-none" id="type_{{$lab_test_row->id}}">{{$idx}}</span>
                  <span class="d-none" id="decimal_{{$lab_test_row->id}}">{{$test_three->ltn_decimal_prec}}</span>

                  <span class="text-primary {{$hid}}">{{$result_type[$idx]['value']}}</span>

                  </td>
                  <td>
                    <span class="btn {{$butclass}}" onClick="javascript:showTemplateModal({{$test_three->get_from_template($labtemplate->id)['id']}},{{$labtemplate->id}},{{$lab_test_row->id}},{{$lab_test_row->lt_result_type}})">{{$but}}</span>

</td>
            </tr>
        @endforeach
  @endforeach
  </tbody>
      </table>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

@include('laboratorynorms.modal_template_result')
@include('laboratorynorms.modal_template_edit')


@endsection
