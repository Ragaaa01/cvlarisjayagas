<div class="modal fade" id="editModal-{{ $status->id_status_tabung }}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{ route('status_tabung.update', $status->id_status_tabung) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Status Tabung</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          @include('admin.pages.status_tabung.form', ['current' => $status->status_tabung])
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
