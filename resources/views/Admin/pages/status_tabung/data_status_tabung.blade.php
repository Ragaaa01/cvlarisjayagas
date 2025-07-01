@extends('admin.layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Data Status Tabung</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- Tombol Tambah di kiri --}}
        <a href="{{ route('status_tabung.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Data
        </a>

        {{-- Tombol Export di kanan --}}
        <form action="{{ url()->current() . '/export' }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">
                <i class="fas fa-file-export mr-1"></i> Export Data
            </button>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $status)
                <tr class="text-center">
                    <td>{{ $status->id_status_tabung }}</td>
                    <td>{{ ucfirst($status->status_tabung) }}</td>
                    <td>
                        <a href="{{ route('jenis_tabung.show', $status->id_status_tabung) }}" class="btn btn-sm btn-info mx-1">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('status_tabung.edit', $status->id_status_tabung) }}" class="btn btn-sm btn-warning mx-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('status_tabung.destroy', $status->id_status_tabung) }}" method="POST" class="d-inline mx-1" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
