@extends('admin.layouts.base')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Detail Riwayat Transaksi #{{ $riwayatTransaksi->id_transaksi }}</h6>
                    <a href="{{ route('admin.riwayat_transaksi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary">Informasi Transaksi</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>ID Transaksi</th>
                                    <td>{{ $riwayatTransaksi->id_transaksi }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Perorangan</th>
                                    <td>{{ $riwayatTransaksi->perorangan ? $riwayatTransaksi->perorangan->nama_lengkap : ($riwayatTransaksi->akun && $riwayatTransaksi->akun->perorangan ? $riwayatTransaksi->akun->perorangan->nama_lengkap : '-') }}</td>
                                </tr>
                                <tr>
                                    <th>Perusahaan</th>
                                    <td>{{ $riwayatTransaksi->perusahaan ? $riwayatTransaksi->perusahaan->nama_perusahaan : ($riwayatTransaksi->perorangan && $riwayatTransaksi->perorangan->perusahaan ? $riwayatTransaksi->perorangan->perusahaan->nama_perusahaan : '-') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <td>{{ \Carbon\Carbon::parse($riwayatTransaksi->tanggal_transaksi)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Transaksi</th>
                                    <td>Rp {{ number_format($riwayatTransaksi->total_transaksi, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Pembayaran</th>
                                    <td>Rp {{ number_format($riwayatTransaksi->total_pembayaran, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Denda</th>
                                    <td>Rp {{ number_format($riwayatTransaksi->denda, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ ucfirst($riwayatTransaksi->metode_pembayaran ?? '-') }}</td>
                                </tr>
                                <tr>
                                    <th>Status Akhir</th>
                                    <td>
                                        <span class="badge badge-sm {{ $riwayatTransaksi->status_akhir == 'success' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                            {{ ucfirst($riwayatTransaksi->status_akhir) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <td>{{ $riwayatTransaksi->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($riwayatTransaksi->tanggal_jatuh_tempo)->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>{{ $riwayatTransaksi->tanggal_selesai ? \Carbon\Carbon::parse($riwayatTransaksi->tanggal_selesai)->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Durasi Peminjaman</th>
                                    <td>{{ $riwayatTransaksi->durasi_peminjaman ? $riwayatTransaksi->durasi_peminjaman . ' hari' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>
                                        @php
                                            $tagihan = $riwayatTransaksi->transaksi ? $riwayatTransaksi->transaksi->tagihan : null;
                                            $riwayat_pembayaran = $tagihan && $tagihan->keterangan ? json_decode($tagihan->keterangan, true) : [];
                                            $hasRiwayat = is_array($riwayat_pembayaran) && !empty($riwayat_pembayaran);
                                        @endphp
                                        @if($hasRiwayat)
                                            Lihat riwayat pembayaran di bawah
                                        @else
                                            {{ $riwayatTransaksi->keterangan ?? '-' }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h5 class="text-primary mt-4">Detail Transaksi</h5>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Tabung</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Tabung</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Transaksi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Batas Waktu Peminjaman</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status Peminjaman</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayatTransaksi->transaksi->detailTransaksis as $detail)
                                    <tr>
                                        <td>{{ $detail->tabung ? $detail->tabung->kode_tabung : '-' }}</td>
                                        <td>{{ $detail->tabung && $detail->tabung->jenisTabung ? $detail->tabung->jenisTabung->nama_jenis : '-' }}</td>
                                        <td>{{ $detail->jenisTransaksi ? $detail->jenisTransaksi->nama_jenis_transaksi : '-' }}</td>
                                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                        <td>{{ $detail->batas_waktu_peminjaman ? \Carbon\Carbon::parse($detail->batas_waktu_peminjaman)->translatedFormat('d F Y') : '-' }}</td>
                                        <td>
                                            {{ $detail->peminjaman ? ucfirst($detail->peminjaman->status_pinjam) : '-' }}
                                            @if ($detail->peminjaman && $detail->peminjaman->pengembalian)
                                                (Kembali: {{ \Carbon\Carbon::parse($detail->peminjaman->pengembalian->tanggal_kembali)->translatedFormat('d F Y') }})
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Tidak ada detail transaksi.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h5 class="text-primary mt-4">Riwayat Pembayaran Tagihan</h5>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembayaran</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Bayar</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Metode Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tagihan = $riwayatTransaksi->transaksi ? $riwayatTransaksi->transaksi->tagihan : null;
                                    $riwayat_pembayaran = $tagihan && $tagihan->keterangan ? json_decode($tagihan->keterangan, true) : [];
                                    $riwayat_pembayaran = is_array($riwayat_pembayaran) ? $riwayat_pembayaran : [];
                                @endphp
                                @forelse ($riwayat_pembayaran as $pembayaran)
                                    <tr>
                                        <td class="text-sm">{{ $loop->iteration }}</td>
                                        <td class="text-sm">{{ \Carbon\Carbon::parse($pembayaran['tanggal_pembayaran'])->translatedFormat('d F Y') }}</td>
                                        <td class="text-sm">Rp {{ number_format($pembayaran['jumlah_bayar'], 0, ',', '.') }}</td>
                                        <td class="text-sm">{{ ucfirst($pembayaran['metode_pembayaran']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Belum ada riwayat pembayaran.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h5 class="text-primary mt-4">Tagihan Terkait</h5>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Tagihan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Dibayar</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sisa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Bayar</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($riwayatTransaksi->transaksi && $riwayatTransaksi->transaksi->tagihan)
                                    <tr>
                                        <td class="text-sm">{{ $riwayatTransaksi->transaksi->tagihan->id_tagihan }}</td>
                                        <td class="text-sm">Rp {{ number_format($riwayatTransaksi->transaksi->tagihan->jumlah_dibayar, 0, ',', '.') }}</td>
                                        <td class="text-sm">Rp {{ number_format($riwayatTransaksi->transaksi->tagihan->sisa, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-sm {{ $riwayatTransaksi->transaksi->tagihan->status == 'lunas' ? 'bg-gradient-success' : 'bg-gradient-warning' }}">
                                                {{ ucfirst($riwayatTransaksi->transaksi->tagihan->status) }}
                                            </span>
                                        </td>
                                        <td class="text-sm">{{ $riwayatTransaksi->transaksi->tagihan->tanggal_bayar_tagihan ? \Carbon\Carbon::parse($riwayatTransaksi->transaksi->tagihan->tanggal_bayar_tagihan)->translatedFormat('d F Y') : '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.tagihan.show', $riwayatTransaksi->transaksi->tagihan->id_tagihan) }}"
                                               class="btn btn-sm btn-link text-dark px-3 mb-0">
                                                <i class="fas fa-eye text-dark me-2" aria-hidden="true"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Tidak ada tagihan terkait.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
    .table-borderless th, .table-borderless td {
        border: none;
    }
    .bg-gradient-success {
        background-color: #28a745 !important;
    }
    .bg-gradient-warning {
        background-color: #ffc107 !important;
    }
    .bg-gradient-secondary {
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