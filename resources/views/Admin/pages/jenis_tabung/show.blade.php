@extends('admin.layouts.base')
@section('title', 'Data Perorangan')

@section('content')
<div class="container">
    <h3>Detail Jenis Tabung</h3>
    <table class="table">
        <tr><th>ID</th><td>{{ $jenis->id_jenis_tabung }}</td></tr>
        <tr><th>Kode Jenis</th><td>{{ $jenis->kode_jenis }}</td></tr>
        <tr><th>Nama Jenis</th><td>{{ $jenis->nama_jenis }}</td></tr>
        <tr><th>Harga</th><td>Rp{{ number_format($jenis->harga) }}</td></tr>
    </table>
    <a href="{{ route('data_jenis_tabung') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
