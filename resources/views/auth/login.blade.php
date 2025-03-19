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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

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
                    localStorage.setItem("access_token", response.access_token);
                    toastr.success("Login successful!");
                    setTimeout(() => {
                        // window.location.href = "/users";
                        window.location.href = "/dashboard";
                    }, 1500);
                }
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON.error || "Invalid credentials");
            }
        });
    });
</script>
@endsection
