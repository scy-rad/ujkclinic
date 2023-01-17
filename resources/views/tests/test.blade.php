@extends('layouts.master')
<?php
// phpinfo();
?>

@section('title', " TESTY" )

@section('content')
<table class="table">
@foreach ($wynik as $row_one)
@switch ($row_one['type'])
@case('head1')
    <tr><td class="bg-dark text-secondary h2" colspan="5">{{$row_one['name']}}</td></tr>
  @break
  @case('head2')
    <tr><td class="text-secondary h4" colspan="5">{{$row_one['name']}}</td></tr>
  @break
  @case('result')
    <tr><td><li>{{$row_one['name']}}</li></td>
      <td class="text-end">{{$row_one['result']}}</td>
      <td>{{$row_one['unit']}}</td>
      <td class="text-center">{{$row_one['result_hl']}}</td>
      <td class="text-center">{{$row_one['norm']}}</td>
    </tr>
    @if (strlen($row_one['result_add'])>0)
      <tr><td></td>
        <td colspan="4">{{$row_one['result_add']}}</td>
      </tr>
    @endif
  @break
  @case('no_result')
    <tr><td><li>{{$row_one['name']}}</li></td>
        <td colspan="4">{{$row_one['value']}}</td>
      </tr>
  @break
@endswitch

@endforeach
</table>

<?php // dump($wynik); ?>

@endsection