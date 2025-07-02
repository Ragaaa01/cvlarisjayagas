@extends('admin.layouts.base')

@section('title', 'Detail Status Transaksi')

@section('content')
<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h3>Detail Status Transaksi</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label>Status:</label>
        <p>{{ ucfirst($statusTransaksi->status) }}</p>
      </div>
      <a href="{{ route('admin.status_transaksi.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
</div>
@endsection
