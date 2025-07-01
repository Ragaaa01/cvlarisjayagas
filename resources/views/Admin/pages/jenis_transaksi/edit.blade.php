@extends('admin.layouts.base')

@section('title', 'Edit Jenis Transaksi')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Edit Jenis Transaksi</h1>
    <form action="{{ route('jenis_transaksi.update', $jenisTransaksi->id_jenis_transaksi) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.jenis_transaksi.form')
        <a href="{{ route('jenis_transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-warning">Update</button>
    </form>
</div>
@endsection
