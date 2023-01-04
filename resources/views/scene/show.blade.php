@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> Scene -> show <span class="text-danger">in progress...</span>
@endsection

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
@endsection

@section('content')

@include('layouts.success_error')

<h1>Show scene</h1>

<h2>{{$scene->scene_name}}</h2>
<!-- <?php dump($scene); ?> -->

<button class="btn btn-warning btn-lg" onClick="javascript:showSceneModal()"> <h1><i class="bi bi-hospital"></i> Edytuj scenę</h1> </button>


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>


@include('scene.modal_scene_master')

@endsection
