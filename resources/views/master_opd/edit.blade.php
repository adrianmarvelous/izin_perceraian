@extends('layouts.sneat')

@section('title', 'Edit Master OPD')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Master OPD: {{ $masterOpd->nama_opd }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('master-opd.update', $masterOpd) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('master_opd._form')
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Update
                        </button>
                        <a href="{{ route('master-opd.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
