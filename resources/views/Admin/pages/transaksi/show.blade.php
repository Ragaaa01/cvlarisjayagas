@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Transaksi</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="{{ route('transaksis.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <div class="form-group">
                <label>Pilih Akun</label>
                <input type="text" class="form-control" value="{{ $transaksi->akun->email ?? 'Tidak ada nama' }}" readonly>
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
                    <input type="text" class="form-control" value="{{ $transaksi->tanggal_transaksi }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Waktu</label>
                    <input type="text" class="form-control" value="{{ $transaksi->waktu_transaksi }}" readonly>
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
                    <input type="text" class="form-control" value="{{ $transaksi->metode_pembayaran }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ $transaksi->statusTransaksi->status }}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label>Tanggal Jatuh Tempo</label>
                <input type="text" class="form-control" value="{{ $transaksi->tanggal_jatuh_tempo }}" readonly>
            </div>
            <h4>Detail Transaksi</h4>
            @foreach($transaksi->detailTransaksis as $detail)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Tabung</label>
                            <input type="text" class="form-control" value="{{ $detail->tabung->kode_tabung }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Jenis Transaksi</label>
                            <input type="text" class="form-control" value="{{ $detail->jenisTransaksi->nama_jenis_transaksi }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Harga (Rp)</label>
                            <input type="text" class="form-control" value="{{ number_format($detail->harga, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Batas Waktu Peminjaman</label>
                            <input type="text" class="form-control" value="{{ $detail->batas_waktu_peminjaman }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection