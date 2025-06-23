<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Password Reset</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/bfp.webp') }}" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />


    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0') }}" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=2.0.0') }}" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark.min.css') }}" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css') }}" />
</head>

<body class="theme-color-red light" data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0"
    tabindex="0">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <a href="#" class="navbar-brand d-flex align-items-center mb-3">
                                        <!--Logo start-->
                                        <!--logo End-->

                                        <!--Logo start-->
                                        <div class="logo-main">
                                            <div class="logo-normal">
                                                <img src="{{ asset('img/bfp.webp') }}" class="text-primary icon-30"
                                                    alt="BFP Logo">
                                            </div>
                                            <div class="logo-mini">
                                                <img src="{{ asset('img/bfp.webp') }}" class="text-primary icon-30"
                                                    alt="BFP Logo">
                                            </div>
                                        </div>
                                        <!--logo End-->
                                        <h4 class="logo-title ms-3">BFP - Abuyog</h4>
                                    </a>
                                    <h2 class="mb-2 text-center">Password Reset</h2>
                                    <form id="resetPasswordForm">
                                        <input type="hidden" name="token" value="{{ request()->route('token') }}">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">New Password</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation" class="form-label">Confirm
                                                        Password</label>
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation" name="password_confirmation"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sign-bg">
                        <img src="{{ asset('img/bfp.svg') }}" height="230" alt="BFP Logo" style="opacity: 3%;">
                    </div>
                </div>
                <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                    <img src="{{ asset('img/background.webp') }}" class="img-fluid gradient-main animated-scaleX"
                        alt="images">
                </div>
            </div>
        </section>
    </div>

    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3"></div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

    <script>
        $(document).ready(function() {
            // Set CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#resetPasswordForm').submit(function(event) {
                event.preventDefault();

                let submitBtn = $('button[type="submit"]');
                submitBtn.prop('disabled', true).text('Processing...');

                clearValidationErrors();

                $.ajax({
                    method: 'POST',
                    url: '{{ route('password.update') }}',
                    data: $('#resetPasswordForm').serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: handleSuccess,
                    error: handleError,
                    complete: () => submitBtn.prop('disabled', false).text('Sign In')
                });
            });

            function handleSuccess(response) {
                window.location.href = '/';
                showToast('success', response.message);
                setTimeout(() => window.location.reload(), 1000);
            }

            function handleError(xhr) {
                if (xhr.status === 422) {
                    showValidationErrors(xhr.responseJSON.errors);
                    showToast('danger', 'Please correct the errors in the form.');
                } else if (xhr.status === 401) {
                    showInvalidLoginError();
                    showToast('danger', 'Invalid email or password.');
                } else {
                    showToast('danger', 'Something went wrong. Please try again.');
                }
            }

            function showValidationErrors(errors) {
                $.each(errors, function(field, messages) {
                    let inputField = $(`#resetPasswordForm [name="${field}"]`);
                    displayFieldError(inputField, messages[0]);
                });
            }

            function showInvalidLoginError() {
                let emailField = $('#resetPasswordForm [name="email"]');
                let passwordField = $('#resetPasswordForm [name="password"]');

                displayFieldError(emailField, 'Invalid email.');
                displayFieldError(passwordField, 'Invalid password.');
            }

            function displayFieldError(inputField, message) {
                inputField.addClass('is-invalid');
                if (!inputField.next('.invalid-feedback').length) {
                    inputField.after(`<div class="invalid-feedback">${message}</div>`);
                } else {
                    inputField.next('.invalid-feedback').text(message);
                }

                inputField.on('input', function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                });
            }

            function clearValidationErrors() {
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            }

            function showToast(type, message) {
                let toastClass = type === 'success' ? 'bg-success' : 'bg-danger';

                let toastHtml = `
                    <div class="toast align-items-center text-white ${toastClass} border-0 show" role="alert">
                        <div class="d-flex">
                            <div class="toast-body text-center w-100">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>`;

                $('.toast-container').html(toastHtml);
                let toastElement = new bootstrap.Toast($('.toast')[0]);
                toastElement.show();
            }
        });
    </script>
</body>

</html>
