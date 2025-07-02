<div class="form-group">
    <label for="kode_jenis">Kode Jenis</label>
    <input type="text" name="kode_jenis" class="form-control @error('kode_jenis') is-invalid @enderror"
        value="{{ old('kode_jenis', $jenis->kode_jenis ?? '') }}" required>
    @error('kode_jenis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="nama_jenis">Nama Jenis</label>
    <input type="text" name="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror"
        value="{{ old('nama_jenis', $jenis->nama_jenis ?? '') }}" required>
    @error('nama_jenis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="harga">Harga</label>
    <input type="text" name="harga" class="form-control format-rupiah @error('harga') is-invalid @enderror"
        value="{{ old('harga', isset($jenis) ? $jenis->harga : '') }}" required>
    @error('harga')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
