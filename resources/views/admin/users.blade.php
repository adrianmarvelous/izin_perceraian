@extends('layouts.sneat')

@section('title', 'Manage Users')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Users</h5>
                <span class="badge bg-primary">{{ $users->count() }} Total</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                {{-- <th>Email</th> --}}
                                <th>Role</th>
                                <th>Registered</th>
                                @can('admin')
                                <th>Actions</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                    </td>
                                    <td><code>{{ $user->username }}</code></td>
                                    {{-- <td>{{ $user->email }}</td> --}}
                                    <td>
                                        @php
                                            $roleBadge = [
                                                'admin' => 'bg-label-danger',
                                                'user' => 'bg-label-secondary',
                                                'opd' => 'bg-label-info',
                                            ];
                                            $role = $user->roles->first()?->name ?? 'N/A';
                                            $badgeClass = $roleBadge[$role] ?? 'bg-label-warning';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $role }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    @can('admin')
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#roleModal{{ $user->id }}">
                                                    <i class="bx bx-shield me-1"></i> Change Role
                                                </button>
                                                <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" onsubmit="return confirm('Reset password {{ $user->name }} ke \"password\"?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-key me-1"></i> Reset Password
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" {{ $user->hasRole('admin') ? 'disabled' : '' }}>
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Role Modal -->
                                        <div class="modal fade" id="roleModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <form action="{{ route('admin.users.role', $user) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Change Role</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="mb-2">User: <strong>{{ $user->name }}</strong></p>
                                                            <select name="role" class="form-select">
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                                        {{ $role->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
if (document.querySelector('#example')) {
    new DataTable('#example');
}
</script>
@endpush
