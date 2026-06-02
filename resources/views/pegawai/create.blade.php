@extends('layouts.sneat')

@section('title', 'Tambah Pegawai')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Pegawai</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pegawai.store') }}" method="POST">
                    @csrf
                    @include('pegawai._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Simpan
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
