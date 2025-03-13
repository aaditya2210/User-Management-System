@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid px-4">
    @php
        $loggedInUser = Auth::user();
        $userRoles = $loggedInUser->roles->pluck('name')->implode(', ');
    @endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary" style="font-size: 1.5rem;">Users Management</h2>
</div>

    {{-- <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Users Management</h2>
    </div> --}}

    <!-- User Info Panel -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fs-4 me-2"></i>
                <div>
                    <strong>Logged in as:</strong> {{ $loggedInUser->first_name }} {{ $loggedInUser->last_name }}
                    <span class="badge bg-secondary ms-1">{{ $userRoles ?: 'User' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Panel -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search users by name, email, or contact info...">
                        <button class="btn btn-outline-secondary border-start-0 d-none" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-md-end">
                        {{-- <a href="{{ route('suppliers.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-box me-1"></i> Suppliers
                        </a>
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-users me-1"></i> Customers
                        </a> --}}
                        <div class="dropdown">
                            <button id="exportDropdown" type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                            <ul class="dropdown-menu shadow" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="{{ route('users.export.csv') }}" id="exportCsv">
                                    <i class="fas fa-file-csv me-1"></i> CSV
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('users.export.excel') }}" id="exportExcel">
                                    <i class="fas fa-file-excel me-1"></i> Excel
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('users.export.pdf') }}" id="exportPdf">
                                    <i class="fas fa-file-pdf me-1"></i> PDF
                                </a></li>
                            </ul>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark">User Database</h5>
                <div class="btn-group">
                    @can('create-users')
                    {{-- @role('admin') --}}
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i> Add User
                        </a>
                        {{-- <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i> Add User
                        </a> --}}
                    @endcan
                    <a href="{{ url('/user-roles') }}" class="btn btn-outline-warning">
                        <i class="fas fa-shield-alt me-1"></i> Manage User Roles
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-warning">
                        <i class="fas fa-shield me-1"></i> Define Roles
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error') || $errors->any())
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') ?? $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover border-bottom" id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">ID</th>
                            <th class="fw-semibold">First Name</th>
                            <th class="fw-semibold">Last Name</th>
                            <th class="fw-semibold">Email</th>
                            <th class="fw-semibold">Contact Number</th>
                            <th class="fw-semibold">Postcode</th>
                            <th class="fw-semibold">Gender</th>
                            <th class="fw-semibold">State</th>
                            <th class="fw-semibold">City</th>
                            <th class="fw-semibold">Roles</th>
                            <th class="fw-semibold">Hobbies</th>
                            <th class="fw-semibold">Uploaded Files</th>
                            <th class="fw-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        {{-- Users will be loaded dynamically via AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div id="searchStats" class="text-muted small"></div>
                </div>
                <div class="col-md-6">
                    <div id="pagination" class="d-flex justify-content-center">
                        <nav>
                            <ul class="pagination pagination-sm"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title text-danger" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-0">Are you sure you want to delete this user? This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                    <i class="fas fa-trash-alt"></i> Delete User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Required Scripts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
    .search-highlight {
        background-color: #fff3cd;
        padding: 0 2px;
        border-radius: 2px;
    }

    #clearSearch {
        cursor: pointer;
    }

    /* Add transition effect for search results */
    #usersTableBody tr {
        transition: background-color 0.2s ease;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let deleteUserId = null;
    let searchTimeout = null;
    let perPage = 10;

    // Initial Load Users
    loadUsers(1);

    // Setup search input
    const searchInput = document.getElementById("searchInput");
    const clearSearchBtn = document.getElementById("clearSearch");

    // Load users dynamically via AJAX
    function loadUsers(page = 1, search = '') {
        // Show loading indicator
        document.getElementById('usersTableBody').innerHTML =
            '<tr><td colspan="13" class="text-center py-4"><i class="fas fa-hourglass-split me-2"></i>Loading users...</td></tr>';

        $.ajax({
            url: `/api/users?page=${page}&search=${search}&per_page=${perPage}`,
            type: "GET",
            dataType: "json",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("access_token")
            },
            success: function(response) {
                console.log(response); // Log the response
                updateUsersTable(response.data, search);
                updatePagination(response, search);
                updateSearchStats(response, search);
            },
            error: function(xhr) {
                console.error("Error loading users:", xhr.responseText);
                alert("Error loading users: " + xhr.statusText);
                document.getElementById('usersTableBody').innerHTML =
                    '<tr><td colspan="13" class="text-center py-4 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Error loading users. Please try again.</td></tr>';
            }
        });
    }

    // Update search statistics
    function updateSearchStats(response, search) {
        const searchStats = document.getElementById('searchStats');
        if (!search) {
            searchStats.innerHTML =
                `Showing ${response.from || 0} to ${response.to || 0} of ${response.total} users`;
        } else {
            searchStats.innerHTML = `Found ${response.total} results for <strong>"${search}"</strong>`;
        }
    }

    // Highlight search terms in results
    function highlightText(text, searchTerm) {
        if (!searchTerm || !text) return text;

        // Escape special characters in the search term
        const escapedSearchTerm = searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escapedSearchTerm})`, 'gi');

        return text.toString().replace(regex, '<span class="search-highlight">$1</span>');
    }

    // Update the Users Table
    function updateUsersTable(users, searchTerm = '') {
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';

        if (users.length === 0) {
            const tr = document.createElement('tr');
            if (searchTerm) {
                tr.innerHTML =
                    `<td colspan="13" class="text-center py-4"><i class="fas fa-search me-2 fs-5"></i>No users found matching "${searchTerm}"</td>`;
            } else {
                tr.innerHTML =
                    '<td colspan="13" class="text-center py-4"><i class="fas fa-emoji-frown me-2 fs-5"></i>No users found.</td>';
            }
            tbody.appendChild(tr);
            return;
        }

        users.forEach(user => {
            const tr = document.createElement('tr');

            // Format roles as badges
            let rolesHtml = user.roles.map(role =>
                `<span class="badge bg-primary">${role.name}</span>`
            ).join(' ');

            // Format hobbies as badges
            let hobbiesArray = Array.isArray(user.hobbies) ? user.hobbies :
                (typeof user.hobbies === 'string' ? JSON.parse(user.hobbies) : []);
            let hobbiesHtml = hobbiesArray.map(hobby =>
                `<span class="badge bg-secondary">${hobby}</span>`
            ).join(' ');

            // Format uploaded files as small previews
            let filesArray = user.uploaded_files ?
                (Array.isArray(user.uploaded_files) ? user.uploaded_files :
                    JSON.parse(user.uploaded_files)) : [];

            let filesHtml = filesArray.length > 0 ?
                filesArray.map(file => {
                    let fileUrl = `/storage/${file}`;
                    let fileName = file.split('/').pop();
                    let fileExtension = fileName.split('.').pop().toLowerCase();

                    // Check if the file is an image
                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
                        return `<img src="${fileUrl}" alt="${fileName}" style="width: 80px; height: 80px; object-fit: cover; margin: 5px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);" />`;
                    } else {
                        // For non-image files, show a file icon with a link
                        return `<a href="${fileUrl}" target="_blank" class="text-decoration-none" style="display: block; margin: 5px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="File" style="width: 40px; height: 40px; vertical-align: middle;">
                        <span class="ms-2 text-truncate" style="max-width: 120px; display: inline-block;">${fileName}</span>
                    </a>`;
                    }
                }).join('') : '<span class="text-muted">N/A</span>';

            // Create actions buttons based on permissions
            let actionsHtml = `
           @can('update-users')
                <a href="/users/${user.id}/edit" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endcan
        `;

            if (user.id != localStorage.getItem("user_id")) {
                actionsHtml += `
               @can('delete-users')
                    <button class="btn btn-danger btn-sm delete-user w-100" data-id="${user.id}">
                          <i class="fas fa-trash-alt"></i> Delete
                    </button>
                @endcan
            `;
            }

            // Apply highlighting if search term exists
            const firstName = searchTerm ? highlightText(user.first_name, searchTerm) : user
                .first_name;
            const lastName = searchTerm ? highlightText(user.last_name, searchTerm) : user
                .last_name;
            const email = searchTerm ? highlightText(user.email, searchTerm) : user.email;
            const contactNumber = searchTerm ? highlightText(user.contact_number, searchTerm) : user
                .contact_number;
            const postcode = searchTerm ? highlightText(user.postcode, searchTerm) : user.postcode;

            tr.innerHTML = `
            <td>${user.id}</td>
            <td>${firstName}</td>
            <td>${lastName}</td>
            <td>${email}</td>
            <td>${contactNumber}</td>
            <td>${postcode}</td>
            <td>${ucFirst(user.gender)}</td>
            <td>${user.state?.name || '<span class="text-muted">N/A</span>'}</td>
            <td>${user.city?.name || '<span class="text-muted">N/A</span>'}</td>
            <td>${rolesHtml}</td>
            <td>${hobbiesHtml}</td>
            <td>${filesHtml}</td>
            <td>${actionsHtml}</td>
        `;
            tbody.appendChild(tr);
        });

        // Add event listeners to delete buttons
        document.querySelectorAll(".delete-user").forEach(button => {
            button.addEventListener("click", function() {
                showDeleteConfirmation(this.getAttribute("data-id"));
            });
        });
    }

    // Helper function to capitalize first letter
    function ucFirst(string) {
        if (!string) return '';
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Update Pagination Links
    function updatePagination(response, search = '') {
        const paginationElement = document.querySelector('#pagination ul');
        paginationElement.innerHTML = '';

        if (response.total <= response.per_page) return;

        // Previous button
        const prevDisabled = response.current_page === 1 ? "disabled" : "";
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${prevDisabled}`;
        prevLi.innerHTML = `
<a class="page-link" href="#" data-page="${response.current_page - 1}" data-search="${search}">
    <i class="fas fa-chevron-left"></i> Prev
</a>
`;
        paginationElement.appendChild(prevLi);

        // Calculate page range to display
        let startPage = Math.max(1, response.current_page - 2);
        let endPage = Math.min(response.last_page, response.current_page + 2);

        // Add first page and ellipsis if necessary
        if (startPage > 1) {
            const firstLi = document.createElement('li');
            firstLi.className = 'page-item';
            firstLi.innerHTML = `<a class="page-link" href="#" data-page="1" data-search="${search}">1</a>`;
            paginationElement.appendChild(firstLi);

            if (startPage > 2) {
                const ellipsisLi = document.createElement('li');
                ellipsisLi.className = 'page-item disabled';
                ellipsisLi.innerHTML = `<span class="page-link">...</span>`;
                paginationElement.appendChild(ellipsisLi);
            }
        }

        // Page numbers
        for (let i = startPage; i <= endPage; i++) {
            const activeClass = i === response.current_page ? "active" : "";
            const pageLi = document.createElement('li');
            pageLi.className = `page-item ${activeClass}`;
            pageLi.innerHTML = `
    <a class="page-link" href="#" data-page="${i}" data-search="${search}">${i}</a>
`;
            paginationElement.appendChild(pageLi);
        }

        // Add last page and ellipsis if necessary
        if (endPage < response.last_page) {
            if (endPage < response.last_page - 1) {
                const ellipsisLi = document.createElement('li');
                ellipsisLi.className = 'page-item disabled';
                ellipsisLi.innerHTML = `<span class="page-link">...</span>`;
                paginationElement.appendChild(ellipsisLi);
            }

            const lastLi = document.createElement('li');
            lastLi.className = 'page-item';
            lastLi.innerHTML =
                `<a class="page-link" href="#" data-page="${response.last_page}" data-search="${search}">${response.last_page}</a>`;
            paginationElement.appendChild(lastLi);
        }

        // Next button
        const nextDisabled = response.current_page === response.last_page ? "disabled" : "";
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${nextDisabled}`;
        nextLi.innerHTML = `
<a class="page-link" href="#" data-page="${response.current_page + 1}" data-search="${search}">
    Next <i class="fas fa-chevron-right"></i>
</a>
`;
        paginationElement.appendChild(nextLi);

        // Add event listeners to pagination links
        document.querySelectorAll(".page-link").forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                if (!this.classList.contains('disabled')) {
                    loadUsers(this.getAttribute("data-page"), this.getAttribute(
                        "data-search"));
                }
            });
        });
    }
    
    // Show delete confirmation modal
    function showDeleteConfirmation(id) {
        deleteUserId = id;
        $('#deleteConfirmationModal').modal('show');
    }

    // Handle user deletion
    $('#confirmDeleteButton').click(function() {
        if (deleteUserId) {
            deleteUser(deleteUserId);
        }
    });

    function deleteUser(userId) {
        $.ajax({
            url: `/api/users/${userId}`,
            type: "DELETE",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("access_token")
            },
            success: function() {
                $('#deleteConfirmationModal').modal('hide');
                showSuccessNotification("User deleted successfully!");

                // Wait 1 second before reloading the current page of users
                setTimeout(() => {
                    let currentPage = document.querySelector(".pagination .active a")
                        ?.textContent || 1;
                    loadUsers(currentPage, searchInput.value);
                }, 1000);
            },
            error: function(xhr) {
                $('#deleteConfirmationModal').modal('hide');
                showErrorNotification("Error deleting user: " + xhr.responseText);
                console.error("Error deleting user:", xhr.responseText);
            }
        });
    }

    // Function to show a success notification
    function showSuccessNotification(message) {
        const alertContainer = document.createElement("div");
        alertContainer.className =
            "alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg";
        alertContainer.style.zIndex = "9999";
        alertContainer.role = "alert";
        alertContainer.innerHTML = `
        <i class="fas fa-check-circle-fill me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

        document.body.append(alertContainer);

        // Auto-dismiss the alert after 3 seconds
        setTimeout(() => {
            alertContainer.classList.remove("show");
            setTimeout(() => alertContainer.remove(), 500);
        }, 3000);
    }

    // Function to show an error notification
    function showErrorNotification(message) {
        const alertContainer = document.createElement("div");
        alertContainer.className =
            "alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg";
        alertContainer.style.zIndex = "9999";
        alertContainer.role = "alert";
        alertContainer.innerHTML = `
        <i class="fas fa-exclamation-triangle-fill me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

        document.body.append(alertContainer);

        setTimeout(() => {
            alertContainer.classList.remove("show");
            setTimeout(() => alertContainer.remove(), 500);
        }, 3000);
    }

    // Search functionality with debounce
    searchInput.addEventListener("input", function() {
        // Show/hide clear button
        if (this.value.length > 0) {
            clearSearchBtn.classList.remove('d-none');
        } else {
            clearSearchBtn.classList.add('d-none');
        }

        // Debounce search for better performance
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadUsers(1, this.value);
        }, 300); // 300ms delay to reduce API calls while typing
    });

    // Clear search button
    clearSearchBtn.addEventListener("click", function() {
        searchInput.value = '';
        clearSearchBtn.classList.add('d-none');
        loadUsers(1, '');
    });

    // Handle Enter key press in search box
    searchInput.addEventListener("keypress", function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            loadUsers(1, this.value);
        }
    });

    // // Export buttons with loading states
    // $('#exportCsv').click(function(e) {
    //     e.preventDefault();
    //     $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
    //     window.location.href = `/api/users/export/csv?token=${localStorage.getItem("access_token")}`;
    //     setTimeout(() => $(this).html('<i class="fas fa-file-csv me-1"></i> CSV'), 1500);
    // });

    // $('#exportExcel').click(function(e) {
    //     e.preventDefault();
    //     $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
    //     window.location.href = `/api/users/export/excel?token=${localStorage.getItem("access_token")}`;
    //     setTimeout(() => $(this).html('<i class="fas fa-file-excel me-1"></i> Excel'), 1500);
    // });

    // $('#exportPdf').click(function(e) {
    //     e.preventDefault();
    //     $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
    //     window.location.href = `/users/export/pdf?token=${localStorage.getItem("access_token")}`;
    //     setTimeout(() => $(this).html('<i class="fas fa-file-pdf me-1"></i> PDF'), 1500);
    // });


    function exportData(format) {
        let token = localStorage.getItem("access_token");
        if (!token) {
            alert("Authorization token is missing!");
            return;
        }

        let exportUrls = {
            csv: "/api/users/export/csv",
            excel: "/api/users/export/excel",
            pdf: "/api/users/export/pdf"
        };

        let button = $(`#export${format.charAt(0).toUpperCase() + format.slice(1)}`);
        button.html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');

        $.ajax({
            url: exportUrls[format],
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            },
            xhrFields: {
                responseType: 'blob' // Ensures file download
            },
            success: function(response, status, xhr) {
                let filename = xhr.getResponseHeader('Content-Disposition')?.split('filename=')[1] || `users.${format}`;
                let blob = new Blob([response], { type: xhr.getResponseHeader('Content-Type') });
                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename.replace(/"/g, '');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(xhr) {
                alert("Failed to export: " + xhr.responseText);
            },
            complete: function() {
                setTimeout(() => {
                    let icons = { csv: "file-csv", excel: "file-excel", pdf: "file-pdf" };
                    button.html(`<i class="fas fa-${icons[format]} me-1"></i> ${format.toUpperCase()}`);
                }, 1500);
            }
        });
    }

    $("#exportCsv").click(function(e) { e.preventDefault(); exportData('csv'); });
    $("#exportExcel").click(function(e) { e.preventDefault(); exportData('excel'); });
    $("#exportPdf").click(function(e) { e.preventDefault(); exportData('pdf'); });
});


</script>
@endsection
