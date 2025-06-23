<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Sign-up</title>

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

    <!-- Google reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                    <img src="{{ asset('img/background.webp') }}" class="img-fluid gradient-main animated-scaleX"
                        alt="images">
                </div>
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0">
                                <div class="card-body">
                                    <a href="#" class="navbar-brand d-flex align-items-center mb-3">
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
                                    <h2 class="mb-2 text-center">Sign Up</h2>
                                    <form id="signUpForm">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="first-name" class="form-label">First Name: <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="first-name"
                                                        name="first_name" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="middle-name" class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control" id="middle-name"
                                                        name="middle_name" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="last-name" class="form-label">Last Name: <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="last-name"
                                                        name="last_name" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="extension-name" class="form-label">Extension
                                                        Name</label>
                                                    <input type="text" class="form-control" id="extension-name"
                                                        name="extension_name" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email: <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">Phone No.: <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="phone"
                                                        name="contact_number" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password: <span
                                                            class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="confirm-password" class="form-label">Confirm Password:
                                                        <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="confirm-password"
                                                        name="password_confirmation" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="g-recaptcha"
                                                    data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary" id="signUpButton">Sign
                                                Up</button>
                                        </div>
                                        <p class="mt-3 text-center">
                                            Already have an Account <a href="{{ route('signin') }}"
                                                class="text-underline">Sign
                                                In</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sign-bg sign-bg-right">
                        <img src="{{ asset('img/bfp.svg') }}" height="230" alt="BFP Logo" style="opacity: 3%;">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3"></div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- Error Handler -->
    <script src="{{ asset('js/error-handler.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

    <script type="text/javascript">
        $(document).ready(function() {
            let phoneInput = $("#phone");
            let errorMessage = phoneInput.next(".error-message");

            // Allow only numbers in the input field
            phoneInput.on("input", function() {
                $(this).val($(this).val().replace(/\D/g, "")); // Remove non-numeric characters
                errorMessage.hide(); // Hide error message when user types
            });

            // Set CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#signUpForm').submit(function(event) {
                event.preventDefault();

                let submitBtn = $('button[type="submit"]');
                submitBtn.prop('disabled', true).text('Processing...');

                // Clear previous validation errors
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.ajax({
                    method: 'POST',
                    url: '{{ route('register') }}',
                    data: $('#signUpForm').serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        showToast('success', response.message);

                        // Reset the form on success
                        $('#signUpForm')[0].reset();

                        location.href = '{{ route('verification.view') }}';
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON && xhr
                            .responseJSON.error) {
                            showToast('danger', xhr.responseJSON.error);
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(field, messages) {
                                let inputField = $(
                                    `#signUpForm [name="${field}"]`);
                                inputField.addClass('is-invalid');

                                let errorHtml =
                                    `<div class="invalid-feedback">${messages[0]}</div>`;
                                inputField.after(errorHtml);

                                // Remove error on input change
                                inputField.on('input', function() {
                                    $(this).removeClass(
                                        'is-invalid');
                                    $(this).next(
                                            '.invalid-feedback')
                                        .remove();
                                });
                            });

                            showToast('danger',
                                'Please correct the errors in the form.');
                        } else {
                            showToast('danger',
                                'Something went wrong. Please try again.');
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).text('Sign Up');
                    }
                });
            });

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
