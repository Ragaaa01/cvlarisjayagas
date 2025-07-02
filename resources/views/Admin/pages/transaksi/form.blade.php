<!-- @extends('admin.layouts.base')
@section('content')
<div class="container mt-4">
    <h2>{{ $editMode ? 'Edit Transaksi #' . $transaksi->id_transaksi : 'Tambah Transaksi' }}</h2>
    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form method="POST" action="{{ $editMode ? route('transaksis.update', $transaksi->id_transaksi) : route('transaksis.store') }}">
        @csrf
        @if($editMode)
            @method('PUT')
        @endif

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Akun</label>
                <select name="id_akun" class="form-control">
                    <option value="">-- Pilih Akun --</option>
                    @foreach($akuns as $akun)
                        <option value="{{ $akun->id_akun }}"
                            {{ old('id_akun', $editMode ? ($transaksi->id_akun ?? '') : '') == $akun->id_akun ? 'selected' : '' }}>
                            {{ $akun->email }} {{ optional($akun->perorangan)->nama_lengkap ? '- ' . $akun->perorangan->nama_lengkap : '' }}
                        </option>
                    @endforeach
                </select>
                @error('id_akun') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Perorangan</label>
                <select name="id_perorangan" class="form-control">
                    <option value="">-- Pilih Perorangan --</option>
                    @foreach($perorangans as $p)
                        <option value="{{ $p->id_perorangan }}"
                            {{ old('id_perorangan', $editMode ? ($transaksi->id_perorangan ?? '') : '') == $p->id_perorangan ? 'selected' : '' }}>
                            {{ $p->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @error('id_perorangan') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Perusahaan</label>
                <select name="id_perusahaan" class="form-control">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($perusahaans as $per)
                        <option value="{{ $per->id_perusahaan }}"
                            {{ old('id_perusahaan', $editMode ? ($transaksi->id_perusahaan ?? '') : '') == $per->id_perusahaan ? 'selected' : '' }}>
                            {{ $per->nama_perusahaan }}
                        </option>
                    @endforeach
                </select>
                @error('id_perusahaan') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control"
                    value="{{ old('tanggal_transaksi', $editMode ? ($transaksi->tanggal_transaksi ?? '') : '') }}">
                @error('tanggal_transaksi') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-3">
                <label>Waktu</label>
                <input type="time" name="waktu_transaksi" class="form-control"
                    value="{{ old('waktu_transaksi', $editMode ? ($transaksi->waktu_transaksi ?? '') : '') }}">
                @error('waktu_transaksi') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-3">
                <label>Total (Rp)</label>
                <input type="number" name="total_transaksi" class="form-control total-transaksi" readonly
                    value="{{ old('total_transaksi', $editMode ? ($transaksi->total_transaksi ?? 0) : 0) }}">
                @error('total_transaksi') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-3">
                <label>Jumlah Bayar (Rp)</label>
                <input type="number" name="jumlah_dibayar" class="form-control"
                    value="{{ old('jumlah_dibayar', $editMode ? ($transaksi->jumlah_dibayar ?? '') : '') }}">
                @error('jumlah_dibayar') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-control">
                    <option value="tunai" {{ old('metode_pembayaran', $editMode ? $transaksi->metode_pembayaran : '') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="transfer" {{ old('metode_pembayaran', $editMode ? $transaksi->metode_pembayaran : '') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
                @error('metode_pembayaran') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-4">
                <label>Status</label>
                <select name="id_status_transaksi" class="form-control">
                    <option value="">-- Pilih Status --</option>
                    @foreach($statusTransaksis as $st)
                        <option value="{{ $st->id_status_transaksi }}"
                            {{ old('id_status_transaksi', $editMode ? ($transaksi->id_status_transaksi ?? '') : '') == $st->id_status_transaksi ? 'selected' : '' }}>
                            {{ $st->status }}
                        </option>
                    @endforeach
                </select>
                @error('id_status_transaksi') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-4">
                <label>Tanggal Jatuh Tempo</label>
                <input type="date" name="tanggal_jatuh_tempo" class="form-control"
                    value="{{ old('tanggal_jatuh_tempo', $editMode ? ($transaksi->tanggal_jatuh_tempo ?? '') : '') }}">
                @error('tanggal_jatuh_tempo') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <hr>
        <h5>Detail Transaksi</h5>
        <div id="detailContainer">
            @php
                $details = old('detail_transaksi', $editMode ? $transaksi->detailTransaksis->toArray() : [[]]);
            @endphp
            @foreach($details as $i => $dt)
            <div class="form-row align-items-end mb-2 detail-row">
                <div class="col">
                    <label>Tabung</label>
                    <select name="detail_transaksi[{{$i}}][id_tabung]" class="form-control tabung-select">
                        <option value="">-- Pilih Tabung --</option>
                        @foreach($tabungs as $tb)
                            <option value="{{ $tb->id_tabung }}"
                                data-harga="{{ $tb->jenisTabung->harga ?? 0 }}"
                                {{ ($dt['id_tabung'] ?? '') == $tb->id_tabung ? 'selected' : '' }}>
                                {{ $tb->kode_tabung }}
                            </option>
                        @endforeach
                    </select>
                    @error("detail_transaksi.$i.id_tabung") <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col">
                    <label>Jenis</label>
                    <select name="detail_transaksi[{{$i}}][id_jenis_transaksi]" class="form-control">
                        <option value="">-- Pilih Jenis Transaksi --</option>
                        @foreach($jenisTransaksis as $jt)
                            <option value="{{ $jt->id_jenis_transaksi }}"
                                {{ ($dt['id_jenis_transaksi'] ?? '') == $jt->id_jenis_transaksi ? 'selected' : '' }}>
                                {{ $jt->nama_jenis_transaksi }}
                            </option>
                        @endforeach
                    </select>
                    @error("detail_transaksi.$i.id_jenis_transaksi") <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col">
                    <label>Harga</label>
                    <input type="number" name="detail_transaksi[{{$i}}][harga]" class="form-control harga-input" readonly
                        value="{{ $dt['harga'] ?? '' }}">
                    @error("detail_transaksi.$i.harga") <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col">
                    <label>Batas Peminjaman</label>
                    <input type="date" name="detail_transaksi[{{$i}}][batas_waktu_peminjaman]" class="form-control"
                        value="{{ $dt['batas_waktu_peminjaman'] ?? '' }}">
                    @error("detail_transaksi.$i.batas_waktu_peminjaman") <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-auto">
                    <button class="btn btn-danger remove-row" type="button">×</button>
                </div>
            </div>
            @endforeach
        </div>

        <button id="addDetail" class="btn btn-secondary btn-sm mt-2" type="button">+ Tambah Detail</button>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">{{ $editMode ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let idx = {{ count($details) }};

    function calculateTotal() {
        let total = 0;
        $('.harga-input').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('.total-transaksi').val(total.toFixed(0));
    }

    $(document).on('change', '.tabung-select', function() {
        const harga = $(this).find(':selected').data('harga') || 0;
        $(this).closest('.form-row').find('.harga-input').val(harga);
        calculateTotal();
    });

    $('.tabung-select').trigger('change');

    $('#addDetail').click(function(e) {
        e.preventDefault();
        const row = `
            <div class="form-row align-items-end mb-2 detail-row">
                <div class="col">
                    <label>Tabung</label>
                    <select name="detail_transaksi[${idx}][id_tabung]" class="form-control tabung-select">
                        <option value="">-- Pilih Tabung --</option>
                        @foreach($tabungs as $tb)
                            <option value="{{ $tb->id_tabung }}" data-harga="{{ $tb->jenisTabung->harga ?? 0 }}">{{ $tb->kode_tabung }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label>Jenis</label>
                    <select name="detail_transaksi[${idx}][id_jenis_transaksi]" class="form-control">
                        <option value="">-- Pilih Jenis Transaksi --</option>
                        @foreach($jenisTransaksis as $jt)
                            <option value="{{ $jt->id_jenis_transaksi }}">{{ $jt->nama_jenis_transaksi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label>Harga</label>
                    <input type="number" name="detail_transaksi[${idx}][harga]" class="form-control harga-input" readonly>
                </div>
                <div class="col">
                    <label>Batas Peminjaman</label>
                    <input type="date" name="detail_transaksi[${idx}][batas_waktu_peminjaman]" class="form-control">
                </div>
                <div class="col-auto">
                    <button class="btn btn-danger remove-row" type="button">×</button>
                </div>
            </div>`;
        $('#detailContainer').append(row);
        idx++;
    });

    $(document).on('click', '.remove-row', function() {
        if ($('.detail-row').length > 1) {
            $(this).closest('.form-row').remove();
            calculateTotal();
        } else {
            alert('Minimal satu detail transaksi harus ada.');
        }
    });

    $(document).on('submit', 'form', function(e) {
        if ($('.detail-row').length === 0) {
            e.preventDefault();
            alert('Harap tambahkan minimal satu detail transaksi.');
        }
    });
});
</script>
@endpush
@endsection -->