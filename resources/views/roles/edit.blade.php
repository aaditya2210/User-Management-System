@extends('layouts.app')

@section('content')
    <h2>Edit Role</h2>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Role Name:</label>
        <input type="text" name="name" value="{{ $role->name }}" required>
        <button type="submit">Update</button>
    </form>
@endsection
