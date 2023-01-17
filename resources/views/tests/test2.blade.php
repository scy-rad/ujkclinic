@extends('layouts.master')

@section('title', " TESTY" )

@section('module_info')
<i class="bi bi-8-square"></i> Tests -> test2
@endsection


@section('content')


@include('layouts.success_error')

<?php dump($wynik); ?>

@endsection