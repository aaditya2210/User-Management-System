@extends('layouts.app')

@section('content')
    <h2>Add Supplier</h2>

    <form id="supplierForm">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="contact_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>GST Number</label>
            <input type="text" name="gst_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Website</label>
            <input type="url" name="website" class="form-control" required>
        </div>

        {{-- <div class="form-group">
            <label>Country</label>
            <input type="text" name="country" class="form-control" required>
        </div> --}}

        {{-- <div class="form-group">
            <label>State</label>
            <input type="text" name="state" class="form-control" required>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control" required>
        </div> --}}
        

        <label for="state">State</label>
        <select name="state_id" id="state" class="form-control" required>
            <option value="">Select State</option>
            @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
            @endforeach
        </select>
        
        <label for="city">City</label>
        <select name="city_id" id="city" class="form-control" required>
            <option value="">Select City</option>
        </select>
        


        <div class="form-group">
            <label>Postal Code</label>
            <input type="text" name="postal_code" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Contact Person</label>
            <input type="text" name="contact_person" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label>Contract Start Date</label>
            <input type="date" name="contract_start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Contract End Date</label>
            <input type="date" name="contract_end_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <style>
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-control.error {
            border-color: red;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#state').change(function () {
    let state_id = $(this).val();
    $('#city').html('<option value="">Loading...</option>');

    $.ajax({
        url: '/get-cities/' + state_id, // Ensure correct route
        type: 'GET',
        dataType: 'json',  // ✅ Forces jQuery to parse as JSON
        success: function (data) {
            console.log("API Response:", data); // Debugging log

            if (!Array.isArray(data)) {
                console.error("Invalid response format:", data);
                alert("Unexpected response format.");
                return;
            }

            let options = '<option value="">Select City</option>';
            data.forEach(city => {
                options += `<option value="${city.id}">${city.name}</option>`;
            });

            $('#city').html(options);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("Error fetching cities.");
        }
    });
});


            // Apply jQuery validation
            $("#supplierForm").validate({
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
                phoneValidation: true // Custom method for phone validation
            },
                    address: {
                        required: true
                    },
                    company_name: {
                        required: true
                    },
                    gst_number: {
                        required: true,
                        minlength: 15,
                        maxlength: 15
                    },
                    website: {
                        required: true,
                        url: true
                    },
                    // country: {
                    //     required: true
                    // },
                    state_id: {
                        required: true
                    },
                    city_id: {
                        required: true
                    },
                    postal_code: {
                        required: true,
                        digits: true,
                        minlength: 5,
                        maxlength: 6
                    },
                    contact_person: {
                        required: true
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
                    contact_number: { required: "Contact number is required.", phoneValidation: "Enter a valid phone number format (e.g., +91 9876543210, 9876543210, 123-456-7890)." },

                    address: {
                        required: "Please enter the address",
                        minlength: "Address must be at least 5 characters long"
                    },
                    company_name: {
                        required: "Please enter the company name",
                        minlength: "Company name must be at least 2 characters long"
                    },
                    gst_number: {
                        required: "Please enter the gst number ",
                        minlength: "Enter a valid GST Number (15 characters)",
                        maxlength: "Enter a valid GST Number (15 characters)"
                    },
                    website: {
                        required:  "Enter a valid URL"
                    },
                    // country: {
                    //     required: "Please enter country"
                    // },
                    state_id: {
                        required: "Please enter state"
                    },
                    city_id: {
                        required: "Please enter city"
                    },
                    postal_code: {
                        required: "Please enter postal code",
                        digits: "Please enter only digits",
                        minlength: "Please enter a 6 digits only",
                        maxlength: "Please enter a 6 digits only",
                    },
                    contact_person: {
                        required: "Please enter contact person name"
                    },
                    status: {
                        required: "Please select the status"
                    },
                    contract_start_date: {
                        required: "Select a start date"
                    },
                    contract_end_date: {
                         required: "Select a end date"
                    },
                   
                },



                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("error");
                },
                unhighlight: function(element) {
                    $(element).removeClass("error");
                },
                submitHandler: function(form) {
                    let formData = $(form).serialize(); // Serialize form data
                    let token = localStorage.getItem("access_token"); // Retrieve token

                    $.ajax({
                        url: "/api/suppliers",
                        method: "POST",
                        data: formData,
                        headers: {
                            'Authorization': "Bearer " + token,
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            $('#formErrors').html(
                                '<div class="alert alert-success">Supplier created successfully!</div>'
                                );

                            // Show a Toastr success notification
                            toastr.success("Supplier created successfully!", "Success");

                            // Redirect after 2 seconds
                            setTimeout(function() {
                                window.location.href = "{{ route('suppliers.index') }}";
                            }, 1000);
                        },

        //                 error: function(xhr) {
        //                     $('#submitBtn').prop('disabled', false).text('Submit');

        //                     if (xhr.responseJSON && xhr.responseJSON.errors) {
        //                         var errors = xhr.responseJSON.errors;
        //                         var errorHtml = '<div class="alert alert-danger"><ul>';
        //                         $.each(errors, function(key, value) {
        //                             errorHtml += '<li>' + value + '</li>';
        //                             toastr.error(value,
        //                             "Error"); // Show Toastr error for each validation error
        //                         });
        //                         errorHtml += '</ul></div>';
        //                         $('#formErrors').html(errorHtml);
        //                     } else {
        //                         toastr.error(
        //                             "An unexpected error occurred. Please try again.",
        //                             "Error");
        //                     }
        //                 }


        //             });
        //         }
        //     });
        // });


        error: function(xhr) {
    console.error("XHR Error:", xhr);
    console.log("Response Text:", xhr.responseText); // Log response

    $('#submitBtn').prop('disabled', false).text('Submit');

    if (xhr.responseJSON && xhr.responseJSON.errors) {
        var errors = xhr.responseJSON.errors;
        var errorHtml = '<div class="alert alert-danger"><ul>';
        $.each(errors, function(key, value) {
            errorHtml += '<li>' + value + '</li>';
            toastr.error(value, "Error");
        });
        errorHtml += '</ul></div>';
        $('#formErrors').html(errorHtml);
    } else {
        toastr.error("An unexpected error occurred: " + xhr.statusText, "Error");
    }
}
});
}
});
});
    </script>
@endsection
