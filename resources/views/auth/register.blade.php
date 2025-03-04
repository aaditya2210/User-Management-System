@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="card">
    <div class="card-header">Register</div>
    <div class="card-body">
        <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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
                <label>State:</label>
                <select name="state_id" id="state" class="form-control" required>
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger error"></span>
            </div>

            <div class="mb-3">
                <label>City:</label>
                <select name="city_id" id="city" class="form-control" required>
                    <option value="">Select City</option>
                </select>
                <span class="text-danger error"></span>
            </div>

            {{-- <div class="mb-3">
                <label>Roles:</label>
                <select name="roles[]" class="form-control" multiple required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger error"></span>
            </div> --}}
            


            <div class="mb-3">
                <label>Roles:</label>
                <input type="text" id="roleSearch" class="form-control" placeholder="Search roles...">
                <select name="roles[]" id="roleSelect" class="form-control" multiple required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
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
                <label>Upload Files:</label>
                <input type="file" name="files[]" multiple class="form-control">
                <span class="text-danger error"></span>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>


<!-- Include Toastr CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>


document.getElementById('roleSearch').addEventListener('input', function () {
        let filter = this.value.toLowerCase();
        let options = document.getElementById('roleSelect').options;
        
        for (let option of options) {
            let text = option.text.toLowerCase();
            option.style.display = text.includes(filter) ? "" : "none";
        }
    });




    $(document).ready(function () {
        $("#registerForm").validate({
            errorElement: 'span',
            errorClass: 'text-danger',
            rules: {
                first_name: { required: true, alphanumeric: true },
                last_name: { required: true, alphanumeric: true },
                email: { required: true, email: true },
                contact_number: { required: true, digits: true, minlength: 10, maxlength: 10 },
                postcode: { required: true, digits: true, minlength: 6, maxlength: 6 },
                password: { required: true, minlength: 6 },
                password_confirmation: { required: true, equalTo: "#password" },
                gender: { required: true },
                "roles[]": { required: true },
                "hobbies[]": { required: true, minlength: 1 },
                state_id: { required: true },
                city_id: { required: true },
                "uploaded_files[]": { required: true }
            },
            messages: {
                first_name: { required: "First name is required.", alphanumeric: "Only letters and numbers are allowed" },
                last_name: { required: "Last name is required.", alphanumeric: "Only letters and numbers are allowed" },
                email: { required: "Email is required.", email: "Enter a valid email." },
                contact_number: { required: "Contact number is required.", digits: "Only digits are allowed.", minlength: "Must be 10 digits.", maxlength: "Must be 10 digits." },
                postcode: { required: "Postcode is required.", digits: "Only digits are allowed.", minlength: "Must be 6 digits.", maxlength: "Must be 6 digits." },
                password: { required: "Password is required.", minlength: "Password must be at least 6 characters." },
                password_confirmation: { required: "Confirm your password.", equalTo: "Passwords do not match." },
                gender: { required: "Select a gender." },
                "roles[]": { required: "Select at least one role." },
                "hobbies[]": { required: "Select at least one hobby." },
                state_id: { required: "Select a state." },
                city_id: { required: "Select a city." },
                "uploaded_files[]": { required: "Please upload at least one file." }
            }
        });

        $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
        }, "Only letters and numbers are allowed.");

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

         // Toastr notifications
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
    });
</script>
@endsection
