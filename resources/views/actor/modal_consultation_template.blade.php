<div class="modal fade" id="ConsultationTemplateModal" tabindex="-1" aria-labelledby="ConsultationTemplateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ConsultationTemplateModalTitle">Edycja szablonu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  <!-- modal-header -->
      <div class="modal-body">
        <form action="{{ route('actor.scenario_actor_save_ajax')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

              <input type="hidden" name="id" id="cons_id" value="">
              <input type="hidden" name="actor_id" value="{{$actor_id}}">
              <input type="hidden" name="action" value="consultation_template">

            <div class="row mb-3">
              <div class="col-4">
                <label for="sctt_id" class="form-label">Zlecenie na:</label>
                <select name="sctt_id" id="sctt_id" class="form-select">
                  @foreach (App\Models\ScenarioConsultationTemplateType::all() as $type_one)
                    <option value="{{$type_one->id}}">{{$type_one->sctt_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-8">
                <label for="sct_type_details" class="form-label">szczegóły (jaką/jakie-czego):</label>
                <input type="text" name="sct_type_details" id="sct_type_details" class="form-control" placeholder="szczegóły rodzaju zlecenia" value="">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-4">
                <label for="sct_minutes_before" class="form-label">ilość minut wstecz:</label>
                <input type="number" step="1" min="0" name="sct_minutes_before" id="sct_minutes_before" class="form-control" placeholder="Ilośc minut wstecz" value="">
              </div>
              <div class="col-8">
                <label for="sct_seconds_description" class="form-label">il. sekund od ostatniego zał. do zrobienia opisu:</label>
                <input type="number" step="1" min="0" name="sct_seconds_description" id="sct_seconds_description" class="form-control" placeholder="Ilośc sekund do opisu" value="">
              </div>
            </div>  
            <div class="row mb-3">
              <div class="col-12">
                <label for="sct_reason" class="form-label">opis powodu zlecenia:</label>
                <textarea name="sct_reason" id="sct_reason" class="form-control"></textarea>
              </div>
              <div class="col-12">
                <label for="sct_verbal_attach" class="form-label">opis słowny (przed opisem pisemnym):</label>
                <textarea name="sct_verbal_attach" id="sct_verbal_attach" class="form-control"></textarea>
              </div>
              <div class="col-12">
                <label for="sct_description" class="form-label">opis:</label>
                <textarea name="sct_description" id="sct_description" class="form-control"></textarea>
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="submit" class="btn btn-success btn-submit btn-tmpl-edit">Potwierdź</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
        </form>
      </div> <!-- modal-body -->
    </div> <!-- modal-content -->
  </div> <!-- modal-dialog -->
</div> <!-- modal fade -->




<script type="text/javascript">
  function showConsultationTemplateModal(idvalue)
  {

    $.ajax({
            type:'GET',
            url:"{{ route('actor.scenario_actor_get_ajax') }}",
            data:{idvalue:idvalue,what:'consultation'},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  // alert(JSON.stringify(data, null, 4));
  
                  $('#cons_id').val(data.ret_data.id);
                  $('#sct_type_details').val(data.ret_data.sct_type_details);
                  $('#sct_reason').val(data.ret_data.sct_reason);
                  $('#sct_minutes_before').val(data.ret_data.sct_minutes_before);
                  $('#sct_seconds_description').val(data.ret_data.sct_seconds_description);
                  $('#sct_verbal_attach').val(data.ret_data.sct_verbal_attach);
                  $('#sct_description').val(data.ret_data.sct_description);

                  $('#sctt_id option:selected').removeAttr('selected');
                  $("#sctt_id option[value=" + data.ret_data.sctt_id + "]").attr("selected","selected");

                  if (data.ret_data.id>0)
                    $('#ConsultationTemplateModalTitle').html('Edycja zlecenia: '+data.ret_data.id);
                  else
                    $('#ConsultationTemplateModalTitle').html('Nowe zlecenie.');
                }
                else
                {
                  printErrorMsg(data.error);
                }
              }
            });

    $('#ConsultationTemplateModal').modal('show');
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

