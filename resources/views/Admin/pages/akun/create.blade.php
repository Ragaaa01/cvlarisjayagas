@extends('admin.layouts.base')

@section('title', 'Tambah Akun')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Akun</h1>

    <form action="{{ route('store_akun') }}" method="POST">
        @csrf
        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="administrator">Administrator</option>
                <option value="pelanggan">Pelanggan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Status Aktif</label><br>
            <input type="checkbox" name="status_aktif" value="1"> Aktif
        </div>
        <div class="mb-3">
            <label>Perorangan (Opsional)</label>
            <select name="id_perorangan" class="form-control select-perorangan" style="width: 100%;"></select>
        </div>
        <a href="{{ route('data_akun') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
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
                return { q: params.term };
            },
            processResults: function(data) {
                return { results: data };
            },
            cache: true
        }
    });
</script>
@endpush
