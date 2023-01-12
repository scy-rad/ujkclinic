<?php
  // scene_master_id
  // actor_id
  // sa_incoming_date
  // sa_incoming_recalculate
  // sa_main_book
  // sa_name
  // sa_birth_date
  // sa_PESEL
  // sa_actor_sex  // 2 - mężczyzna,  3 - kobieta
  // sa_actor_nn
  // sa_actor_role_name
  // sa_history_for_actor
  // sa_actor_simulation
?>


<div class="modal fade" id="LabOrder" tabindex="-2" aria-labelledby="LabOrderLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="LabOrderTitle">Zlecenie badań laboratoryjnych</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      <div class="modal-body">


          <form action="{__{ route('laboratoryorder.store') }__}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <input type="hidden" name="scene_master_id" value="">
            <input type="hidden" id="actor_id" name="id" value="">
            

            <div class="row mb-3">
              <div class="col col-auto">
                @foreach (App\Models\LaboratoryOrderGroup::all() as $group_one)
                  {{$group_one->log_name}}
                    @foreach (App\Models\LaboratoryOrder::where('laboratory_order_group_id',$group_one->id)->get() as $test_one)
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="test{{$test_one->id}}" name="test{{$test_one->id}}">
                        <label class="form-check-label" for="flexCheckDefault">
                          {{$test_one->lo_name}}
                        </label>
                      </div>
                      @if ($test_one->lo_break)
                        </div>  
                        <div class="col col-auto">
                      @endif
                    @endforeach
                @endforeach
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
  function showLabOrderModal()
  {
    $('#LabOrder').modal('show');
  }

  function proposeActor()
  {
    $.ajax({
            type:'GET',
            url:"{{ route('scene.getajax') }}",
            data:{actor_sex:$('#sa_actor_sex').val(),
              birth_date:$('#sa_birth_date').val(),
              what:'actor_propose'},
            success:function(data){
                if($.isEmptyObject(data.error)){
                  // alert(JSON.stringify(data, null, 4));
                  $('#sa_PESEL').val(data.PESEL);
                  $('#sa_name').val(data.name);
                  }else{
                    printErrorMsg(data.error);
                  }
                }
            });
  }
</script>
