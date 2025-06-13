@extends ('admin.layouts.base')
@section('title', 'Show Data Akun')
@section('content')
<div class="container">
    <h1>Detail Akun</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>ID Akun:</strong> {{ $akun->id_akun }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $akun->email }}</li>
        <li class="list-group-item"><strong>Role:</strong> {{ $akun->role }}</li>
        <li class="list-group-item"><strong>Status Aktif:</strong> {{ $akun->status_aktif ? 'Aktif' : 'Tidak Aktif' }}</li>
        <li class="list-group-item"><strong>Perorangan:</strong> {{ $akun->perorangan->nama_lengkap ?? '-' }}</li>
    </ul>
    <a href="{{ route('data_akun') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
