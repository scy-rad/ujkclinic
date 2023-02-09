<div class="modal fade" id="TemplateEditModal" tabindex="-1" aria-labelledby="TemplateEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="TemplateEditModalTitle">Edycja szablonu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('laboratorytemplate.update')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

              <input type="hidden" name="id" required="required" value="{{$lab_order_template->id}}">
              <input type="hidden" name="character_id" required="required" value="{{$character_id}}">

            <div class="row mb-3">
              <div class="col-5">
                <label for="lrt_type" class="form-label">rodzaj szablonu:</label>
                <select name="lrt_type" class="form-select">
                  <option value="1" @if ($lab_order_template->lrt_type==1) checked="checked" @endif>historyczny</option>
                  <option value="2" @if ($lab_order_template->lrt_type==2) checked="checked" @endif>bieżący</option>
                </select>
              </div>
              <div class="col-4">
                <label for="lrt_minutes_before" class="form-label">ilość minut wstecz:</label>
                <input type="number" step="1" min="0" name="lrt_minutes_before" class="form-control" placeholder="Ilośc minut wstecz" value="{{$lab_order_template->lrt_minutes_before}}">
              </div>
              <div class="col-3">
                <label for="lrt_sort" class="form-label">kolejność:</label>
                <input type="number" step="1" min="1" max="50" name="lrt_sort" class="form-control" placeholder="kolejność" value="{{$lab_order_template->lrt_sort*1}}">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label for="description_for_leader" class="form-label">Opis dla instruktora:</label>
                <textarea name="description_for_leader" class="form-control">{!!$lab_order_template->description_for_leader!!}</textarea>
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="submit" class="btn btn-success btn-submit btn-tmpl-edit">Potwierdź</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function showTemplateEditModal()

  {
    $('#TemplateEditModal').modal('show');
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

