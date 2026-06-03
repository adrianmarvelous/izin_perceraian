@extends('layouts.sneat')

@section('title', 'Edit Unit Kerja')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Unit Kerja: {{ $masterUnitKerja->nama_unit }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('master-unit-kerja.update', $masterUnitKerja) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('master_unit_kerja._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Update
                        </button>
                        <a href="{{ route('master-unit-kerja.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
