@extends('layouts.master')

@section('content')
   Edit scenario:
    <div class="p-6 text-gray-900 dark:text-gray-100">
    </div>

<form action="{{ route('scenario.update',$scenario->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('scenario.formCrUd')
<div class="row mt-2">
  <button type="submit" class="btn btn-primary ml-3">Zapisz</button>
</div>
</form>


@endsection
