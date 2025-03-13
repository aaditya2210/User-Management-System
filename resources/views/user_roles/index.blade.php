{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage User Roles & Permissions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <h3>Users & Roles</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Current Roles</th>
                <th>Assign Role</th>
                <th>Remove Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                <td>
                    <form action="{{ route('user.assignRole', $user->id) }}" method="POST">
                        @csrf
                        <select name="role" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary mt-1">Assign</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('user.removeRole', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <select name="role" class="form-control" required>
                            @foreach($user->getRoleNames() as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-danger mt-1">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Roles & Permissions</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Role</th>
                <th>Permissions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>
                    <form action="{{ route('role.updatePermissions', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="d-flex flex-wrap">
                            @foreach($permissions as $permission)
                                <div class="form-check me-3">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" 
                                        {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Update Permissions</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}





@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Manage User Roles & Permissions</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <!-- Users & Roles Section -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 text-dark">Users & Roles</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover border-bottom">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">User</th>
                            <th class="fw-semibold">Current Roles</th>
                            <th class="fw-semibold">Assign Role</th>
                            <th class="fw-semibold">Remove Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $user->first_name }} {{ $user->last_name }}</div>
                            </td>
                            <td>
                                @foreach($user->getRoleNames() as $role)
                                    <span class="badge bg-primary me-1">{{ $role }}</span>
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('user.assignRole', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <select name="role" class="form-select" required>
                                            <option value="" selected disabled>Select role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plus-circle me-1"></i>Assign
                                        </button> --}}
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-plus-circle me-1"></i>Assign
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('user.removeRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="input-group">
                                        <select name="role" class="form-select" required>
                                            <option value="" selected disabled>Select role</option>
                                            @foreach($user->getRoleNames() as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-minus-circle me-1"></i>Remove
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Roles & Permissions Section -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 text-dark">Roles & Permissions</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover border-bottom">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold" style="width: 20%">Role</th>
                            <th class="fw-semibold">Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $role->name }}</div>
                            </td>
                            <td>
                                <form action="{{ route('role.updatePermissions', $role->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                           class="form-check-input" id="perm_{{ $role->id }}_{{ $permission->id }}"
                                                           {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm_{{ $role->id }}_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-1"></i>Update Permissions
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Required Scripts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection