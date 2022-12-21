@extends('layouts.master')

@section('content')

@include('layouts.success_error')

   Details of scenario:
    <div class="p-6 text-gray-900 dark:text-gray-100">
      <p><strong>{{$scenario->scenario_code}}</strong>: 
        {{$scenario->scenario_name}}
      </p>
      <p><label>autor scenariusza:</label>
        <strong>
          @isset($scenario->author)
            {{$scenario->author->name}}
          @else
            nieokreślony
          @endisset
        </strong>
      </p>
      <p><label>scenariusz dla kierunku:</label>
        <strong>
            {{$scenario->center->center_direct}}
        </strong>
      </p>
      <p><label>typ scenariusza:</label>
        <strong>
            {{$scenario->type->name}}
        </strong>
      </p>
      <p><label>główny problem:</label>
        <strong>
            {{$scenario->scenario_main_problem}}
        </strong>
      </p>
      <p><label>opis:</label>
        <strong>
            {{$scenario->scenario_description}}
        </strong>
      </p>

    </div>



<form action="{{ route('scenario.destroy',$scenario->id) }}" method="Post">
<a class="btn btn-primary" href="{{ route('scenario.edit',$scenario->id) }}">Edit</a>
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger">Delete</button>
</form>


@endsection
