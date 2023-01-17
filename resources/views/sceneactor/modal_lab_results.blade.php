<?php
?>

<div class="modal fade" id="LabResults" tabindex="-2" aria-labelledby="LabResultsLabel" aria-hidden="true">
  <div class="modal-xl modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="float-start modal-title" id="LabResultsTitle">Wyniki badań laboratoryjnych</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <span id="salo_results">
        </span>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function showLabResultModal(idvalue)
  {
    $.ajax({
            type:'GET',
            url:"{{ route('salaborder.getajax') }}",
            data:{idvalue:idvalue,what:'lab_results'},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  // alert(JSON.stringify(data, null, 4));
                  // console.log("aaa");

                    $('#salo_results').html(data.salo_data);
                    // $('#salo_date_order').val(data.salo_data.salo_date_order);
                    // $('#salo_date_take').val(data.salo_data.salo_date_take);
                }
                else
                {
                  printErrorMsg(data.error);
                }
              }
            });

    $('#LabResults').modal('show');
  }

</script>
