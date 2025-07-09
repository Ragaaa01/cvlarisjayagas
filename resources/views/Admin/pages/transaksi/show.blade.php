@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Transaksi</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="{{ route('transaksis.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <div class="form-group">
                <label>ID Transaksi</label>
                <input type="text" class="form-control" value="{{ $transaksi->id_transaksi }}" readonly>
            </div>
            <div class="form-group">
                <label>Akun</label>
                <input type="text" class="form-control" value="{{ $transaksi->akun->email ?? 'Tidak ada akun' }}" readonly>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" class="form-control" value="{{ $transaksi->perorangan->nama_lengkap ?? 'Tidak ada nama' }}" readonly>
            </div>
            <div class="form-group">
                <label>Perusahaan</label>
                <input type="text" class="form-control" value="{{ $transaksi->perusahaan->nama_perusahaan ?? 'Tidak ada perusahaan' }}" readonly>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Tanggal Transaksi</label>
                    <input type="text" class="form-control" value="{{ $transaksi->tanggal_transaksi ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_transaksi)->translatedFormat('d F Y') : '-' }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Waktu</label>
                    <input type="text" class="form-control" value="{{ $transaksi->waktu_transaksi ?? '-' }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Total (Rp)</label>
                    <input type="text" class="form-control" value="{{ number_format($transaksi->total_transaksi, 0, ',', '.') }}" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Jumlah Bayar (Rp)</label>
                    <input type="text" class="form-control" value="{{ number_format($transaksi->jumlah_dibayar, 0, ',', '.') }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Metode Pembayaran</label>
                    <input type="text" class="form-control" value="{{ $transaksi->metode_pembayaran ?? '-' }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($transaksi->statusTransaksi->status ?? '-') }}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label>Tanggal Jatuh Tempo</label>
                <input type="text" class="form-control" value="{{ $transaksi->tanggal_jatuh_tempo ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_jatuh_tempo)->translatedFormat('d F Y') : '-' }}" readonly>
            </div>
            <h4>Detail Transaksi</h4>
            @forelse($transaksi->detailTransaksis as $detail)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Tabung</label>
                                <input type="text" class="form-control" value="{{ $detail->tabung->kode_tabung ?? '-' }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Jenis Transaksi</label>
                                <input type="text" class="form-control" value="{{ $detail->jenisTransaksi->nama_jenis_transaksi ?? '-' }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Harga (Rp)</label>
                                <input type="text" class="form-control" value="{{ number_format($detail->harga, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Batas Waktu Peminjaman</label>
                                <input type="text" class="form-control" value="{{ $detail->batas_waktu_peminjaman ? \Illuminate\Support\Carbon::parse($detail->batas_waktu_peminjaman)->translatedFormat('d F Y') : '-' }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Tidak ada detail transaksi.</p>
            @endforelse
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
    /* Styling tambahan untuk form dan card */
    .form-control[readonly] {
        background-color: #e9ecef;
        opacity: 1;
    }
    .card-body {
        padding: 1.5rem;
    }
    .form-group label {
        font-weight: 500;
    }
    .form-row {
        margin-bottom: 1rem;
    }
</style>
@endpush