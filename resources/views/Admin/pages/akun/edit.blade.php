@extends('admin.layouts.base')

@section('title', 'Edit Akun')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Akun</h1>

    <form action="{{ route('update_akun', $akun->id_akun) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3"><label>Email</label><input type="email" name="email" value="{{ $akun->email }}" class="form-control" required></div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="administrator" {{ $akun->role == 'administrator' ? 'selected' : '' }}>Administrator</option>
                <option value="pelanggan" {{ $akun->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Status Aktif</label><br>
            <input type="checkbox" name="status_aktif" value="1" {{ $akun->status_aktif ? 'checked' : '' }}> Aktif
        </div>
        <div class="mb-3">
            <label>Perorangan (Opsional)</label>
            <select name="id_perorangan" class="form-control select-perorangan" style="width: 100%;">
                @if($akun->perorangan)
                    <option value="{{ $akun->perorangan->id_perorangan }}" selected>
                        {{ $akun->perorangan->id_perorangan }} - {{ $akun->perorangan->nama_lengkap }} - {{ $akun->perorangan->nik }}
                    </option>
                @endif
            </select>
        </div>
        <a href="{{ route('data_akun') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection

@push('scripts')
<!-- Select2 JS & CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('.select-perorangan').select2({
    placeholder: 'Cari perorangan...',
    allowClear: true,
    ajax: {
        url: '{{ route('search_perorangan') }}',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                q: params.term,
                current_id: '{{ $akun->id_akun }}'
            };
        },
        processResults: function(data) {
            return { results: data };
        },
        cache: true
    }
});

</script>
@endpush
