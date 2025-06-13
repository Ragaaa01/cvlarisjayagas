<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" method="POST" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header"><h5 class="modal-title">Edit Data</h5></div>
        <div class="modal-body">@include('admin.pages.perorangan.form')</div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
  </div>
</div>
