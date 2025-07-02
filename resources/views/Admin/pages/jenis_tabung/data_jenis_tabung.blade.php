@extends('admin.layouts.base')
@section('title', 'Data Jenis Tabung')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Jenis Tabung</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('jenis_tabung.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
        <!-- Tombol Export -->
        <a href="#" class="btn btn-success">
            <i class="fas fa-file-export"></i> Export Data
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="bg-dark text-white">
            <tr>
                <th>ID</th>
                <th>Kode Jenis</th>
                <th>Nama Jenis</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenis_tabung as $jenis)
                <tr>
                    <td>{{ $jenis->id_jenis_tabung }}</td>
                    <td>{{ $jenis->kode_jenis }}</td>
                    <td>{{ $jenis->nama_jenis }}</td>
                    <td>Rp{{ number_format($jenis->harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('jenis_tabung.show', $jenis->id_jenis_tabung) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('jenis_tabung.edit', $jenis->id_jenis_tabung) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('jenis_tabung.destroy', $jenis->id_jenis_tabung) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
