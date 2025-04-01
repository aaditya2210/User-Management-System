@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary" style="font-size: 1.8rem;">Supplier Management</h2>
        {{-- <h2 class="fw-bold text-primary">Supplier Management</h2> --}}

        {{-- @can('manage-suppliers') --}}
        @can('create-suppliers')
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Add Supplier
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
                        <input type="text" id="searchSupplier" class="form-control" placeholder="Search suppliers by name, company, or contact info...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-md-end">
                        <button class="btn btn-outline-primary" id="exportCSV">
                            <i class="fas fa-file-csv me-1"></i> CSV
                        </button>
                      <button class="btn btn-outline-success"id="exportExcel">
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

    <!-- Suppliers Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 text-dark">Supplier Database</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover border-bottom" id="suppliersTable">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Name</th>
                            <th class="fw-semibold">Email</th>
                            <th class="fw-semibold">Contact</th>
                            <th class="fw-semibold">Address</th>
                            <th class="fw-semibold">Company</th>
                            <th class="fw-semibold">GST Number</th>
                            <th class="fw-semibold">Website</th>
                            <th class="fw-semibold">State</th>
                            <th class="fw-semibold">City</th>
                            <th class="fw-semibold">Postal Code</th>
                            <th class="fw-semibold">Contact Person</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold">Contract Start</th>
                            <th class="fw-semibold">Contract End</th>
                            <th class="fw-semibold text-center">Actions</th>
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
                <p class="mb-0">Are you sure you want to delete this supplier? This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete Supplier</button>
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
    // Global variable for supplier ID
    let deleteSupplierId = null;
    
    // Configure toast notifications
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Fetch suppliers with search and pagination
    function fetchSuppliers(page = 1, search = '') {
        let token = localStorage.getItem("access_token");
        
        // Show loading state
        $("#suppliersTable tbody").html(`
            <tr>
                <td colspan="15" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                    Loading supplier data...
                </td>
            </tr>
        `);
        
        $.ajax({
            url: `/api/suppliers?page=${page}&search=${encodeURIComponent(search)}`,
            method: "GET",
            headers: { Authorization: `Bearer ${token}` },
            success: function(response) {
                let tableBody = $("#suppliersTable tbody");
                tableBody.empty();

                if (response.data && response.data.length > 0) {
                    response.data.forEach(supplier => {
                        // Format dates
                        const startDate = supplier.contract_start_date ? 
                            new Date(supplier.contract_start_date).toLocaleDateString() : 'N/A';
                        const endDate = supplier.contract_end_date ? 
                            new Date(supplier.contract_end_date).toLocaleDateString() : 'N/A';
                            
                        // Format status with appropriate badge
                        const statusBadge = supplier.status === 'active' ? 
                            '<span class="badge bg-success">Active</span>' : 
                            '<span class="badge bg-danger">Inactive</span>';
                            
                        // Format website with clickable link if available
                        const website = supplier.website ? 
                            `<a href="${supplier.website}" target="_blank" class="text-primary">
                                <i class="fas fa-external-link-alt me-1"></i>Visit
                            </a>` : 'N/A';
                        
                        tableBody.append(`
                            <tr>
                                <td>
                                    <div class="fw-semibold">${supplier.name}</div>
                                </td>
                                <td>${supplier.email}</td>
                                <td>${supplier.contact_number || 'N/A'}</td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 150px;" 
                                          data-bs-toggle="tooltip" title="${supplier.address || 'Not Available'}">
                                        ${supplier.address || 'N/A'}
                                    </span>
                                </td>
                                <td>${supplier.company_name || 'N/A'}</td>
                                <td>${supplier.gst_number || 'N/A'}</td>
                                <td>${website}</td>
                                <td>${supplier.state ? supplier.state.name : 'N/A'}</td>
                                <td>${supplier.city ? supplier.city.name : 'N/A'}</td>
                                <td>${supplier.postal_code || 'N/A'}</td>
                                <td>${supplier.contact_person || 'N/A'}</td>
                                <td>${statusBadge}</td>
                                <td>${startDate}</td>
                                <td>${endDate}</td>
                                <td class="text-center">
                                 
                                    @can('update-suppliers')
                                    <div class="btn-group btn-group-sm">
                                        <a href="/suppliers/${supplier.id}/edit" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete-suppliers')
                                        <button class="btn btn-outline-danger" onclick="showDeleteConfirmation(${supplier.id})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    @endcan
                                </td>
                            </tr>
                        `);
                    });
                    
                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    
                } else {
                    tableBody.append(`
                        <tr>
                            <td colspan="15" class="text-center py-4">
                                <i class="fas fa-search me-2 text-muted"></i>
                                No suppliers found matching your criteria.
                            </td>
                        </tr>
                    `);
                }

                // Update Pagination Links
                let paginationLinks = $('#paginationLinks');
                paginationLinks.empty();
                
                if (response.links && response.links.length > 3) {
                    paginationLinks.append(`<nav aria-label="Supplier pagination"><ul class="pagination pagination-sm mb-0"></ul></nav>`);
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
                                       onclick="fetchSuppliers('${link.url.split('page=')[1].split('&')[0]}', '${search}')">
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
                let errorMessage = "Unable to load supplier data";
                
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage += `: ${xhr.responseJSON.error}`;
                } else if (xhr.status === 401) {
                    errorMessage = "Your session has expired. Please log in again.";
                    // Redirect to login page after a delay
                    setTimeout(() => window.location.href = '/login', 2000);
                }
                
                $("#suppliersTable tbody").html(`
                    <tr>
                        <td colspan="15" class="text-center text-danger py-3">
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
        deleteSupplierId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        modal.show();
    }

    // Delete supplier
    function deleteSupplier(id) {
        const loadingBtn = $("#confirmDeleteButton").html(
            `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Deleting...`
        );
        loadingBtn.prop('disabled', true);
        
        $.ajax({
            url: `/api/suppliers/${id}`,
            method: 'POST',
            data: { _method: 'DELETE' },
            headers: {
                'Authorization': "Bearer " + localStorage.getItem("access_token"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                toastr.success("Supplier has been successfully deleted");
                fetchSuppliers(); // Refresh the list
            },
            error: function(xhr) {
                bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                
                let errorMsg = "An error occurred while deleting the supplier.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                toastr.error(errorMsg);
            },
            complete: function() {
                $("#confirmDeleteButton").html("Delete Supplier").prop('disabled', false);
            }
        });
    }

    // Initialize on document ready
    $(document).ready(function() {
        // Initial data load
        fetchSuppliers();
        
        // Search with debounce
        let searchTimer;
        $("#searchSupplier").on("input", function() {
            clearTimeout(searchTimer);
            const query = $(this).val();
            
            searchTimer = setTimeout(() => {
                fetchSuppliers(1, query);
            }, 400);
        });
        
        // // Export buttons with loading states
        // $('#exportCSV').click(function() {
        //     $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
        //     window.location.href = `/api/suppliers/export/csv?token=${localStorage.getItem("access_token")}`;
        //     setTimeout(() => $(this).html('<i class="fas fa-file-csv me-1"></i> CSV'), 1500);
        // });

        // $('#exportExcel').click(function() {
        //     $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
        //     window.location.href = `/api/suppliers/export/excel?token=${localStorage.getItem("access_token")}`;
        //     setTimeout(() => $(this).html('<i class="fas fa-file-excel me-1"></i> Excel'), 1500);
        // });

        // // $('#exportExcel').click(function() {
        // //     $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
        // //     window.location.href = `/api/suppliers/export/excel?token=${localStorage.getItem("access_token")}`;
        // //     setTimeout(() => $(this).html('<i class="fas fa-file-excel me-1"></i> Excel'), 1500);
        // // });




        // $('#exportPDF').click(function() {
        //     $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
        //     window.location.href = `/api/suppliers/export/pdf?token=${localStorage.getItem("access_token")}`;
        //     setTimeout(() => $(this).html('<i class="fas fa-file-pdf me-1"></i> PDF'), 1500);
        // });

















        function exportData(format) {
    let token = localStorage.getItem("access_token");
    if (!token) {
        alert("Authorization token is missing!");
        return;
    }

    let exportUrls = {
        csv: "/api/suppliers/export/csv",
        excel: "/api/suppliers/export/excel",
        pdf: "/api/suppliers/export/pdf"
    };

    let button = $(`#export${format.toUpperCase()}`);
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
            let filename = xhr.getResponseHeader('Content-Disposition')?.split('filename=')[1] || `suppliers.${format}`;
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

$("#exportCSV").click(function(e) { e.preventDefault(); exportData('csv'); });
$("#exportExcel").click(function(e) { e.preventDefault(); exportData('excel'); });
$("#exportPDF").click(function(e) { e.preventDefault(); exportData('pdf'); });

        
        // Confirm delete button action
        $('#confirmDeleteButton').click(function() {
            if (deleteSupplierId) {
                deleteSupplier(deleteSupplierId);
            }
        });
    });




//     $(document).ready(function() {
//     // Global variable for supplier ID
//     let deleteSupplierId = null;

//     // Configure toast notifications
//     toastr.options = {
//         "closeButton": true,
//         "progressBar": true,
//         "positionClass": "toast-top-right",
//         "timeOut": "3000"
//     };

//     // Fetch suppliers with search and pagination
//     function fetchSuppliers(page = 1, search = '') {
//         let token = localStorage.getItem("access_token");

//         // Show loading state
//         $("#suppliersTable tbody").html(`
//             <tr>
//                 <td colspan="15" class="text-center py-4">
//                     <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
//                     Loading supplier data...
//                 </td>
//             </tr>
//         `);

//         $.ajax({
//             url: `/api/suppliers?page=${page}&search=${encodeURIComponent(search)}`,
//             method: "GET",
//             headers: { Authorization: `Bearer ${token}` },
//             success: function(response) {
//                 let tableBody = $("#suppliersTable tbody");
//                 tableBody.empty();

//                 if (response.data && response.data.length > 0) {
//                     response.data.forEach(supplier => {
//                         // Format dates
//                         const startDate = supplier.contract_start_date ? 
//                             new Date(supplier.contract_start_date).toLocaleDateString() : 'N/A';
//                         const endDate = supplier.contract_end_date ? 
//                             new Date(supplier.contract_end_date).toLocaleDateString() : 'N/A';
                            
//                         // Format status with appropriate badge
//                         const statusBadge = supplier.status === 'active' ? 
//                             '<span class="badge bg-success">Active</span>' : 
//                             '<span class="badge bg-danger">Inactive</span>';
                            
//                         // Format website with clickable link if available
//                         const website = supplier.website ? 
//                             `<a href="${supplier.website}" target="_blank" class="text-primary">
//                                 <i class="fas fa-external-link-alt me-1"></i>Visit
//                             </a>` : 'N/A';
                        
//                         tableBody.append(`
//                             <tr>
//                                 <td>
//                                     <div class="fw-semibold">${supplier.name}</div>
//                                 </td>
//                                 <td>${supplier.email}</td>
//                                 <td>${supplier.contact_number || 'N/A'}</td>
//                                 <td>
//                                     <span class="text-truncate d-inline-block" style="max-width: 150px;" 
//                                           data-bs-toggle="tooltip" title="${supplier.address || 'Not Available'}">
//                                         ${supplier.address || 'N/A'}
//                                     </span>
//                                 </td>
//                                 <td>${supplier.company_name || 'N/A'}</td>
//                                 <td>${supplier.gst_number || 'N/A'}</td>
//                                 <td>${website}</td>
//                                 <td>${supplier.state ? supplier.state.name : 'N/A'}</td>
//                                 <td>${supplier.city ? supplier.city.name : 'N/A'}</td>
//                                 <td>${supplier.postal_code || 'N/A'}</td>
//                                 <td>${supplier.contact_person || 'N/A'}</td>
//                                 <td>${statusBadge}</td>
//                                 <td>${startDate}</td>
//                                 <td>${endDate}</td>
//                                 <td class="text-center">
//                                     @can('manage-suppliers')
//                                     <div class="btn-group btn-group-sm">
//                                         <a href="/suppliers/${supplier.id}/edit" class="btn btn-outline-primary">
//                                             <i class="fas fa-edit"></i>
//                                         </a>
//                                         <button class="btn btn-outline-danger" onclick="showDeleteConfirmation(${supplier.id})">
//                                             <i class="fas fa-trash-alt"></i>
//                                         </button>
//                                     </div>
//                                     @endcan
//                                 </td>
//                             </tr>
//                         `);
//                     });
                    
//                     // Initialize tooltips
//                     $('[data-bs-toggle="tooltip"]').tooltip();
                    
//                 } else {
//                     tableBody.append(`
//                         <tr>
//                             <td colspan="15" class="text-center py-4">
//                                 <i class="fas fa-search me-2 text-muted"></i>
//                                 No suppliers found matching your criteria.
//                             </td>
//                         </tr>
//                     `);
//                 }

//                 // Update Pagination Links
//                 let paginationLinks = $('#paginationLinks');
//                 paginationLinks.empty();
                
//                 if (response.links && response.links.length > 3) {
//                     paginationLinks.append(`<nav aria-label="Supplier pagination"><ul class="pagination pagination-sm mb-0"></ul></nav>`);
//                     const paginationUl = paginationLinks.find('ul');
                    
//                     response.links.forEach(link => {
//                         if (link.url) {
//                             let label = link.label;
//                             let iconClass = '';
                            
//                             // Replace numbered labels with icons for Previous/Next
//                             if (link.label === "&laquo; Previous") {
//                                 label = `<i class="fas fa-chevron-left"></i>`;
//                                 iconClass = 'prev-page';
//                             } else if (link.label === "Next &raquo;") {
//                                 label = `<i class="fas fa-chevron-right"></i>`;
//                                 iconClass = 'next-page';
//                             }
                            
//                             paginationUl.append(`
//                                 <li class="page-item ${link.active ? 'active' : ''} ${iconClass}">
//                                     <a class="page-link" href="javascript:void(0)" 
//                                        onclick="fetchSuppliers('${link.url.split('page=')[1].split('&')[0]}', '${search}')">
//                                         ${label}
//                                     </a>
//                                 </li>
//                             `);
//                         }
//                     });
//                 }
//             },
//             error: function(xhr) {
//                 console.error("API Error:", xhr);
//                 let errorMessage = "Unable to load supplier data";
                
//                 if (xhr.responseJSON && xhr.responseJSON.error) {
//                     errorMessage += `: ${xhr.responseJSON.error}`;
//                 } else if (xhr.status === 401) {
//                     errorMessage = "Your session has expired. Please log in again.";
//                     // Redirect to login page after a delay
//                     setTimeout(() => window.location.href = '/login', 2000);
//                 }
                
//                 $("#suppliersTable tbody").html(`
//                     <tr>
//                         <td colspan="15" class="text-center text-danger py-3">
//                             <i class="fas fa-exclamation-circle me-2"></i>
//                             ${errorMessage}
//                         </td>
//                     </tr>
//                 `);
                
//                 toastr.error(errorMessage);
//             }
//         });
//     }

//     // Show delete confirmation modal
//     function showDeleteConfirmation(id) {
//         deleteSupplierId = id;
//         const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
//         modal.show();
//     }

//     // Delete supplier
//     function deleteSupplier(id) {
//         const loadingBtn = $("#confirmDeleteButton").html(
//             `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Deleting...`
//         );
//         loadingBtn.prop('disabled', true);
        
//         $.ajax({
//             url: `/api/suppliers/${id}`,
//             method: 'POST',
//             data: { _method: 'DELETE' },
//             headers: {
//                 'Authorization': "Bearer " + localStorage.getItem("access_token"),
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//                 'Accept': 'application/json'
//             },
//             success: function(response) {
//                 bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
//                 toastr.success("Supplier has been successfully deleted");
//                 fetchSuppliers(); // Refresh the list
//             },
//             error: function(xhr) {
//                 bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal')).hide();
                
//                 let errorMsg = "An error occurred while deleting the supplier.";
//                 if (xhr.responseJSON && xhr.responseJSON.message) {
//                     errorMsg = xhr.responseJSON.message;
//                 }
                
//                 toastr.error(errorMsg);
//             },
//             complete: function() {
//                 $("#confirmDeleteButton").html("Delete Supplier").prop('disabled', false);
//             }
//         });
//     }

//     // Initialize on document ready
//     $(document).ready(function() {
//         // Initial data load
//         fetchSuppliers();
        
//         // Search with debounce
//         let searchTimer;
//         $("#searchSupplier").on("input", function() {
//             clearTimeout(searchTimer);
//             const query = $(this).val();
            
//             searchTimer = setTimeout(() => {
//                 fetchSuppliers(1, query);
//             }, 400);
//         });
        
//         // Export buttons with loading states
//         $('#exportCSV').click(function(e) {
//             e.preventDefault();
//             $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
//             window.location.href = `/api/suppliers/export/csv?token=${localStorage.getItem("access_token")}`;
//             setTimeout(() => $(this).html('<i class="fas fa-file-csv me-1"></i> CSV'), 1500);
//         });

//         $('#exportExcel').click(function(e) {
//             e.preventDefault();
//             $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
//             window.location.href = `/api/suppliers/export/excel?token=${localStorage.getItem("access_token")}`;
//             setTimeout(() => $(this).html('<i class="fas fa-file-excel me-1"></i> Excel'), 1500);
//         });

//         $('#exportPDF').click(function(e) {
//             e.preventDefault();
//             $(this).html('<i class="fas fa-spinner fa-spin me-1"></i> Exporting...');
//             window.location.href = `/api/suppliers/export/pdf?token=${localStorage.getItem("access_token")}`;
//             setTimeout(() => $(this).html('<i class="fas fa-file-pdf me-1"></i> PDF'), 1500);
//         });
        
//         // Confirm delete button action
//         $('#confirmDeleteButton').click(function() {
//             if (deleteSupplierId) {
//                 deleteSupplier(deleteSupplierId);
//             }
//         });
//     });
// });
</script>
@endsection