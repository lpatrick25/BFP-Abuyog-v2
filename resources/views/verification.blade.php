<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Email Verification</title>

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

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css') }}" />

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
                                        <h4 class="logo-title ms-3">BFP - Abuyog</h4>
                                    </a>
                                    <img src="{{ asset('assets/images/auth/mail.png') }}" class="img-fluid"
                                        width="80" alt="">
                                    <h2 class="mt-3 mb-0">Success!</h2>
                                    <p class="cnf-mail mb-1">
                                        An email has been sent to <strong>{{ auth()->user()->email }}</strong>. Please
                                        check your email and click on the link to verify your account.
                                    </p>
                                    <div class="d-inline-block w-100">
                                        <button id="send-verification" class="btn btn-primary mt-3">Resend Verification</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sign-bg">
                        <img src="{{ asset('img/bfp.svg') }}" height="330" alt="BFP Logo" style="opacity: 3%;">

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
        function showToast(type, message) {
            var toastContainer = $('.toast-container');

            // Create the toast HTML dynamically
            var toast = `
                <div class="toast align-items-center text-bg-${type} border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            toastContainer.append(toast); // Add toast to container

            // Show toast and remove after 3 seconds
            setTimeout(function() {
                $('.toast').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        $(document).ready(function() {
            $('#send-verification').click(function() {
                var btn = $(this);
                btn.prop('disabled', true).text('Resend Verification (1:00)');

                // Send AJAX request to resend email
                $.ajax({
                    url: '/email/verification-notification',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        showToast('success', response.message);
                    },
                    error: function(xhr) {
                        showToast('danger', xhr.responseJSON.error || 'Something went wrong.');
                    }
                });

                // Countdown timer
                var timeLeft = 60;
                var timer = setInterval(function() {
                    timeLeft--;
                    btn.text('Resend Verification (' + timeLeft + 's)');

                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        btn.prop('disabled', false).text('Resend Verification');
                    }
                }, 1000);
            });
        });
    </script>
</body>

</html>
