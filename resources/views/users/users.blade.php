@extends('layouts.master')

@section('title', "osoby...")

@section('module_info')
  <i class="bi bi-8-square"></i> Users -> users
@endsection

<!-- for datatables: -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/date-1.2.0/r-2.4.0/sp-2.1.0/datatables.min.css"/>
<link href="{{ asset('css5/users.css') }}" rel="stylesheet">

@section('content')

@include('layouts.success_error')

<h1>użytkownicy</h1>
@if ($users->count()>0)
<table id="worktable" class="table table-striped">
  <thead>
    <tr>
      <th> osoba </th>
  </tr>
</thead>
<tbody>
  @foreach ($users as $user)
  <tr><td>
  <div class="row mb-2 ">
    <?php if ($user->user_status != 1) $able = "danger";
    else $able = ""; ?>
    <div class="col-sm-5 d-flex">
      <img src="{{ $user->user_fotka }}" class="user-box">
      <span class="bg-{{$able}} mt-auto">
        <a href="{{route('user.profile', $user->id)}}" class="no_decoration"> {{$user->title->user_title_short}} {{$user->firstname}} {{$user->lastname}} </a>
      </span>
    </div>
    <div class="col-sm-4 d-flex">
      <a href="mailto:{{$user->email}}" class="mt-auto no_decoration"><i class="bi bi-envelope"></i>: {{$user->email}}</a>
    </div>
    <div class="col-sm-3 d-flex">
      <div class="mt-auto">
        @foreach ($user->phones()->get() as $phone)
        <div style="float:left; margin-right:10px;">{!! $phone->phone_for_me('html5') !!}</div>
        @endforeach
      </div>
    </div>
  </div>
</td></tr>
  @endforeach
</tbody>
</table>
@endif


<!-- for datatables: -->
<script
      src="https://code.jquery.com/jquery-3.6.1.min.js"
      integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
      crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/date-1.2.0/r-2.4.0/sp-2.1.0/datatables.min.js"></script>

    <script>
$(document).ready(function () {
    $('#worktable').DataTable({
        search: {
            return: true,
        },
        "pageLength": 25,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/pl.json"
        },

    });
});
</script>

@endsection