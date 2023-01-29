<div class="modal fade" id="ScenePersonel" tabindex="-2" aria-labelledby="ScenePersonelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="float-start">
          <h5 class="float-start modal-title" id="ScenePersonelTitle">Dodawanie personelu</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('scene.update_scene_ajax') }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
          </div>

          <input type="hidden" name="what" value="personel">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="scene_master_id" value="{{$scene->id}}">

          <div class="row mb-3">
            <div class="col-12">
            <label for="personel_to_scene_id" class="form-label">personel:</label>
              <select id="personel_to_scene_id" name="personel_to_scene_id" class="form-select">
                @foreach ($free_personels as $personel_one)
                <option value="{{$personel_one->id}}">{{$personel_one->firstname}} {{$personel_one->lastname}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label for="scene_personel_name" class="form-label">Imię i nazwisko:</label>
              <input type="text" id="scene_personel_name" name="scene_personel_name" class="form-control" placeholder="Imię i nazwisko" value="{{ json_decode(App\Models\SceneActor::random_actor('1975-09-04',1))->name }}">
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
  function showPersonelModal(idvalue)
  {
    $('#ScenePersonel').modal('show');
  }

</script>