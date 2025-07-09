@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Peminjaman</h1>
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
                            <th scope="col">Nama Peminjam</th>
                            <th scope="col">Kode Tabung</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $peminjaman)
                            <tr>
                                <td>{{ (($peminjamans->currentPage() - 1) * $peminjamans->perPage()) + $loop->iteration }}</td>
                                <td>
                                    @if($peminjaman->detailTransaksi->transaksi->perusahaan && $peminjaman->detailTransaksi->transaksi->id_perusahaan)
                                        {{ $peminjaman->detailTransaksi->transaksi->perusahaan->nama_perusahaan }}
                                    @else
                                        {{ $peminjaman->detailTransaksi->transaksi->perorangan->nama_lengkap ?? '-' }}
                                    @endif
                                </td>
                                <td>{{ $peminjaman->detailTransaksi->tabung->kode_tabung ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                                <td>
                                    <span class="badge {{ $peminjaman->status_pinjam === 'aktif' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($peminjaman->status_pinjam) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.peminjaman.show', $peminjaman->id_peminjaman) }}" class="btn btn-primary btn-sm">Lihat</a>
                                    @if($peminjaman->status_pinjam === 'aktif')
                                        <form action="{{ route('admin.pengembalian.store', $peminjaman->id_peminjaman) }}" method="POST" style="display:inline;" class="form-pengembalian">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm btn-pengembalian">Pengembalian</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginasi -->
            <div class="d-flex justify-content-center mt-3">
                <div>
                    {{ $peminjamans->links('pagination::bootstrap-4') }}
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

    // Konfirmasi SweetAlert2 untuk pengembalian dengan input kondisi_tabung dan keterangan
    document.querySelectorAll('.form-pengembalian').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Pengembalian',
                html:
                    '<div class="swal-custom-container">' +
                    '<div class="form-group">' +
                    '<label for="kondisi_tabung" class="swal-label">Kondisi Tabung</label>' +
                    '<select id="kondisi_tabung" class="form-control custom-select">' +
                    '<option value="baik">Baik</option>' +
                    '<option value="rusak">Rusak</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="keterangan" class="swal-label">Keterangan</label>' +
                    '<textarea id="keterangan" class="form-control custom-textarea" placeholder="Masukkan keterangan (opsional)"></textarea>' +
                    '</div>' +
                    '</div>',
                iconHtml: '<i class="fas fa-question-circle text-secondary" style="font-size: 1.5rem;"></i>',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-secondary',
                buttonsStyling: false,
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                preConfirm: () => {
                    const kondisiTabung = document.getElementById('kondisi_tabung').value;
                    const keterangan = document.getElementById('keterangan').value;
                    if (!kondisiTabung) {
                        Swal.showValidationMessage('Kondisi tabung wajib diisi');
                        return false;
                    }
                    return { kondisiTabung, keterangan };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const kondisiInput = document.createElement('input');
                    kondisiInput.type = 'hidden';
                    kondisiInput.name = 'kondisi_tabung';
                    kondisiInput.value = result.value.kondisiTabung;
                    form.appendChild(kondisiInput);

                    const keteranganInput = document.createElement('input');
                    keteranganInput.type = 'hidden';
                    keteranganInput.name = 'keterangan';
                    keteranganInput.value = result.value.keterangan || ''; // Jika kosong, kirim string kosong
                    form.appendChild(keteranganInput);

                    form.submit();
                }
            });
        });
    });
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

    /* Custom styling untuk SweetAlert2 */
    .swal-custom-popup {
        width: 320px !important;
        padding: 20px;
        border-radius: 0.25rem;
        background-color: #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        text-align: center;
    }
    .swal-custom-container .form-group {
        margin-bottom: 0;
    }
    .swal-label {
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
        text-align: left;
        margin-bottom: 0.25rem;
    }
    .custom-select, .custom-textarea {
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 0.95rem;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .custom-select:focus, .custom-textarea:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .custom-textarea {
        min-height: 80px;
        resize: vertical;
    }
    .swal-custom-popup .swal2-html-container {
        margin: 0.75rem 0;
        font-size: 1.1rem;
        color: #333;
    }
</style>
@endpush