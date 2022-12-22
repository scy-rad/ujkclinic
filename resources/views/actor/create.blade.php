@extends('layouts.master')

@section('content')
   Create actor:
   <form action="{{ route('actor.store') }}" method="POST" enctype="multipart/form-data">
@csrf
@include('actor.formCrUd')
<div class="row mt-2">
  <button type="submit" class="btn btn-primary ml-3">Stwórz</button>
</div>
</form>
<div class="col-4">
    <a href="{{ url()->previous() }}"><button class="btn btn-secondary ml-3">Powrót</button></a>
</div>

@endsection
