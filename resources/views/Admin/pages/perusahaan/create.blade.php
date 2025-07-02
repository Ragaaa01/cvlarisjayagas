@extends('admin.layouts.base')

@section('title', 'Tambah Perusahaan')

@section('content')
<div class="container mt-4">
    <h3>Tambah Data Perusahaan</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('perusahaan.store') }}">
        @include('admin.pages.perusahaan.form')
    </form>
</div>
@endsection
