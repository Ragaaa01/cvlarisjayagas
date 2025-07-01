@extends('admin.layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Tambah Status Tabung</h2>
    <form action="{{ route('status_tabung.store') }}" method="POST">
        @csrf
        @include('admin.pages.status_tabung.form')
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('data_status_tabung') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
