@extends('layouts.master')

@section('add_styles')
<link href="{{ asset('css/scenarios.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
   Edit character:
    <div class="p-6 text-gray-900 dark:text-gray-100">
    </div>

<form action="{{ route('character.update',$character->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('character.formCrUd')
<div class="row mt-2">
  <div class="col-4">
    <button type="submit" class="btn btn-primary ml-3">Zapisz</button>
    </form>
  </div>
  <div class="col-4">
    @if ( ($character->lab_order_templates->count()==0) && ($character->consultation_templates->count()==0) )
      <span class="btn btn-danger m-1" oNClick="javascript:showTemplateDeleteModal()"><i class="bi bi-trash"></i> usuń</span>
    @endif
  </div>
  <div class="col-4">
    <a href="{{ url()->previous() }}"><span class="btn btn-secondary ml-3">Powrót</span></a>
  </div>
</div>




<div class="modal fade" id="TemplateDeleteModal" tabindex="-1" aria-labelledby="TemplateDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TemplateDeleteModalTitle">Usuń postać...</h5>
        <button type="button" class="btn-close" onClick="javascript:$('#TemplateDeleteModal').modal('hide')" aria-label="Close"></button>
      </div>  <!-- modal-header -->
      <div class="modal-body">
            <div class="row mb-3">
              <div class="col-12">
                <label for="template_delete_yes" class="form-label">na pewno chcesz usunąć? [TAK]</label>
                <input type="text" name="template_delete_yes" id="template_delete_yes" class="form-control" placeholder="napisz TAK, żeby usunąć..." value="">
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="button" class="btn btn-success" onClick="javascript:template_delete({{$character->id}})">Potwierdź</button>
              <button type="button" class="btn btn-secondary" onClick="javascript:$('#TemplateDeleteModal').modal('hide')">zamknij</button>
            </div>
      </div> <!-- modal-body -->
    </div> <!-- modal-content -->
  </div> <!-- modal-dialog -->
</div> <!-- modal fade -->


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
function showTemplateDeleteModal()
  {
    $('#TemplateDeleteModal').modal('show');
  }
  
  function template_delete(id)
  {
    if (document.getElementById('template_delete_yes').value == 'TAK')
    {

      $.ajax({
        type:'DELETE',
        // type:'POST',
          url:"{{route('character.destroy',$character->id)}}",
          data:{
                id: id,
                delete_approve: document.getElementById('template_delete_yes').value
              },
          success:function(data){
            if(data.code==1)
              {
                $('#TemplateDeleteModal').modal('hide');
                location.href="{{route('scenario.show',$character->scenario->id)}}";
              }
            else
              {
                alert('coś poszło nie tak...');
              }
          }
      });
    }
  }

</script>


<script type="text/javascript">      
    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
</script>




@endsection
