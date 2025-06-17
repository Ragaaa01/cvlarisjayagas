@extends('admin.layouts.base')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Status Tabung</h2>
        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus mr-1"></i> Tambah Data
        </button>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $status)
                <tr class="text-center">
                    <td>{{ $status->id_status_tabung }}</td>
                    <td>{{ ucfirst($status->status_tabung) }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            {{-- Detail --}}
                            <a href="{{ route('jenis_tabung.show', $status->id_status_tabung) }}"
                               class="btn btn-sm btn-info mx-1" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- Edit --}}
                            <button class="btn btn-sm btn-warning mx-1" title="Edit Data"
                                    data-toggle="modal"
                                    data-target="#editModal-{{ $status->id_status_tabung }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- Modal Edit --}}
                            @include('admin.pages.status_tabung.modal_edit', ['status' => $status])

                            {{-- Hapus --}}
                            <form action="{{ route('status_tabung.destroy', $status->id_status_tabung) }}"
                                  method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="d-inline mx-1">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
@include('admin.pages.status_tabung.modal_create')
@endsection
