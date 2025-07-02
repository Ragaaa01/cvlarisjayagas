@extends('admin.layouts.base')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Transaksi</h1>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('transaksis.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksis.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="akun-select" class="font-weight-bold">Pilih Akun</label>
                    <select name="id_akun" id="akun-select" class="form-control @error('id_akun') is-invalid @enderror custom-select">
                        <option value="">-- Pilih Akun --</option>
                        @foreach($akuns as $akun)
                            <option value="{{ $akun->id_akun }}">{{ $akun->email }} - {{ $akun->perorangan->nama_lengkap ?? '-' }} - {{ $akun->perorangan->perusahaan->nama_perusahaan ?? '-' }}</option>
                        @endforeach
                    </select>
                    @error('id_akun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="perorangan-select" class="font-weight-bold">Pilih Perorangan</label>
                    <select name="id_perorangan" id="perorangan-select" class="form-control @error('id_perorangan') is-invalid @enderror custom-select">
                        <option value="">-- Pilih Perorangan --</option>
                        @foreach($perorangans as $perorangan)
                            <option value="{{ $perorangan->id_perorangan }}">{{ $perorangan->nama_lengkap }} - {{ $perorangan->nik }}</option>
                        @endforeach
                    </select>
                    @error('id_perorangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama-lengkap" class="font-weight-bold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama-lengkap" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="perusahaan" class="font-weight-bold">Perusahaan</label>
                    <input type="text" name="perusahaan" id="perusahaan" class="form-control" readonly>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="tanggal_transaksi_display" class="font-weight-bold">Tanggal Transaksi</label>
                        <input type="text" id="tanggal_transaksi_display" class="form-control" readonly>
                        <input type="hidden" name="tanggal_transaksi" id="tanggal_transaksi">
                        @error('tanggal_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="waktu_transaksi_display" class="font-weight-bold">Waktu</label>
                        <input type="text" id="waktu_transaksi_display" class="form-control" readonly>
                        <input type="hidden" name="waktu_transaksi" id="waktu_transaksi">
                        @error('waktu_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="total_transaksi_display" class="font-weight-bold">Total (Rp)</label>
                        <input type="text" id="total_transaksi_display" class="form-control @error('total_transaksi') is-invalid @enderror" value="Rp 0" readonly>
                        <input type="hidden" name="total_transaksi" id="total_transaksi" value="0">
                        @error('total_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="jumlah_dibayar_display" class="font-weight-bold">Jumlah Bayar (Rp)</label>
                        <input type="text" id="jumlah_dibayar_display" class="form-control @error('jumlah_dibayar') is-invalid @enderror" value="{{ old('jumlah_dibayar', 'Rp 0') }}">
                        <input type="hidden" name="jumlah_dibayar" id="jumlah_dibayar" value="{{ old('jumlah_dibayar', 0) }}">
                        @error('jumlah_dibayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="metode_pembayaran" class="font-weight-bold">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror custom-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                        @error('metode_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="status_transaksi_display" class="font-weight-bold">Status</label>
                        <input type="text" id="status_transaksi_display" class="form-control" readonly value="Pending">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tanggal_jatuh_tempo_display" class="font-weight-bold">Tanggal Jatuh Tempo</label>
                    <input type="text" id="tanggal_jatuh_tempo_display" class="form-control" readonly value="">
                </div>
                <div id="detail-transaksi" class="mt-4">
                    <h4 class="mb-3 text-primary">Detail Transaksi</h4>
                    <div class="detail-items">
                        <div class="detail-item bg-light p-3 rounded mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label for="detail_transaksi_0_id_tabung" class="font-weight-bold">Tabung</label>
                                    <select name="detail_transaksi[0][id_tabung]" id="detail_transaksi_0_id_tabung" class="form-control tabung-select @error('detail_transaksi.0.id_tabung') is-invalid @enderror custom-select" required>
                                        <option value="">-- Pilih Tabung --</option>
                                        @foreach($tabungs as $tabung)
                                            @if($tabung->statusTabung->status_tabung === 'tersedia')
                                                <option value="{{ $tabung->id_tabung }}" data-harga="{{ $tabung->jenisTabung->harga ?? 0 }}">{{ $tabung->kode_tabung }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('detail_transaksi.0.id_tabung')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label for="detail_transaksi_0_id_jenis_transaksi" class="font-weight-bold">Jenis Transaksi</label>
                                    <select name="detail_transaksi[0][id_jenis_transaksi]" id="detail_transaksi_0_id_jenis_transaksi" class="form-control jenis-transaksi-select @error('detail_transaksi.0.id_jenis_transaksi') is-invalid @enderror custom-select" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        @foreach($jenisTransaksis as $jenis)
                                            <option value="{{ $jenis->id_jenis_transaksi }}" data-nama="{{ $jenis->nama_jenis_transaksi }}">{{ $jenis->nama_jenis_transaksi }}</option>
                                        @endforeach
                                    </select>
                                    @error('detail_transaksi.0.id_jenis_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label for="detail_transaksi_0_harga" class="font-weight-bold">Harga (Rp)</label>
                                    <input type="text" class="form-control harga-tabung-display @error('detail_transaksi.0.harga') is-invalid @enderror" value="Rp 0" readonly>
                                    <input type="hidden" name="detail_transaksi[0][harga]" class="harga-tabung" value="0" required>
                                    @error('detail_transaksi.0.harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <label for="detail_transaksi_0_batas_waktu" class="font-weight-bold">Batas Waktu Peminjaman</label>
                                    <input type="text" class="form-control batas-waktu-peminjaman-display" readonly value="-">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-detail mt-4" title="Hapus Detail">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-success btn-sm" onclick="addDetail()">
                            <i class="fas fa-plus mr-2"></i> Tambah Detail
                        </button>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm mr-2 d-flex align-items-center" onclick="window.location.href='{{ route('transaksis.index') }}'">
                                <i class="fas fa-times mr-2"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                                <i class="fas fa-save mr-2"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan CDN Select2, jQuery, Font Awesome, dan SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let detailCount = 1;

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

    // Fungsi untuk memperbarui tanggal dan waktu secara real-time
    function updateDateTime() {
        const now = new Date();
        const options = { timeZone: 'Asia/Jakarta' };
        const date = now.toLocaleDateString('en-CA', options); // Format YYYY-MM-DD
        const time = now.toLocaleTimeString('en-GB', { ...options, hour: '2-digit', minute: '2-digit' }); // Format HH:mm
        $('#tanggal_transaksi_display').val(date);
        $('#waktu_transaksi_display').val(time);
        $('#tanggal_transaksi').val(date);
        $('#waktu_transaksi').val(time);
        updateTanggalJatuhTempo();
        updateAllBatasWaktuPeminjaman();
    }

    // Fungsi untuk memperbarui status transaksi dan tanggal jatuh tempo secara real-time
    function updateStatus() {
        const total = parseInt($('#total_transaksi').val()) || 0;
        const jumlahDibayar = parseInt($('#jumlah_dibayar').val()) || 0;
        const statusDisplay = $('#status_transaksi_display');
        if (jumlahDibayar >= total && total > 0) {
            statusDisplay.val('Success');
            statusDisplay.removeClass('text-warning text-danger').addClass('text-success');
        } else if (total > 0) {
            statusDisplay.val('Pending');
            statusDisplay.removeClass('text-success text-danger').addClass('text-warning');
        } else {
            statusDisplay.val('Pending');
            statusDisplay.removeClass('text-success text-danger').addClass('text-warning');
        }
        updateTanggalJatuhTempo();
    }

    // Fungsi untuk memperbarui tanggal jatuh tempo berdasarkan status
    function updateTanggalJatuhTempo() {
        const status = $('#status_transaksi_display').val();
        const tanggalTransaksi = $('#tanggal_transaksi').val();
        const tanggalJatuhTempoDisplay = $('#tanggal_jatuh_tempo_display');
        if (status === 'Pending' && tanggalTransaksi) {
            const date = new Date(tanggalTransaksi);
            date.setDate(date.getDate() + 30);
            const jatuhTempo = date.toLocaleDateString('en-CA'); // Format YYYY-MM-DD
            tanggalJatuhTempoDisplay.val(jatuhTempo);
        } else {
            tanggalJatuhTempoDisplay.val('-');
        }
    }

    // Fungsi untuk memperbarui batas waktu peminjaman berdasarkan jenis transaksi
    function updateBatasWaktuPeminjaman($select) {
        const jenisTransaksi = $select.find('option:selected').data('nama') || '';
        const $batasWaktuInput = $select.closest('.row').find('.batas-waktu-peminjaman-display');
        const tanggalTransaksi = $('#tanggal_transaksi').val();
        if (jenisTransaksi.toLowerCase().trim() === 'peminjaman' && tanggalTransaksi) {
            const date = new Date(tanggalTransaksi);
            date.setDate(date.getDate() + 30);
            const batasWaktu = date.toLocaleDateString('en-CA'); // Format YYYY-MM-DD
            $batasWaktuInput.val(batasWaktu);
        } else {
            $batasWaktuInput.val('-');
        }
    }

    // Fungsi untuk memperbarui semua batas waktu peminjaman
    function updateAllBatasWaktuPeminjaman() {
        $('.jenis-transaksi-select').each(function() {
            updateBatasWaktuPeminjaman($(this));
        });
    }

    // Simpan daftar tabung asli dari server
    const originalTabungOptions = @json($tabungs->filter(function($tabung) {
        return $tabung->statusTabung->status_tabung === 'tersedia';
    })->map(function($tabung) {
        return [
            'id' => $tabung->id_tabung,
            'text' => $tabung->kode_tabung,
            'harga' => $tabung->jenisTabung->harga ?? 0
        ];
    })->values());

    // Simpan daftar jenis transaksi asli dari server
    const originalJenisTransaksiOptions = @json($jenisTransaksis->map(function($jenis) {
        return [
            'id' => $jenis->id_jenis_transaksi,
            'text' => $jenis->nama_jenis_transaksi,
            'nama' => $jenis->nama_jenis_transaksi
        ];
    })->values());

    // Fungsi untuk memperbarui opsi tabung di semua dropdown
    function updateTabungOptions() {
        const selectedTabungs = [];
        $('.tabung-select').each(function() {
            const selectedValue = $(this).val();
            if (selectedValue && selectedValue !== '') {
                selectedTabungs.push(selectedValue);
            }
        });

        $('.tabung-select').each(function() {
            const $select = $(this);
            const currentValue = $select.val();
            $select.find('option').not(':first').remove(); // Simpan opsi "-- Pilih Tabung --"

            originalTabungOptions.forEach(function(tabung) {
                if (!selectedTabungs.includes(tabung.id.toString()) || tabung.id.toString() === currentValue) {
                    const option = new Option(tabung.text, tabung.id, false, tabung.id.toString() === currentValue);
                    option.dataset.harga = tabung.harga;
                    $select.append(option);
                }
            });

            // Perbarui Select2
            $select.trigger('change.select2');
        });
    }

    // Fungsi untuk menghitung total transaksi
    function updateTotal() {
        let total = 0;
        $('.harga-tabung').each(function() {
            total += parseInt($(this).val()) || 0;
        });
        $('#total_transaksi').val(total);
        $('#total_transaksi_display').val(formatRupiah(total));
        updateStatus(); // Perbarui status setelah total berubah
    }

    // Fungsi untuk menambahkan detail transaksi baru
    function addDetail() {
        detailCount++;
        const newDetail = `
            <div class="detail-item bg-light p-3 rounded mb-3">
                <div class="row align-items-center">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="detail_transaksi_${detailCount}_id_tabung" class="font-weight-bold">Tabung</label>
                        <select name="detail_transaksi[${detailCount}][id_tabung]" id="detail_transaksi_${detailCount}_id_tabung" class="form-control tabung-select @error('detail_transaksi.${detailCount}.id_tabung') is-invalid @enderror custom-select" required>
                            <option value="">-- Pilih Tabung --</option>
                            @foreach($tabungs as $tabung)
                                @if($tabung->statusTabung->status_tabung === 'tersedia')
                                    <option value="{{ $tabung->id_tabung }}" data-harga="{{ $tabung->jenisTabung->harga ?? 0 }}">{{ $tabung->kode_tabung }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('detail_transaksi.${detailCount}.id_tabung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="detail_transaksi_${detailCount}_id_jenis_transaksi" class="font-weight-bold">Jenis Transaksi</label>
                        <select name="detail_transaksi[${detailCount}][id_jenis_transaksi]" id="detail_transaksi_${detailCount}_id_jenis_transaksi" class="form-control jenis-transaksi-select @error('detail_transaksi.${detailCount}.id_jenis_transaksi') is-invalid @enderror custom-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach($jenisTransaksis as $jenis)
                                <option value="{{ $jenis->id_jenis_transaksi }}" data-nama="{{ $jenis->nama_jenis_transaksi }}">{{ $jenis->nama_jenis_transaksi }}</option>
                            @endforeach
                        </select>
                        @error('detail_transaksi.${detailCount}.id_jenis_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="detail_transaksi_${detailCount}_harga" class="font-weight-bold">Harga (Rp)</label>
                        <input type="text" class="form-control harga-tabung-display @error('detail_transaksi.${detailCount}.harga') is-invalid @enderror" value="Rp 0" readonly>
                        <input type="hidden" name="detail_transaksi[${detailCount}][harga]" class="harga-tabung" value="0" required>
                        @error('detail_transaksi.${detailCount}.harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <label for="detail_transaksi_${detailCount}_batas_waktu" class="font-weight-bold">Batas Waktu Peminjaman</label>
                        <input type="text" class="form-control batas-waktu-peminjaman-display" readonly value="-">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-detail mt-4" title="Hapus Detail">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        $('.detail-items').append(newDetail);

        // Inisialisasi Select2 untuk dropdown baru
        $(`#detail_transaksi_${detailCount}_id_tabung`).select2({
            placeholder: "-- Pilih Tabung --",
            allowClear: true
        }).on('change', function() {
            const harga = parseInt($(this).find('option:selected').data('harga')) || 0;
            const $hargaInput = $(this).closest('.row').find('.harga-tabung');
            const $hargaInputDisplay = $(this).closest('.row').find('.harga-tabung-display');
            $hargaInput.val(harga);
            $hargaInputDisplay.val(formatRupiah(harga));
            updateTotal();
            updateTabungOptions();
        });

        $(`#detail_transaksi_${detailCount}_id_jenis_transaksi`).select2({
            placeholder: "-- Pilih Jenis --",
            allowClear: true
        }).on('change', function() {
            updateBatasWaktuPeminjaman($(this));
        });

        // Inisialisasi event untuk tombol hapus detail baru
        $(`.remove-detail`).off('click').on('click', function() {
            $(this).closest('.detail-item').remove();
            updateTotal();
            updateTabungOptions();
        });
    }

    // Fungsi untuk menangani pemilihan akun atau perorangan
    function handleSelection(selectedType) {
        const akunSelect = $('#akun-select');
        const peroranganSelect = $('#perorangan-select');
        const namaLengkapInput = $('#nama-lengkap');
        const perusahaanInput = $('#perusahaan');

        const akunData = @json($akuns->keyBy('id_akun'));
        const peroranganData = @json($perorangans->keyBy('id_perorangan'));

        if (selectedType === 'akun' && akunSelect.val()) {
            peroranganSelect.prop('disabled', true).val(null).trigger('change');
            const perorangan = akunData[akunSelect.val()]?.perorangan;
            namaLengkapInput.val(perorangan?.nama_lengkap ?? '-');
            perusahaanInput.val(perorangan?.perusahaan?.nama_perusahaan ?? '-');
        } else if (selectedType === 'perorangan' && peroranganSelect.val()) {
            akunSelect.prop('disabled', true).val(null).trigger('change');
            const perorangan = peroranganData[peroranganSelect.val()];
            namaLengkapInput.val(perorangan?.nama_lengkap ?? '-');
            perusahaanInput.val(perorangan?.perusahaan?.nama_perusahaan ?? '-');
        } else {
            akunSelect.prop('disabled', false);
            peroranganSelect.prop('disabled', false);
            namaLengkapInput.val('');
            perusahaanInput.val('');
        }
    }

    $(document).ready(function() {
        // Inisialisasi Select2 untuk akun dan perorangan
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

        // Inisialisasi Select2 untuk semua tabung-select dan jenis-transaksi-select yang ada saat load
        $('.tabung-select').select2({
            placeholder: "-- Pilih Tabung --",
            allowClear: true
        }).on('change', function() {
            const harga = parseInt($(this).find('option:selected').data('harga')) || 0;
            const $hargaInput = $(this).closest('.row').find('.harga-tabung');
            const $hargaInputDisplay = $(this).closest('.row').find('.harga-tabung-display');
            $hargaInput.val(harga);
            $hargaInputDisplay.val(formatRupiah(harga));
            updateTotal();
            updateTabungOptions();
        });

        $('.jenis-transaksi-select').select2({
            placeholder: "-- Pilih Jenis --",
            allowClear: true
        }).on('change', function() {
            updateBatasWaktuPeminjaman($(this));
        });

        // Set harga awal dan batas waktu peminjaman berdasarkan tabung dan jenis transaksi yang dipilih
        $('.tabung-select').each(function() {
            const $select = $(this);
            const $hargaInput = $select.closest('.row').find('.harga-tabung');
            const $hargaInputDisplay = $select.closest('.row').find('.harga-tabung-display');
            $select.on('select2:select', function() {
                const harga = parseInt($select.find('option:selected').data('harga')) || 0;
                $hargaInput.val(harga);
                $hargaInputDisplay.val(formatRupiah(harga));
                updateTotal();
            });
            if ($select.val()) {
                const harga = parseInt($select.find('option:selected').data('harga')) || 0;
                $hargaInput.val(harga);
                $hargaInputDisplay.val(formatRupiah(harga));
            } else {
                $hargaInput.val(0);
                $hargaInputDisplay.val(formatRupiah(0));
            }
        });

        $('.jenis-transaksi-select').each(function() {
            updateBatasWaktuPeminjaman($(this));
        });

        // Format jumlah_dibayar ke Rupiah saat input dan perbarui status serta tanggal jatuh tempo
        $('#jumlah_dibayar_display').on('input', function() {
            let value = unformatRupiah($(this).val());
            $(this).val(formatRupiah(value));
            $('#jumlah_dibayar').val(value);
            updateStatus();
        });

        // Inisialisasi format Rupiah untuk jumlah_dibayar saat halaman dimuat
        let jumlahDibayar = $('#jumlah_dibayar').val();
        $('#jumlah_dibayar_display').val(formatRupiah(jumlahDibayar));

        // Inisialisasi dan update tanggal dan waktu real-time
        updateDateTime();
        setInterval(updateDateTime, 1000); // Update setiap detik

        updateTotal();
        updateTabungOptions();
        updateStatus(); // Inisialisasi status saat halaman dimuat

        // Event untuk tombol hapus detail
        $(document).on('click', '.remove-detail', function() {
            $(this).closest('.detail-item').remove();
            updateTotal();
            updateTabungOptions();
        });

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

<style>
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-danger { color: #dc3545 !important; }
    .custom-select {
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .detail-items .detail-item {
        border-left: 4px solid #007bff;
        transition: all 0.3s ease;
    }
    .detail-items .detail-item:hover {
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    .remove-detail {
        padding: 0.25rem 0.5rem;
        font-size: 0.9rem;
    }
</style>
@endsection