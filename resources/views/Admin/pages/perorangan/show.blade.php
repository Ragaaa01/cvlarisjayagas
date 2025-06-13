@extends('admin.layouts.base')

@section('title', 'Show Data Perorangan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Data Perorangan</h2>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <strong>ID:</strong> {{ $perorangan->id_perorangan }}
            </div>
            <div class="mb-3">
                <strong>Nama Lengkap:</strong> {{ $perorangan->nama_lengkap }}
            </div>
            <div class="mb-3">
                <strong>NIK:</strong> {{ $perorangan->nik }}
            </div>
            <div class="mb-3">
                <strong>No Telepon:</strong> {{ $perorangan->no_telepon }}
            </div>
            <div class="mb-3">
                <strong>Alamat:</strong> {{ $perorangan->alamat }}
            </div>
            <div class="mb-3">
                <strong>Perusahaan:</strong> {{ $perorangan->perusahaan->nama_perusahaan ?? '-' }}
            </div>
        </div>
    </div>

    <a href="{{ route('data_perorangan') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
