<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ __('Profile Information') }}</h5>
        <small class="text-muted">{{ __("Update your account's profile information.") }}</small>
    </div>
    <div class="card-body">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input id="name" name="name" type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="username" class="form-label">{{ __('Username') }} <span class="text-danger">*</span></label>
                    <input id="username" name="username" type="text"
                           class="form-control @error('username') is-invalid @enderror"
                           value="{{ old('username', $user->username) }}" required autocomplete="username">
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                    <input id="email" name="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-warning mb-1">{{ __('Your email address is unverified.') }}</p>
                            <button form="send-verification" class="btn btn-sm btn-outline-warning">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </div>

                    @endif
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save"></i> {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</div>
