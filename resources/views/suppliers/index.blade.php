@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Suppliers</h2>

        @can('manage-suppliers')
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add Supplier</a>
        @endcan

        <div class="mb-3">
            <button class="btn btn-success" id="exportCSV">Export CSV</button>
            <button class="btn btn-info" id="exportExcel">Export Excel</button>
            <button class="btn btn-danger" id="exportPDF">Export PDF</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="suppliersTable">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Company Name</th>
                        <th>GST Number</th>
                        <th>Website</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Postal Code</th>
                        <th>Contact Person</th>
                        <th>Status</th>
                        <th>Contract Start Date</th>
                        <th>Contract End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="paginationLinks" class="mt-3"></div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this supplier?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let deleteSupplierId = null;

        function fetchSuppliers(page = 1) {
            let token = localStorage.getItem("access_token"); // Retrieve token from local storage

            $.ajax({
                url: "/api/suppliers?page=" + page,
                method: "GET",
                headers: {
                    Authorization: "Bearer " + token
                },
                success: function(response) {
                    console.log("API Response:", response); // Debugging log

                    let tableBody = $("#suppliersTable tbody");
                    tableBody.empty(); // Clear existing table data

                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(supplier) {
                            tableBody.append(`
                                <tr>
                                    <td>${supplier.name}</td>
                                    <td>${supplier.email}</td>
                                    <td>${supplier.contact_number || 'N/A'}</td>
                                    <td>${supplier.address || 'N/A'}</td>
                                    <td>${supplier.company_name || 'N/A'}</td>
                                    <td>${supplier.gst_number || 'N/A'}</td>
                                    <td><a href="${supplier.website || '#'}" target="_blank">${supplier.website || 'N/A'}</a></td>
                                    <td>${supplier.country || 'N/A'}</td>
                                    <td>${supplier.state || 'N/A'}</td>
                                    <td>${supplier.city || 'N/A'}</td>
                                    <td>${supplier.postal_code || 'N/A'}</td>
                                    <td>${supplier.contact_person || 'N/A'}</td>
                                    <td><span class="badge ${supplier.status === 'active' ? 'bg-success' : 'bg-danger'}">
                                        ${supplier.status.charAt(0).toUpperCase() + supplier.status.slice(1)}</span>
                                    </td>
                                    <td>${supplier.contract_start_date ? new Date(supplier.contract_start_date).toLocaleDateString() : 'N/A'}</td>
                                    <td>${supplier.contract_end_date ? new Date(supplier.contract_end_date).toLocaleDateString() : 'N/A'}</td>
                                    <td>
                                        @can('manage-suppliers')
                                            <a href="/suppliers/${supplier.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                                            <button class="btn btn-danger btn-sm" onclick="showDeleteConfirmation(${supplier.id})">Delete</button>
                                        @endcan
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        tableBody.append(
                            `<tr><td colspan="16" class="text-center">No suppliers found.</td></tr>`);
                    }

                    // Update Pagination Links
                    let paginationLinks = $('#paginationLinks');
                    paginationLinks.empty();
                    if (response.links) {
                        response.links.forEach(link => {
                            paginationLinks.append(
                                `<a href="#" onclick="fetchSuppliers(${link.label})" class="btn btn-sm ${link.active ? 'btn-primary' : 'btn-light'}">${link.label}</a> `
                                );
                        });
                    }
                },
                error: function(xhr) {
                    console.error("XHR Response:", xhr);
                    alert("Error fetching data: " + (xhr.responseJSON?.error || xhr.responseText ||
                        "Unknown error"));
                }
            });
        }

        function showDeleteConfirmation(id) {
            deleteSupplierId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $('#confirmDeleteButton').click(function() {
            if (deleteSupplierId) {
                deleteSupplier(deleteSupplierId);
            }
        });

        function deleteSupplier(id) {
            $.ajax({
                url: `/api/suppliers/${id}`,
                method: 'POST', // Change from DELETE to POST
                data: {
                    _method: 'DELETE'
                }, // Laravel will recognize this as a DELETE request
                headers: {
                    'Authorization': "Bearer " + localStorage.getItem("access_token"),
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(response) {
                    $('#deleteConfirmationModal').modal('hide');
                    toastr.success("Supplier deleted successfully!", "Success");
                    fetchSuppliers(); // Refresh the list
                },
                error: function(xhr) {
                    $('#deleteConfirmationModal').modal('hide');
                    toastr.error("An error occurred while deleting the supplier.", "Error");
                }
            });
        }

        $(document).ready(function() {
            fetchSuppliers();

            $('#exportCSV').click(function() {
                window.location.href = "/api/suppliers/export/csv?token=" + localStorage.getItem(
                    "access_token");
            });

            $('#exportExcel').click(function() {
                window.location.href = "/api/suppliers/export/excel?token=" + localStorage.getItem(
                    "access_token");
            });

            $('#exportPDF').click(function() {
                window.location.href = "/api/suppliers/export/pdf?token=" + localStorage.getItem(
                    "access_token");
            });
        });
    </script>
@endsection