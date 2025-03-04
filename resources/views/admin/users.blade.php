@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage User Roles</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Roles</th>
                <th>Assign Role</th>
                <th>Remove Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <form action="{{ route('admin.assignRole', $user->id) }}" method="POST">
                            @csrf
                            <select name="role" class="form-select" required>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success mt-2">Assign</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.removeRole', $user->id) }}" method="POST">
                            @csrf
                            <select name="role" class="form-select" required>
                                <option value="">Select Role</option>
                                @foreach ($user->roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-danger mt-2">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
