<div class="modal fade" id="ModalStartVisit" tabindex="-2" aria-labelledby="ModalStartVisitLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <div class="float-start">
          <h5 class="float-start modal-title" id="ModalStartVisitTitle">Czy chcesz zakończyć wizytę?</h5>
        </div>
        <div style="margin: 0 auto">
        </div>
      </div>
      <form action="{{ route('sceneactor.medical_form_save_ajax') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>

        <input type="hidden" id="scene_actor" name="scene_actor_id" value="{{$sceneactor->id}}">
        <input type="hidden" id="mcvc_id" name="mcvc_id" value="{{$mcvc_id}}">
        <input type="hidden" id="visit_action" name="save_action" value="end_visit">      
  
        <div class="modal-body text-center" style="font-size: 72px">
          <p><span class="text-warning h1" id="ModalStartVisitQuestion">Czy chcesz zakończyć wizytę</span><br>
          <span class="text-white font-weight-bold">{{$sceneactor->sa_name}}?</span><br>
          <span class="text-warning h1">({{$sceneactor->sa_PESEL}})</span></p>
          </p>
        </div>
        <div class="row p-3 text-center">
              <div class="col-4" id="back_button">
                  <button type="button" class="btn btn-warning" data-bs-dismiss="modal" style="font-size: 48px; width: 100%">anuluj</button>
              </div>
              <div class="col-4 text-end" id="for_delete">
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-success text-white btn-submit btn-tmpl-save" style="font-size: 48px; width: 100%">TAK</button>
              </div>
            </div>
      </form>
    </div>
  </div>
</div>
