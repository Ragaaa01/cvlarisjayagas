@extends('admin.layouts.base')

@section('title', 'Tambah Jenis Transaksi')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Tambah Jenis Transaksi</h1>
    <form action="{{ route('jenis_transaksi.store') }}" method="POST">
        @csrf
        @include('admin.pages.jenis_transaksi.form')
        <a href="{{ route('jenis_transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
