<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ __('Update Password') }}</h5>
        <small class="text-muted">{{ __('Ensure your account is using a long, random password to stay secure.') }}</small>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="update_password_current_password" class="form-label">{{ __('Current Password') }} <span class="text-danger">*</span></label>
                    <input id="update_password_current_password" name="current_password" type="password"
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                           autocomplete="current-password">
                    @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="update_password_password" class="form-label">{{ __('New Password') }} <span class="text-danger">*</span></label>
                    <input id="update_password_password" name="password" type="password"
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                           autocomplete="new-password">
                    @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                           class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                           autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
