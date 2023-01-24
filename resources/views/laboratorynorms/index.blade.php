@extends('layouts.master')

@section('add_styles')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
@include('layouts.success_error')

<div class="row">

<div class="pull-right col-3"><span class="btn btn-outline-success" onClick="javascript:showLTGmodal(0)"> Create New Test Group</span></div>
</div>



<?php     $lang="pl"; ?>

  @foreach(App\Models\LaboratoryTestGroup::all()->sortBy('ltg_sort') as $test_one)
  <div class="card m-2" style="width: x18rem;">
    <div class="card-header">
      {{$test_one->ltg_name}} <span class="btn btn-outline-success " onClick="javascript:showLTGmodal({{$test_one->id}})"> Edit Test Group</span>
      <span class="btn btn-outline-success" onClick="javascript:showLTmodal(0,{{$test_one->id}})"> Create Test</span>
    </div>
    <div class="card-body">
      <table class="table table-striped" style="width:100%">
        <tbody>
        <!-- @ foreach(App\Models\LaboratoryTest::where('laboratory_test_group_id',$test_one->id)->get() as $test_two) -->
        @foreach(App\Models\LaboratoryTest::where('laboratory_test_group_id',$test_one->id)->get() as $test_two)
            <?php 
            $normy=App\Models\LaboratoryTestNorm::where('laboratory_test_id',$test_two->id)->get();
            $count=$normy->count();
            $next=""; ?>
            <tr>
              @if ($normy->count()>1)
                <td rowspan="{{$normy->count()}}">
              @else
                <td>
              @endif
          
                @if ($lang=="pl") {{$test_two->lt_name}} @endif
                @if ($lang=="en") {{$test_two->lt_name_en}} @endif
              </td>
  
              @if ($normy->count()>1)
                <td rowspan="{{$normy->count()}}">
              @else
                <td>
              @endif

                <span class="btn btn-outline-success" onClick="javascript:showLTmodal({{$test_two->id}},{{$test_one->id}})"> Edit Test</span>
                <span class="btn btn-outline-success" onClick="javascript:showLTNmodal(0,{{$test_two->id}})"> Add Norm</span>
              </td>

              @if ($normy->count()>1)
                <td rowspan="{{$normy->count()}}">
              @else
                <td>
              @endif
              
              @if ($lang=="pl") {{$test_two->lt_short}} @endif
              @if ($lang=="en") {{$test_two->lt_short_en}} @endif
              </td>
              <td>
                @if ($lang=="pl") {{$test_two->lt_unit}} @endif
                @if ($lang=="en") {{$test_two->lt_unit_en}} @endif
              </td>

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
                    <span class="btn btn-outline-success" onClick="javascript:showLTNmodal({{$test_three->id}},{{$test_two->id}})"> Edit Norm</span>
                  </td>
                  <?php $next="</tr><tr>"; ?>
                @endforeach  
            </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @endforeach

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

  @include('laboratorynorms.modal_ltg')

@endsection
