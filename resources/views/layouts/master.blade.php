<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Sebastian Dudek">
  <title>{{ config('app.name', 'UJKclinic') }}: @yield('title')</title>

  <meta name="color-scheme" content="dark light">

  @include('layoutparts.styles')
   
  @yield('add_styles')
</head>
<body>

@if (!( (Auth::user()->hasRoleCode('scene_doctor')) ||
      (Auth::user()->hasRoleCode('scene_nurse'))   ||
      (Auth::user()->hasRoleCode('scene_midwife')) ||
      (Auth::user()->hasRoleCode('scene_paramedic'))
      ))

@include('layoutparts.header')

@endif

<main class="p-2" style="width: 100%">
@yield('content')
</main>

@include('layoutparts.footer')

@include('layoutparts.scripts')

@yield('add_scripts')      
</body>
</html>