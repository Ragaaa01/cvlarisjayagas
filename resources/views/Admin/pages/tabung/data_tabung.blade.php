@extends('admin.layouts.base')

@section('title', 'Data Tabung')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Data Tabung</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3 flex-wrap align-items-center">
        {{-- Filter Dropdown --}}
        <form method="GET" action="{{ route('data_tabung') }}" class="form-inline d-flex align-items-center mb-2 mb-md-0">
            <label for="jenis" class="mr-2">Filter Jenis Tabung:</label>
            <select name="jenis" id="jenis" class="form-control mr-2" style="width: auto;">
                <option value="">Semua</option>
                @foreach($jenisTabungs as $jenis)
                    <option value="{{ $jenis->id_jenis_tabung }}" {{ request('jenis') == $jenis->id_jenis_tabung ? 'selected' : '' }}>
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-filter"></i> Tampilkan
            </button>
        </form>

        {{-- Tombol Tambah dan Export --}}
        <div>
            <a href="{{ route('tabung.create') }}" class="btn btn-primary mr-2">
                <i class="fas fa-plus"></i> Tambah Tabung
            </a>
            <a href="#" class="btn btn-success">
                <i class="fas fa-file-export"></i> Export Data
            </a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="bg-dark text-white">
            <tr>
                <th>Kode Tabung</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tabungs as $tabung)
                <tr>
                    <td>{{ $tabung->kode_tabung }}</td>
                    <td>{{ $tabung->jenisTabung->nama_jenis ?? '-' }}</td>
                    <td>{{ $tabung->statusTabung->status_tabung ?? '-' }}</td>
                    <td>
                        <a href="{{ route('tabung.show', $tabung->id_tabung) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('tabung.edit', $tabung->id_tabung) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('tabung.destroy', $tabung->id_tabung) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data tabung.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
