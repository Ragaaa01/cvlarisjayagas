@extends('admin.layouts.base')

@section('title', 'Data Status Transaksi')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Manajemen Status Transaksi</h1>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Alert error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tombol tambah --}}
    <a href="{{ route('admin.status_transaksi.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Status Transaksi
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statusTransaksis as $statusTransaksi)
                        <tr>
                            <td>{{ $statusTransaksi->id_status_transaksi }}</td>
                            <td>{{ ucfirst($statusTransaksi->status) }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.status_transaksi.show', $statusTransaksi) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.status_transaksi.edit', $statusTransaksi) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.status_transaksi.destroy', $statusTransaksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
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

            <div class="d-flex justify-content-center">
                {{ $statusTransaksis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
