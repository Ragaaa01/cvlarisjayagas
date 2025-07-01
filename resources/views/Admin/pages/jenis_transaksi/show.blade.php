@extends('admin.layouts.base')

@section('title', 'Detail Jenis Transaksi')

@section('content')
<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h3>Detail Jenis Transaksi</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label>ID Jenis Transaksi:</label>
        <p>{{ $jenisTransaksi->id_jenis_transaksi }}</p>
      </div>
      <div class="form-group">
        <label>Nama Jenis Transaksi:</label>
        <p>{{ $jenisTransaksi->nama_jenis_transaksi }}</p>
      </div>
      <a href="{{ route('jenis_transaksi.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
</div>
@endsection
