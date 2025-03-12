@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="card">
        <div class="card-header">Create User</div>
        <div class="card-body">
            <form id="userForm" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>First Name:</label>
                    <input type="text" name="first_name" class="form-control" required>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" class="form-control" required>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" required>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Contact Number:</label>
                    <input type="text" name="contact_number" class="form-control" required>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Postcode:</label>
                    <input type="text" name="postcode" class="form-control" required>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Confirm Password:</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Gender:</label>
                    <div>
                        <input type="radio" name="gender" value="male" required> Male
                        <input type="radio" name="gender" value="female"> Female
                    </div>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Hobbies:</label>
                    <div>
                        <input type="checkbox" name="hobbies[]" value="Reading"> Reading
                        <input type="checkbox" name="hobbies[]" value="Sports"> Sports
                        <input type="checkbox" name="hobbies[]" value="Music"> Music
                    </div>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Roles:</label>
                    <select name="roles[]" multiple class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>State:</label>
                    <select name="state_id" id="state" class="form-control">
                        <option value="">Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>City:</label>
                    <select name="city_id" id="city" class="form-control">
                        <option value="">Select City</option>
                    </select>
                    <span class="text-danger error"></span>
                </div>

                <div class="mb-3">
                    <label>Upload Files:</label>
                    <input type="file" name="files[]" multiple class="form-control">
                    <span class="text-danger error"></span>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>

        $(document).ready(function() {
            // jQuery Validation
            $("#userForm").validate({
                errorElement: 'span',
                errorClass: 'text-danger',
                rules: {
                    first_name: {
                        required: true,
                        alphanumeric: true
                    },
                    last_name: {
                        required: true,
                        alphanumeric: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    contact_number: { 
                required: true, 
                phoneValidation: true // Custom method for phone validation
            },
                    postcode: {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength: 6
                    },
                    password: { 
                required: true, 
                minlength: 8,
                strongPassword: true 
            },
            password_confirmation: { 
                required: true, 
                equalTo: "#password" 
            },
                    gender: {
                        required: true
                    },
                    "hobbies[]": {
                        required: true,
                        minlength: 1
                    },
                    "roles[]": {
                        required: true
                    },
                    state_id: {
                        required: true
                    },
                    city_id: {
                        required: true
                    },
                    "files[]": {
                        required: true
                    }
                },
                messages: {
                    first_name: {
                        required: "First name is required.",
                        alphanumeric: "Only letters and numbers are allowed"
                    },
                    last_name: {
                        required: "Last name is required.",
                        alphanumeric: "Only letters and numbers are allowed"
                    },
                    email: {
                        required: "Email is required.",
                        email: "Enter a valid email."
                    },
                    contact_number: { required: "Contact number is required.", phoneValidation: "Enter a valid phone number format (e.g., +91 9876543210, 9876543210, 123-456-7890)." },
                    postcode: {
                        required: "Postcode is required.",
                        digits: "Only digits are allowed.",
                        minlength: "Must be 6 digits.",
                        maxlength: "Must be 6 digits."
                    },
                    password: { 
                required: "Password is required.", 
                minlength: "Password must be at least 8 characters.",
                strongPassword: "Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character."
            },
            password_confirmation: { 
                required: "Confirm your password.", 
                equalTo: "Passwords do not match." 
            },
                    gender: {
                        required: "Select a gender."
                    },
                    "hobbies[]": {
                        required: "Select at least one hobby."
                    },
                    "roles[]": {
                        required: "Select at least one role."
                    },
                    state_id: {
                        required: "Select a state."
                    },
                    city_id: {
                        required: "Select a city."
                    },
                    "files[]": {
                        required: "Please upload at least one file."
                    }
                }
            });


   // Custom phone number validation method
   $.validator.addMethod("phoneValidation", function (value, element) {
    return this.optional(element) || /^(?!0{10})(\+?\d{1,3}[-.\s]?)?\d{10}$/.test(value);
}, "Enter a valid phone number format.");


            // Custom validation method for alphanumeric fields
            $.validator.addMethod("alphanumeric", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
            }, "Only letters and numbers are allowed.");

            // Handle dynamic City dropdown based on State selection
            $('#state').change(function() {
                let state_id = $(this).val();
                $('#city').html('<option value="">Loading...</option>');

                $.ajax({
                    url: '/cities/' + state_id,
                    type: 'GET',
                    success: function(data) {
                        let options = '<option value="">Select City</option>';
                        data.forEach(city => {
                            options +=
                                `<option value="${city.id}">${city.name}</option>`;
                        });
                        $('#city').html(options);
                    },
                    error: function() {
                        alert("Error fetching cities.");
                    }
                });
            });

            $('#userForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Validate the form before submitting via AJAX
        if (!$("#userForm").valid()) {
            return;
        }

        var formData = new FormData(this); // Create FormData object
        $('#submitBtn').prop('disabled', true).text('Submitting...');

        $.ajax({
            url: "/users", // Adjust URL as needed (Laravel Route)
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
    $('#formErrors').html('<div class="alert alert-success">User created successfully!</div>');

    // Show a Toastr success notification
    toastr.success("User created successfully!", "Success");

    // Redirect after 2 seconds
    setTimeout(function() {
        window.location.href = "{{ route('users.index') }}";
    }, 1000);
},

            error: function(xhr) {
                $('#submitBtn').prop('disabled', false).text('Submit');

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value + '</li>';
                        toastr.error(value, "Error"); // Show Toastr error for each validation error
                    });
                    errorHtml += '</ul></div>';
                    $('#formErrors').html(errorHtml);
                } else {
                    toastr.error("An unexpected error occurred. Please try again.", "Error");
                }
            }
        });
    });
});
    </script>
@endsection
