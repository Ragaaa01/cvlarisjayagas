<!-- Modal Tambah Akun -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('store_akun') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="administrator">Administrator</option>
                            <option value="pelanggan">Pelanggan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status Aktif</label><br>
                        <input type="checkbox" name="status_aktif" value="1"> Aktif
                    </div>
                    <div class="mb-3">
    <label for="addIdPerorangan">Perorangan (Opsional)</label>
    <select name="id_perorangan" id="addIdPerorangan" class="form-control"></select>
</div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Akun</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Akun -->
@foreach($akuns as $akun)
<div class="modal fade" id="editModal{{ $akun->id_akun }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('update_akun', $akun->id_akun) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Akun</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $akun->email }}" required></div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="administrator" {{ $akun->role == 'administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="pelanggan" {{ $akun->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status Aktif</label><br>
                        <input type="checkbox" name="status_aktif" value="1" {{ $akun->status_aktif ? 'checked' : '' }}> Aktif
                    </div>
                    <div class="mb-3">
    <label for="editIdPerorangan{{ $akun->id_akun }}">Perorangan</label>
    <select name="id_perorangan" id="editIdPerorangan{{ $akun->id_akun }}" class="form-control">
        @if($akun->perorangan)
            <option value="{{ $akun->perorangan->id_perorangan }}" selected>
                {{ $akun->perorangan->id_perorangan }} - {{ $akun->perorangan->nama_lengkap }} - {{ $akun->perorangan->nik }}
            </option>
        @endif
    </select>
</div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
