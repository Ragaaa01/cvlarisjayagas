@extends('admin.layouts.base')

@section('title', 'Data Perorangan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Akun Perorangan</h2>

    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahModal">
        <i class="fas fa-plus"></i> Tambah Data
    </button>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Perusahaan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perorangans as $perorangan)
                    <tr>
                        <td>{{ $perorangan->id_perorangan }}</td>
                        <td>{{ $perorangan->nama_lengkap }}</td>
                        <td>{{ $perorangan->nik }}</td>
                        <td>{{ $perorangan->no_telepon }}</td>
                        <td>{{ $perorangan->alamat }}</td>
                        <td>{{ $perorangan->perusahaan->nama_perusahaan ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <a href="{{ route('perorangan.show', $perorangan->id_perorangan) }}"
                                   class="btn btn-sm text-white mr-1"
                                   style="background-color: #17a2b8;"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <button class="btn btn-sm text-white mr-1"
                                        style="background-color: #f0ad4e;"
                                        title="Edit Data"
                                        onclick='editData(@json($perorangan))'>
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('perorangan.destroy', $perorangan->id_perorangan) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin hapus?')"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm text-white"
                                            style="background-color: #d9534f;"
                                            title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data perorangan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin.pages.perorangan.modal_create')
@include('admin.pages.perorangan.modal_edit')

<script>
function editData(data) {
    const form = document.getElementById('editForm');
    form.action = `/admin/perorangan/${data.id_perorangan}`;
    form.querySelector('[name=nama_lengkap]').value = data.nama_lengkap;
    form.querySelector('[name=nik]').value = data.nik;
    form.querySelector('[name=no_telepon]').value = data.no_telepon;
    form.querySelector('[name=alamat]').value = data.alamat;

    const select = form.querySelector('[name=id_perusahaan]');
    select.innerHTML = '<option value="">-- Pilih Perusahaan --</option>';

    const allPerusahaans = @json($perusahaans);
    const current = data.perusahaan;

    allPerusahaans.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.id_perusahaan;
        opt.textContent = p.nama_perusahaan;
        if (p.id_perusahaan === data.id_perusahaan) {
            opt.selected = true;
        }
        select.appendChild(opt);
    });

    // Tambah perusahaan yang sedang dipakai user tapi tidak dalam daftar
    if (current && !allPerusahaans.some(p => p.id_perusahaan === current.id_perusahaan)) {
        const opt = document.createElement('option');
        opt.value = current.id_perusahaan;
        opt.textContent = current.nama_perusahaan;
        opt.selected = true;
        select.appendChild(opt);
    }

    $('#editModal').modal('show');
}
</script>
@endsection
