@extends('admin.layouts.base')
@section('content')
<div class="container">
    <h3>Detail Tabung</h3>
    <p><strong>Kode Tabung:</strong> {{ $tabung->kode_tabung }}</p>
    <p><strong>Jenis Tabung:</strong> {{ $tabung->jenisTabung->nama_jenis }}</p>
    <p><strong>Status Tabung:</strong> {{ $tabung->statusTabung->status_tabung }}</p>
    <a href="{{ route('data_tabung') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection