@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Pengembalian</h1>
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
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID Peminjaman</th>
                            <th scope="col">ID Transaksi</th>
                            <th scope="col">Kode Tabung</th>
                            <th scope="col">Tanggal Kembali</th>
                            <th scope="col">Kondisi Tabung</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $pengembalian)
                            <tr>
                                <td>{{ (($pengembalians->currentPage() - 1) * $pengembalians->perPage()) + $loop->iteration }}</td>
                                <td>{{ $pengembalian->id_peminjaman }}</td>
                                <td>{{ $pengembalian->peminjaman->detailTransaksi->transaksi->id_transaksi }}</td>
                                <td>{{ $pengembalian->peminjaman->detailTransaksi->tabung->kode_tabung }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->translatedFormat('d F Y') }}</td>
                                <td>
                                    <span class="badge {{ $pengembalian->kondisi_tabung === 'baik' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($pengembalian->kondisi_tabung) }}
                                    </span>
                                </td>
                                <td>{{ $pengembalian->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginasi -->
            <div class="d-flex flex-column align-items-center mt-3">
                <div>
                    {{ $pengembalians->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan CDN jQuery dan Bootstrap 4 JS jika belum ada di admin.layouts.base -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    .badge-danger {
        background-color: #dc3545 !important;
    }
</style>
@endsection