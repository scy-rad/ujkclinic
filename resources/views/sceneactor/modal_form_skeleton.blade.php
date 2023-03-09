

<script type="text/javascript">
  function showCharacterModal(idvalue)
  {
    $.ajax({
            type:'GET',
            url:"{{ route('scene.get_scene_ajax') }}",
            data:{idvalue:idvalue,what:'character'},
            success:function(data){
                if($.isEmptyObject(data.error))
                {
                  // alert(JSON.stringify(data, null, 4));
                  if (data.scene_data.sa_sex>0)
                  {
                    $('#ModalMedicalFormTitle').html('Edycja aktora: '+data.scene_data.id);
                    $('#character_id').val(data.scene_data.id);
                    $('#sa_incoming_date').val(data.scene_data.sa_incoming_date);
                    $('#sa_incoming_recalculate').val(data.scene_data.sa_incoming_recalculate);
                    $('#sa_main_book').val(data.scene_data.sa_main_book);
                    $('#sa_name').val(data.scene_data.sa_name);
                    $('#sa_birth_date').val(data.scene_data.sa_birth_date);
                    $('#sa_birth_date_start').val(data.scene_data.sa_birth_date);
                    $('#sa_PESEL').val(data.scene_data.sa_PESEL);
                    $('#sa_sex').val(data.scene_data.sa_sex);
                    $('#sa_sex_start').val(data.scene_data.sa_sex);
                    $('#sa_nn').val(data.scene_data.sa_nn);                  
                    $('#sa_role_name').val(data.scene_data.sa_role_name);
                    $('#sa_history_for_actor').val(data.scene_data.sa_history_for_actor);
                    $('#sa_simulation').val(data.scene_data.sa_simulation);
                  }
                  else
                  {
                    $('#ModalMedicalFormTitle').html('Dodawanie aktora');
                    $('#character_id').val(data.scene_data.id);
                    $('#sa_incoming_date').val(data.scene_data.sa_incoming_date);
                    $('#sa_incoming_recalculate').val(0);
                    $('#sa_main_book').val(data.scene_data.sa_main_book);
                    $('#sa_name').val(data.scene_data.sa_name);
                    $('#sa_birth_date').val(data.scene_data.sa_birth_date);
                    $('#sa_birth_date_start').val(data.scene_data.sa_birth_date);
                    $('#sa_PESEL').val(data.scene_data.sa_PESEL);
                    // $('#sa_sex').val(data.scene_data.sa_sex);
                    $('#sa_sex_start').val(data.scene_data.sa_sex);
                    $('#sa_nn').val(0);                  
                    $('#sa_role_name').val(data.scene_data.sa_role_name);
                    $('#sa_history_for_actor').val(data.scene_data.sa_history_for_actor);
                    $('#sa_simulation').val(data.scene_data.sa_simulation);
                  }
                }
                else
                {
                  printErrorMsg(data.error);
                }
              }
            });

    // $('#ModalMedicalForm').modal('show');
  }


</script>
