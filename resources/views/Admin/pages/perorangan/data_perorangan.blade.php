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
                    <th scope="col">Nomor</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">NIK</th>
                    <th scope="col">No Telepon</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Perusahaan</th>
                    <th class="text-center" scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($perorangans as $d)
                    <tr>
                        <td>{{ $perorangans->firstItem() + $loop->index }}</td>
                        <td>{{ $d->nama_lengkap }}</td>
                        <td>{{ $d->nik }}</td>
                        <td>{{ $d->no_telepon }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td>{{ $d->perusahaan->nama_perusahaan ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <a href="{{ route('perorangan.show', $d->id_perorangan) }}" class="btn btn-sm btn-info mr-1" title="Lihat Detail">
                                    <i class="fas fa-eye action-icon"></i>
                                </a>
                                <a href="{{ route('perorangan.edit', $d->id_perorangan) }}" class="btn btn-sm btn-warning mr-1" title="Edit Data">
                                    <i class="fas fa-edit action-icon"></i>
                                </a>
                                <form method="POST" action="{{ route('perorangan.destroy', $d->id_perorangan) }}" onsubmit="return confirm('Yakin ingin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus Data">
                                        <i class="fas fa-trash-alt action-icon"></i>
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

    <!-- Paginasi -->
    <div class="d-flex flex-column align-items-center mt-3">
        <div>
            {{ $perorangans->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Tambahkan CDN jQuery, Bootstrap 4 JS, SweetAlert2, dan Font Awesome -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Notifikasi SweetAlert2 untuk session success/warning/error
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @elseif (session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: '{{ session('warning') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @elseif ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $errors->first() }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});
</script>

<style>
    /* Styling tambahan untuk tabel dan paginasi */
    .table th, .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .thead-dark {
        background-color: #343a40;
        color: white;
    }
    .pagination {
        margin-bottom: 0;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }
    .pagination .page-link {
        color: #007bff;
    }
    .pagination .page-link:hover {
        color: #0056b3;
        background-color: #e9ecef;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        width: 32px; /* Menyamakan lebar tombol */
        height: 32px; /* Menyamakan tinggi tombol */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        min-width: 1000px; /* Memastikan tabel cukup lebar untuk memicu scroll jika diperlukan */
    }
    .action-icon {
        font-size: 0.85rem; /* Ukuran ikon sedikit lebih besar untuk kejelasan */
        line-height: 1; /* Memastikan alignment vertikal seragam */
    }
</style>
@endpush