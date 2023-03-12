<div class="modal fade" id="ModalMedicalForm" tabindex="-2" aria-labelledby="ModalMedicalFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <div class="float-start">
          <h5 class="float-start modal-title" id="ModalMedicalFormTitle">Tytuł</h5>
        </div>
        <div style="margin: 0 auto">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('sceneactor.medical_form_save_ajax') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>

        <input type="hidden" id="scene_actor" name="scene_actor_id" value="{{$sceneactor->id}}">
        <input type="hidden" id="mcvc_id" name="mcvc_id" value="{{$mcvc_id}}">
        <input type="hidden" id="medical_form_type_id" name="medical_form_type_id" value="">
        <input type="hidden" id="save_action" name="save_action" value="">

        <div class="modal-body" id="medical_form">
        </div>
        <div class="row mb-3 text-center">
              <div class="col-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">anuluj</button>
              </div>
              <div class="col-4 text-end" id="for_delete">
              </div>
              <div class="col-4 text-center">
                <button type="submit" class="btn btn-success btn-submit btn-tmpl-save">Potwierdź</button>
              </div>
            </div>
      </form>
    </div>
  </div>
</div>
