@extends('layouts.master')

@section('title', "profil: ".$user->lastname." ".$user->firstname)


@section('module_info')
<i class="bi bi-badge-8k"></i> Users -> userprofile
@endsection


@section('content')

<style>
  /* The Modal (background) */
  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
  }

  /* Modal Content/Box */
  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    /* Could be more or less, depending on screen size */
  }

  /* The Close Button */
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
</style>

@include('layouts.success_error')

<div class="row justify-content-center">
  <div class="col-sm-3 mb-4 alert alert-primary rounded-3">
    <div class="">
      <div class="border bg-white border-dark border-0 rounded-3 m-2 p-2">
        <img class="border border-dark border-2 rounded-3" style="width: 100%" src="{{ $user->user_fotka }}">
      </div>
    </div>
    @if ($isAdmin || $isOwn)
    <div class="justify-content-center">
      <form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update_avatar">
        {{ csrf_field() }}
        <div class="form-group">
          <input type="hidden" name="user_id" value="{{$user->id}}">
          <input type="file" class="form-control" name="fotka" id="fotkaFile" aria-describedby="fileHelp">
          <button type="submit" class="form-control btn btn-primary">Prześlij</button>
          <p id="fileHelp" class="small form-text">Zdjęcie JPG nie może być większe niż 2MB. Zostanie dopasowane do rozmiaru 800x600.</p>
        </div>
      </form>

      <h2>widok startowy</h2>
      <form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="change_home_view">
        {{ csrf_field() }}
        <div class="form-group">
          <div>
            <label for="sel1">I moduł (To Do):</label><br>
            <select class="form-select" name="home_todo_module">
              <option value="0" <?php if ($user->home_todo_module == 0) echo ' selected="selected"'; ?>>brak modułu</option>
              <option value="1" <?php if ($user->home_todo_module == 1) echo ' selected="selected"'; ?>>włączony To Do</option>
            </select>
          </div>
          <div>
            <label for="sel1">ilość dni pracy:</label><br>
            <select class="form-select" name="home_own_days">
              @for ($i = 0; $i <= 7; $i++) <option value="{{ $i }}" <?php if ($user->home_own_days == $i) echo ' selected="selected"'; ?>>{{ $i }}</option>
                @endfor
            </select>
          </div>
          <div>
            <label for="sel1">II moduł:</label><br>
            <select class="form-select" name="home_second_module">
              <option value="0" <?php if ($user->home_second_module == 0) echo ' selected="selected"'; ?>>brak modułu</option>
              <option value="1" <?php if ($user->home_second_module == 1) echo ' selected="selected"'; ?>>bieżący dzień (scheduler)</option>
            </select>
          </div>
          <input type="hidden" name="user_id" value="{{$user->id}}">
          <hr>
          <button type="submit" class="col-sm-12 btn btn-primary mb-3">Zmień widok</button>
        </div>
      </form>
    </div>
    @endif
  </div>
  <div class="col-sm-9 mb-4">
    <div class="row border border-2 border-top-0 border-start-0 border-end-0 border-primary m-2">
      <div class="col-8">
        <h4> {{$user->title->user_title_short}}</h4>
        <h2> {{$user->firstname}} {{$user->lastname}}</h2>
      </div>
      <div class="col-4">
      @if ($isAdmin)
        <button class="float-end btn btn-primary btn-sm mb-2" onClick="openPersonalModal()">Edytuj dane osobowe</button>
      @endif
      @if ( ($isAdmin) || (Auth::user()->hasRoleCode('workers')) )
        <button class="float-end btn btn-success btn-sm" onClick="openAdditionalModal()">Edytuj dane dodatkowe</button>
      @endif
      </div>
    </div>
    <ul class="mb-4">
      @foreach ($user->roles as $row)
      <li>{{$row->role_name}}<br>
        <i>{{$row->role_description}}</i>
        @if ($isAdmin)
        @if (!($row->role_name=='Administrator' && Auth::user()->hasRoleCode('administrators')))
        <div class="float-end">
          <form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="remove_role">
            {{ csrf_field() }}
            <input type="hidden" name="role_id" value="{{$row->pivot->role_id}}">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <button type="submit" class="btn btn-danger btn-sm">usuń rolę</button>
          </form>
        </div>
        <hr>
        @endif
        @endif
      </li>
      @endforeach
    </ul>
    
    <i class="bi bi-envelope"></i> <a href="mailto:{{$user->email}}">{{$user->email}}</a>
    @if ($isAdmin || $isOwn)
    <div style="float:right">
      <button class="btn btn-primary btn-sm" onClick="openMailModal()">Edytuj e-mail</button>
    </div>
    <hr>
    @endif
    <br>
    @foreach ($user->phones as $row)
    @if (
    (Auth::user()->hasRoleCode('administrators'))
    || ((Auth::user()->hasRoleCode('coordinators')) && ($row->phone_for_coordinators==1))
    || ((Auth::user()->hasRoleCode('instructors')) && ($row->phone_for_trainers==1))
    || ((Auth::user()->hasRoleCode('technicians')) && ($row->phone_for_technicians==1))
    || ($row->phone_for_guests==1)
    )
    <abbr title="{{$row->type->user_phone_type_name}}">
      <span class="glyphicon {{$row->type->user_phone_type_glyphicon}}"></span>
    </abbr>
    {{$row->phone_number}}<br>
    @endif
    @if ($isAdmin || $isOwn)
    <div style="float:right">
      <button class="btn btn-primary btn-sm" onClick="openPhoneModal('{{$row->id}}','{{$row->type->id}}','{{$row->phone_number}}','{{$row->phone_for_coordinators}}','{{$row->phone_for_technicians}}','{{$row->phone_for_trainers}}','{{$row->phone_for_guests}}','{{$row->phone_for_anonymouse}}')">Edytuj numer</button>
    </div>
    <hr>
    @endif
    @endforeach

    @if ($isAdmin || $isOwn)
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    otrzymywanie powiadomień mailowych o zajęciach
    <div style="float:right" onClick="change_notify()">
      <input value="1" class="simmed_notify" type="checkbox" <?php if ($user->simmed_notify == 1) echo "checked"; ?> data-toggle="toggle" data-on="wysyłaj" data-off="nie wysyłaj">
    </div>
    <hr>
    @endif

    {!!$user->about!!}
    @if ($isAdmin || $isOwn)
    <div style="float:right">
      <button class="btn btn-primary btn-sm" onClick="openAboutModal()">Edytuj opis</button>
    </div>
    <hr>
    @endif

  </div>
</div>

@if ($isAdmin || $isOwn)
<div class="row alert alert-danger">
  <h2>Panel administracyjny</h2>
  <h5> login: <strong>{{$user->name}}</strong> [id: <strong>{{$user->id}}</strong>] </h5>
  <div class="form-group">
    <a href="{{ route('changePasswordForm') }}"><button class="col-sm-4 btn btn-primary">Zmień hasło</button></a>
    <button class="col-sm-4 btn btn-primary" onClick="openPhoneModal('0','0','','1','1','1','0','0')">Dodaj numer telefonu</button>
  </div>
</div>

@if ($isAdmin)
<form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
  <input type="hidden" name="action" value="change_password">
  {{ csrf_field() }}
  <div class="input-group mb-3">
    <span class="input-group-text">nowe hasło:</span>
    <input type="password" name="password" placeholder="Wpisz hasło" value="">
    <span class="input-group-text">#</span>
    <input type="password" name="passwordre" placeholder="Ponów hasło" value="">
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <button type="submit" class="btn btn-primary">Zmień</button>
  </div>
</form>

<form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
  <input type="hidden" name="action" value="change_status">
  {{ csrf_field() }}
  <div class="input-group mb-3">
    <span class="input-group-text col-2">Status:</span>
    <select class="form-select" name="user_status">
      <option value="0" <?php if ($user->user_status == 0) echo ' selected="selected"'; ?>> nieaktywny </option>
      <option value="1" <?php if ($user->user_status == 1) echo ' selected="selected"'; ?>> aktywny </option>
    </select>
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <button type="submit" class="btn btn-primary">Zmień</button>
  </div>
</form>

<form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
  <input type="hidden" name="action" value="add_role">
  {{ csrf_field() }}
  <div class="input-group mb-3">
    <span class="input-group-text col-2">Rola:</span>
    <select class="form-select" name="role_id">
      @foreach (App\Models\UserRole::get() as $row)
      @if (!($user->hasRoleCode($row->role_code)))
      @if (!($row->role_code=='administrators' && Auth::user()->hasRoleCode('administrators')))
      <option value="{{$row->id}}"> {{$row->role_name}} </option>
      @endif
      @endif
      @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Dodaj</button>
  </div>
  <input type="hidden" name="user_id" value="{{$user->id}}">
</form>
@endif


<!-- The Modal -->
<div id="phoneModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row">
      <span class="close">&times;</span>
    </div>
    <form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="change_phone">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-sm-5 col-md-6">
          <div class="row">
            <div class="col-12">
              <label for="phone_number">numer telefonu:</label><br>
              <input type="text" class="form-control" id="phone_number" name="phone_number" value="">
            </div>
            <div class="col-12">
              <label for="user_phone_type_id">rodzaj telefonu:</label><br>
              <select class="form-select" id="user_phone_type_id" name="user_phone_type_id">
                @foreach (App\Models\UserPhoneType::get() as $row)
                <option value="{{$row->id}}"> {{$row->user_phone_type_name}} </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="col-sm-5 col-md-4">
          <label for="xyz">prezentowanie telefonu:</label><br>
          <input type="checkbox" class="form-check-input" id="phone_for_coordinators" name="phone_for_coordinators">koordynatorom<br>
          <input type="checkbox" class="form-check-input" id="phone_for_technicians" name="phone_for_technicians">technikom<br>
          <input type="checkbox" class="form-check-input" id="phone_for_trainers" name="phone_for_trainers">instruktorom<br>
          <input type="checkbox" class="form-check-input" id="phone_for_guests" name="phone_for_guests" checked>gościom<br>
          <input type="checkbox" class="form-check-input" id="phone_for_anonymouse" name="phone_for_anonymouse" checked>wszystkim<br>
        </div>
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input type="hidden" name="id_phone" id="id_phone" value="">
        <button type="submit" class="col-sm-2 col-md-2 btn btn-primary">Zapisz</button>
      </div>
  </div>
  </form>
</div>
</div>

<!-- The Modal -->
<div id="mailModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row">
      <span class="close">&times;</span>
    </div>


    <div class="row">
      <form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="change_email">
        {{ csrf_field() }}
        <div class="input-group mb-3">
          <span class="input-group-text">@</span>
          <input class="form-control" type="text" id="email" name="email" value="{{$user->email}}">
          <input type="hidden" name="user_id" value="{{$user->id}}">
          <button type="submit" class="btn btn-primary">Zapisz</button>
        </div>

      </form>
    </div>
  </div>
</div>


<!-- The TEXT editor Modal -->
<div id="aboutModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row">
      <span class="close">&times;</span>
    </div>
    <div class="row">
      <form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="change_about">
        {{ csrf_field() }}
        <div class="form-group">
          <label>opis</label>
          <textarea class="form-control tinymce-editor {{ $errors->has('about') ? 'error' : '' }}" name="about" id="about" rows="4">
            {!! $user->about !!}
          </textarea>
          @if ($errors->has('about'))
          <div class="error">
            {{ $errors->first('about') }}
          </div>
          @endif
        </div>
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input type="submit" name="send" value="Zapisz" class="btn btn-dark btn-block">
      </form>
    </div>
  </div>
</div>


<!-- The Modal -->
<div id="personalModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row">
      <span class="close">&times;</span>
    </div>
    <form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="update_personal">
      {{ csrf_field() }}
      <div class="row">
        <!-- <div class="form-group"> -->
        <div class="col-md-2 col-sm-6">
          <label for="user_title_id">tytuł:</label><br>
          <select class="form-select" id="user_title_id" name="user_title_id">
            @foreach (App\Models\UserTitle::get() as $row)
            <option value="{{$row->id}}" <?php if ($row->id == $user->user_title_id) echo 'selected="selected"'; ?>> {{$row->user_title_short}} </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3 col-sm-6">
          <label for="name">login:</label><br>
          <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
        </div>
        <div class="col-md-3 col-sm-5">
          <label for="firstname">imię:</label><br>
          <input type="text" class="form-control" id="firstname" name="firstname" value="{{$user->firstname}}">
        </div>
        <div class="col-md-3 col-sm-5">
          <label for="lastname">nazwisko:</label><br>
          <input type="text" class="form-control" id="lastname" name="lastname" value="{{$user->lastname}}">
        </div>
        <button type="submit" class="col-md-1 col-sm-2 btn btn-primary p-2">Zapisz</button>
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <!-- </div> -->
      </div>
    </form>
  </div>
</div>
<!-- end of The Modal -->

<!-- The Modal -->
<div id="additionalModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row">
      <span class="close">&times;</span>
    </div>
    <form action="{{ route('user.change') }}" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="update_additional">
      {{ csrf_field() }}
      <div class="row">
        <!-- <div class="form-group"> -->
        <div class="col-md-4 col-sm-6">
          <label for="time_begin">początek pracy:</label><br>
          <input type="time" step="300" min="06:00" max="14:00" class="form-control" id="time_begin" name="time_begin" value="{{$user->time_begin}}">
        </div>
        <div class="col-md-8 col-sm-6">
          <br>
          <button type="submit" class="col-12 btn btn-primary">Zapisz</button>
          <input type="hidden" name="user_id" value="{{$user->id}}">
        </div>
      </div>
    </form>
  </div>
</div>
<!-- end of The Modal -->


<script>
  var change_notify = function() {
    var modal = document.getElementById("simmed_notify");
    checkedValue = $('.simmed_notify:checked').val();
    if (checkedValue)
      to_check = 0;
    else
      to_check = 1;

    let _token = '{{csrf_token()}}';
    $.ajax({
      url: "/ajaxusernotify",
      type: "POST",
      data: {
        simmed_notify: to_check,
        user_id: {{ $user->id }},
        _token: _token
      },
      success: function(response) {
        console.log(response);
        if (response) {
          $('.success').text(response.success);
          //$("#ajaxform")[0].reset();
          //alert(response.success);
        }
      },
    });

  };
</script>

<!-- for modals -->
<script>
  var openPhoneModal = function(id_phone, type, phone, phone_for_coordinators, phone_for_technicians, phone_for_trainers, phone_for_guests, phone_for_anonymouse) {
    document.getElementById('id_phone').value = id_phone;
    document.getElementById('phone_number').value = phone;
    document.getElementById("phone_for_coordinators").checked = Boolean(Number(phone_for_coordinators));
    document.getElementById("phone_for_technicians").checked = Boolean(Number(phone_for_technicians));
    document.getElementById("phone_for_trainers").checked = Boolean(Number(phone_for_trainers));
    document.getElementById("phone_for_guests").checked = Boolean(Number(phone_for_guests));
    document.getElementById("phone_for_anonymouse").checked = Boolean(Number(phone_for_anonymouse));
    modal.style.display = "block";
    var sel = document.getElementById('user_phone_type_id');
    var opts = sel.options;
    for (var opt, j = 0; opt = opts[j]; j++) {
      if (opt.value == type) {
        sel.selectedIndex = j;
        break;
      }
    }
  };

  var openMailModal = function() {
    modal2.style.display = "block";
  };

  var openAboutModal = function() {
    modal3.style.display = "block";
  };

  var openPersonalModal = function() {
    modal4.style.display = "block";
  };

  var openAdditionalModal = function() {
    modal5.style.display = "block";
  };

  var modal = document.getElementById("phoneModal");
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  var modal2 = document.getElementById("mailModal");
  // Get the <span> element that closes the modal
  var span2 = document.getElementsByClassName("close")[1];
  // When the user clicks on <span> (x), close the modal
  span2.onclick = function() {
    modal2.style.display = "none";
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal2) {
      modal2.style.display = "none";
    }
  }

  var modal3 = document.getElementById("aboutModal");
  // Get the <span> element that closes the modal
  var span3 = document.getElementsByClassName("close")[2];
  // When the user clicks on <span> (x), close the modal
  span3.onclick = function() {
    modal3.style.display = "none";
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal3) {
      modal3.style.display = "none";
    }
  }

  var modal4 = document.getElementById("personalModal");
  // Get the <span> element that closes the modal
  var span4 = document.getElementsByClassName("close")[3];
  // When the user clicks on <span> (x), close the modal
  span4.onclick = function() {
    modal4.style.display = "none";
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal4) {
      modal4.style.display = "none";
    }
  }

  var modal5 = document.getElementById("additionalModal");
  // Get the <span> element that closes the modal
  var span5 = document.getElementsByClassName("close")[4];
  // When the user clicks on <span> (x), close the modal
  span5.onclick = function() {
    modal5.style.display = "none";
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal5) {
      modal5.style.display = "none";
    }
  }
</script>


<!-- for txt editor -->
<script src="https://cdn.tiny.cloud/1/6ylsotqai3tcowhx675l8ua28xj37zvsamtqvf4r94plg389/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script
      src="https://code.jquery.com/jquery-3.6.1.min.js"
      integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
      crossorigin="anonymous"></script>

<script type="text/javascript">
  tinymce.init({
    selector: 'textarea.tinymce-editor',
    height: 500,
    menubar: true,
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    content_css: '//www.tiny.cloud/css/codepen.min.css'
  });
</script>

@endif





@endsection