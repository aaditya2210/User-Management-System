@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Login</div>
                <div class="card-body">
                    <form id="loginForm">
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
                    </form>

                    <p class="text-center mt-2">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login Success Modal -->
<div class="modal fade" id="loginSuccessModal" tabindex="-1" role="dialog" aria-labelledby="loginSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginSuccessModalLabel">Login Successful</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                You have successfully logged in!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="continueButton">Continue</button>
            </div>
        </div>
    </div>
</div>

<!-- Login Failure Modal -->
<div class="modal fade" id="loginFailureModal" tabindex="-1" role="dialog" aria-labelledby="loginFailureModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginFailureModalLabel">Login Failed</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loginFailureMessage">
                <!-- Error message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $("#loginForm").submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: "/login",
            method: "POST",
            data: {
                email: $("#email").val(),
                password: $("#password").val(),
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.access_token) {
                    // Store access token in local storage
                    localStorage.setItem("access_token", response.access_token);

                    // Show the login success modal
                    $('#loginSuccessModal').modal('show');
                }
            },
            error: function (xhr) {
                // Show the login failure modal with the error message
                $('#loginFailureMessage').text("Login failed: " + xhr.responseJSON.error);
                $('#loginFailureModal').modal('show');
            }
        });
    });

    // Redirect to the users page when the continue button is clicked
    $('#continueButton').click(function() {
        window.location.href = "/users";
    });
</script>
@endsection