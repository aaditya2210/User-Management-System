@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Edit User</h4>
        </div>
        <div class="card-body">
            {{-- Display Validation Errors --}}
            <div id="formErrors"></div>

            {{-- Edit User Form --}}
            <form id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- First Name --}}
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                    </div>

                    {{-- Last Name --}}
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    {{-- Contact Number --}}
                    <div class="col-md-6 mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" id="contact_number" value="{{ old('contact_number', $user->contact_number) }}" required>
                    </div>

                    {{-- Postcode --}}
                    <div class="col-md-6 mb-3">
                        <label for="postcode" class="form-label">Postcode</label>
                        <input type="text" name="postcode" class="form-control" id="postcode" value="{{ old('postcode', $user->postcode) }}" required>
                    </div>

                    {{-- Gender --}}
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" class="form-control" id="gender" required>
                            <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    {{-- State Dropdown --}}
                    <div class="col-md-6 mb-3">
                        <label for="state_id" class="form-label">State</label>
                        <select name="state_id" id="state_id" class="form-control" required>
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" {{ $user->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- City Dropdown --}}
                    <div class="col-md-6 mb-3">
                        <label for="city_id" class="form-label">City</label>
                        <select name="city_id" id="city_id" class="form-control" required>
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- File Uploads --}}
                    <div class="col-md-12 mb-3">
                        <label for="files" class="form-label">Upload Files</label>
                        <input type="file" name="files[]" class="form-control" id="files" multiple>
                        @if (!empty(json_decode($user->uploaded_files, true)))
                            <div class="mt-2">
                                <strong>Previously Uploaded Files:</strong>
                                <ul>
                                    @foreach (json_decode($user->uploaded_files, true) as $file)
                                        <li><a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle form submission via AJAX
        $('#editUserForm').validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                contact_number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 15
                },
                postcode: {
                    required: true,
                    digits: true,
                    minlength: 5,
                    maxlength: 10
                },
                gender: {
                    required: true
                },
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                }
            },
            messages: {
                first_name: {
                    required: "Please enter the first name",
                    minlength: "First name must be at least 2 characters long"
                },
                last_name: {
                    required: "Please enter the last name",
                    minlength: "Last name must be at least 2 characters long"
                },
                email: {
                    required: "Please enter the email",
                    email: "Please enter a valid email address"
                },
                contact_number: {
                    required: "Please enter the contact number",
                    digits: "Please enter only digits",
                    minlength: "Contact number must be at least 10 digits long",
                    maxlength: "Contact number must be no more than 15 digits long"
                },
                postcode: {
                    required: "Please enter the postcode",
                    digits: "Please enter only digits",
                    minlength: "Postcode must be at least 5 digits long",
                    maxlength: "Postcode must be no more than 10 digits long"
                },
                gender: {
                    required: "Please select the gender"
                },
                state_id: {
                    required: "Please select the state"
                },
                city_id: {
                    required: "Please select the city"
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
                var formData = new FormData(form);
                formData.append('_method', 'PUT'); // Laravel requires PUT for updates

                $.ajax({
                    url: "{{ route('users.update', $user->id) }}",
                    type: "POST", // Always POST when using FormData with `_method`
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#formErrors').html('<div class="alert alert-success">User updated successfully!</div>');

                        setTimeout(function() {
                            window.location.href = "{{ route('users.index') }}"; // Redirect after success
                        }, 1000); // Redirect after 2 seconds
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('#formErrors').html(errorHtml);
                        } else {
                            $('#formErrors').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                        }
                    }
                });
            }
        });

        // Handle state-city dynamic dropdown
        $('#state_id').on('change', function() {
            var stateId = $(this).val();
            if (stateId) {
                $.ajax({
                    url: "{{ route('get.cities') }}",
                    type: "GET",
                    data: { state_id: stateId },
                    success: function(response) {
                        $('#city_id').empty().append('<option value="">Select City</option>');
                        $.each(response, function(key, city) {
                            $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                });
            } else {
                $('#city_id').empty().append('<option value="">Select City</option>');
            }
        });

        // Trigger change event on page load if editing a user
        var selectedState = $('#state_id').val();
        if (selectedState) {
            $('#state_id').trigger('change');
        }
    });
</script>
@endsection