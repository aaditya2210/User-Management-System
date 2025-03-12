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



                      {{-- Role (Read-Only) --}}
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" value="{{ $user->getRoleNames()->first() ?? 'No Role Assigned' }}" readonly>
                    </div>

                    {{-- Hobbies --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hobbies</label><br>
                        @php
                            $userHobbies = json_decode($user->hobbies, true) ?? [];
                        @endphp
                        @foreach(['Reading', 'Sports', 'Music'] as $hobby)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{ $hobby }}" 
                                    {{ in_array($hobby, $userHobbies) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $hobby }}</label>
                            </div>
                        @endforeach
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
                            {{-- <div class="mt-2">
                                <strong>Previously Uploaded Files:</strong>
                                <ul>
                                    @foreach (json_decode($user->uploaded_files, true) as $file)
                                        <li><a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a></li>
                                    @endforeach
                                </ul>
                            </div> --}}



                            <div class="mt-2">
                                <strong>Previously Uploaded Files:</strong>
                                <div class="file-preview-container">
                                    @foreach (json_decode($user->uploaded_files, true) as $file)
                                        @php
                                            $filePath = asset('storage/' . $file);
                                            $fileName = basename($file);
                                            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                        @endphp
                            
                                        @if (in_array(strtolower($fileExtension), $imageExtensions))
                                            {{-- Display Image Preview --}}
                                            <img src="{{ $filePath }}" alt="{{ $fileName }}" class="preview-image" onclick="openModal('{{ $filePath }}')" />
                                        @else
                                            {{-- Display File Link with Icon --}}
                                            <a href="{{ $filePath }}" target="_blank" class="file-link">
                                                <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="File" class="file-icon">
                                                {{ $fileName }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>


                            
                        @endif
                    </div>


{{-- Modal for Enlarged Image --}}
<div id="imageModal" class="modal" onclick="closeModal()">
    <span class="close">&times;</span>
    <img class="modal-content" id="expandedImg">
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


{{-- Styles --}}
<style>
    .file-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .preview-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .preview-image:hover {
        transform: scale(1.1);
    }
    .file-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #000;
        font-size: 14px;
    }
    .file-icon {
        width: 40px;
        height: 40px;
        margin-right: 5px;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        text-align: center;
    }
    .modal-content {
        max-width: 90%;
        max-height: 90%;
        margin-top: 5%;
        border-radius: 10px;
    }
    .close {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 40px;
        font-weight: bold;
        color: white;
        cursor: pointer;
    }
</style>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
<script>
   $(document).ready(function() {

// Custom phone number validation method
$.validator.addMethod("phoneValidation", function (value, element) {
    return this.optional(element) || /^(?!0{10})(\+?\d{1,3}[-.\s]?)?\d{10}$/.test(value);
}, "Enter a valid phone number format.");

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
            phoneValidation: true // Custom method for phone validation
        },
        postcode: {
            required: true,
            digits: true,
            minlength: 6,
            maxlength: 6
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
            required: "Contact number is required.", 
            phoneValidation: "Enter a valid phone number format (e.g., +91 9876543210, 9876543210, 123-456-7890)." 
        },
        postcode: {
            required: "Please enter the postcode",
            digits: "Please enter only digits",
            minlength: "Postcode must be at least 6 digits long",
            maxlength: "Postcode must be no more than 6 digits long"
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

        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent()); // If inside an input group
        } else {
            error.insertAfter(element); // Insert directly after the field
        }
    },
    highlight: function(element) {
        $(element).addClass('is-invalid').removeClass('is-valid');
        $(element).closest('.form-group').find('.invalid-feedback').show();
    },
    unhighlight: function(element) {
        $(element).removeClass('is-invalid').addClass('is-valid');
        $(element).closest('.form-group').find('.invalid-feedback').hide();
    },
    submitHandler: function(form) {
        console.log("Form is valid, submitting via AJAX...");
        
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
                }, 1000); // Redirect after 1 second
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

                // **Select the correct city after the dropdown is populated**
                var selectedCity = "{{ $user->city_id }}";
                if (selectedCity) {
                    $('#city_id').val(selectedCity).change();
                }
            }
        });
    } else {
        $('#city_id').empty().append('<option value="">Select City</option>');
    }
});

// **Trigger state change after document is fully loaded**
var selectedState = $('#state_id').val();
if (selectedState) {
    $('#state_id').trigger('change'); // This will populate the city dropdown
}

});

// Image Modal Functions
function openModal(imageSrc) {
document.getElementById("expandedImg").src = imageSrc;
document.getElementById("imageModal").style.display = "block";
}

function closeModal() {
document.getElementById("imageModal").style.display = "none";
}

</script>
@endsection