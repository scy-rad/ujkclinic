@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> Scene -> index <span class="text-danger">in progress...</span>
@endsection

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
@endsection

@section('content')

@include('layouts.success_error')

<h1>Scenes list</h1>

<ul>
@foreach ($scenes as $scene)
<li> <a href="{{ route('scene.show',$scene->id) }}"><i class="bi bi-hospital"></i> {{$scene->scene_code}}: {{$scene->scene_name}} </a> </li>
<?php //dump($scene); ?>
@endforeach
</ul>

<button class="btn btn-warning btn-lg" onClick="javascript:showSceneModal()"> <h1><i class="bi bi-hospital"></i> Stwórz scenę</h1> </button>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<?php
 $scene= new App\Models\SceneMaster();
 ?>
@include('scene.modal_scene_master')

@endsection
