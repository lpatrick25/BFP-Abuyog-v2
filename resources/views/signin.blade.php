<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Sign-in</title>

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
                                    <h2 class="mb-2 text-center">Sign In</h2>
                                    <form id="loginForm">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" aria-describedby="email" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" aria-describedby="password" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-between">
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                                    <label class="form-check-label" for="customCheck1">Remember
                                                        Me</label>
                                                </div>
                                                <a href="/recover">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div id="lockout-message" class="text-danger text-center mb-3"
                                                style="display: none;"></div>
                                            <button type="submit" class="btn btn-primary">Sign In</button>
                                        </div>
                                        <p class="mt-3 text-center">
                                            Don’t have an account? <a href="/signup" class="text-underline">Click
                                                here to sign up.</a>
                                        </p>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let lockoutTimerInterval;

            // Check lockout status on page load
            checkLockoutStatus();

            $('#loginForm').submit(function(event) {
                event.preventDefault();

                let submitBtn = $('button[type="submit"]');
                submitBtn.prop('disabled', true).text('Processing...');

                clearValidationErrors();

                $.ajax({
                    method: 'POST',
                    url: '{{ route('login') }}',
                    data: $('#loginForm').serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: handleSuccess,
                    error: handleError,
                    complete: () => submitBtn.prop('disabled', false).text('Sign In')
                });
            });

            function handleSuccess(response) {
                clearLockout();
                showToast('success', response.message || 'Login successful');
                setTimeout(() => window.location.reload(), 1000);
            }

            function handleError(xhr) {
                const response = xhr.responseJSON;

                if (xhr.status === 429 && response?.message) {
                    setLockout(response.lockout_end, response.seconds_remaining);
                    showToast('danger', response.message);
                } else if (xhr.status === 422 && response?.errors) {
                    showValidationErrors(response.errors);
                    showToast('danger',
                        `Please correct the errors. ${response.remaining_attempts} attempts remaining.`);
                } else if ((xhr.status === 401 || xhr.status === 403) && response?.message) {
                    showInvalidLoginError(response.message);
                    showToast('danger', `${response.message} ${response.remaining_attempts} attempts remaining.`);
                } else {
                    showToast('danger', 'Something went wrong. Please try again.');
                }
            }

            function showValidationErrors(errors) {
                $.each(errors, function(field, messages) {
                    let inputField = $(`#loginForm [name="${field}"]`);
                    displayFieldError(inputField, messages[0]);
                });
            }

            function showInvalidLoginError(message) {
                let emailField = $('#loginForm [name="email"]');
                let passwordField = $('#loginForm [name="password"]');

                displayFieldError(emailField, message || 'Invalid email.');
                displayFieldError(passwordField, message || 'Invalid password.');
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

            function checkLockoutStatus() {
                $.ajax({
                    method: 'GET',
                    url: '/check-lockout', // Update with correct route
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status === 'locked') {
                            setLockout(response.lockout_end, response.seconds_remaining);
                        } else {
                            clearLockout();
                        }
                    },
                    error: function() {
                        // Fallback to localStorage
                        const lockoutData = JSON.parse(localStorage.getItem('lockout_data') || '{}');
                        if (lockoutData.lockout_end) {
                            const secondsRemaining = Math.floor((new Date(lockoutData.lockout_end) -
                                new Date()) / 1000);
                            if (secondsRemaining > 0) {
                                setLockout(lockoutData.lockout_end, secondsRemaining);
                            } else {
                                clearLockout();
                            }
                        }
                    }
                });
            }

            function setLockout(lockoutEnd, secondsRemaining) {
                // Store in localStorage
                localStorage.setItem('lockout_data', JSON.stringify({
                    lockout_end: lockoutEnd
                }));

                // Disable form
                $('#loginForm input, #loginForm button').prop('disabled', true);

                // Start timer
                updateLockoutTimer(secondsRemaining);

                clearInterval(lockoutTimerInterval);
                lockoutTimerInterval = setInterval(() => {
                    secondsRemaining--;
                    if (secondsRemaining <= 0) {
                        clearLockout();
                    } else {
                        updateLockoutTimer(secondsRemaining);
                    }
                }, 1000);
            }

            function updateLockoutTimer(secondsRemaining) {
                const minutes = Math.floor(secondsRemaining / 60);
                const seconds = secondsRemaining % 60;
                const timeString = minutes > 0 ? `${minutes}m ${seconds}s` : `${seconds}s`;
                $('#lockout-message').text(`Too many attempts. Try again in ${timeString}.`).show();
            }

            function clearLockout() {
                clearInterval(lockoutTimerInterval);
                $('#lockout-message').hide();
                $('#loginForm input, #loginForm button').prop('disabled', false);
                localStorage.removeItem('lockout_data');
            }
        });
    </script>
</body>

</html>
