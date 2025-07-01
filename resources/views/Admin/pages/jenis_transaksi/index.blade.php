@extends('admin.layouts.base')

@section('title', 'Data Jenis Transaksi')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Data Jenis Transaksi</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('jenis_transaksi.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Jenis Transaksi
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Jenis Transaksi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenisTransaksis as $jenisTransaksi)
                        <tr>
                            <td>{{ $jenisTransaksi->id_jenis_transaksi }}</td>
                            <td>{{ $jenisTransaksi->nama_jenis_transaksi }}</td>
                            <td class="text-center">
                                <a href="{{ route('jenis_transaksi.show', $jenisTransaksi->id_jenis_transaksi) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('jenis_transaksi.edit', $jenisTransaksi->id_jenis_transaksi) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jenis_transaksi.destroy', $jenisTransaksi->id_jenis_transaksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $jenisTransaksis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
