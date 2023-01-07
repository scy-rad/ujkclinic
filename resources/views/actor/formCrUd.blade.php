<div class="row">
<!-- hidden:  -->

<input type="hidden" name="scenario_id" value="{{$scenario_id}}">
      
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="actor_role_plan_id">Rodzaj roli:</label><br>
        <select class="form-select" id="actor_role_plan_id" name="actor_role_plan_id">
          @foreach (App\Models\ActorRolePlan::all() as $row_one)
            <option value="{{$row_one->id}}" @isset($actor) @if ($row_one->id==$actor->actor_role_plan_id) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="actor_role_name">nazwa opisowa roli:</label><br>
      <input type="text" name="actor_role_name" value="@isset($actor){{$actor->actor_role_name}}@endisset" class="form-control" placeholder="Wiek od">
      @error('actor_role_name')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="actor_type_id">rodzaj aktora:</label><br>
        <select class="form-select" id="actor_type_id" name="actor_type_id">
          @foreach (App\Models\ActorType::all() as $row_one)
            <option value="{{$row_one->id}}" @isset($actor) @if ($row_one->id==$actor->actor_type_id) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="actor_age_from">wiek od:</label><br>
      <input type="text" name="actor_age_from" value="@isset($actor){{$actor->actor_age_from}}@endisset" class="form-control" placeholder="Wiek od">
      @error('actor_age_from')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="actor_age_to">wiek do:</label><br>
      <input type="text" name="actor_age_to" value="@isset($actor){{$actor->actor_age_to}}@endisset" class="form-control" placeholder="Wiek do">
      @error('actor_age_to')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="actor_age_interval">interwał:</label><br>
        <select class="form-select" id="actor_age_interval" name="actor_age_interval">
          @foreach (App\Models\Actor::age_interval_select() as $row_one)
            <option value="{{$row_one->id}}" @isset($actor) @if ($row_one->id==$actor->actor_age_interval) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="actor_sex">płeć:</label><br>
        <select class="form-select" id="actor_sex" name="actor_sex">
          @foreach (App\Models\Actor::lex_select() as $row_one)
            <option value="{{$row_one->id}}" @isset($actor) @if ($row_one->id==$actor->actor_sex) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="actor_nn">NN:</label><br>
      <input type="text" name="actor_nn" value="@isset($actor){{$actor->actor_nn}}@endisset" class="form-control" placeholder="Czy NN">
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="actor_incoming_recalculate">przesunięcie czasu przyjęcia:</label><br>
      <input type="text" name="actor_incoming_recalculate" value="{{$actor->actor_incoming_recalculate}}" class="form-control" placeholder="przesunięcie czasu przyjęcia">
    </div>
  </div>
  

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="history_for_actor">historia dla aktora:</label><br>
      <textarea name="history_for_actor" class="form-control" placeholder="historia dla aktora">@isset($actor){!!$actor->history_for_actor!!}@endisset</textarea>
      @error('history_for_actor')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="actor_simulation">opis pozoracji:</label><br>
      <textarea name="actor_simulation" class="form-control" placeholder="opis pozoracji">@isset($actor){!!$actor->actor_simulation!!}@endisset</textarea>
      @error('actor_simulation')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

</div>