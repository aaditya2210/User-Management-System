@extends('layouts.app')

@section('content')
    <h2>Edit Supplier</h2>

    <form id="editSupplierForm" action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $supplier->email }}" required>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ $supplier->contact_number }}" required>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ $supplier->address }}</textarea>
        </div>

        <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ $supplier->company_name }}">
        </div>

        <div class="form-group">
            <label>GST Number</label>
            <input type="text" name="gst_number" class="form-control" value="{{ $supplier->gst_number }}">
        </div>

        <div class="form-group">
            <label>Website</label>
            <input type="url" name="website" class="form-control" value="{{ $supplier->website }}">
        </div>

        <div class="form-group">
            <label>Country</label>
            <input type="text" name="country" class="form-control" value="{{ $supplier->country }}">
        </div>

        <div class="form-group">
            <label>State</label>
            <input type="text" name="state" class="form-control" value="{{ $supplier->state }}">
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="{{ $supplier->city }}">
        </div>

        <div class="form-group">
            <label>Postal Code</label>
            <input type="text" name="postal_code" class="form-control" value="{{ $supplier->postal_code }}">
        </div>

        <div class="form-group">
            <label>Contact Person</label>
            <input type="text" name="contact_person" class="form-control" value="{{ $supplier->contact_person }}">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $supplier->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $supplier->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label>Contract Start Date</label>
            <input type="date" name="contract_start_date" class="form-control" value="{{ $supplier->contract_start_date }}">
        </div>

        <div class="form-group">
            <label>Contract End Date</label>
            <input type="date" name="contract_end_date" class="form-control" value="{{ $supplier->contract_end_date }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editSupplierForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    contact_number: {
                        required: true,
                        digits: true
                    },
                    address: {
                        required: true,
                        minlength: 5
                    },
                    company_name: {
                        required: true,
                        minlength: 2
                    },
                    gst_number: {
                        required: true,
                        minlength: 2
                    },
                    website: {
                        required: true,
                        url: true
                    },
                    country: {
                        required: true,
                        minlength: 2
                    },
                    state: {
                        required: true,
                        minlength: 2
                    },
                    city: {
                        required: true,
                        minlength: 2
                    },
                    postal_code: {
                        required: true,
                        digits: true
                    },
                    contact_person: {
                        required: true,
                        minlength: 2
                    },
                    status: {
                        required: true
                    },
                    contract_start_date: {
                        required: true,
                        date: true
                    },
                    contract_end_date: {
                        required: true,
                        date: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter the name",
                        minlength: "Name must be at least 3 characters long"
                    },
                    email: {
                        required: "Please enter the email",
                        email: "Please enter a valid email address"
                    },
                    contact_number: {
                        required: "Please enter the contact number",
                        digits: "Please enter only digits"
                    },
                    address: {
                        required: "Please enter the address",
                        minlength: "Address must be at least 5 characters long"
                    },
                    company_name: {
                        required: "Please enter the company name",
                        minlength: "Company name must be at least 2 characters long"
                    },
                    gst_number: {
                        required: "Please enter the GST number",
                        minlength: "GST number must be at least 2 characters long"
                    },
                    website: {
                        required: "Please enter the website",
                        url: "Please enter a valid URL"
                    },
                    country: {
                        required: "Please enter the country",
                        minlength: "Country must be at least 2 characters long"
                    },
                    state: {
                        required: "Please enter the state",
                        minlength: "State must be at least 2 characters long"
                    },
                    city: {
                        required: "Please enter the city",
                        minlength: "City must be at least 2 characters long"
                    },
                    postal_code: {
                        required: "Please enter the postal code",
                        digits: "Please enter only digits"
                    },
                    contact_person: {
                        required: "Please enter the contact person",
                        minlength: "Contact person must be at least 2 characters long"
                    },
                    status: {
                        required: "Please select the status"
                    },
                    contract_start_date: {
                        required: "Please enter the contract start date",
                        date: "Please enter a valid date"
                    },
                    contract_end_date: {
                        required: "Please enter the contract end date",
                        date: "Please enter a valid date"
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $(form).attr('action'),
                        method: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            toastr.success('Supplier updated successfully!');
                            setTimeout(function() {
                                window.location.href = "{{ route('suppliers.index') }}";
                            }, 2000);
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred while updating the supplier.');
                        }
                    });
                }
            });
        });
    </script>
@endsection