@extends('admin.layouts.base')

@section('title', 'Data Perusahaan')

@section('content')
<div class="container">
    <h2>Data Perusahaan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah Data dengan ikon -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCreate">
        <i class="fas fa-plus mr-1"></i> Tambah Data
    </button>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Email</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($perusahaans as $index => $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->nama_perusahaan }}</td>
                <td>{{ $row->alamat_perusahaan }}</td>
                <td>{{ $row->email_perusahaan }}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('perusahaan.show', $row->id_perusahaan) }}"
                            class="btn btn-sm text-white mx-1"
                            style="background-color: #17a2b8;" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        <button class="btn btn-sm text-white btnEdit mx-1"
                            style="background-color: #ffc107;" title="Edit"
                            data-id="{{ $row->id_perusahaan }}"
                            data-nama="{{ $row->nama_perusahaan }}"
                            data-alamat="{{ $row->alamat_perusahaan }}"
                            data-email="{{ $row->email_perusahaan }}"
                            data-toggle="modal" data-target="#modalEdit">
                            <i class="fas fa-edit"></i>
                        </button>

                        <form action="{{ route('perusahaan.destroy', $row->id_perusahaan) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm text-white mx-1"
                                style="background-color: #dc3545;"
                                onclick="return confirm('Yakin hapus?')" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Include Modals --}}
@include('admin.pages.perusahaan.modal_create')
@include('admin.pages.perusahaan.modal_edit')
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.btnEdit').on('click', function () {
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_alamat').val($(this).data('alamat'));
            $('#edit_email').val($(this).data('email'));
            const id = $(this).data('id');
            $('#formEdit').attr('action', 'perusahaan/' + id);
        });
    });
</script>
@endsection
