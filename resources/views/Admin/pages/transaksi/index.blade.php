@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Transaksi</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            <!-- Notifikasi Error -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            <a href="{{ route('transaksis.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">Akun</th>
                            <th scope="col">Perorangan</th>
                            <th scope="col">Perusahaan</th>
                            <th scope="col">Tanggal Transaksi</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Total (Rp)</th>
                            <th scope="col">Jumlah Bayar (Rp)</th>
                            <th scope="col">Metode Pembayaran</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal Jatuh Tempo</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksis->firstItem() + $loop->index }}</td>
                                <td>{{ $transaksi->akun->email ?? '-' }}</td>
                                <td>{{ $transaksi->perorangan->nama_lengkap ?? '-' }}</td>
                                <td>{{ $transaksi->perusahaan->nama_perusahaan ?? '-' }}</td>
                                <td>{{ $transaksi->tanggal_transaksi ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_transaksi)->translatedFormat('d F Y') : '-' }}</td>
                                <td>{{ $transaksi->waktu_transaksi ?? '-' }}</td>
                                <td>{{ number_format($transaksi->total_transaksi, 0, ',', '.') }}</td>
                                <td>{{ number_format($transaksi->jumlah_dibayar, 0, ',', '.') }}</td>
                                <td>{{ $transaksi->metode_pembayaran ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $transaksi->statusTransaksi->status == 'success' ? 'badge-success' : ($transaksi->statusTransaksi->status == 'pending' ? 'badge-warning' : 'badge-danger') }}">
                                        {{ ucfirst($transaksi->statusTransaksi->status ?? '-') }}
                                    </span>
                                </td>
                                <td>{{ $transaksi->tanggal_jatuh_tempo ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_jatuh_tempo)->translatedFormat('d F Y') : '-' }}</td>
                                <td>
                                    <a href="{{ route('transaksis.show', $transaksi) }}" class="btn btn-primary btn-sm">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginasi -->
            <div class="d-flex flex-column align-items-center mt-3">
                <div>
                    {{ $transaksis->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Tambahkan CDN jQuery, Bootstrap 4 JS, dan SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Notifikasi SweetAlert2 untuk session success/error
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
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
    .badge-success {
        background-color: #28a745 !important;
    }
    .badge-warning {
        background-color: #ffc107 !important;
    }
    .badge-danger {
        background-color: #dc3545 !important;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        min-width: 1000px; /* Memastikan tabel cukup lebar untuk memicu scroll jika diperlukan */
    }
</style>
@endpush
