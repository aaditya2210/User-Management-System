@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary" style="font-size: 1.5rem;">Customer Management</h2>
        {{-- <h2 class="fw-bold text-primary">Customer Management</h2> --}}
      
        {{-- @can('manage-customers') --}}
        @can('create-customers')
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Add Customer
            </a>
        @endcan
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
                        <input type="text" id="searchCustomer" class="form-control" placeholder="Search customers by name, email, or company...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-md-end">
                        <button class="btn btn-outline-primary" id="exportCSV">
                            <i class="fas fa-file-csv me-1"></i> CSV
                        </button>
                        <button class="btn btn-outline-success" id="exportExcel">
                            <i class="fas fa-file-excel me-1"></i> Excel
                        </button>
                        <button class="btn btn-outline-danger" id="exportPDF">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 text-dark">Customer Database</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover border-bottom" id="customersTable">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Name</th>
                            <th class="fw-semibold">Email</th>
                            <th class="fw-semibold">Contact</th>
                            <th class="fw-semibold">Company</th>
                            <th class="fw-semibold">Job Title</th>
                            <th class="fw-semibold">Gender</th>
                            <th class="fw-semibold">Date of Birth</th>
                            <th class="fw-semibold">Nationality</th>
                            <th class="fw-semibold">Type</th>
                            <th class="fw-semibold">Contact Method</th>
                            <th class="fw-semibold">Newsletter</th>
                            <th class="fw-semibold">Notes</th>
                            <th class="fw-semibold">Balance</th>
                            @can('manage-customers')
                                <th class="fw-semibold text-center">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div id="paginationLinks" class="d-flex justify-content-center"></div>
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
                <p class="mb-0">Are you sure you want to delete this customer? This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete Customer</button>
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

<script>
    // Global variable for customer ID
    let deleteCustomerId = null;
    
    // Configure toast notifications
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Fetch customers with search and pagination
    function fetchCustomers(page = 1, search = "") {
        let token = localStorage.getItem("access_token");
        
        // Show loading state
        $("#customersTable tbody").html(`
            <tr>
                <td colspan="14" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                    Loading customer data...
                </td>
            </tr>
        `);
        
        $.ajax({
            url: `/api/customers?page=${page}&search=${encodeURIComponent(search)}`,
            method: "GET",
            headers: { Authorization: `Bearer ${token}` },
            success: function(response) {
                let tableBody = $("#customersTable tbody");
                tableBody.empty();

                if (response.data && response.data.length > 0) {
                    response.data.forEach(customer => {
                        // Format date if available
                        const formattedDOB = customer.date_of_birth ? 
                            new Date(customer.date_of_birth).toLocaleDateString() : 'N/A';
                            
                        // Newsletter status with badge
                        const newsletterStatus = customer.newsletter_subscription ? 
                            '<span class="badge bg-success">Subscribed</span>' : 
                            '<span class="badge bg-secondary">Not Subscribed</span>';
                            
                        // Format account balance
                        const formattedBalance = customer.account_balance ? 
                            new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' })
                            .format(customer.account_balance) : 'N/A';
                        
                        tableBody.append(`
                            <tr>
                                <td>
                                    <div class="fw-semibold">${customer.name}</div>
                                </td>
                                <td>${customer.email}</td>
                                <td>${customer.contact_number || 'N/A'}</td>
                                <td>${customer.company_name || 'N/A'}</td>
                                <td>${customer.job_title || 'N/A'}</td>
                                <td>${customer.gender || 'N/A'}</td>
                                <td>${formattedDOB}</td>
                                <td>${customer.nationality || 'N/A'}</td>
                                <td>
                                    <span class="badge ${customer.customer_type === 'Premium' ? 'bg-warning text-dark' : 'bg-info'}">
                                        ${customer.customer_type || 'Standard'}
                                    </span>
                                </td>
                                <td>${customer.preferred_contact_method || 'N/A'}</td>
                                <td>${newsletterStatus}</td>
                                <td>
                                    ${customer.notes ? 
                                        `<span class="text-truncate d-inline-block" style="max-width: 150px;" 
                                        data-bs-toggle="tooltip" title="${customer.notes}">
                                            ${customer.notes}
                                        </span>` : 
                                        'N/A'
                                    }
                                </td>
                                <td>${formattedBalance}</td>
                            
                                <td class="text-center">
                                    @can('update-customers')
                                    <div class="btn-group btn-group-sm">
                                        <a href="/customers/${customer.id}/edit" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                         @endcan
                                          @can('delete-customers')
                                        <button class="btn btn-outline-danger" onclick="showDeleteConfirmation(${customer.id})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                           @endcan
                                    </div>
                                </td>
                             
                            </tr>
                        `);
                    });
                    
                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    
                } else {
                    tableBody.append(`
                        <tr>
                            <td colspan="14" class="text-center py-4">
                                <i class="fas fa-search me-2 text-muted"></i>
                                No customers found matching your criteria.
                            </td>
                        </tr>
                    `);
                }

                // Update Pagination Links
                let paginationLinks = $('#paginationLinks');
                paginationLinks.empty();
                
                if (response.links && response.links.length > 3) {
                    paginationLinks.append(`<nav aria-label="Customer pagination"><ul class="pagination pagination-sm mb-0"></ul></nav>`);
                    const paginationUl = paginationLinks.find('ul');
                    
                    response.links.forEach(link => {
                        if (link.url) {
                            let label = link.label;
                            let iconClass = '';
                            
                            // Replace numbered labels with icons for Previous/Next
                            if (link.label === "&laquo; Previous") {
                                label = `<i class="fas fa-chevron-left"></i>`;
                                iconClass = 'prev-page';
                            } else if (link.label === "Next &raquo;") {
                                label = `<i class="fas fa-chevron-right"></i>`;
                                iconClass = 'next-page';
                            }
                            
                            paginationUl.append(`
                                <li class="page-item ${link.active ? 'active' : ''} ${iconClass}">
                                    <a class="page-link" href="javascript:void(0)" 
                                       onclick="fetchCustomers('${link.url.split('page=')[1].split('&')[0]}', '${search}')">
                                        ${label}
                                    </a>
                                </li>
                            `);
                        }
                    });
                }
            },
            error: function(xhr) {
                console.error("API Error:", xhr);
                let errorMessage = "Unable to load customer data";
                
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage += `: ${xhr.responseJSON.error}`;
                } else if (xhr.status === 401) {
                    errorMessage = "Your session has expired. Please log in again.";
                    // Redirect to login page after a delay
                    setTimeout(() => window.location.href = '/login', 2000);
                }
                
                $("#customersTable tbody").html(`
                    <tr>
                        <td colspan="14" class="text-center text-danger py-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            ${errorMessage}
                        </td>
                    </tr>
                `);
                
                toastr.error(errorMessage);
            }
        });
    }

    // Show delete confirmation modal
    function showDeleteConfirmation(id) {
        deleteCustomerId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        modal.show();
    }

    // Delete customer
    function deleteCustomer(id) {
        const loadingBtn = $("#confirmDeleteButton").html(
            `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Deleting...`
        );
        loadingBtn.prop('disabled', true);
        
        $.ajax({
            url: `/api/customers/${id}`,
            method: 'POST',
            data: { _method: 'DELETE' },
            headers: {
                'Authorization': "Bearer " + localStorage.getItem("access_token"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                toastr.success("Customer has been successfully deleted");
                fetchCustomers(); // Refresh the list
            },
            error: function(xhr) {
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                
                let errorMsg = "An error occurred while deleting the customer.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                toastr.error(errorMsg);
            },
            complete: function() {
                $("#confirmDeleteButton").html("Delete Customer").prop('disabled', false);
            }
        });
    }

    // Initialize on document ready
    $(document).ready(function() {
        // Initial data load
        fetchCustomers();
        
        // Search with debounce
        let searchTimer;
        $("#searchCustomer").on("keyup", function() {
            clearTimeout(searchTimer);
            const query = $(this).val();
            
            searchTimer = setTimeout(() => {
                fetchCustomers(1, query);
            }, 400);
        });
        
        // Export buttons
        $('#exportCSV').click(function() {
            $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
            window.location.href = `/api/customers/export/csv?token=${localStorage.getItem("access_token")}`;
            setTimeout(() => $(this).html('<i class="fas fa-file-csv me-1"></i> CSV'), 1500);
        });

        $('#exportExcel').click(function() {
            $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
            window.location.href = `/api/customers/export/excel?token=${localStorage.getItem("access_token")}`;
            setTimeout(() => $(this).html('<i class="fas fa-file-excel me-1"></i> Excel'), 1500);
        });

        $('#exportPDF').click(function() {
            $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
            window.location.href = `/api/customers/export/pdf?token=${localStorage.getItem("access_token")}`;
            setTimeout(() => $(this).html('<i class="fas fa-file-pdf me-1"></i> PDF'), 1500);
        });
        
        // Confirm delete button action
        $('#confirmDeleteButton').click(function() {
            if (deleteCustomerId) {
                deleteCustomer(deleteCustomerId);
            }
        });
    });
</script>
@endsection