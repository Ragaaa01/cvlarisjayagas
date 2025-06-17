<!-- Modal -->
<div class="modal fade" id="editModal{{ $jenis->id_jenis_tabung }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('jenis_tabung.update', $jenis->id_jenis_tabung) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jenis Tabung</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('admin.pages.jenis_tabung.form', ['jenis' => $jenis])
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
