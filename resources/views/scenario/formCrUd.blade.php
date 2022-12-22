<div class="row">

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="scenario_code">KOD:</label><br>
      <input type="text" name="scenario_code" value="@isset($scenario){{$scenario->scenario_code}}@endisset" class="form-control" placeholder="Kod scenariusza">
      @error('scenario_code')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <label for="scenario_name">Tytuł scenariusza:</label><br>
      <input type="text" name="scenario_name" value="@isset($scenario){{$scenario->scenario_name}}@endisset" class="form-control" placeholder="Tytuł scenariusza">
      @error('scenario_name')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="scenario_author_id">Autor:</label><br>
        <select class="form-select" id="scenario_author_id" name="scenario_author_id">
            <option value="" @isset($scenario) @if ($scenario->scenario_author_id==null) selected="selected" @endif @endisset> - - - </option>
          @foreach (App\Models\User::all() as $row_one)
            <option value="{{$row_one->id}}" @isset($scenario) @if ($row_one->id==$scenario->scenario_author_id) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <lab  el for="center_id">Scenariusz dla kierunku:</label><br>
        <select class="form-select" id="center_id" name="center_id">
          @foreach (App\Models\Center::all() as $row_one)
            <option value="{{$row_one->id}}" @isset($scenario) @if ($row_one->id==$scenario->center_id) selected="selected" @endif @endisset> {{$row_one->center_direct}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="scenario_type_id">Typ scenariusza:</label><br>
        <select class="form-select" id="scenario_type_id" name="scenario_type_id">
          @foreach (App\Models\ScenarioType::all() as $row_one)
            <option value="{{$row_one->id}}" @isset($scenario) @if ($row_one->id==$scenario->scenario_type_id) selected="selected" @endif @endisset> {{$row_one->name}} </option>
          @endforeach
        </select>      
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="scenario_main_problem">Główny problem:</label><br>
      <input type="text" name="scenario_main_problem" value="@isset($scenario){{$scenario->scenario_main_problem}}@endisset" class="form-control" placeholder="Główny problem">
      @error('scenario_main_problem')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="scenario_description">Opis:</label><br>
      <input type="text" name="scenario_description" class="form-control" placeholder="Opis scenriusza" value="@isset($scenario){!!$scenario->scenario_description!!}@endisset">
      @error('scenario_description')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="scenario_for_students">Opis dla studentów:</label><br>
      <input type="text" name="scenario_for_students" class="form-control" placeholder="Opis scenriusza" value="@isset($scenario){!!$scenario->scenario_for_students!!}@endisset">
      @error('scenario_for_students')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>


  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label for="scenario_for_leader">Opis dla instruktora:</label><br>
      <input type="text" name="scenario_for_leader" class="form-control" placeholder="Opis scenriusza" value="@isset($scenario){!!$scenario->scenario_for_leader!!}@endisset">
      @error('scenario_for_leader')
      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      @enderror
    </div>
  </div>

</div>