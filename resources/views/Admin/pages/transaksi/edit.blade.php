@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Transaksi</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="{{ route('transaksis.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('transaksis.update', $transaksi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Pilih Akun</label>
                    <select name="id_akun" id="akun-select" class="form-control @error('id_akun') is-invalid @enderror">
                        <option value="">-- Pilih Akun --</option>
                        @foreach($akuns as $akun)
                        <option value="{{ $akun->id_akun }}" {{ old('id_akun', $transaksi->id_akun) == $akun->id_akun ? 'selected' : '' }}>{{ $akun->email }} - {{ $akun->perorangan->nama_lengkap ?? '-' }} - {{ $akun->perorangan->perusahaan->nama_perusahaan ?? '-' }}</option>
                        @endforeach
                    </select>
                    @error('id_akun')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Pilih Perorangan</label>
                    <select name="id_perorangan" id="perorangan-select" class="form-control @error('id_perorangan') is-invalid @enderror">
                        <option value="">-- Pilih Perorangan --</option>
                        @foreach($perorangans as $perorangan)
                        <option value="{{ $perorangan->id_perorangan }}" {{ old('id_perorangan', $transaksi->id_perorangan) == $perorangan->id_perorangan ? 'selected' : '' }}>{{ $perorangan->nama_lengkap }} - {{ $perorangan->nik }}</option>
                        @endforeach
                    </select>
                    @error('id_perorangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama-lengkap" class="form-control" readonly value="{{ old('nama_lengkap', $transaksi->perorangan->nama_lengkap ?? '-') }}">
                </div>
                <div class="form-group">
                    <label>Perusahaan</label>
                    <input type="text" name="perusahaan" id="perusahaan" class="form-control" readonly value="{{ old('perusahaan', $transaksi->perorangan->perusahaan->nama_perusahaan ?? '-') }}">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi) }}" required>
                        @error('tanggal_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Waktu</label>
                        <input type="time" name="waktu_transaksi" class="form-control @error('waktu_transaksi') is-invalid @enderror" value="{{ old('waktu_transaksi', $transaksi->waktu_transaksi) }}" required>
                        @error('waktu_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Total (Rp)</label>
                        <input type="number" name="total_transaksi" class="form-control @error('total_transaksi') is-invalid @enderror" value="{{ old('total_transaksi', $transaksi->total_transaksi) }}" required>
                        @error('total_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Jumlah Bayar (Rp)</label>
                        <input type="number" name="jumlah_dibayar" class="form-control @error('jumlah_dibayar') is-invalid @enderror" value="{{ old('jumlah_dibayar', $transaksi->jumlah_dibayar) }}" required>
                        @error('jumlah_dibayar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="tunai" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                        @error('metode_pembayaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Status</label>
                        <select name="id_status_transaksi" class="form-control @error('id_status_transaksi') is-invalid @enderror" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach($statusTransaksis as $status)
                            <option value="{{ $status->id_status_transaksi }}" {{ old('id_status_transaksi', $transaksi->id_status_transaksi) == $status->id_status_transaksi ? 'selected' : '' }}>{{ $status->status }}</option>
                            @endforeach
                        </select>
                        @error('id_status_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Tanggal Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror" value="{{ old('tanggal_jatuh_tempo', $transaksi->tanggal_jatuh_tempo) }}">
                    @error('tanggal_jatuh_tempo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @endif
                </div>
                <div id="detail-transaksi">
                    <h4>Detail Transaksi</h4>
                    @foreach($transaksi->detailTransaksis as $index => $detail)
                    <div class="detail-item">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Tabung</label>
                                <select name="detail_transaksi[{{ $index }}][id_tabung]" class="form-control @error('detail_transaksi.' . $index . '.id_tabung') is-invalid @enderror" required>
                                    <option value="">-- Pilih Tabung --</option>
                                    @foreach($tabungs as $tabung)
                                    <option value="{{ $tabung->id_tabung }}" {{ old('detail_transaksi.' . $index . '.id_tabung', $detail->id_tabung) == $tabung->id_tabung ? 'selected' : '' }}>{{ $tabung->kode_tabung }}</option>
                                    @endforeach
                                </select>
                                @error('detail_transaksi.' . $index . '.id_tabung')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Jenis Transaksi</label>
                                <select name="detail_transaksi[{{ $index }}][id_jenis_transaksi]" class="form-control @error('detail_transaksi.' . $index . '.id_jenis_transaksi') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    @foreach($jenisTransaksis as $jenis)
                                    <option value="{{ $jenis->id_jenis_transaksi }}" {{ old('detail_transaksi.' . $index . '.id_jenis_transaksi', $detail->id_jenis_transaksi) == $jenis->id_jenis_transaksi ? 'selected' : '' }}>{{ $jenis->nama_jenis_transaksi }}</option>
                                    @endforeach
                                </select>
                                @error('detail_transaksi.' . $index . '.id_jenis_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Harga (Rp)</label>
                                <input type="number" name="detail_transaksi[{{ $index }}][harga]" class="form-control @error('detail_transaksi.' . $index . '.harga') is-invalid @enderror" value="{{ old('detail_transaksi.' . $index . '.harga', $detail->harga) }}" required>
                                @error('detail_transaksi.' . $index . '.harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label>Batas Waktu Peminjaman</label>
                                <input type="date" name="detail_transaksi[{{ $index }}][batas_waktu_peminjaman]" class="form-control @error('detail_transaksi.' . $index . '.batas_waktu_peminjaman') is-invalid @enderror" value="{{ old('detail_transaksi.' . $index . '.batas_waktu_peminjaman', $detail->batas_waktu_peminjaman) }}">
                                @error('detail_transaksi.' . $index . '.batas_waktu_peminjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger mt-2" onclick="this.parentElement.remove()">Hapus</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-success mb-3" onclick="addDetail()">Tambah Detail</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan CDN Select2 dan jQuery -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let detailCount = {{ count($transaksi->detailTransaksis) }};

    function addDetail() {
        const detailDiv = document.createElement('div');
        detailDiv.className = 'detail-item mt-3';
        detailDiv.innerHTML = `
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Tabung</label>
                    <select name="detail_transaksi[${detailCount}][id_tabung]" class="form-control" required>
                        <option value="">-- Pilih Tabung --</option>
                        @foreach($tabungs as $tabung)
                        <option value="{{ $tabung->id_tabung }}">{{ $tabung->kode_tabung }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Jenis Transaksi</label>
                    <select name="detail_transaksi[${detailCount}][id_jenis_transaksi]" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($jenisTransaksis as $jenis)
                        <option value="{{ $jenis->id_jenis_transaksi }}">{{ $jenis->nama_jenis_transaksi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Harga (Rp)</label>
                    <input type="number" name="detail_transaksi[${detailCount}][harga]" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Batas Waktu Peminjaman</label>
                    <input type="date" name="detail_transaksi[${detailCount}][batas_waktu_peminjaman]" class="form-control">
                </div>
            </div>
            <button type="button" class="btn btn-danger mt-2" onclick="this.parentElement.remove()">Hapus</button>
        `;
        document.getElementById('detail-transaksi').appendChild(detailDiv);
        detailCount++;
        $(detailDiv).find('select').select2();
    }

    function handleSelection(selectedType) {
        const akunSelect = $('#akun-select');
        const peroranganSelect = $('#perorangan-select');
        const namaLengkapInput = $('#nama-lengkap');
        const perusahaanInput = $('#perusahaan');

        if (selectedType === 'akun' && akunSelect.val()) {
            peroranganSelect.prop('disabled', true).val(null).trigger('change');
            const selectedAkun = @json($akuns->keyBy('id_akun'));
            const perorangan = selectedAkun[akunSelect.val()]?.perorangan;
            namaLengkapInput.val(perorangan?.nama_lengkap ?? '-');
            perusahaanInput.val(perorangan?.perusahaan?.nama_perusahaan ?? '-');
        } else if (selectedType === 'perorangan' && peroranganSelect.val()) {
            akunSelect.prop('disabled', true).val(null).trigger('change');
            const selectedPerorangan = @json($perorangans->keyBy('id_perorangan'));
            namaLengkapInput.val(selectedPerorangan[peroranganSelect.val()]?.nama_lengkap ?? '-');
            perusahaanInput.val('');
        } else if (!akunSelect.val() && !peroranganSelect.val()) {
            akunSelect.prop('disabled', false);
            peroranganSelect.prop('disabled', false);
            namaLengkapInput.val('');
            perusahaanInput.val('');
        }
    }

    $(document).ready(function() {
        $('#akun-select').select2({
            placeholder: "-- Pilih Akun --",
            allowClear: true
        }).on('change', function() {
            if ($(this).val()) {
                $('#perorangan-select').prop('disabled', true).val(null).trigger('change');
            } else {
                $('#perorangan-select').prop('disabled', false);
            }
            handleSelection('akun');
        });

        $('#perorangan-select').select2({
            placeholder: "-- Pilih Perorangan --",
            allowClear: true
        }).on('change', function() {
            if ($(this).val()) {
                $('#akun-select').prop('disabled', true).val(null).trigger('change');
            } else {
                $('#akun-select').prop('disabled', false);
            }
            handleSelection('perorangan');
        });

        // Set initial selection based on existing data
        const initialAkunId = '{{ $transaksi->id_akun }}';
        const initialPeroranganId = '{{ $transaksi->id_perorangan }}';
        if (initialAkunId) {
            $('#akun-select').val(initialAkunId).trigger('change');
            $('#perorangan-select').prop('disabled', true).val(null).trigger('change');
            handleSelection('akun');
        } else if (initialPeroranganId) {
            $('#perorangan-select').val(initialPeroranganId).trigger('change');
            $('#akun-select').prop('disabled', true).val(null).trigger('change');
            handleSelection('perorangan');
        }

        // Tampilkan alert sukses atau error
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

<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection