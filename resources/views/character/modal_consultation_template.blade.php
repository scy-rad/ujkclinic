<div class="modal fade" id="ConsultationTemplateModal" tabindex="-1" aria-labelledby="ConsultationTemplateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ConsultationTemplateModalTitle">Edycja szablonu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  <!-- modal-header -->
      <div class="modal-body">
        <form action="{{ route('character.scenario_character_save_ajax')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

              <input type="hidden" name="id" id="cons_id" value="">
              <input type="hidden" name="character_id" value="{{$character_id}}">
              <input type="hidden" name="action" value="consultation_template">

            <div class="row mb-3">
              <div class="col-2">
                <label for="sctt_id" class="form-label">Zlecenie na:</label>
                <select name="sctt_id" id="sctt_id" class="form-select">
                  @foreach (App\Models\ScenarioConsultationTemplateType::all() as $type_one)
                    <option value="{{$type_one->id}}">{{$type_one->sctt_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-6">
                <label for="sct_type_details" class="form-label">szczegóły (jaką/jakie-czego):</label>
                <input type="text" name="sct_type_details" id="sct_type_details" class="form-control" placeholder="szczegóły rodzaju zlecenia" value="">
              </div>
              <div class="col-2">
                <label for="sct_minutes_before" class="form-label">ilość minut wstecz:</label>
                <input type="number" step="1" min="0" name="sct_minutes_before" id="sct_minutes_before" class="form-control" placeholder="Ilośc minut wstecz" value="">
              </div>
              <div class="col-2">
                <label for="sct_seconds_description" class="form-label">ilość sekund od <abbr title="ostatniego załącznika do zrobienia opisu">...</abbr>:</label>
                <input type="number" step="1" min="0" name="sct_seconds_description" id="sct_seconds_description" class="form-control" placeholder="Ilośc sekund do opisu" value="">
              </div>
            </div>
            <div class="row mb-0">
            <label class="form-label">załączniki:</label>
            <div class="row mb-3" id="ConsultationAttachments">
            </div>
            <div class="row mb-3">
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
              <button type="submit" class="btn btn-success btn-submit btn-tmpl-save">Potwierdź</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
        </form>
      </div> <!-- modal-body -->
    </div> <!-- modal-content -->
  </div> <!-- modal-dialog -->
</div> <!-- modal fade -->


<div class="modal fade" id="TextSubModal" tabindex="-1" aria-labelledby="TextSubModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TextSubModalTitle">Edycja tekstu</h5>
        <button type="button" class="btn-close" onClick="javascript:$('#TextSubModal').modal('hide')" aria-label="Close"></button>
      </div>  <!-- modal-header -->
      <div class="modal-body">
        <form action="{{ route('character.scenario_character_save_ajax')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
              <input type="hidden" name="id" id="id_subtxt" value="">
            <div class="row mb-3">
              <div class="col-12">
                <label for="scta_subtxt" class="form-label">nazwa zdjęcia:</label>
                <input type="text" name="scta_subtxt" id="scta_subtxt" class="form-control" placeholder="opis zdjęcia" value="">
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="button" class="btn btn-success" onClick="javascript:pic_descrip_save()">Potwierdź</button>
              <button type="button" class="btn btn-secondary" onClick="javascript:$('#TextSubModal').modal('hide')">zamknij</button>
            </div>
        </form>
      </div> <!-- modal-body -->
    </div> <!-- modal-content -->
  </div> <!-- modal-dialog -->
</div> <!-- modal fade -->


<div class="modal fade" id="FotDeleteModal" tabindex="-1" aria-labelledby="FotDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="FotDeleteModalTitle">Usuń zdjęcie</h5>
        <button type="button" class="btn-close" onClick="javascript:$('#FotDeleteModal').modal('hide')" aria-label="Close"></button>
      </div>  <!-- modal-header -->
      <div class="modal-body">
        <form action="{{ route('character.scenario_character_save_ajax')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
              <input type="hidden" name="id" id="id_fotdelete" value="">
            <div class="row mb-3">
              <div class="col-12">
                <label for="fot_delete_yes" class="form-label">na pewno chcesz usunąć? [TAK]</label>
                <input type="text" name="fot_delete_yes" id="fot_delete_yes" class="form-control" placeholder="napisz TAK, żeby usunąć..." value="">
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="button" class="btn btn-success" onClick="javascript:pic_delete_save()">Potwierdź</button>
              <button type="button" class="btn btn-secondary" onClick="javascript:$('#FotDeleteModal').modal('hide')">zamknij</button>
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
            url:"{{ route('character.scenario_character_get_ajax') }}",
            data:{idvalue:idvalue,what:'consultation'},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  // alert(JSON.stringify(data.ret_data.attachments, null, 4));
  
                  $('#cons_id').val(data.ret_data.id);
                  $('#sct_type_details').val(data.ret_data.sct_type_details);
                  $('#sct_minutes_before').val(data.ret_data.sct_minutes_before);
                  $('#sct_seconds_description').val(data.ret_data.sct_seconds_description);
                  $('#sct_verbal_attach').val(data.ret_data.sct_verbal_attach);
                  $('#sct_description').val(data.ret_data.sct_description);

                  $('#sctt_id option:selected').removeAttr('selected');
                  $("#sctt_id option[value=" + data.ret_data.sctt_id + "]").attr("selected","selected");

                  valueX='';
                  value_last='';

                  if (data.ret_data.id>0)
                  {
                    $.each(data.ret_data.attachments, function(index, value) {
                      
                      valueX = valueX+'<div class="card col-3">';
                      valueX = valueX+'<img class="card-img-top" id="scta_file_'+value.id+'" src="'+value.scta_file+'" alt="'+value.scta_name+'">';
                      valueX = valueX+'<div class="card-body p-0">';
                      valueX = valueX+'<p class="card-text" id="scta_name_'+value.id+'">'+value.scta_name+'</p>';
                      valueX = valueX+'<span class="btn btn-sm btn-primary" onClick="javascript:open_flmngr('+value.id+',\''+value.scta_file+'\',\''+value.scta_name+'\')"><i class="bi bi-pencil-square"></i> fot</span> ';
                      valueX = valueX+'<span class="btn btn-sm btn-primary" onClick="javascript:pic_descrip('+value.id+')"><i class="bi bi-pencil-square"></i> txt</span> ';
                      valueX = valueX+'<span class="btn btn-sm btn-danger" onClick="javascript:pic_delete('+value.id+')"><i class="bi bi-trash"></i></span>';
                      valueX = valueX+'</div>';
                      valueX = valueX+'</div>';
                      
                      value_last=value.scta_file;
                    });
                    valueX = valueX+'<div class="card col-3">';
                      valueX = valueX+'<img class="card-img-top" id="scta_file_0" src="" alt="...">';
                      valueX = valueX+'<div class="card-body p-0">';
                      valueX = valueX+'<span class="btn btn-sm btn-primary" onClick="javascript:open_flmngr(0,\''+value_last+'\',\''+''+'\')"><i class="bi bi-plus-square"></i> fot</span> &nbsp; ';
                      valueX = valueX+'</div>';
                      valueX = valueX+'</div>';
                      valueX = valueX+'<input type="hidden" id="sub_id">';
                      valueX = valueX+'<input type="hidden" id="new_image">';

                  }
                  $('#ConsultationAttachments').html(valueX);

                  if (data.ret_data.id>0)
                    $('#ConsultationTemplateModalTitle').html('Edycja zlecenia: '+data.ret_data.id);
                  else
                  {
                    $('#ConsultationTemplateModalTitle').html('Nowe zlecenie.');
                    $('#ConsultationAttachments').html('najpierw należy zapisać zlecenie, aby móc dodawać załączniki...');

                  }
                }
                else
                {
                  printErrorMsg(data.error);
                }
              }
            });

    $('#ConsultationTemplateModal').modal('show');
  }

  function open_flmngr(id,catalog,file)
  {
    $('#sub_id').val(id);
    $('#new_image').val('');

    window.open('/file-manager/fm-button?leftPath=look', 'fm', 'width=1400,height=800');
  }

  function fmSetLink($url) {

    $.ajax({
        type:'POST',
        url:"{{ route('character.scenario_character_save_ajax') }}",
        data:{
              action: 'pic_file_save',
              id: document.getElementById('sub_id').value,
              sct_id: document.getElementById('cons_id').value,
              scta_file_full: $url
            },
        success:function(data){
          if(data.code==1)
            {
              $('#TextSubModal').modal('hide');

              if (document.getElementById('sub_id').value>0)
              {
                // alert(JSON.stringify(data, null, 4));
                document.getElementById('new_image').value = $url;
                document.getElementById('scta_file_'+$('#sub_id').val()).src = $url;
              }
              else
              {
                showConsultationTemplateModal(document.getElementById('cons_id').value);
              }
            }
          else
            {
              alert('coś poszło nie tak...');
            }
        }
    });

  }

  function pic_descrip(id)
  {
    document.getElementById('id_subtxt').value = id;
    document.getElementById('scta_subtxt').value = document.getElementById('scta_name_'+id).innerHTML;
    
    $('#TextSubModal').modal('show');
  }
  function pic_descrip_save()
  {
    id = document.getElementById('id_subtxt').value;
    descript = document.getElementById('scta_subtxt').value;

    $.ajax({
        type:'POST',
        url:"{{ route('character.scenario_character_save_ajax') }}",
        data:{
              action: 'pic_descript_save',
              id: document.getElementById('id_subtxt').value,
              scta_name: document.getElementById('scta_subtxt').value          
            },
        success:function(data){
          if(data.code==1)
            {
              $('#TextSubModal').modal('hide');
                // alert(JSON.stringify(data, null, 4));
                document.getElementById('scta_name_'+id).innerHTML = descript;
            }
          else
            {
              alert('coś poszło nie tak...');
            }
        }
    });
    
  }

  function pic_delete(id)
  {
    document.getElementById('id_fotdelete').value = id;
    document.getElementById('fot_delete_yes').value = '';
    
    $('#FotDeleteModal').modal('show');
  }
  
  function pic_delete_save()
  {
    id = document.getElementById('id_fotdelete').value;
    descript = document.getElementById('fot_delete_yes').value;

    if (document.getElementById('fot_delete_yes').value == 'TAK')
    {
      $.ajax({
          type:'POST',
          url:"{{ route('character.scenario_character_save_ajax') }}",
          data:{
                action: 'pic_delete',
                id: document.getElementById('id_fotdelete').value,
                delete_approve: document.getElementById('fot_delete_yes').value          
              },
          success:function(data){
            if(data.code==1)
              {
                $('#FotDeleteModal').modal('hide');
                showConsultationTemplateModal(document.getElementById('cons_id').value);
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

