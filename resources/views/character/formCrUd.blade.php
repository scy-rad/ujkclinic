<div class="row">
<!-- hidden:  -->

<input type="hidden" name="scenario_id" value="{{$scenario_id}}">
      
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="character_role_plan_id">Rodzaj roli:</label><br>
        <select class="form-select" id="character_role_plan_id" name="character_role_plan_id">
          @foreach (App\Models\CharacterRolePlan::all() as $row_one)
            <option value="{{$row_one->id}}" @isset($character) @if ($row_one->id==$character->character_role_plan_id) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="character_role_name">nazwa opisowa roli:</label><br>
      <input type="text" name="character_role_name" value="@isset($character){{$character->character_role_name}}@endisset" class="form-control" placeholder="Nazwa opisowa roli">
      @error('character_role_name')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="character_type_id">rodzaj aktora:</label><br>
        <select class="form-select" id="character_type_id" name="character_type_id">
          @foreach (App\Models\CharacterType::all() as $row_one)
            <option value="{{$row_one->id}}" @isset($character) @if ($row_one->id==$character->character_type_id) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="character_age_from">wiek od:</label><br>
      <input type="text" name="character_age_from" value="@isset($character){{$character->character_age_from}}@endisset" class="form-control" placeholder="Wiek od">
      @error('character_age_from')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="character_age_to">wiek do:</label><br>
      <input type="text" name="character_age_to" value="@isset($character){{$character->character_age_to}}@endisset" class="form-control" placeholder="Wiek do">
      @error('character_age_to')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="character_age_interval">interwał:</label><br>
        <select class="form-select" id="character_age_interval" name="character_age_interval">
          @foreach (App\Models\Character::age_interval_select() as $row_one)
            <option value="{{$row_one->id}}" @isset($character) @if ($row_one->id==$character->character_age_interval) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="character_sex">płeć:</label><br>
        <select class="form-select" id="character_sex" name="character_sex">
          @foreach (App\Models\Character::lex_select() as $row_one)
            <option value="{{$row_one->id}}" @isset($character) @if ($row_one->id==$character->character_sex) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="character_nn">NN:</label><br>
      <input type="text" name="character_nn" value="@isset($character){{$character->character_nn}} @else 0 @endisset" class="form-control" placeholder="Czy NN">
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="character_incoming_recalculate">przesunięcie czasu przyjęcia:</label><br>
      <input type="text" name="character_incoming_recalculate" value="@isset($character){{$character->character_incoming_recalculate}} @else 0 @endisset" class="form-control" placeholder="przesunięcie czasu przyjęcia">
    </div>
  </div>
  

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="history_for_actor">historia dla aktora:</label><br>
      <textarea name="history_for_actor" class="form-control" placeholder="historia dla aktora">@isset($character){!!$character->history_for_actor!!}@endisset</textarea>
      @error('history_for_actor')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="character_simulation">opis pozoracji:</label><br>
      <textarea name="character_simulation" class="form-control" placeholder="opis pozoracji">@isset($character){!!$character->character_simulation!!}@endisset</textarea>
      @error('character_simulation')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

</div>