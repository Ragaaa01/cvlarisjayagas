<div class="modal fade" id="tambahModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('perorangan.store') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header"><h5 class="modal-title">Tambah Data</h5></div>
        <div class="modal-body">@include('admin.pages.perorangan.form')</div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
</div>
