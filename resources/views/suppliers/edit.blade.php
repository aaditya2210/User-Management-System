@extends('layouts.app')

@section('content')
<h2 class="fw-bold text-primary fs-1 mb-3">Edit Supplier</h2>

    <form id="editSupplierForm" action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $supplier->name }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $supplier->email }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ $supplier->contact_number }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ $supplier->address }}</textarea>
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ $supplier->company_name }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>GST Number</label>
            <input type="text" name="gst_number" class="form-control" value="{{ $supplier->gst_number }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Website</label>
            <input type="url" name="website" class="form-control" value="{{ $supplier->website }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>State</label>
            <select name="state_id" id="state_id" class="form-control">
                <option value="">Select State</option>
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ $supplier->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
            </select>
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>City</label>
            <select name="city_id" id="city_id" class="form-control">
                <option value="">Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $supplier->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            <span class="error text-danger"></span>
        </div>




        {{-- Newly added fields --}}

        <div class="form-group">
            <label>Postal Code</label>
            <input type="text" name="postal_code" class="form-control" value="{{ $supplier->postal_code }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Contact Person</label>
            <input type="text" name="contact_person" class="form-control" value="{{ $supplier->contact_person }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $supplier->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $supplier->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Contract Start Date</label>
            <input type="date" name="contract_start_date" class="form-control" value="{{ $supplier->contract_start_date }}">
            <span class="error text-danger"></span>
        </div>

        <div class="form-group">
            <label>Contract End Date</label>
            <input type="date" name="contract_end_date" class="form-control" value="{{ $supplier->contract_end_date }}">
            <span class="error text-danger"></span>
        </div>


        <button type="submit" class="btn btn-success">Update</button>
    </form>

    {{-- jQuery & Validation Plugins --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

    {{-- Toastr CSS & JS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            // Custom phone number validation method
            $.validator.addMethod("phoneValidation", function (value, element) {
    return this.optional(element) || /^(?!0{10})(\d{10}|\+91\d{10})$/.test(value);
}, "Enter a valid phone number (10 digits or +91 format).");


            // Handle state-city dynamic dropdown
            $('#state_id').on('change', function() {
                var stateId = $(this).val();

                if (stateId) {
                    $.ajax({
                        url: "{{ route('get.cities') }}",
                        type: "GET",
                        data: { state_id: stateId },
                        dataType: "json",
                        success: function(response) {
                            $('#city_id').empty().append('<option value="">Select City</option>');
                            $.each(response, function(key, city) {
                                $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                            });

                            var selectedCity = "{{ $supplier->city_id ?? '' }}";
                            if (selectedCity) {
                                $('#city_id').val(selectedCity).change();
                            }
                        },
                        error: function() {
                            toastr.error("Failed to load cities.");
                        }
                    });
                } else {
                    $('#city_id').empty().append('<option value="">Select City</option>');
                }
            });

            if ($('#state_id').val()) {
                $('#state_id').trigger('change');
            }

            // Form validation with red error messages
            $('#editSupplierForm').validate({
                errorClass: 'text-danger',  // Makes error messages red
                errorElement: 'span',       // Wraps errors in <span>
                highlight: function(element) {
                    $(element).addClass('is-invalid');  // Adds red border
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');  // Removes red border
                },
                rules: {
                    name: { required: true, minlength: 3 },
                    email: { required: true, email: true },
                    contact_number: { required: true, phoneValidation: true },
                    address: { required: true, minlength: 5 },
                    company_name: { required: true },
                    gst_number: {
                        required: true,
                        minlength: 15,
                        maxlength: 15
                    },
                    website: { required: true, url: true },
                    state_id: { required: true },
                    city_id: { required: true },
                    postal_code: { required: true, digits: true, minlength: 6, maxlength: 6 },
                    contact_person: { required: true, minlength: 3 },
                    status: { required: true },
                    contract_start_date: { required: true, date: true },
                    contract_end_date: { required: true, date: true }
                },
                messages: {
                    name: "Please enter at least 3 characters",
                    email: "Enter a valid email",
                    contact_number: { required: "Contact number is required.", phoneValidation: "Enter a valid phone number format (e.g., +91 9876543210, 9876543210, 123-456-7890)." },
                    address: "Address must be at least 5 characters",
                    company_name: "Company name is required",
                    gst_number: {
                        required: "Please enter the gst number ",
                        minlength: "Enter a valid GST Number (15 characters)",
                        maxlength: "Enter a valid GST Number (15 characters)"
                    },
                    website: "Enter a valid URL",
                    state_id: "Please select a state",
                    city_id: "Please select a city",
                    postal_code: { required: "Postcode is required.", digits: "Only digits are allowed.", minlength: "Must be 6 digits.", maxlength: "Must be 6 digits." },
                    contact_person: "Enter at least 3 characters.",
                    status: "Please select status.",
                    contract_start_date: "Select a valid start date.",
                    contract_end_date: "Select a valid end date."
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: $(form).attr('action'),
                        method: 'POST',
                        data: $(form).serialize() + "&_method=PUT",
                        success: function () {
                            toastr.success("Supplier updated successfully!");
                            setTimeout(() => {
                                window.location.href = "{{ route('suppliers.index') }}";
                            }, 2000);
                        },
                        error: function () {
                            toastr.error("An error occurred while updating.");
                        }
                    });
                }
            });
        });
    </script>

@endsection
