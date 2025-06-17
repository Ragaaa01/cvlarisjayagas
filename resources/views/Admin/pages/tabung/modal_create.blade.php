<!-- Modal -->
<div class="modal fade" id="createTabungModal" tabindex="-1" role="dialog" aria-labelledby="createTabungModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('tabung.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createTabungModalLabel">Tambah Tabung</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @include('admin.pages.tabung.form')
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
