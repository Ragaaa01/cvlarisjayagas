@extends('admin.layouts.base')

@section('title', 'Data Akun')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Data Akun</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal" title="Tambah Akun">
        <i class="fas fa-plus"></i> Tambah Akun
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status Aktif</th>
                <th>Perorangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($akuns as $akun)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $akun->email }}</td>
                <td>{{ ucfirst($akun->role) }}</td>
                <td>{{ $akun->status_aktif ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td>
                    {{ $akun->perorangan ? $akun->perorangan->id_perorangan . ' - ' . $akun->perorangan->nama_lengkap . ' - ' . $akun->perorangan->nik : '-' }}
                </td>
                <td>
                    <a href="{{ route('show_data_akun', $akun->id_akun) }}" class="btn btn-info btn-sm" title="Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $akun->id_akun }}" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('delete_akun', $akun->id_akun) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus akun ini?')" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @include('admin.pages.akun.modals')
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#addModal').on('shown.bs.modal', function () {
            $('#addIdPerorangan').select2({
                dropdownParent: $('#addModal'),
                placeholder: "-- Pilih ID, Nama, dan NIK Perorangan --",
                allowClear: true,
                width: '100%'
            });
        });

        @foreach($akuns as $akun)
        $('#editModal{{ $akun->id_akun }}').on('shown.bs.modal', function () {
            $('#editIdPerorangan{{ $akun->id_akun }}').select2({
                dropdownParent: $('#editModal{{ $akun->id_akun }}'),
                placeholder: "-- Pilih ID, Nama, dan NIK Perorangan --",
                allowClear: true,
                width: '100%'
            });
        });
        @endforeach
    });
</script>
@endsection
