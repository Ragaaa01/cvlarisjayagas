<div class="form-group">
    <label for="nama_jenis_transaksi">Nama Jenis Transaksi</label>
    <input type="text" name="nama_jenis_transaksi" id="nama_jenis_transaksi"
        class="form-control @error('nama_jenis_transaksi') is-invalid @enderror"
        value="{{ old('nama_jenis_transaksi', $jenisTransaksi->nama_jenis_transaksi ?? '') }}" required>
    @error('nama_jenis_transaksi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
