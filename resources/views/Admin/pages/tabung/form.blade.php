<div class="form-group">
    <label for="kode_tabung">Kode Tabung</label>
    <input type="text" name="kode_tabung" class="form-control" value="{{ old('kode_tabung', $tabung->kode_tabung ?? '') }}" required>
</div>

<div class="form-group">
    <label for="id_jenis_tabung">Jenis Tabung</label>
    <select name="id_jenis_tabung" class="form-control" required>
        @foreach($jenisTabungs as $jenis)
            <option value="{{ $jenis->id_jenis_tabung }}" {{ (isset($tabung) && $tabung->id_jenis_tabung == $jenis->id_jenis_tabung) ? 'selected' : '' }}>
                {{ $jenis->nama_jenis }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="id_status_tabung">Status Tabung</label>
    <select name="id_status_tabung" class="form-control" required>
        @foreach($statusTabungs as $status)
            <option value="{{ $status->id_status_tabung }}" {{ (isset($tabung) && $tabung->id_status_tabung == $status->id_status_tabung) ? 'selected' : '' }}>
                {{ $status->status_tabung }}
            </option>
        @endforeach
    </select>
</div>
