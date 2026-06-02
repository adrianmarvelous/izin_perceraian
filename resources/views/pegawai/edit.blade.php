@extends('layouts.sneat')

@section('title', 'Edit Pegawai')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Pegawai: {{ $pegawai->nama }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pegawai.update', $pegawai) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('pegawai._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Update
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
