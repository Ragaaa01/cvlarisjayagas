@extends('admin.layouts.base')

@section('title', 'Data Akun')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Data Akun</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol Aksi --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- Tambah Akun --}}
        <a href="{{ route('create_akun') }}" class="btn btn-primary" title="Tambah Akun">
            <i class="fas fa-plus"></i> Tambah Akun
        </a>

        {{-- Export Data --}}
        <a href="#" class="btn btn-success" title="Export Seluruh Data Akun">
            <i class="fas fa-file-export"></i> Export Data
        </a>
    </div>

    {{-- Tabel Data Akun --}}
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Nomor</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status Aktif</th>
                <th>Perorangan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($akuns as $akun)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $akun->email }}</td>
                <td>{{ ucfirst($akun->role) }}</td>
                <td>{{ $akun->status_aktif ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td>
                    {{ $akun->perorangan ? $akun->perorangan->nama_lengkap . ' - ' . $akun->perorangan->nik : '-' }}
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('show_data_akun', $akun->id_akun) }}" class="btn btn-info btn-sm mx-1" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('edit_akun', $akun->id_akun) }}" class="btn btn-warning btn-sm mx-1" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('delete_akun', $akun->id_akun) }}" method="POST" class="d-inline mx-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus akun ini?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
