@extends('admin.layouts.base')

@section('title', 'Data Perorangan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Perorangan</h2>

    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahModal">
        <i class="fas fa-plus"></i> Tambah Data
    </button>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)
        <div>{{ $e }}</div>
        @endforeach
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
            @forelse($perorangans as $d)
                <tr>
                    <td>{{ $d->id_perorangan }}</td>
                    <td>{{ $d->nama_lengkap }}</td>
                    <td>{{ $d->nik }}</td>
                    <td>{{ $d->no_telepon }}</td>
                    <td>{{ $d->alamat }}</td>
                    <td>{{ $d->perusahaan->nama_perusahaan ?? '-' }}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="{{ route('perorangan.show', $d->id_perorangan) }}"
                                class="btn btn-sm btn-info mr-1" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-warning mr-1"
                                title="Edit Data"
                                onclick='editData(@json($d))'>
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST"
                                action="{{ route('perorangan.destroy', $d->id_perorangan) }}"
                                onsubmit="return confirm('Yakin ingin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus Data">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin.pages.perorangan.modal_create')
@include('admin.pages.perorangan.modal_edit')
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Init Select2 pada modal tambah
    $('#tambahModal select[name="id_perusahaan"]').select2({
        width: '100%',
        dropdownParent: $('#tambahModal')
    });
});

function editData(data) {
    const form = $('#editForm');
    form.attr('action', `/admin/perorangan/${data.id_perorangan}`);
    form.find('[name="nama_lengkap"]').val(data.nama_lengkap);
    form.find('[name="nik"]').val(data.nik);
    form.find('[name="no_telepon"]').val(data.no_telepon);
    form.find('[name="alamat"]').val(data.alamat);

    const select = form.find('select[name="id_perusahaan"]');
    select.empty().append(new Option('-- Pilih Perusahaan --', ''));

    const perusahaans = @json($perusahaans);
    const current = data.perusahaan;

    perusahaans.forEach(p => {
        const opt = new Option(p.nama_perusahaan, p.id_perusahaan);
        if(p.id_perusahaan === data.id_perusahaan) opt.selected = true;
        select.append(opt);
    });
    if(current && !perusahaans.some(p => p.id_perusahaan === current.id_perusahaan)) {
        select.append(new Option(current.nama_perusahaan, current.id_perusahaan, true, true));
    }

    select.select2({
        width: '100%',
        dropdownParent: $('#editModal')
    });

    $('#editModal').modal('show');
}
</script>
@endpush
