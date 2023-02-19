<div class="modal fade" id="TemplateDeleteModal" tabindex="-1" aria-labelledby="TemplateDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TemplateDeleteModalTitle">Usuń szablon...</h5>
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
            @if ($lab_order_template->id>0)
              <button type="button" class="btn btn-success" onClick="javascript:template_delete({{$lab_order_template->id}})">Potwierdź</button>
            @endif
              <button type="button" class="btn btn-secondary" onClick="javascript:$('#TemplateDeleteModal').modal('hide')">zamknij</button>
            </div>
      </div> <!-- modal-body -->
    </div> <!-- modal-content -->
  </div> <!-- modal-dialog -->
</div> <!-- modal fade -->


<script>
function showTemplateDeleteModal()
  {
    document.getElementById('template_delete_yes').value='';
    $('#TemplateDeleteModal').modal('show');
  }
  
  function template_delete(id)
  {
    if (document.getElementById('template_delete_yes').value == 'TAK')
    {
      $.ajax({
        // type:'DELETE',
        type:'POST',
          url:"{{route('laboratorytemplate.delete')}}",
          data:{
                id: id,
                delete_approve: document.getElementById('template_delete_yes').value
              },
          success:function(data){
            if(data.code==1)
              {
                $('#TemplateDeleteModal').modal('hide');
                location.href="{{route('character.show',$character_id)}}";
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

