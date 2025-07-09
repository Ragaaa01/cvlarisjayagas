@extends('admin.layouts.base')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Daftar Tagihan</h1>

    <!-- Tabel Tagihan Belum Lunas -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary">Tagihan Belum Lunas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-nowrap">No</th>
                            <th scope="col" class="text-nowrap">Nama Pelanggan</th>
                            <th scope="col" class="text-nowrap">Jumlah Dibayar</th>
                            <th scope="col" class="text-nowrap">Sisa Tagihan</th>
                            <th scope="col" class="text-nowrap">Status</th>
                            <th scope="col" class="text-nowrap">Tanggal Bayar</th>
                            <th scope="col" class="text-nowrap">Hari Keterlambatan</th>
                            <th scope="col" class="text-nowrap">Periode</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" class="text-nowrap sticky-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihansBelumLunas as $tagihan)
                            <tr>
                                <td class="text-nowrap">{{ (($tagihansBelumLunas->currentPage() - 1) * $tagihansBelumLunas->perPage()) + $loop->iteration }}</td>
                                <td class="text-nowrap">
                                    @if ($tagihan->transaksi->id_perusahaan)
                                        {{ $tagihan->transaksi->perusahaan->nama_perusahaan ?? 'N/A' }}
                                    @else
                                        {{ $tagihan->transaksi->perorangan->nama_lengkap ?? 'N/A' }}
                                    @endif
                                </td>
                                <td class="text-nowrap">Rp {{ number_format($tagihan->jumlah_dibayar, 2, ',', '.') }}</td>
                                <td class="text-nowrap">Rp {{ number_format($tagihan->sisa, 2, ',', '.') }}</td>
                                <td class="text-nowrap">
                                    <span class="badge badge-danger">Belum Lunas</span>
                                </td>
                                <td class="text-nowrap">
                                    @php
                                        $riwayat = $tagihan->keterangan ? json_decode($tagihan->keterangan, true) : [];
                                        $hasRiwayat = is_array($riwayat) && !empty($riwayat);
                                        $latestPaymentDate = $hasRiwayat ? end($riwayat)['tanggal_pembayaran'] : null;
                                    @endphp
                                    @if ($latestPaymentDate)
                                        {{ \Illuminate\Support\Carbon::parse($latestPaymentDate)->format('d-m-Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $tagihan->hari_keterlambatan ?? '-' }}</td>
                                <td class="text-nowrap">{{ $tagihan->periode_ke ?? '-' }}</td>
                                <td class="truncate-ket">
                                    @if($hasRiwayat)
                                        <span data-toggle="tooltip" data-placement="top" title="Lihat riwayat pembayaran di detail">
                                            Riwayat pembayaran tersedia
                                        </span>
                                    @else
                                        {{ $tagihan->keterangan ?? '-' }}
                                    @endif
                                </td>
                                <td class="text-nowrap sticky-right bg-white">
                                    <a href="{{ route('admin.tagihan.show', $tagihan->id_tagihan) }}" 
                                       class="btn btn-sm btn-primary">Lihat</a>
                                    <button class="btn btn-sm btn-success btn-pay" 
                                            data-id="{{ $tagihan->id_tagihan }}"
                                            data-sisa="{{ $tagihan->sisa }}">Bayar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Tidak ada tagihan belum lunas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination untuk Belum Lunas -->
            <div class="mt-4">
                {{ $tagihansBelumLunas->links('pagination::bootstrap-4', ['paginationName' => 'belumLunasPage']) }}
            </div>
        </div>
    </div>

    <!-- Tabel Tagihan Lunas -->
    <div class="card shadow">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary">Tagihan Lunas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-nowrap">No</th>
                            <th scope="col" class="text-nowrap">Nama Pelanggan</th>
                            <th scope="col" class="text-nowrap">Jumlah Dibayar</th>
                            <th scope="col" class="text-nowrap">Sisa Tagihan</th>
                            <th scope="col" class="text-nowrap">Status</th>
                            <th scope="col" class="text-nowrap">Tanggal Bayar</th>
                            <th scope="col" class="text-nowrap">Hari Keterlambatan</th>
                            <th scope="col" class="text-nowrap">Periode</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" class="text-nowrap sticky-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihansLunas as $tagihan)
                            <tr>
                                <td class="text-nowrap">{{ (($tagihansLunas->currentPage() - 1) * $tagihansLunas->perPage()) + $loop->iteration }}</td>
                                <td class="text-nowrap">
                                    @if ($tagihan->transaksi->id_perusahaan)
                                        {{ $tagihan->transaksi->perusahaan->nama_perusahaan ?? 'N/A' }}
                                    @else
                                        {{ $tagihan->transaksi->perorangan->nama_lengkap ?? 'N/A' }}
                                    @endif
                                </td>
                                <td class="text-nowrap">Rp {{ number_format($tagihan->jumlah_dibayar, 2, ',', '.') }}</td>
                                <td class="text-nowrap">Rp {{ number_format($tagihan->sisa, 2, ',', '.') }}</td>
                                <td class="text-nowrap">
                                    <span class="badge badge-success">Lunas</span>
                                </td>
                                <td class="text-nowrap">{{ $tagihan->tanggal_bayar_tagihan ? \Illuminate\Support\Carbon::parse($tagihan->tanggal_bayar_tagihan)->format('d-m-Y') : '-' }}</td>
                                <td class="text-nowrap">{{ $tagihan->hari_keterlambatan ?? '-' }}</td>
                                <td class="text-nowrap">{{ $tagihan->periode_ke ?? '-' }}</td>
                                <td class="truncate-ket">
                                    @php
                                        $riwayat = $tagihan->keterangan ? json_decode($tagihan->keterangan, true) : [];
                                        $hasRiwayat = is_array($riwayat) && !empty($riwayat);
                                    @endphp
                                    @if($hasRiwayat)
                                        <span data-toggle="tooltip" data-placement="top" title="Lihat riwayat pembayaran di detail">
                                            Riwayat pembayaran tersedia
                                        </span>
                                    @else
                                        {{ $tagihan->keterangan ?? '-' }}
                                    @endif
                                </td>
                                <td class="text-nowrap sticky-right bg-white">
                                    <a href="{{ route('admin.tagihan.show', $tagihan->id_tagihan) }}" 
                                       class="btn btn-sm btn-primary">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Tidak ada tagihan lunas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination untuk Lunas -->
            <div class="mt-4">
                {{ $tagihansLunas->links('pagination::bootstrap-4', ['paginationName' => 'lunasPage']) }}
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Pembayaran -->
<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payModalLabel">Pembayaran Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="payForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_tagihan" id="id_tagihan">
                    <div class="form-group">
                        <label for="sisa_tagihan" class="font-weight-bold">Sisa Tagihan</label>
                        <input type="text" id="sisa_tagihan" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_bayar_display" class="font-weight-bold">Jumlah Bayar (Rp)</label>
                        <input type="text" id="jumlah_bayar_display" class="form-control @error('jumlah_bayar') is-invalid @enderror" value="Rp 0">
                        <input type="hidden" name="jumlah_bayar" id="jumlah_bayar" value="0">
                        @error('jumlah_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="metode_pembayaran" class="font-weight-bold">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control custom-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer</option>
                        </select>
                        @error('metode_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan CDN jQuery, Bootstrap JS, dan SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi untuk memformat angka ke format Rupiah
    function formatRupiah(angka) {
        if (!angka) return 'Rp 0';
        let number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    // Fungsi untuk menghapus format Rupiah dan mengembalikan angka murni
    function unformatRupiah(rupiah) {
        return parseInt(rupiah.replace(/[^0-9]/g, '')) || 0;
    }

    $(document).ready(function() {
        // Inisialisasi tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // Event untuk tombol Bayar
        $('.btn-pay').on('click', function() {
            const idTagihan = $(this).data('id');
            const sisaTagihan = $(this).data('sisa');

            // Isi data ke dalam modal
            $('#id_tagihan').val(idTagihan);
            $('#sisa_tagihan').val(formatRupiah(sisaTagihan));
            $('#jumlah_bayar_display').val(formatRupiah(0));
            $('#jumlah_bayar').val(0);
            $('#metode_pembayaran').val('');

            // Tampilkan modal
            $('#payModal').modal('show');
        });

        // Format input jumlah_bayar
        $('#jumlah_bayar_display').on('input', function() {
            let value = unformatRupiah($(this).val());
            $(this).val(formatRupiah(value));
            $('#jumlah_bayar').val(value);
        });

        // Submit form pembayaran melalui AJAX
        $('#payForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const idTagihan = $('#id_tagihan').val();

            $.ajax({
                url: `/admin/tagihan/${idTagihan}/pay`,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#payModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message || 'Pembayaran tagihan berhasil.',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors || {};
                    let errorMessage = xhr.responseJSON.message || 'Gagal memproses pembayaran.';
                    let errorText = errorMessage;

                    if (Object.keys(errors).length > 0) {
                        errorText = Object.values(errors).flat().join('<br>');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: errorText,
                        timer: 3000,
                        showConfirmButton: true
                    });
                }
            });
        });

        // Tampilkan alert sukses atau error dari session
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
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        width: 100%;
        min-width: 1000px;
    }
    .truncate-ket {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sticky-right {
        position: sticky;
        right: 0;
        background-color: #f8f9fa;
    }
    .sticky-right.bg-white {
        background-color: #ffffff;
    }
    .btn-pay {
        margin-left: 5px;
    }
    .modal-content {
        border-radius: 0.5rem;
    }
    .modal-header {
        background-color: #007bff;
        color: white;
    }
    .custom-select {
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
</style>

<!-- Tambahkan meta tag untuk CSRF token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection