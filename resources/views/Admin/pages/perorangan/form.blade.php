<div class="mb-3">
    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap" class="form-control" required>
</div>
<div class="mb-3">
    <label>NIK</label>
    <input type="text" name="nik" class="form-control" required>
</div>
<div class="mb-3">
    <label>No Telepon</label>
    <input type="text" name="no_telepon" class="form-control" required>
</div>
<div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control" required></textarea>
</div>
<div class="mb-3">
    <label>Perusahaan</label>
    <select name="id_perusahaan" class="form-control select2">
        <option value="">-- Pilih Perusahaan --</option>
        @foreach($perusahaans as $p)
            <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
        @endforeach
    </select>
</div>
