<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="formEdit">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditLabel">Edit Perusahaan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_nama" class="form-label">Nama Perusahaan</label>
            <input type="text" class="form-control" id="edit_nama" name="nama_perusahaan" required>
          </div>
          <div class="mb-3">
            <label for="edit_alamat" class="form-label">Alamat Perusahaan</label>
            <input type="text" class="form-control" id="edit_alamat" name="alamat_perusahaan" required>
          </div>
          <div class="mb-3">
            <label for="edit_email" class="form-label">Email Perusahaan</label>
            <input type="email" class="form-control" id="edit_email" name="email_perusahaan" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
