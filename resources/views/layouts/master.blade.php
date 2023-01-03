<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Sebastian Dudek">
  <title>{{ config('app.name', 'UJKclinic') }}: @yield('title')</title>

  @include('layoutparts.styles')
   
  @yield('add_styles')
</head>
<body>

@include('layoutparts.header')

<main class="p-5" style="width: 100%">
    @yield('content')
</main>

@include('layoutparts.footer')

@include('layoutparts.scripts')
@yield('add_scripts')      
</body>
</html>