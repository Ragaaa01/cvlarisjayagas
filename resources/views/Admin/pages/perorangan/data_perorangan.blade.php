@extends('admin.layouts.base')

@section('title', 'Data Perorangan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Perorangan</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    {{-- Tombol Aksi --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('perorangan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Data
        </a>

        {{-- Tombol Export (tampilan saja, belum terhubung route) --}}
        <a href="#" class="btn btn-success" title="Export Data">
            <i class="fas fa-download"></i> Export Data
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Perusahaan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($perorangans as $d)
                    <tr>
                        <td>{{ $d->id_perorangan }}</td>
                        <td>{{ $d->nama_lengkap }}</td>
                        <td>{{ $d->nik }}</td>
                        <td>{{ $d->no_telepon }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td>{{ $d->perusahaan->nama_perusahaan ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <a href="{{ route('perorangan.show', $d->id_perorangan) }}" class="btn btn-sm btn-info mr-1" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('perorangan.edit', $d->id_perorangan) }}" class="btn btn-sm btn-warning mr-1" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('perorangan.destroy', $d->id_perorangan) }}" onsubmit="return confirm('Yakin ingin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
    