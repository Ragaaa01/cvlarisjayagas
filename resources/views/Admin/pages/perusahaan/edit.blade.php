@extends('admin.layouts.base')

@section('title', 'Edit Perusahaan')

@section('content')
<div class="container mt-4">
    <h3>Edit Data Perusahaan</h3>

    <form method="POST" action="{{ route('perusahaan.update', $perusahaan->id_perusahaan) }}">
        @csrf
        @method('PUT')
        @include('admin.pages.perusahaan.form')
    </form>
</div>
@endsection
