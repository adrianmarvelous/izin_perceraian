@extends('layouts.sneat')

@section('title', 'Tambah Unit Kerja')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Unit Kerja</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('master-unit-kerja.store') }}" method="POST">
                    @csrf
                    @include('master_unit_kerja._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Simpan
                        </button>
                        <a href="{{ route('master-unit-kerja.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
