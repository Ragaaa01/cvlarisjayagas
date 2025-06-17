{{-- modal_create --}}
<div class="modal fade" id="tambahModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('perorangan.store') }}" class="modal-content">
      @csrf
      <div class="modal-header"><h5 class="modal-title">Tambah Data</h5></div>
      <div class="modal-body">
        @include('admin.pages.perorangan.form')
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>