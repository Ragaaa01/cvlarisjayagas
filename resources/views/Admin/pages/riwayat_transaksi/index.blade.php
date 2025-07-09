@extends('admin.layouts.base')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Riwayat Transaksi</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table table-hover align-items-center mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7">ID Transaksi</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Nama Perorangan</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Total Transaksi</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Total Pembayaran</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Denda</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Metode Pembayaran</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayatTransaksis as $riwayat)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $riwayat->id_transaksi }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $riwayat->perorangan?->nama_lengkap 
                                                    ?? $riwayat->akun?->perorangan?->nama_lengkap 
                                                    ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                Rp {{ number_format($riwayat->total_transaksi, 0, ',', '.') }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                Rp {{ number_format($riwayat->total_pembayaran, 0, ',', '.') }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                Rp {{ number_format($riwayat->denda, 0, ',', '.') }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ ucfirst($riwayat->metode_pembayaran ?? '-') }}
                                            </p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $riwayat->status_akhir == 'success' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ ucfirst($riwayat->status_akhir) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.riwayat_transaksi.show', $riwayat->id_riwayat_transaksi) }}"
                                               class="btn btn-sm btn-link text-dark px-3 mb-0">
                                                <i class="fas fa-eye text-dark me-2" aria-hidden="true"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Tidak ada data riwayat transaksi.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginasi -->
                    <div class="d-flex justify-content-center mt-3">
                        <div>
                            {{ $riwayatTransaksis->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan CDN Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Style tambahan -->
<style>
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
    .badge-secondary {
        background-color: #6c757d !important;
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
        min-width: 800px;
    }
</style>
@endsection