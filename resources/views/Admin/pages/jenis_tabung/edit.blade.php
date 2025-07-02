@extends('admin.layouts.base')
@section('title', 'Edit Jenis Tabung')

@section('content')
<div class="container mt-4">
    <h2>Edit Jenis Tabung</h2>

    <form action="{{ route('jenis_tabung.update', $jenis->id_jenis_tabung) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.jenis_tabung.form', ['jenis' => $jenis])
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('data_jenis_tabung') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
