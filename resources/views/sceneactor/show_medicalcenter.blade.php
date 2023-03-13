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
        <label>wiek:</label> {{$sceneactor->sa_age_txt}}<br>
        <label>PESEL:</label> {{$sceneactor->sa_PESEL}}<br>
      </p>
    </div>
    <div class="col-12 border border-2 rounded text-center btn-outline-success mt-3"
      onClick="javascript:showMedicalFormDiv('show_visit',0,0)">
      przebieg wizyty
    </div>
    <div class="col-12 border border-2 rounded mt-3">
      <ul>
        @if (!(is_null($visit_card)))
        @foreach ($visit_card->medical_forms as $form_one)
          <li onClick="javascript:showMedicalFormDiv('show_form',{{$form_one->id}},{{$form_one->medical_form_type_id}})">{{$form_one->form_type->form_familly->mff_name}}
              {{$form_one->form_type->mft_name}}
              <!-- {{$form_one->mf_string_1}} -->
          </li>
        @endforeach
        @endif
      </ul>
    </div>
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
    @if ($view_action=='visit_in_progress') 
      <div class="card mb-2">
        <div class="card-header text-warning" onClick="javascript:showMedicalFormModal('edit_visit',0)">
          <i class="bi bi-book"></i> edytuj wizytę
        </div>
      </div> <!-- card -->
      @foreach (\App\Models\MedicalFormFamilly::all() as $mff_one)
        <div class="card mb-2">
          <div class="card-header" onClick="javascript:ShowHideDiv('TYP_{{$mff_one->mff_code}}','.hide_type')">
          <i class="bi bi-file-plus"></i> {!!$mff_one->mff_icon!!} {{$mff_one->mff_name}}
          </div>
          <div class="hide_type" style="display: none" id="TYP_{{$mff_one->mff_code}}">
            <ul>
              @foreach($mff_one->form_types as $mft_one)
              <li onClick="showMedicalFormModal('edit_form',{{$mft_one->id}})">{{$mft_one->mft_short}}</li>
              @endforeach
            </ul>
          </div>
        </div> <!-- card -->
      @endforeach

      <div class="card mb-2">
        <div class="card-header text-danger" onClick="javascript:showEndVisitModal()">
          <i class="bi bi-book"></i> zakończ wizytę
        </div>
      </div> <!-- card -->
    @endif
  </div>
  <!--/======================== RIGHT COLUMN ======================== -->

</div>


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

@include('sceneactor.inc_modal_medical_center_visit_begin_end')

@if ( ($view_action=='start_visit_required') || ($view_action=='start_visit_optional') )

<script type="text/javascript">
    $(window).on('load', function() {
      $('#ModalStartVisitTitle').html('Czy chcesz rozpocząć wizytę');
      $('#ModalStartVisitQuestion').html('Czy chcesz rozpocząć wizytę');
      $('#visit_action').val('begin_visit');
      @if ($view_action=='start_visit_required')
        $('#back_button').html('<a class="text-decoration-none" href="{{ route('scene.show',$sceneactor->scene->id) }}"><button type="button" class="btn btn-warning" style="font-size: 48px; width: 100%">anuluj</button></a>');
      @endif


      $('#ModalStartVisit').modal({ keyboard: false, backdrop: 'static' });
      $('#ModalStartVisit').modal('show');
    });
</script>

@endif

@include('sceneactor.inc_modal_medical_center_form')


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


  function showMedicalFormModal(whattodo,medical_form_type_id)
  {
    $('#ModalMedicalFormTitle').html('formularz w trakcie przygotowywania...');
    $('#medical_form').html('');
    
    $.ajax({
            type:'GET',
            url:"{{ route('sceneactor.medical_form_get_ajax') }}",
            data:{save_action:whattodo,scene_actor_id:{{$sceneactor->id}},mcvc_id:{{$mcvc_id}},medical_form_type_id:medical_form_type_id},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  // alert(JSON.stringify(data, null, 4));              
                  $('#medical_form_type_id').val(medical_form_type_id);
                  $('#save_action').val(whattodo);
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

  function showMedicalFormDiv(whattodo,medical_form_id,medical_form_type_id)
  {
    $('#extra_body').html("pobieram dane...");

    $.ajax({
            type:'GET',
            url:"{{ route('sceneactor.medical_form_get_ajax') }}",
            data:{save_action:whattodo,scene_actor_id:{{$sceneactor->id}},mcvc_id:{{$mcvc_id}},medical_form_id:medical_form_id,medical_form_type_id:medical_form_type_id},
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

  function showEndVisitModal()
  {
    $('#ModalStartVisit').modal({ keyboard: false, backdrop: 'static' });
    $('#ModalStartVisit').modal('show');
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
