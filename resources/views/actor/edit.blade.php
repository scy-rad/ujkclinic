@extends('layouts.master')

@section('content')
   Edit actor:
    <div class="p-6 text-gray-900 dark:text-gray-100">
    </div>

<form action="{{ route('actor.update',$actor->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('actor.formCrUd')
<div class="row mt-2">
  <div class="col-4">
    <button type="submit" class="btn btn-primary ml-3">Zapisz</button>
    </form>
  </div>
  <div class="col-4">
    <form action="{{ route('actor.destroy',$actor->id) }}" method="Post">
      <!-- <a class="btn btn-primary m-1" href="{{ route('actor.edit',$actor->id) }}">Edytuj</a> -->
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger m-1">Usuń</button>
    </form>
  </div>
  <div class="col-4">
    <a href="{{ url()->previous() }}"><button class="btn btn-secondary ml-3">Powrót</button></a>
  </div>
</div>




@endsection
