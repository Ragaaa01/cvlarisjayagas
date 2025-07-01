@extends('admin.layouts.base')

@section('title', 'Tambah Data Perorangan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tambah Data Perorangan</h2>

    {{-- Tampilkan notifikasi validasi --}}
    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('perorangan.store') }}">
        @csrf
        @include('admin.pages.perorangan.form')
        <button class="btn btn-primary mt-2">Simpan</button>
        <a href="{{ route('data_perorangan') }}" class="btn btn-secondary mt-2">Batal</a>
    </form>
</div>
@endsection
