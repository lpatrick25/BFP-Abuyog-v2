<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Email Verified</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/bfp.webp') }}" />

    <!-- Library / Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />

    <!-- UI Design System CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0') }}" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=2.0.0') }}" />

    <!-- Dark Mode CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark.min.css') }}" />

    <!-- Customizer CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css') }}" />

    <!-- RTL Support CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css') }}" />

    <style>
        .progress {
            height: 12px;
            border-radius: 6px;
            margin-top: 15px;
            background: #e9ecef;
        }

        .progress-bar {
            transition: width 0.6s ease-in-out;
        }

        .auth-card {
            text-align: center;
            padding: 30px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        }

        .success-icon {
            width: 90px;
            margin-bottom: 15px;
        }

        .logo-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .btn-primary {
            border-radius: 8px;
            font-size: 16px;
            padding: 10px 20px;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: #d32f2f;
            border-color: #d32f2f;
        }
    </style>

</head>

<body class="theme-color-red light" data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0"
    tabindex="0">

    <!-- Loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- Loader End -->

    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <!-- Logo -->
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

                                    <!-- Success Icon -->
                                    <img src="{{ asset('assets/images/auth/mail.png') }}" class="success-icon"
                                        alt="Email Verified">

                                    <h2 class="mt-3 mb-2">Success!</h2>
                                    <p class="cnf-mail mb-3">Your email has been successfully verified.</p>

                                    <!-- Progress Bar -->
                                    <div class="progress">
                                        <div id="progress-bar" class="progress-bar bg-success" role="progressbar"
                                            style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>

                                    <!-- Dashboard Button -->
                                    <button id="dashboard-btn" class="btn btn-primary mt-4">Proceed to Dashboard</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sign-bg">
                        <img src="{{ asset('img/bfp.svg') }}" height="330" alt="BFP Logo" style="opacity: 3%;">
                    </div>
                </div>

                <!-- Right Side Image -->
                <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                    <img src="{{ asset('img/background.webp') }}" class="img-fluid gradient-main animated-scaleX"
                        alt="Background Image">
                </div>
            </div>
        </section>
    </div>

    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3"></div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>
    <script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>
    <script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('assets/js/charts/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/setting.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

    <script>
        $(document).ready(function () {
            let progress = 0;
            let progressBar = $("#progress-bar");

            let interval = setInterval(function () {
                progress += 25;
                progressBar.css("width", progress + "%").attr("aria-valuenow", progress);

                if (progress >= 100) {
                    clearInterval(interval);
                    setTimeout(function () {
                        window.location.href = "/";
                    }, 1000);
                }
            }, 800);

            $("#dashboard-btn").click(function () {
                window.location.href = "/";
            });
        });
    </script>

</body>

</html>
