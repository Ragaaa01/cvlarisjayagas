@extends('admin.layouts.base')
@section('title', 'Tambah Jenis Tabung')

@section('content')
<div class="container mt-4">
    <h2>Tambah Jenis Tabung</h2>

    <form action="{{ route('jenis_tabung.store') }}" method="POST">
        @csrf
        @include('admin.pages.jenis_tabung.form')
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('data_jenis_tabung') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
