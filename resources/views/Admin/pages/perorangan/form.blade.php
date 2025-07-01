<div class="mb-3">
    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap" class="form-control" required value="{{ old('nama_lengkap', $perorangan->nama_lengkap ?? '') }}">
</div>
<div class="mb-3">
    <label>NIK</label>
    <input type="text" name="nik" class="form-control" required value="{{ old('nik', $perorangan->nik ?? '') }}">
</div>
<div class="mb-3">
    <label>No Telepon</label>
    <input type="text" name="no_telepon" class="form-control" required value="{{ old('no_telepon', $perorangan->no_telepon ?? '') }}">
</div>
<div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control" required>{{ old('alamat', $perorangan->alamat ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Perusahaan</label>
    <select name="id_perusahaan" class="form-control select2">
        <option value="">-- Pilih Perusahaan --</option>
        @foreach($perusahaans as $p)
            <option value="{{ $p->id_perusahaan }}" 
                {{ old('id_perusahaan', $perorangan->id_perusahaan ?? '') == $p->id_perusahaan ? 'selected' : '' }}>
                {{ $p->nama_perusahaan }}
            </option>
        @endforeach
    </select>
</div>

{{-- Include Select2 --}}
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Pilih perusahaan",
            allowClear: true
        });
    });
</script>
@endpush
