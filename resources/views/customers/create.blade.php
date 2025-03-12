@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Customer</h2>

        <form id="createCustomerForm" action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Contact Number:</label>
                <input type="text" name="contact_number" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Address:</label>
                <textarea name="address" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Company Name:</label>
                <input type="text" name="company_name" class="form-control">
            </div>

            <div class="form-group">
                <label>Job Title:</label>
                <input type="text" name="job_title" class="form-control">
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <select name="gender" class="form-control">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="date_of_birth" class="form-control">
            </div>

            <div class="form-group">
                <label>Nationality:</label>
                <input type="text" name="nationality" class="form-control">
            </div>

            <div class="form-group">
                <label>Customer Type:</label>
                <select name="customer_type" class="form-control">
                    <option value="Regular">Regular</option>
                    <option value="VIP">VIP</option>
                    <option value="Corporate">Corporate</option>
                </select>
            </div>

            <div class="form-group">
                <label>Notes:</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Preferred Contact Method:</label>
                <select name="preferred_contact_method" class="form-control">
                    <option value="Email">Email</option>
                    <option value="Phone">Phone</option>
                    <option value="WhatsApp">WhatsApp</option>
                </select>
            </div>

            <div class="form-group">
                <label>Newsletter Subscription:</label>
                <select name="newsletter_subscription" class="form-control">
                    <option value="1">Subscribed</option>
                    <option value="0">Not Subscribed</option>
                </select>
            </div>

            <div class="form-group">
                <label>Account Balance ($):</label>
                <input type="number" step="0.01" name="account_balance" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
     $(document).ready(function() {
    // ✅ Custom phone number validation method (placed outside)
    $.validator.addMethod("phoneValidation", function(value, element) {
        return this.optional(element) || /^(?!0{10})(\+?\d{1,3}[-.\s]?)?\d{10}$/.test(value);
    }, "Enter a valid phone number format.");

    $('#createCustomerForm').validate({
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
                phoneValidation: true // ✅ Custom validation now works correctly
            },
            address: {
                required: true,
                minlength: 5
            },
            company_name: {
                required: true,
                minlength: 2
            },
            job_title: {
                required: true,
                minlength: 2
            },
            gender: {
                required: true
            },
            date_of_birth: {
                required: true,
                date: true
            },
            nationality: {
                required: true,
                minlength: 2
            },
            customer_type: {
                required: true
            },
            notes: {
                required: true,
                minlength: 5
            },
            preferred_contact_method: {
                required: true
            },
            newsletter_subscription: {
                required: true
            },
            account_balance: {
                required: true,
                number: true,
                min: 0
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
                required: "Contact number is required.",
                phoneValidation: "Enter a valid phone number format (e.g., +91 9876543210, 9876543210, 123-456-7890)."
            },
            address: {
                required: "Please enter the address",
                minlength: "Address must be at least 5 characters long"
            },
            company_name: {
                required: "Please enter the company name",
                minlength: "Company name must be at least 2 characters long"
            },
            job_title: {
                required: "Please enter the job title",
                minlength: "Job title must be at least 2 characters long"
            },
            gender: {
                required: "Please select the gender"
            },
            date_of_birth: {
                required: "Please enter the date of birth",
                date: "Please enter a valid date"
            },
            nationality: {
                required: "Please enter the nationality",
                minlength: "Nationality must be at least 2 characters long"
            },
            customer_type: {
                required: "Please select the customer type"
            },
            notes: {
                required: "Please enter the notes",
                minlength: "Notes must be at least 5 characters long"
            },
            preferred_contact_method: {
                required: "Please select the preferred contact method"
            },
            newsletter_subscription: {
                required: "Please select the newsletter subscription status"
            },
            account_balance: {
                required: "Please enter the account balance",
                number: "Please enter a valid number",
                min: "Account balance cannot be negative"
            }
        },

        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form) {
            $.ajax({
                url: $(form).attr('action'),
                method: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    toastr.success('Customer created successfully!');
                    setTimeout(function() {
                        window.location.href = "{{ route('customers.index') }}";
                    }, 2000);
                },
                error: function(xhr) {
                    toastr.error('An error occurred while creating the customer.');
                }
            });
        }
    });
});
    </script>
@endsection
