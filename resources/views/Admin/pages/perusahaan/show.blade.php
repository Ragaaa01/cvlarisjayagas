@extends('admin.layouts.base') 

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Detail Data Perusahaan</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $perusahaan->id_perusahaan }}</p>
            <p><strong>Nama Perusahaan:</strong> {{ $perusahaan->nama_perusahaan }}</p>
            <p><strong>Alamat:</strong> {{ $perusahaan->alamat_perusahaan }}</p>
            <p><strong>Email:</strong> {{ $perusahaan->email_perusahaan }}</p>
        </div>
    </div>

    <a href="{{ route('data_perusahaan') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
