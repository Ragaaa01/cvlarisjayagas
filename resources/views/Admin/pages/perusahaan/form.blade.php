@csrf

<div class="form-group mb-3">
    <label for="nama_perusahaan">Nama Perusahaan</label>
    <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control"
           value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="alamat_perusahaan">Alamat Perusahaan</label>
    <input type="text" name="alamat_perusahaan" id="alamat_perusahaan" class="form-control"
           value="{{ old('alamat_perusahaan', $perusahaan->alamat_perusahaan ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="email_perusahaan">Email Perusahaan</label>
    <input type="email" name="email_perusahaan" id="email_perusahaan" class="form-control"
           value="{{ old('email_perusahaan', $perusahaan->email_perusahaan ?? '') }}" required>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        {{ isset($perusahaan) ? 'Perbarui' : 'Simpan' }}
    </button>
    <a href="{{ route('data_perusahaan') }}" class="btn btn-secondary">Kembali</a>
</div>
