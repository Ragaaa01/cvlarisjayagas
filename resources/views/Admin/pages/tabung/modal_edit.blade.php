<!-- Modal -->
<div class="modal fade" id="editTabungModal{{ $tabung->id_tabung }}" tabindex="-1" role="dialog" aria-labelledby="editTabungModalLabel{{ $tabung->id_tabung }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('tabung.update', $tabung->id_tabung) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editTabungModalLabel{{ $tabung->id_tabung }}">Edit Tabung</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @include('admin.pages.tabung.form', ['tabung' => $tabung])
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
