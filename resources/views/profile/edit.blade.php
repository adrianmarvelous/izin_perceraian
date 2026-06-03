@extends('layouts.sneat')

@section('title', 'Profile')

@section('content')
<div class="row">
    <div class="col-12">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="col-12 mt-4">
        @include('profile.partials.update-password-form')
    </div>

</div>
@endsection
