@extends('layouts.master')

@section('content')
   Create scenario:
   <form action="{{ route('scenario.store') }}" method="POST" enctype="multipart/form-data">
@csrf
@include('scenario.formCrUd')
<div class="row mt-2">
  <button type="submit" class="btn btn-primary ml-3">Stwórz</button>
</div>
</form>

@endsection
