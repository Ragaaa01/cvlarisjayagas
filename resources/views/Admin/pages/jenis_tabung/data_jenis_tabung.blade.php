@extends('admin.layouts.base')
@section('title', 'Show Data Jenis Tabung')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Jenis Tabung</h2>

    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal">
        <i class="fas fa-plus"></i> Tambah Data
    </button>

    @include('admin.pages.jenis_tabung.modal_create')

    <table class="table table-bordered table-striped">
        <thead style="background-color: #4e5d6c; color: white;">
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Kode Jenis</th>
                <th>Nama Jenis</th>
                <th>Harga</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenis_tabung as $index => $jenis)
                <tr>
                    <td>{{ $jenis->id_jenis_tabung }}</td>
                    <td>{{ $jenis->kode_jenis }}</td>
                    <td>{{ $jenis->nama_jenis }}</td>
                    <td>Rp{{ number_format($jenis->harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('jenis_tabung.show', $jenis->id_jenis_tabung) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @include('admin.pages.jenis_tabung.modal_edit', ['jenis' => $jenis])
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $jenis->id_jenis_tabung }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('jenis_tabung.destroy', $jenis->id_jenis_tabung) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rupiahInputs = document.querySelectorAll('.format-rupiah');

        rupiahInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let value = this.value.replace(/[^,\d]/g, '').toString();
                const numberString = value.split(',')[0];
                let sisa = numberString.length % 3;
                let rupiah = numberString.substr(0, sisa);
                const ribuan = numberString.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    const separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                this.value = 'Rp' + rupiah;
            });

            input.closest('form').addEventListener('submit', function () {
                input.value = input.value.replace(/[^0-9]/g, '');
            });
        });
    });
</script>
@endpush
