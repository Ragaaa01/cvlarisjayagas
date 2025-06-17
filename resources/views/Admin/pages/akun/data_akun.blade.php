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
        <thead class="thead-light">
            <tr>
                <th>Nomor</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status Aktif</th>
                <th>Perorangan</th>
                <th class="text-center">Aksi</th>
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
                    {{ $akun->perorangan ? $akun->perorangan->nama_lengkap . ' - ' . $akun->perorangan->nik : '-' }}
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('show_data_akun', $akun->id_akun) }}" class="btn btn-info btn-sm mx-1" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#editModal{{ $akun->id_akun }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('delete_akun', $akun->id_akun) }}" method="POST" class="d-inline mx-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus akun ini?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Include file modal --}}
    @include('admin.pages.akun.modals')
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Tambah akun
        $('#addIdPerorangan').select2({
            dropdownParent: $('#addModal'),
            placeholder: "-- Pilih ID, Nama, dan NIK Perorangan --",
            allowClear: true,
            width: '100%',
            ajax: {
                url: '{{ route("search_perorangan") }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data // Data sudah dalam bentuk {id, text}
                    };
                },
                cache: true
            }
        });

        // Edit akun
        @foreach($akuns as $akun)
        $('#editIdPerorangan{{ $akun->id_akun }}').select2({
            dropdownParent: $('#editModal{{ $akun->id_akun }}'),
            placeholder: "-- Pilih ID, Nama, dan NIK Perorangan --",
            allowClear: true,
            width: '100%',
            ajax: {
                url: '{{ route("search_perorangan") }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        @endforeach
    });
</script>
@endpush
