@extends('admin.layouts.base')

@section('title', 'Edit Status Transaksi')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Edit Status Transaksi</h1>

    <form action="{{ route('admin.status_transaksi.update', $statusTransaksi) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.status_transaksi.form', ['statusTransaksi' => $statusTransaksi])

        <a href="{{ route('admin.status_transaksi.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-warning">Update</button>
    </form>
</div>
@endsection
