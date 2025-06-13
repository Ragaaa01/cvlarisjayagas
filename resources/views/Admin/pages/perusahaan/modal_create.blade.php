<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('perusahaan.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Perusahaan</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          @include('admin.pages.perusahaan.form')
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
