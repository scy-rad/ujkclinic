<div class="modal fade" id="LTGModal" tabindex="-1" aria-labelledby="LTGModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="LTGModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form >
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="mb-3">
              <input type="hidden" id="id" name="id" required="required">
            </div>
            <div class="mb-3">
              <label for="ltg_name" class="form-label">Nazwa:</label>
              <input type="text" id="ltg_name" name="ltg_name" class="form-control" placeholder="Nazwa" required="required">
            </div>
            <div class="mb-3">
              <label for="ltg_name_en" class="form-label">Nazwa angielska:</label>
              <input type="text" id="ltg_name_en" name="ltg_name_en" class="form-control" placeholder="Nazwa angielska" required="required">
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="ltg_levels_count" class="form-label">Poziomy badania:</label>
                <input  type="number" step="1" min="1" max="9" id="ltg_levels_count" name="ltg_levels_count" class="form-control" placeholder="Poziomy badania" required="required">
              </div>
              <div class="col-6">
                <label for="ltg_sort" class="form-label">Sortowanie:</label>
                <input type="number" step="1" min="1" max="99" id="ltg_sort" name="ltg_sort" class="form-control" placeholder="Kolejnośc sortowania" required="required">
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="button" class="btn btn-success btn-submit btn-ltg">Potwierdź</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="LTModal" tabindex="-1" aria-labelledby="LTModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="LTModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form >
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="mb-3">
              <input type="hidden" id="id" name="id" required="required">
              <input type="hidden" id="laboratory_test_group_id" name="laboratory_test_group_id" required="required">
              
            </div>
            <div class="mb-3">
              <label for="lt_name" class="form-label">Nazwa:</label>
              <input type="text" id="lt_name" name="lt_name" class="form-control" placeholder="Nazwa" required="required">
            </div>
            <div class="mb-3">
              <label for="lt_name_en" class="form-label">Nazwa angielska:</label>
              <input type="text" id="lt_name_en" name="lt_name_en" class="form-control" placeholder="Nazwa angielska" required="required">
            </div>
            <div class="row mb-3"> 
              <div class="col-6">
                <label for="lt_short" class="form-label">Skrót:</label>
                <input type="text" id="lt_short" name="lt_short" class="form-control" placeholder="Skrót" required="required">
              </div>
              <div class="col-6">
                <label for="lt_short_en" class="form-label">Skrót angielski:</label>
                <input type="text" id="lt_short_en" name="lt_short_en" class="form-control" placeholder="Skrót angielski" required="required">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="lt_level" class="form-label">Poziom badania:</label>
                <input type="number" step="1" min="1" max="9" id="lt_level" name="lt_level" class="form-control" placeholder="Poziom badania (1-9)" required="required">
              </div>
              <div class="col-6">
                <label for="lt_sort" class="form-label">Sortowanie:</label>
                <input type="number" step="1" min="1" max="99" id="lt_sort" name="lt_sort" class="form-control" placeholder="Kolejnośc sortowania" required="required">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="lt_time" class="form-label">Czas badania (min.):</label>
                <input type="number" step="1" min="0" id="lt_time" name="lt_time" class="form-control" placeholder="Czas badania" required="required">
              </div>
              <div class="col-6">
                <label for="lt_coast" class="form-label">Koszt badania (gr.):</label>
                <input type="number" step="1" min="1" id="lt_coast" name="lt_coast" class="form-control" placeholder="Koszt badania" required="required">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="lt_time_cito" class="form-label">Czas badania (CITO):</label>
                <input type="number" step="1" min="0" id="lt_time_cito" name="lt_time_cito" class="form-control" placeholder="Czas badania CITO" required="required">
              </div>
              <div class="col-6">
                <label for="lt_coast_cito" class="form-label">Kost badania (CITO):</label>
                <input type="number" step="1" min="1" id="lt_coast_cito" name="lt_coast_cito" class="form-control" placeholder="Koszt badania CITO" required="required">
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="button" class="btn btn-success btn-submit btn-lt">Potwierdź</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>








<div class="modal fade" id="LTNModal" tabindex="-1" aria-labelledby="LTNModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="LTNModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form >
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="mb-3">
              <input type="hidden" id="id" name="id" required="required">
              <input type="hidden" id="laboratory_test_id" name="laboratory_test_id" required="required">
              
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="ltn_days_from" class="form-label">wiek:norma od (dni) (max 180):</label>
                <input type="number" step="1" min="0" max="180" id="ltn_days_from" name="ltn_days_from" class="form-control" placeholder="dni (0-180)" required="required">
              </div>
              <div class="col-6">
              <label for="ltn_days_to" class="form-label">wiek:norma do (dni) (1r=365d):</label>
                <input type="number" step="1" min="0" max="{{120*365}}" id="ltn_days_to" name="ltn_days_to" class="form-control" placeholder="dni (max: {{120*365}})" required="required">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="ltn_norm_type" class="form-label">rodzaj zakresu:</label>
                <input type="number" step="1" id="ltn_norm_type" name="ltn_norm_type" class="form-control" placeholder="rodzaj zakresu" required="required">
              </div>
              <div class="col-6">
                <label for="ltn_decimal_prec" class="form-label">dzielnik dla normy (wielokr. 10):</label>
                <input type="number" step="1" id="ltn_decimal_prec" name="ltn_decimal_prec" class="form-control" placeholder="dzielnik dla normy" required="required">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">
                <label for="ltn_norm_m_min" class="form-label">OD - dla mężczyzn:</label>
                <input type="number" step="1" id="ltn_norm_m_min" name="ltn_norm_m_min" class="form-control" placeholder="norma dla mężczyzn" required="required">
              </div>
              <div class="col-6">
                <label for="ltn_norm_m_max" class="form-label">DO - dla mężczyzn:</label>
                <input type="number" step="1" id="ltn_norm_m_max" name="ltn_norm_m_max" class="form-control" placeholder="norma dla mężczyzn" required="required">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="ltn_norm_w_min" class="form-label">OD - dla kobiet:</label>
                <input type="number" step="1" id="ltn_norm_w_min" name="ltn_norm_w_min" class="form-control" placeholder="norma dla kobiet" required="required">
              </div>
              <div class="col-6">
                <label for="ltn_norm_w_max" class="form-label">DO - dla kobiet:</label>
                <input type="number" step="1" id="ltn_norm_w_max" name="ltn_norm_w_max" class="form-control" placeholder="norma dla kobiet" required="required">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6">
                <label for="ltn_norm_p_min" class="form-label">OD - dla kobiet w ciąży:</label>
                <input type="number" step="1" id="ltn_norm_p_min" name="ltn_norm_p_min" class="form-control" placeholder="dla kobiet w ciąży" required="required">
              </div>
              <div class="col-6">
                <label for="ltn_norm_p_max" class="form-label">DO - dla kobiet w ciąży:</label>
                <input type="number" step="1" id="ltn_norm_p_max" name="ltn_norm_p_max" class="form-control" placeholder="dla kobiet w ciąży" required="required">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">
                <label for="ltn_unit" class="form-label">Jednostka:</label>
                <input type="text" id="ltn_unit" name="ltn_unit" class="form-control" placeholder="Nazwa" required="required">
              </div>
              <div class="col-6">
                <label for="ltn_unit_en" class="form-label">Jednostka EN:</label>
                <input type="text" id="ltn_unit_en" name="ltn_unit_en" class="form-control" placeholder="Nazwa" required="required">
              </div>
            </div>
            <div class="mb-3 text-center">
              <button type="button" class="btn btn-success btn-submit btn-ltn">Potwierdź</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">zamknij</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  function showLTGmodal(idvalue) 
  {
    $.ajax({
            type:'GET',
            url:"{{ route('laboratorynorms.getajax') }}",
            data:{idvalue:idvalue,table:'ltg'},
            success:function(data){
                if($.isEmptyObject(data.error)){
                  // alert(JSON.stringify(data, null, 4));
                  $('#LTGModalTitle').html('edycja nazwy grupy badań');
                  $('#id').val(data.ltg_data.id);
                  $('#ltg_name').val(data.ltg_data.ltg_name);
                  $('#ltg_name_en').val(data.ltg_data.ltg_name_en);
                  $('#ltg_levels_count').val(data.ltg_data.ltg_levels_count);
                  $('#ltg_sort').val(data.ltg_data.ltg_sort);
                  }else{
                    printErrorMsg(data.error);
                  }
                }
            });
    $('#LTGModal').modal('show');
  }
function showLTmodal(idvalue,idLTG) 
  {
    $.ajax({
            type:'GET',
            url:"{{ route('laboratorynorms.getajax') }}",
            data:{idvalue:idvalue,table:'lt',idLTG:idLTG},
            success:function(data){
                if($.isEmptyObject(data.error)){
                  // alert(JSON.stringify(data, null, 4));
                  $('#LTModalTitle').html('Grupa badania: '+data.lt_data.ltg_name);
                  $('#id').val(data.lt_data.id);
                  $('#laboratory_test_group_id').val(idLTG);
                  $('#lt_name').val(data.lt_data.lt_name);
                  $('#lt_name_en').val(data.lt_data.lt_name_en);
                  $('#lt_short').val(data.lt_data.lt_short);
                  $('#lt_short_en').val(data.lt_data.lt_short_en);
                  $('#lt_level').val(data.lt_data.lt_level);
                  $('#lt_sort').val(data.lt_data.lt_sort);
                  $('#lt_time').val(data.lt_data.lt_time);
                  $('#lt_coast').val(data.lt_data.lt_coast);
                  $('#lt_time_cito').val(data.lt_data.lt_time_cito);
                  $('#lt_coast_cito').val(data.lt_data.lt_coast_cito);
                  }else{
                    printErrorMsg(data.error);
                  }
                }
            });
    $('#LTModal').modal('show');
  }

  function showLTNmodal(idvalue,idLT) 
  {
    $.ajax({
            type:'GET',
            url:"{{ route('laboratorynorms.getajax') }}",
            data:{idvalue:idvalue,table:'ltn',idLT:idLT},
            success:function(data){
                if($.isEmptyObject(data.error)){
                  // alert(JSON.stringify(data, null, 4));
                  $('#LTNModalTitle').html('Norma dla badania: '+data.ltn_data.lt_name);
                  $('#id').val(data.ltn_data.id);
                  $('#laboratory_test_id').val(idLT);
                  $('#ltn_days_from').val(data.ltn_data.ltn_days_from);
                  $('#ltn_days_to').val(data.ltn_data.ltn_days_to);

                  $('#ltn_norm_type').val(data.ltn_data.ltn_norm_type);
                  $('#ltn_decimal_prec').val(data.ltn_data.ltn_decimal_prec);

                  $('#ltn_norm_m_min').val(data.ltn_data.ltn_norm_m_min);
                  $('#ltn_norm_m_max').val(data.ltn_data.ltn_norm_m_max);
                  $('#ltn_norm_w_min').val(data.ltn_data.ltn_norm_w_min);
                  $('#ltn_norm_w_max').val(data.ltn_data.ltn_norm_w_max);
                  $('#ltn_norm_p_min').val(data.ltn_data.ltn_norm_p_min);
                  $('#ltn_norm_p_max').val(data.ltn_data.ltn_norm_p_max);
                  
                  $('#ltn_unit').val(data.ltn_data.ltn_unit);
                  $('#ltn_unit_en').val(data.ltn_data.ltn_unit_en);
                  }else{
                    printErrorMsg(data.error);
                  }
                }
            });
    $('#LTNModal').modal('show');
  }
</script>


<script type="text/javascript">
      
    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  
    $(".btn-ltg").click(function(e){    
        e.preventDefault();
        $('#LTGModalTitle').html('zapisywanie nazwy grupy badań');
        $.ajax({
           type:'POST',
           url:"{{ route('laboratorynorms.updateajax') }}",
           data:{
                  table: 'ltg',
                  id: $('#id').val(),
                  ltg_name: $('#ltg_name').val(),
                  ltg_name_en: $('#ltg_name_en').val(),
                  ltg_levels_count: $('#ltg_levels_count').val(),
                  ltg_sort: $('#ltg_sort').val()
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
  

    $(".btn-lt").click(function(e){
        e.preventDefault();
        $('#LTModalTitle').html('zapisywanie nazwy badania');
        $.ajax({
          type:'POST',
          url:"{{ route('laboratorynorms.updateajax') }}",
          data:{
                table: 'lt',
                id: $('#id').val(),
                laboratory_test_group_id: $('#laboratory_test_group_id').val(),
                lt_name: $('#lt_name').val(),
                lt_name_en: $('#lt_name_en').val(),
                lt_short: $('#lt_short').val(),
                lt_short_en: $('#lt_short_en').val(),
                lt_level: $('#lt_level').val(),
                lt_sort: $('#lt_sort').val(),
                lt_time: $('#lt_time').val(),
                lt_coast: $('#lt_coast').val(),
                lt_time_cito: $('#lt_time_cito').val(),
                lt_coast_cito: $('#lt_coast_cito').val()                  
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

    $(".btn-ltn").click(function(e){
        e.preventDefault();
        $('#LTNModalTitle').html('zapisywanie normy');
        $.ajax({
          type:'POST',
          url:"{{ route('laboratorynorms.updateajax') }}",
          data:{
                table: 'ltn',
                id: $('#id').val(),
                laboratory_test_id: $('#laboratory_test_id').val(),
                ltn_days_from: $('#ltn_days_from').val(),
                ltn_days_to: $('#ltn_days_to').val(),
                ltn_norm_type: $('#ltn_norm_type').val(),
                ltn_decimal_prec: $('#ltn_decimal_prec').val(),
                ltn_norm_m_min: $('#ltn_norm_m_min').val(),
                ltn_norm_m_max: $('#ltn_norm_m_max').val(),
                ltn_norm_w_min: $('#ltn_norm_w_min').val(),
                ltn_norm_w_max: $('#ltn_norm_w_max').val(),
                ltn_norm_p_min: $('#ltn_norm_p_min').val(),
                ltn_norm_p_max: $('#ltn_norm_p_max').val(),
                ltn_unit: $('#ltn_unit').val(),
                ltn_unit_en: $('#ltn_unit_en').val()
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

