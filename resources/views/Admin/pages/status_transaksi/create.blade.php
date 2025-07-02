@extends('admin.layouts.base')

@section('title', 'Tambah Status Transaksi')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Tambah Status Transaksi</h1>

    <form action="{{ route('admin.status_transaksi.store') }}" method="POST">
        @csrf
        @include('admin.pages.status_transaksi.form')

        <a href="{{ route('admin.status_transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
