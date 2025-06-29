@extends('admin.layouts.base')

@section('content')
<div class="container">
    <h3>Data Tabung</h3>

    <!-- Tombol Tambah Tabung -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createTabungModal">
        Tambah Tabung
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Tabung</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tabungs as $tabung)
                <tr>
                    <td>{{ $tabung->kode_tabung }}</td>
                    <td>{{ $tabung->jenisTabung->nama_jenis ?? '-' }}</td>
                    <td>{{ $tabung->statusTabung->status_tabung ?? '-' }}</td>
                    <td>
                        <a href="{{ route('tabung.show', $tabung->id_tabung) }}" class="btn btn-info btn-sm">Show</a>

                        <!-- Tombol Edit Modal -->
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editTabungModal{{ $tabung->id_tabung }}">
                            Edit
                        </button>

                        <!-- Form Delete -->
                        <form action="{{ route('tabung.destroy', $tabung->id_tabung) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Include Modal Create -->
@include('admin.pages.tabung.modal_create')

<!-- Include Modal Edit untuk setiap tabung -->
@foreach($tabungs as $tabung)
    @include('admin.pages.tabung.modal_edit', ['tabung' => $tabung])
@endforeach
@endsection
