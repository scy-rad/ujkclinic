@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> Scenario -> edit
@endsection

@section('content')
   Edit scenario:
    <div class="p-6 text-gray-900 dark:text-gray-100">
    </div>

<form action="{{ route('scenario.update',$scenario->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('scenario.formCrUd')
<div class="row mt-2">
  <div class="col-4">
    <button type="submit" class="btn btn-primary ml-3">Zapisz</button>
    </form>
  </div>
  <div class="col-4">
    @if ($scenario->characters->count()==0)
    <form action="{{ route('scenario.destroy',$scenario->id) }}" method="Post">
      <!-- <a class="btn btn-primary m-1" href="{{ route('scenario.edit',$scenario->id) }}">Edytuj</a> -->
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger m-1">Usuń</button>
    </form>
    @endif
  </div>
  <div class="col-4">
    <a href="{{ url()->previous() }}"><button class="btn btn-secondary ml-3">Powrót</button></a>
  </div> 
</div>




@endsection
