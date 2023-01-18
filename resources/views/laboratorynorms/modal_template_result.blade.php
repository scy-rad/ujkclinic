<div class="modal fade" id="TemplateModal" tabindex="-1" aria-labelledby="TemplateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="TemplateModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form >
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="mb-3">
              <input type="hidden" id="lab_result_template_id" name="lab_result_template_id" required="required">
              <input type="hidden" id="lab_order_template_id" name="lab_order_template_id" required="required">
              <input type="hidden" id="laboratory_test_id" name="laboratory_test_id" required="required">
              <input type="hidden" id="labtype" name="labtype" required="required">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">dokładność: 1 / </span>
                <input type="text" class="form-control" id="decimal_prec" name="decimal_prec" required="required" readonly>
              </div>
            </div>
            <div class="mb-3" id="lrtr_result_label">
              <label for="lrtr_result" class="form-label">lrtr_result:</label>
              <input type="text" id="lrtr_result" name="lrtr_result" class="form-control" placeholder="lrtr_result" required="required">
            </div>
            <div class="mb-3" id="lrtr_resulttxt_label">
              <label for="lrtr_resulttxt" class="form-label">lrtr_resulttxt:</label>
              <input type="text" id="lrtr_resulttxt" name="lrtr_resulttxt" class="form-control" placeholder="lrtr_resulttxt" required="required">
            </div>
            <div class="mb-3">
                <label for="lrtr_addedtext" class="form-label">lrtr_addedtext:</label>
                <input type="text" id="lrtr_addedtext" name="lrtr_addedtext" class="form-control" placeholder="lrtr_addedtext" required="required">
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="lrtr_type" class="form-label">lrtr_type:</label>
                <select id="lrtr_type" name="lrtr_type" class="form-select">
                  @foreach ($result_type as $result_one)
                    <option value="{{$result_one['id']}}">{{$result_one['value']}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-6">
                <label for="lrtr_sort" class="form-label">lrtr_sort:</label>
                <input type="number" step="1" min="1" max="99" id="lrtr_sort" name="lrtr_sort" class="form-control" placeholder="Kolejność sortowania" required="required">
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="button" class="btn btn-success btn-submit btn-tmpl">Potwierdź</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function showTemplateModal(id_result,id_tmpl,id_lab,labtype)

  {
    if (labtype==1)
    {
      $('#lrtr_result').val(document.getElementById('result_'+id_lab).innerHTML);
      $('#lrtr_resulttxt').val("");
      $('#lrtr_result_label').show();
      $('#lrtr_resulttxt_label').hide();
    }
    else
    {
    $('#lrtr_result').val("");
    $('#lrtr_resulttxt').val(document.getElementById('result_'+id_lab).innerHTML);
    $('#lrtr_result_label').hide();
    $('#lrtr_resulttxt_label').show();
    }
    $('#labtype').val(labtype);
    $('#lab_result_template_id').val(id_result);
    $('#lab_order_template_id').val(id_tmpl);
    $('#laboratory_test_id').val(id_lab);
    $('#lrtr_addedtext').val(document.getElementById('addedtext_'+id_lab).innerHTML);
    $('#decimal_prec').val(document.getElementById('decimal_'+id_lab).innerHTML);
    
    $('#lrtr_type option:selected').removeAttr('selected');
    $("#lrtr_type option[value=" + document.getElementById('type_'+id_lab).innerHTML + "]").attr("selected","selected");

    $('#TemplateModal').modal('show');
  }
</script>

<script type="text/javascript">      
    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  
    $(".btn-tmpl").click(function(e){    
        e.preventDefault();
        $('#TemplateModalTitle').html('zapisywanie szablonu badań');
        $.ajax({
           type:'POST',
           url:"{{ route('laboratorytemplate.updateajax') }}",
           data:{
            lab_result_template_id: $('#lab_result_template_id').val(),
            lab_order_template_id: $('#lab_order_template_id').val(),
            laboratory_test_id: $('#laboratory_test_id').val(),
            lrtr_resultX: $('#lrtr_result').val(),
            lrtr_resulttxt: $('#lrtr_resulttxt').val(),
            lrtr_addedtext: $('#lrtr_addedtext').val(),
            lrtr_type: $('#lrtr_type').val(),
            decimal_prec: $('#decimal_prec').val(),
                },
           success:function(data){
                if($.isEmptyObject(data.error)){
                    // alert(JSON.stringify(data, null, 4));
                    // alert(data.success);
                    location.reload();
                }else{
                    printErrorMsg(data.error);
                }
            }
        });    
    });
  
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
  
</script>

