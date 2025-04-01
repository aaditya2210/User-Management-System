@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold text-primary fs-1 mb-3">Define User Roles</h2>


    <!-- Add Role Button -->
    <button class="btn btn-success mb-3" onclick="openCreateModal()">Add Role</button>

    <!-- Roles Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $index => $role)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $role->id }}, '{{ $role->name }}')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="openDeleteModal({{ $role->id }}, '{{ $role->name }}')">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add/Edit Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="roleForm">
                <div class="modal-body">
                    <input type="hidden" id="roleId">

                    <!-- Role Name Input -->
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="roleName" required>
                        <small class="text-danger d-none" id="roleError"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Role Modal -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteRoleName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteRole">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        let roleModal = new bootstrap.Modal(document.getElementById('roleModal'));
        let deleteRoleModal = new bootstrap.Modal(document.getElementById('deleteRoleModal'));

        // Open Create Role Modal
        window.openCreateModal = function () {
            $('#modalTitle').text('Add Role');
            $('#roleForm')[0].reset();
            $('#roleId').val('');
            $('#roleError').text('').addClass('d-none');
            roleModal.show();
        };

        // Open Edit Role Modal
        window.openEditModal = function (id, name) {
            $('#modalTitle').text('Edit Role');
            $('#roleId').val(id);
            $('#roleName').val(name);
            $('#roleError').text('').addClass('d-none');
            roleModal.show();
        };

        // Open Delete Role Modal
        window.openDeleteModal = function (id, name) {
            $('#deleteRoleName').text(name);
            $('#confirmDeleteRole').attr('data-id', id);
            deleteRoleModal.show();
        };

        // Handle Create & Update Role
        $('#roleForm').submit(function (event) {
            event.preventDefault();
            let id = $('#roleId').val();
            let name = $('#roleName').val();
            let url = id ? `/roles/${id}` : '/roles';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: {
                    name: name,
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    location.reload();
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON?.errors?.name?.[0] || 'Something went wrong';
                    $('#roleError').text(errorMessage).removeClass('d-none');
                }
            });
        });

        // Handle Delete Role
        $('#confirmDeleteRole').click(function () {
            let id = $(this).attr('data-id');

            $.ajax({
                url: `/roles/${id}`,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function (response) {
                    // alert(response.success);
                    location.reload();
                },
                error: function (xhr) {
                    // alert('Failed to delete role: ' + (xhr.responseJSON?.error || "Unknown error"));
                }
            });
        });
    });
</script>
@endsection
