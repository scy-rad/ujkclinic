@extends('layouts.master')

@section('module_info')
<i class="bi bi-badge-8k"></i> SceneActor -> show <strong>medical center</strong> <span class="text-danger">in progress...</span>
@endsection

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

@include('layouts.success_error')





<input type="hidden" id="relative_sec" value="{{$diff_sec}}">
<!-- end of clock code part I -->

<div class="row">

  <!-- ======================== LEFT COLUMN ======================== -->
  <div class="col-2 pe-0">
    <div class="card">
      <div class="card-header">
      <i class="bi bi-file-person"></i>
        <h2>{{$sceneactor->sa_name}}</h2>
      </div>
      <p>
        <label>nr KG:</label> {{$sceneactor->sa_main_book}}<br>
        <label>wiek:</label> {{$sceneactor->sa_age_txt}}<br>
        <label>PESEL:</label> {{$sceneactor->sa_PESEL}}<br>
        <label>data prz.:</label> {{$sceneactor->sa_incoming_date}}<br>
      </p>
    </div>
    <div class="col-12 border border-2 rounded mt-3">
      <ul>
        @foreach ($sceneactor->scene_actor_forms as $form_one)
          <li onClick="javascript:showMedicalFormDiv({{$form_one->id}})">{{$form_one->form_type->form_familly->mff_name}}
              {{$form_one->form_type->mft_name}}
              <!-- {{$form_one->mf_string_1}} -->
          </li>
        @endforeach
      </ul>
    </div>  <!-- extra_body -->
  </div>
  <!--/======================== LEFT COLUMN ======================== -->


  <!-- ======================== CENTER COLUMN ======================== -->
  <div class="col-8">
    @include('sceneactor.inc_head_medicalcenter')
    <div id="extra_body" class="col-12 border border-2 rounded p-2 m-0">
      &nbsp;
    </div>  <!-- extra_body -->
  </div>
  <!--/======================== CENTER COLUMN ======================== -->

  <!-- ======================== RIGHT COLUMN ======================== -->
  <div class="col-2 ps-0">
      @foreach (\App\Models\MedicalFormFamilly::all() as $mff_one)
      <div class="card mb-2">
        <div class="card-header" onClick="javascript:ShowHideDiv('TYP_{{$mff_one->mff_code}}','.hide_type')">
        <i class="bi bi-file-plus"></i> {!!$mff_one->mff_icon!!} {{$mff_one->mff_name}}
        </div>
        <div class="hide_type" style="display: none" id="TYP_{{$mff_one->mff_code}}">
          <ul>
            @foreach($mff_one->form_types as $mft_one)
            <li onClick="showMedicalFormModal({{$mft_one->id}})">{{$mft_one->mft_short}}</li>
            @endforeach
          </ul>
        </div>
      </div> <!-- card -->
      @endforeach
  </div>
  <!--/======================== RIGHT COLUMN ======================== -->

</div>

<div class="modal fade" id="ModalMedicalForm" tabindex="-2" aria-labelledby="ModalMedicalFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <div class="float-start">
          <h5 class="float-start modal-title" id="ModalMedicalFormTitle">Tytuł</h5>
        </div>
        <div style="margin: 0 auto">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('sceneactor.medical_form_save_ajax') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>

        <input type="hidden" id="scene_actor" name="scene_actor_id" value="{{$sceneactor->id}}">
        <input type="hidden" id="medical_form_type_id" name="medical_form_type_id" value="">
        
  
        <div class="modal-body" id="medical_form">
        </div>
        <div class="row mb-3 text-center">
              <div class="col-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">anuluj</button>
              </div>
              <div class="col-4 text-end" id="for_delete">
              </div>
              <div class="col-4 text-center">
                <button type="submit" class="btn btn-success btn-submit btn-tmpl-save">Potwierdź</button>
              </div>
            </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
  function ShowHideDiv(x_div,x_class)
  {
    if (document.getElementById(x_div).style.display === 'block')
    {
      document.getElementById(x_div).style = 'display: none';
    }
    else
    {
    for (let el of document.querySelectorAll(x_class)) el.style.display = 'none';
      document.getElementById(x_div).style = 'display: block';
    }
  };


  function showMedicalFormModal(medical_form_type_id)
  {
    $('#ModalMedicalFormTitle').html('formularz w trakcie przygotowywania...');
    $('#medical_form').html('');
    $.ajax({
            type:'GET',
            url:"{{ route('sceneactor.medical_form_get_ajax') }}",
            data:{show_edit:'edit',scene_actor_id:{{$sceneactor->id}},medical_form_type_id:medical_form_type_id},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  // alert(JSON.stringify(data, null, 4));
                  
                  $('#medical_form_type_id').val(medical_form_type_id);
                  $('#medical_form').html(data.ret_form);
                  $('#ModalMedicalFormTitle').html(data.ret_data.head);

                }
                else
                {
                  // alert(JSON.stringify(data, null, 4));
                  printErrorMsg(data.error);
                }
              }

            }); //$.ajax

    $('#ModalMedicalForm').modal({ keyboard: false, backdrop: 'static' });
    $('#ModalMedicalForm').modal('show');

  }

  function showMedicalFormDiv(medical_form_id)
  {
    $('#extra_body').html("pobieram dane...");

    $.ajax({
            type:'GET',
            url:"{{ route('sceneactor.medical_form_get_ajax') }}",
            data:{show_edit:'show',scene_actor_id:{{$sceneactor->id}},medical_form_id:medical_form_id},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  // alert(JSON.stringify(data, null, 4));
                  foot=' <hr><button class="btn btn-sm btn-outline-success col-12" onClick="javascript:clearMedicalFormDiv()">zamknij</button>';
                  $('#extra_body').html(data.ret_form+foot);

                }
                else
                {
                  // alert(JSON.stringify(data, null, 4));
                  printErrorMsg(data.error);
                }
              }
            }); //$.ajax
  }

  function clearMedicalFormDiv()
  {
    $('#extra_body').html("&nbsp;");
  }



  

</script>



@if (!is_null($sceneactor->scene->scene_relative_date))

@include('sceneactor.js_clock_include')

@endif

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script> 

@endsection
