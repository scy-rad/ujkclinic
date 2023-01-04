@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> Scenario -> index
@endsection

@section('content')

  @include('layouts.success_error')

  <div class="pull-right"><a class="btn btn-success" href="{{ route('scenario.create') }}"> Create New Scenario</a></div>

  List of scenarios:
  <div class="p-6 text-gray-900 dark:text-gray-100">
    <ul>
      @foreach($scenarios as $scenario)
        <li> <strong><a href="{{route('scenario.show', $scenario)}}"><i class="bi bi-camera-reels"></i>  {{$scenario->scenario_code}}</a></strong>: {{$scenario->scenario_name}}</li>
        <?php // dump ($scenario); ?>
      @endforeach
    </ul>
  </div>
@endsection
