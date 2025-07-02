@extends('admin.layouts.base')

@section('title', 'Data Perusahaan')

@section('content')
<div class="container mt-4">
    <h2>Data Perusahaan</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Tombol Tambah dan Export --}}
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('perusahaan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Data
        </a>

        <a href="#" class="btn btn-success">
            <i class="fas fa-file-export"></i> Export Data
        </a>
    </div>

    {{-- Tabel --}}
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Perusahaan</th>
                <th>Alamat</th>
                <th>Email</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perusahaans as $index => $perusahaan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $perusahaan->nama_perusahaan }}</td>
                    <td>{{ $perusahaan->alamat_perusahaan }}</td>
                    <td>{{ $perusahaan->email_perusahaan }}</td>
                    <td class="text-center">
                        {{-- Show --}}
                        <a href="{{ route('perusahaan.show', $perusahaan->id_perusahaan) }}"
                           class="btn btn-info btn-sm mx-1 text-white" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('perusahaan.edit', $perusahaan->id_perusahaan) }}"
                           class="btn btn-warning btn-sm mx-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Delete --}}
                        <form method="POST" action="{{ route('perusahaan.destroy', $perusahaan->id_perusahaan) }}"
                              class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mx-1" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data perusahaan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
