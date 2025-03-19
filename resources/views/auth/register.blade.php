@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left side image section -->
        <div class="col-lg-5 d-none d-lg-flex bg-primary p-0">
            <div class="register-banner w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-5">
                <h1 class="display-4 font-weight-bold mb-4">User Management System</h1>
                <p class="lead mb-5">Create your account to get started with our comprehensive user management solution</p>
                <div class="banner-image">
                    <!-- SVG illustration for registration -->
                    <svg width="400" height="300" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100%" height="100%" fill="none"/>
                        <circle cx="300" cy="150" r="100" fill="rgba(255,255,255,0.2)"/>
                        <path d="M200,250 C200,180 400,180 400,250" stroke="rgba(255,255,255,0.5)" stroke-width="10" fill="none"/>
                        <circle cx="300" cy="120" r="40" fill="#ffffff"/>
                        <rect x="250" y="300" width="100" height="30" rx="5" fill="rgba(255,255,255,0.8)"/>
                        <rect x="230" y="340" width="140" height="20" rx="5" fill="rgba(255,255,255,0.6)"/>
                        <rect x="270" y="370" width="60" height="20" rx="5" fill="rgba(255,255,255,0.4)"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Right side registration form -->
        <div class="col-lg-7 d-flex align-items-center justify-content-center py-5">
            <div class="card border-0 shadow-lg mx-auto" style="max-width: 800px; width: 100%;">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="font-weight-bold">Create Your Account</h2>
                        <p class="text-muted">Fill in your information to get started</p>
                    </div>
                    
                    <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Personal Information Section -->
                            <div class="col-12">
                                <h5 class="text-primary font-weight-bold mb-3">Personal Information</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">FIRST NAME</label>
                                    <input type="text" name="first_name" class="form-control bg-light" required>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">LAST NAME</label>
                                    <input type="text" name="last_name" class="form-control bg-light" required>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">EMAIL ADDRESS</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                        </div>
                                        <input type="email" name="email" class="form-control bg-light border-left-0" required>
                                    </div>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">CONTACT NUMBER</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0">
                                                <i class="fas fa-phone text-muted"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="contact_number" class="form-control bg-light border-left-0" required>
                                    </div>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">GENDER</label>
                                    <div class="bg-light p-2 rounded">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="male" name="gender" value="male" class="custom-control-input" required>
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="female" name="gender" value="female" class="custom-control-input">
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <!-- Location Section -->
                            <div class="col-12 mt-3">
                                <h5 class="text-primary font-weight-bold mb-3">Location Details</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">POSTCODE</label>
                                    <input type="text" name="postcode" class="form-control bg-light" required>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">STATE</label>
                                    <select name="state_id" id="state" class="form-control bg-light" required>
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">CITY</label>
                                    <select name="city_id" id="city" class="form-control bg-light" required>
                                        <option value="">Select City</option>
                                    </select>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <!-- Account Section -->
                            <div class="col-12 mt-3">
                                <h5 class="text-primary font-weight-bold mb-3">Account Security</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">PASSWORD</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" id="password" class="form-control bg-light border-left-0" required>
                                    </div>
                                    <small class="form-text text-muted">Must include uppercase, lowercase, number and special character</small>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">CONFIRM PASSWORD</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="password_confirmation" class="form-control bg-light border-left-0" required>
                                    </div>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <!-- Additional Information Section -->
                            <div class="col-12 mt-3">
                                <h5 class="text-primary font-weight-bold mb-3">Additional Information</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">ROLES</label>
                                    <div class="mb-2">
                                        <input type="text" id="roleSearch" class="form-control bg-light" placeholder="Search roles...">
                                    </div>
                                    <select name="roles[]" id="roleSelect" class="form-control bg-light" multiple required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label text-muted font-weight-bold small">HOBBIES</label>
                                    <div class="bg-light p-2 rounded">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input" id="reading" name="hobbies[]" value="Reading">
                                            <label class="custom-control-label" for="reading">Reading</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input" id="sports" name="hobbies[]" value="Sports">
                                            <label class="custom-control-label" for="sports">Sports</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="music" name="hobbies[]" value="Music">
                                            <label class="custom-control-label" for="music">Music</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="form-label text-muted font-weight-bold small">UPLOAD FILES</label>
                                    <div class="custom-file">
                                        <input type="file" name="files[]" multiple class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose files</label>
                                    </div>
                                    <span class="text-danger error"></span>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-2">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="termsCheckbox">
                                    <label class="custom-control-label text-muted" for="termsCheckbox">
                                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-2">Create Account</button>
                                <div class="mt-3">
                                    <span class="text-muted">Already have an account?</span> <a href="{{ route('login') }}" class="text-primary font-weight-bold">Sign In</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fonts and Icons -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Bootstrap and Toastr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    .register-banner {
        background-color: #2563eb;
        background-image: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    }
    .btn-primary {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    .btn-primary:hover {
        background-color: #1d4ed8;
        border-color: #1d4ed8;
    }
    .text-primary {
        color: #2563eb !important;
    }
    .form-control {
        padding: .6rem .75rem;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        border-color: #93c5fd;
    }
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    select[multiple] {
        height: 120px;
    }
    .custom-file-label::after {
        background-color: #e9ecef;
        color: #495057;
    }
</style>

<!-- jQuery, Bootstrap, Validate and Toastr scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        // Configure toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000"
        };
        
        // File input enhancement
        $(".custom-file-input").on("change", function() {
            var fileCount = $(this)[0].files.length;
            var label = fileCount > 1 ? fileCount + " files selected" : $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(label);
        });
        
        // Role search functionality
        document.getElementById('roleSearch').addEventListener('input', function () {
            let filter = this.value.toLowerCase();
            let options = document.getElementById('roleSelect').options;
            
            for (let option of options) {
                let text = option.text.toLowerCase();
                option.style.display = text.includes(filter) ? "" : "none";
            }
        });
        
        // City dropdown loading based on state selection
        $('#state').change(function () {
            let state_id = $(this).val();
            $('#city').html('<option value="">Loading...</option>');
            $.get('/cities/' + state_id, function (data) {
                let options = '<option value="">Select City</option>';
                data.forEach(city => {
                    options += `<option value="${city.id}">${city.name}</option>`;
                });
                $('#city').html(options);
            });
        });
        
        // Form validation
        $("#registerForm").validate({
            errorElement: 'span',
            errorClass: 'text-danger',
            rules: {
                first_name: { required: true, alphanumeric: true },
                last_name: { required: true, alphanumeric: true },
                email: { required: true, email: true },
                contact_number: { required: true, phoneValidation: true },
                postcode: { required: true, digits: true, minlength: 6, maxlength: 6 },
                password: { required: true, minlength: 8, strongPassword: true },
                password_confirmation: { required: true, equalTo: "#password" },
                gender: { required: true },
                "roles[]": { required: true },
                "hobbies[]": { required: true, minlength: 1 },
                state_id: { required: true },
                city_id: { required: true }
            },
            messages: {
                first_name: { required: "First name is required.", alphanumeric: "Only letters and numbers are allowed" },
                last_name: { required: "Last name is required.", alphanumeric: "Only letters and numbers are allowed" },
                email: { required: "Email is required.", email: "Enter a valid email." },
                contact_number: { required: "Contact number is required.", phoneValidation: "Enter a valid phone number format (e.g., +91 9876543210, 9876543210, 123-456-7890)." },
                postcode: { required: "Postcode is required.", digits: "Only digits are allowed.", minlength: "Must be 6 digits.", maxlength: "Must be 6 digits." },
                password: { required: "Password is required.", minlength: "Password must be at least 8 characters.", strongPassword: "Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character." },
                password_confirmation: { required: "Confirm your password.", equalTo: "Passwords do not match." },
                gender: { required: "Select a gender." },
                "roles[]": { required: "Select at least one role." },
                "hobbies[]": { required: "Select at least one hobby." },
                state_id: { required: "Select a state." },
                city_id: { required: "Select a city." }
            },
            highlight: function(element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {
                    error.appendTo(element.closest(".form-group"));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Custom validation methods
        $.validator.addMethod("strongPassword", function (value, element) {
            return this.optional(element) || 
                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
        }, "Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.");

        $.validator.addMethod("phoneValidation", function (value, element) {
            return this.optional(element) || /^(?!0{10})(\d{10}|\+91\d{10})$/.test(value);
        }, "Enter a valid phone number (10 digits or +91 format).");

        $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
        }, "Only letters and numbers are allowed.");

        // Display toastr notifications
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });
</script>
@endsection