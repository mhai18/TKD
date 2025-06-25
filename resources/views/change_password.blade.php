<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Change Password | {{ env('APP_NAME') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .auth-logo img {
            max-width: 120px;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 0.375rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .text-center h2 {
            font-weight: 600;
            color: #343a40;
        }

        .text-center p {
            color: #6c757d;
        }

        #alert-container .alert {
            border-radius: 0.375rem;
        }
    </style>
</head>

<body>
    <div id="loading">
        <div id="loading-center"></div>
    </div>

    <div class="wrapper">
        <section class="login-content">
            <div class="container h-100">
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="auth-logo text-center">
                                    <img src="{{ asset('assets/images/taekwondo_light.png') }}" class="img-fluid rounded-normal" alt="logo">
                                </div>
                                <h2 class="mb-3 text-center">Change Password</h2>
                                <p class="text-center mb-4">Enter your new password below to secure your account.</p>

                                <form id="change-password-form">
                                    <div id="alert-container" class="mb-3"></div>

                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input id="password" class="form-control" type="password" name="password" placeholder="Enter new password">
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Confirm new password">
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Update Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('signin') }}" class="text-muted">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS Assets -->
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        function showDatumAlert(type, message) {
            $('#alert-container').html(`
                <div class="alert text-white bg-${type}" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-${type === 'success' ? 'checkbox-circle-line' : 'error-warning-line'}"></i>
                    </div>
                    <div class="iq-alert-text">${message}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            `);
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#change-password-form').on('submit', function(e) {
                e.preventDefault();

                $(".form-control").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                const formData = {
                    password: $("input[name=password]").val(),
                    password_confirmation: $("input[name=password_confirmation]").val()
                };

                $.ajax({
                    url: "{{ route('changePassword') }}",
                    method: "POST",
                    data: formData,
                    beforeSend: function() {
                        $("button[type=submit]").attr("disabled", true).text("Updating...");
                    },
                    success: function(response) {
                        showDatumAlert('success', response.message || 'Password changed successfully!');
                        setTimeout(() => {
                            window.location.href = '{{ route('userDashboard') }}';
                        }, 1000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (const field in errors) {
                                const input = $(`input[name=${field}]`);
                                input.addClass("is-invalid");
                                input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                            }
                        } else {
                            showDatumAlert('danger', xhr.responseJSON?.message || 'Something went wrong.');
                        }
                    },
                    complete: function() {
                        $("button[type=submit]").attr("disabled", false).text("Update Password");
                    }
                });
            });
        });
    </script>
</body>

</html>
