<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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

<main class="container mt-5">
    @yield('content')
</main>

@include('layoutparts.footer')

@include('layoutparts.scripts')
      
</body>
</html>