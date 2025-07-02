@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Transaksi</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="{{ route('transaksis.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Akun</th>
                            <th>Perorangan</th>
                            <th>Perusahaan</th>
                            <th>Tanggal Transaksi</th>
                            <th>Waktu</th>
                            <th>Total (Rp)</th>
                            <th>Jumlah Bayar (Rp)</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->id_transaksi }}</td>
                            <td>{{ $transaksi->akun->email ?? '-' }}</td>
                            <td>{{ $transaksi->perorangan->nama_lengkap ?? '-' }}</td>
                            <td>{{ $transaksi->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td>{{ $transaksi->tanggal_transaksi }}</td>
                            <td>{{ $transaksi->waktu_transaksi }}</td>
                            <td>{{ number_format($transaksi->total_transaksi, 0, ',', '.') }}</td>
                            <td>{{ number_format($transaksi->jumlah_dibayar, 0, ',', '.') }}</td>
                            <td>{{ $transaksi->metode_pembayaran }}</td>
                            <td>{{ $transaksi->statusTransaksi->status }}</td>
                            <td>{{ $transaksi->tanggal_jatuh_tempo }}</td>
                            <td>
                                <a href="{{ route('transaksis.show', $transaksi) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('transaksis.edit', $transaksi) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('transaksis.destroy', $transaksi) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection