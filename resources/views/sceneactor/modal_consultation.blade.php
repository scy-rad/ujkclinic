<div class="modal fade" id="ConsultationOrderModal" tabindex="-1" aria-labelledby="ConsultationOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ConsultationOrderModalTitle">Zleć konsultację/diagnostykę</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  <!-- modal-header -->
      <div class="modal-body">
        <form action="{{ route('sceneactorconsultation.consultation_save_ajax')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
              <input type="hidden" name="consultation_id" value="0">
              <input type="hidden" name="scene_actor_id" value="{{$sceneactor->id}}">
              <input type="hidden" name="action" value="consultation_order">
            <div class="row mb-3">
              <div class="col-2">

              <p><label for="cont_id" class="form-label">Zlecenie na:</label>
                <select name="cont_id" class="form-select">
                  @foreach (App\Models\ConsultationType::all() as $type_one)
                    <option value="{{$type_one->id}}">{{$type_one->cont_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-6">
                <label for="sac_type_details" class="form-label">szczegóły (jaką/jakie-czego):</label>
                <input type="text" name="sac_type_details" class="form-control" placeholder="szczegóły rodzaju zlecenia" value="">
              </div>
            </div>
            <div class="col-12">
                <label for="sac_reason" class="form-label">powód:</label>
                <textarea name="sac_reason" class="form-control"></textarea>
              </div>
            <div class="row mb-3">
              <div class="col-4">
                <button type="submit" class="btn btn-success btn-submit btn-tmpl-save">Potwierdź</button>
              </div>
              <div class="col-4 text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
              </div>
              <div class="col-4 text-end" id="for_delete">
              </div>
            </div>
        </form>
      </div> <!-- modal-body -->
    </div> <!-- modal-content -->
  </div> <!-- modal-dialog -->
</div> <!-- modal fade -->




<div class="modal fade" id="ConsultationShowModal" tabindex="-1" aria-labelledby="ConsultationShowModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ConsultationShowModalTitle">Wyniki...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  <!-- modal-header -->
      <div class="modal-body">
            <div class="row">
              <div class="col-4">
                <p><label class="form-label">zlecono:</label>
                <span id="sac_date_order"></span></p>
              </div>
              <div class="col-4">
                <p><label class="form-label">wykonano:</label>
                <span id="sac_date_visit"></span></p>
              </div>
              <div class="col-4">
                <p><label class="form-label">opisano:</label>
                <span id="sac_date_descript"></span></p>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="cont_id" class="form-label">Zlecenie na:</label>
                <span id="consultation_type"></span> <span class="h2" id="sac_type_details"></span></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label class="form-label  mb-0">powód:</label>
              </div>
              <div class="col-12" id="sac_reason">
              </div>
            </div>
            <div class="row mb-3">
              <label class="form-label">załączniki:</label>
              <div class="row mb-3" id="ConsultationAttachments">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label class="form-label mb-0">opis:</label>
              </div>
              <div class="col-12" id="sac_description">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-4">
                <button type="submit" class="btn btn-success btn-submit btn-tmpl-save">Potwierdź</button>
              </div>
              <div class="col-4 text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
              </div>
              <div class="col-4 text-end" id="for_delete">
              </div>
            </div>
        </form>
      </div> <!-- modal-body -->
    </div> <!-- modal-content -->
  </div> <!-- modal-dialog -->
</div> <!-- modal fade -->


<script type="text/javascript">
    function showConsultationOrderModal()
  {
    $('#ConsultationOrderModal').modal('show');
  }



  function showConsultationShowModal(idvalue)
  {
    $.ajax({
            type:'GET',
            url:"{{ route('sceneactorconsultation.consultation_get_ajax') }}",
            data:{idvalue:idvalue,what:'get_consultation'},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  alert(JSON.stringify(data, null, 4));
                  alert(data.ret_data.consultation_type.cont_head);
  
                  $('#consultation_id').val(data.ret_data.id);

                  $('#sac_type_details').html(data.ret_data.sac_type_details);
                  $('#sac_reason').html(data.ret_data.sac_reason);
                  $('#sac_date_order').html(data.ret_data.sac_date_order);
                  $('#sac_date_visit').html(data.ret_data.sac_date_visit);
                  $('#sac_date_descript').html(data.ret_data.sac_date_descript);
                  $('#sac_description').html(data.ret_data.sac_description);

                  $('#consultation_type').html(data.ret_data.consultation_type.cont_head);

                  $('#cont_id option:selected').removeAttr('selected');
                  $("#cont_id option[value=" + data.ret_data.cont_id + "]").attr("selected","selected");

                  valueX = '';
                  if (data.ret_data.id>0)
                  {
                    $.each(data.ret_data.attachments, function(index, value) {
                      valueX = valueX+'<div class="card col-3">';
                      valueX = valueX+'<img class="card-img-top" id="scta_file_'+value.id+'" src="'+value.scta_file+'" alt="'+value.scta_name+'">';
                      valueX = valueX+'<div class="card-body p-0">';
                      valueX = valueX+'<p class="card-text" id="scta_name_'+value.id+'">'+value.scta_name+'</p>';
                      valueX = valueX+'</div>';
                      valueX = valueX+'</div>';
                      
                      value_last=value.scta_file;
                    });
                  }
                  $('#ConsultationAttachments').html(valueX);
              
                    $('#ConsultationShowModalTitle').html('Szczegóły: '+data.ret_data.id);
                }
                else
                {
                  printErrorMsg(data.error);
                  slert('error modal show consultation');
                }
              }
            });

    $('#ConsultationShowModal').modal('show');
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

