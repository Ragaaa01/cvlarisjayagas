@extends('admin.layouts.base')

@section('content')
<div class="container">
    <h1>Detail Status Tabung</h1>

    <div class="card">
        <div class="card-body">
            <h5>ID: {{ ucfirst($status->id_status_tabung) }}</h5>
            <h5>Status: {{ ucfirst($status->status_tabung) }}</h5>
            <p>Dibuat pada: {{ $status->created_at->format('d-m-Y H:i') }}</p>
            <p>Diubah terakhir: {{ $status->updated_at->format('d-m-Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('data_status_tabung') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
