@extends('admin.layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Edit Status Tabung</h2>
    <form action="{{ route('status_tabung.update', $status->id_status_tabung) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.status_tabung.form', ['current' => $status->status_tabung])
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('data_status_tabung') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
