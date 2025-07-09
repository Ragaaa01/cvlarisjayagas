@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Peminjaman</h1>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">ID Peminjaman: {{ $peminjaman->id_peminjaman }}</h6>
            <div>
                @if($peminjaman->status_pinjam === 'aktif')
                    <form action="{{ route('admin.pengembalian.store', $peminjaman->id_peminjaman) }}" method="POST" style="display:inline;" class="form-pengembalian">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm mr-2">Pengembalian</button>
                    </form>
                @endif
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <h5 class="font-weight-bold">Informasi Peminjaman</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID Peminjaman</th>
                            <td>{{ $peminjaman->id_peminjaman }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pinjam</th>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                        </tr>
                        <tr>
                            <th>Status Peminjaman</th>
                            <td>
                                <span class="badge {{ $peminjaman->status_pinjam === 'aktif' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $peminjaman->status_pinjam }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="font-weight-bold">Informasi Tabung</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Kode Tabung</th>
                            <td>{{ $peminjaman->detailTransaksi->tabung->kode_tabung }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Tabung</th>
                            <td>{{ $peminjaman->detailTransaksi->tabung->jenisTabung->nama_jenis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Batas Waktu Peminjaman</th>
                            <td>{{ $peminjaman->detailTransaksi->batas_waktu_peminjaman ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="font-weight-bold">Informasi Transaksi</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID Transaksi</th>
                            <td>{{ $peminjaman->detailTransaksi->transaksi->id_transaksi }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <td>{{ $peminjaman->detailTransaksi->transaksi->tanggal_transaksi }}</td>
                        </tr>
                        <tr>
                            <th>Total Transaksi</th>
                            <td>Rp {{ number_format($peminjaman->detailTransaksi->transaksi->total_transaksi, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Dibayar</th>
                            <td>Rp {{ number_format($peminjaman->detailTransaksi->transaksi->jumlah_dibayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>{{ $peminjaman->detailTransaksi->transaksi->metode_pembayaran }}</td>
                        </tr>
                        <tr>
                            <th>Status Transaksi</th>
                            <td>
                                <span class="badge {{ $peminjaman->detailTransaksi->transaksi->statusTransaksi->status === 'success' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $peminjaman->detailTransaksi->transaksi->statusTransaksi->status }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="font-weight-bold">Informasi Pelanggan</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Pelanggan</th>
                            <td>{{ $peminjaman->detailTransaksi->transaksi->perorangan->nama_lengkap ?? ($peminjaman->detailTransaksi->transaksi->akun->perorangan->nama_lengkap ?? '-') }}</td>
                        </tr>
                        <tr>
                            <th>Perusahaan</th>
                            <td>{{ $peminjaman->detailTransaksi->transaksi->perusahaan->nama_perusahaan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $peminjaman->detailTransaksi->transaksi->akun->email ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.form-pengembalian').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah tabung sudah dikembalikan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Sudah Dikembalikan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
@endsection