<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In | {{ env('APP_NAME') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .login-content {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .auth-logo img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .custom-control-label {
            font-size: 14px;
        }

        .text-primary {
            color: #007bff !important;
            transition: color 0.3s ease;
        }

        .text-primary:hover {
            color: #0056b3 !important;
        }

        .alert {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <!-- Loader Start -->
    <div id="loading">
        <div id="loading-center"></div>
    </div>
    <!-- Loader End -->

    <div class="wrapper">
        <section class="login-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="auth-logo">
                                    <img src="{{ asset('assets/images/taekwondo_light.png') }}" alt="logo">
                                </div>
                                <h2 class="mb-3">Welcome Back</h2>
                                <p class="mb-4">Sign in to continue to {{ env('APP_NAME') }}.</p>
                                <form>
                                    <div id="alert-container" class="mb-3"></div>
                                    <div class="form-group text-left">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="admin@example.com">
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="********">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                        </div>
                                        {{-- <a href="#" class="text-primary">Forgot Password?</a> --}}
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Scripts -->
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

            $("form").on("submit", function(e) {
                e.preventDefault();

                $(".form-control").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                const email = $("input[name=email]").val();
                const password = $("input[name=password]").val();

                $.ajax({
                    url: "{{ route('signin') }}",
                    method: "POST",
                    data: {
                        email: email,
                        password: password,
                    },
                    beforeSend: function() {
                        $("button[type=submit]").attr("disabled", true).text("Signing In...");
                    },
                    success: function(response) {
                        showDatumAlert('success', response.message);
                        setTimeout(() => {
                            window.location.href =
                                '{{ route('isUsingDefaultPassword') }}';
                        }, 1000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (const field in errors) {
                                const input = $(`input[name=${field}]`);
                                input.addClass("is-invalid");
                                input.after(
                                    `<div class="invalid-feedback">${errors[field][0]}</div>`
                                );
                            }
                        } else {
                            showDatumAlert('danger', xhr.responseJSON?.message ||
                                'Something went wrong.');
                        }
                    },
                    complete: function() {
                        $("button[type=submit]").attr("disabled", false).text("Sign In");
                    }
                });
            });
        });
    </script>
</body>

</html>
