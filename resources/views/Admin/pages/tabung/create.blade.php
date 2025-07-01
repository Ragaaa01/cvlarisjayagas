@extends('admin.layouts.base')

@section('content')
<div class="container">
    <h3>Tambah Tabung</h3>

    <form action="{{ route('tabung.store') }}" method="POST">
        @csrf
        @include('admin.pages.tabung.form')
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('data_tabung') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
