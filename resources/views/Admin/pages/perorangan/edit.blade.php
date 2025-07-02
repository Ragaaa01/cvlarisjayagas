@extends('admin.layouts.base')

@section('title', 'Edit Perorangan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Data Perorangan</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
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

    <form method="POST" action="{{ route('perorangan.update', $perorangan->id_perorangan) }}">
        @csrf
        @method('PUT')
        @include('admin.pages.perorangan.form')
        <button class="btn btn-warning mt-2">Update</button>
        <a href="{{ route('data_perorangan') }}" class="btn btn-secondary mt-2">Batal</a>
    </form>
</div>
@endsection
