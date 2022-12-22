@extends('layouts.master')

@section('content')
@include('layouts.success_error')

<div class="pull-right"><a class="btn btn-success" href="{{ route('scenario.create') }}"> Create New Scenario</a></div>
   List of scenarios:
                <div class="p-6 text-gray-900 dark:text-gray-100">
                  <ul>
                  @foreach($scenarios as $scenario)
                    <li> <strong><a href="{{route('scenario.show', $scenario)}}">{{$scenario->scenario_code}} <i class="bi bi-hospital"></i></a></strong>: {{$scenario->scenario_name}}</li>
                    <?php // dump ($scenario); ?>
                  @endforeach
                  </ul>
                </div>
@endsection
