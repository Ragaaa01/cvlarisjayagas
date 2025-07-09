@extends('admin.layouts.base')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Detail Tagihan</h1>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Informasi Tagihan</h5>
            <a href="{{ route('admin.tagihan.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="h5 font-weight-bold">Detail Tagihan</h2>
                    <p><strong>ID Tagihan:</strong> {{ $tagihan->id_tagihan }}</p>
                    <p><strong>ID Transaksi:</strong> {{ $tagihan->transaksi->id_transaksi ?? 'N/A' }}</p>
                    <p><strong>Jumlah Dibayar:</strong> Rp {{ number_format($tagihan->jumlah_dibayar, 2, ',', '.') }}</p>
                    <p><strong>Sisa Tagihan:</strong> Rp {{ number_format($tagihan->sisa, 2, ',', '.') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge {{ $tagihan->status == 'lunas' ? 'badge-success' : 'badge-danger' }}">
                            {{ $tagihan->status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                        </span>
                    </p>
                    <p><strong>Tanggal Bayar:</strong> {{ $tagihan->tanggal_bayar_tagihan ? \Illuminate\Support\Carbon::parse($tagihan->tanggal_bayar_tagihan)->format('d-m-Y') : '-' }}</p>
                    <p><strong>Hari Keterlambatan:</strong> {{ $tagihan->hari_keterlambatan ?? '-' }}</p>
                    <p><strong>Periode:</strong> {{ $tagihan->periode_ke }}</p>
                    <p><strong>Keterangan:</strong> {{ is_array(json_decode($tagihan->keterangan, true)) ? 'Lihat riwayat pembayaran di bawah' : ($tagihan->keterangan ?? '-') }}</p>
                </div>
                <div class="col-md-6">
                    <h2 class="h5 font-weight-bold">Detail Transaksi</h2>
                    <p><strong>Akun:</strong> {{ $tagihan->transaksi->akun->email ?? '-' }}</p>
                    <p><strong>Perorangan:</strong> {{ $tagihan->transaksi->perorangan->nama_lengkap ?? '-' }}</p>
                    <p><strong>Perusahaan:</strong> {{ $tagihan->transaksi->perusahaan->nama_perusahaan ?? '-' }}</p>
                    <p><strong>Tanggal Transaksi:</strong> {{ $tagihan->transaksi->tanggal_transaksi ? \Illuminate\Support\Carbon::parse($tagihan->transaksi->tanggal_transaksi)->format('d-m-Y') : '-' }}</p>
                    <p><strong>Total Transaksi:</strong> Rp {{ number_format($tagihan->transaksi->total_transaksi ?? 0, 2, ',', '.') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ $tagihan->transaksi->metode_pembayaran ?? '-' }}</p>
                    <p><strong>Tanggal Jatuh Tempo:</strong> {{ $tagihan->transaksi->tanggal_jatuh_tempo ? \Illuminate\Support\Carbon::parse($tagihan->transaksi->tanggal_jatuh_tempo)->format('d-m-Y') : '-' }}</p>
                </div>
            </div>

            <h4 class="mt-4 text-primary">Riwayat Pembayaran</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-nowrap">No</th>
                            <th scope="col" class="text-nowrap">Tanggal Pembayaran</th>
                            <th scope="col" class="text-nowrap">Jumlah Bayar</th>
                            <th scope="col" class="text-nowrap">Metode Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $riwayat_pembayaran = $tagihan->keterangan ? json_decode($tagihan->keterangan, true) : [];
                            $riwayat_pembayaran = is_array($riwayat_pembayaran) ? $riwayat_pembayaran : [];
                        @endphp
                        @forelse ($riwayat_pembayaran as $pembayaran)
                            <tr>
                                <td class="text-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ \Illuminate\Support\Carbon::parse($pembayaran['tanggal_pembayaran'])->format('d-m-Y') }}</td>
                                <td class="text-nowrap">Rp {{ number_format($pembayaran['jumlah_bayar'], 2, ',', '.') }}</td>
                                <td class="text-nowrap">{{ ucfirst($pembayaran['metode_pembayaran']) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada riwayat pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tagihan->transaksi && $tagihan->transaksi->riwayatTransaksis->isNotEmpty())
                <div class="mt-4">
                    <a href="{{ route('admin.riwayat_transaksi.show', $tagihan->transaksi->riwayatTransaksis->first()->id_riwayat_transaksi) }}" 
                       class="btn btn-secondary btn-sm">
                        <i class="fas fa-history mr-2"></i> Lihat Riwayat Transaksi
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Tambahkan CDN Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        width: 100%;
        min-width: 600px;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-danger {
        background-color: #dc3545;
    }
    .btn {
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn i {
        margin-right: 0.5rem;
    }
</style>
@endsection