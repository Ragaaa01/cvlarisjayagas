@extends('admin.layouts.base')

@section('content')
<div class="container">
    <h3>Edit Tabung</h3>

    <form action="{{ route('tabung.update', $tabung->id_tabung) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.tabung.form', ['tabung' => $tabung])
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('data_tabung') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
