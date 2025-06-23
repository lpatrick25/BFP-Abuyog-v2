<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} | Homepage</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/bfp.webp') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="{{ asset('css/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leaflet/Control.Geocoder.css') }}">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">

    <style>
        /* General Reset for Consistency */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* Elegant Header Styling */
        .bfp-header {
            background: linear-gradient(rgba(178, 34, 34, 0.95), rgba(178, 34, 34, 0.85)),
                url("https://bfp.gov.ph/wp-content/uploads/2018/08/banner_bg02_18Aug2018.png") no-repeat center;
            background-size: cover;
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Logo Styling */
        .bfp-logo img {
            max-height: 80px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .bfp-logo img:hover {
            /* transform: scale(1.05); */
        }

        /* Logo and Time Container */
        .logo-container,
        .time-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .time-container {
            text-align: right;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .time-container .time-label,
        .time-container .time-value {
            color: #fff;
            opacity: 0.9;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #fff;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
            padding: 10px 0;
        }

        .navbar-brand h4 {
            color: #b22222;
            font-weight: 600;
            margin-left: 10px;
        }

        .nav-link {
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #b22222;
        }

        /* Hero Section */
        .bfp-section {
            position: relative;
            background: url('https://bfp.gov.ph/wp-content/uploads/2022/03/bfp-firefighters.jpg') no-repeat center center;
            background-size: cover;
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .bfp-overlay {
            background: rgba(0, 0, 0, 0.6);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Vision & Mission Image */
        .vision-mission img {
            max-width: 900px;
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .vision-mission img:hover {
            transform: scale(1.02);
        }

        /* Floating Label Styling */
        .floating-label .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .floating-label .form-control:focus {
            border-color: #b22222;
            box-shadow: 0 0 8px rgba(178, 34, 34, 0.3);
        }

        .floating-label .form-label {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            background: #fff;
            padding: 0 5px;
            font-size: 0.9rem;
            color: #6c757d;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .floating-label .form-control:focus~.form-label,
        .floating-label .form-control:not(:placeholder-shown)~.form-label {
            top: 0;
            font-size: 0.75rem;
            color: #b22222;
        }

        /* Search Button */
        .btn-search {
            background-color: #b22222;
            color: white;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-search:hover {
            background-color: #8b1a1a;
            transform: translateY(-2px);
        }

        /* PDF View Container */
        .pdf-view-container {
            padding: 15px;
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: opacity 0.3s ease;
        }

        /* Toast Styling */
        .toast {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .toast.bg-success {
            background-color: #28a745 !important;
        }

        .toast.bg-danger {
            background-color: #b22222 !important;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .primary-gradient-card {
            background: linear-gradient(135deg, #b22222 0%, #dc3545 100%);
            color: white;
            border-radius: 8px;
        }

        .credit-card-widget .primary-gradient-card {
            background: linear-gradient(135deg, #b22222 0%, #dc3545 100%);
        }

        /* Footer Styling */
        .footer {
            background-color: #fff;
            padding: 20px 0;
            border-top: 1px solid #e0e0e0;
        }

        .footer .right-panel {
            color: #333;
            font-size: 0.9rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .bfp-header {
                padding: 15px 0;
                text-align: center;
            }

            .bfp-section {
                padding: 50px 15px;
            }

            .logo-container,
            .time-container {
                justify-content: center;
                margin-bottom: 10px;
            }

            .time-container {
                text-align: center;
            }

            .navbar-brand h4 {
                font-size: 1.2rem;
            }

            .bfp-logo img {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .floating-label {
                flex-direction: column;
                gap: 10px;
            }

            .btn-search {
                width: 100%;
            }

            .vision-mission img {
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="theme-color-red light boxed-fancy">
    <div class="boxed-inner">
        <!-- Loader Start -->
        <div id="loading">
            <div class="loader simple-loader">
                <div class="loader-body"></div>
            </div>
        </div>
        <!-- Loader END -->
        <span class="screen-darken"></span>
        <main class="main-content">
            <!-- Nav Start -->
            <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
                <div class="container-fluid navbar-inner">
                    <button data-trigger="navbar_main" class="d-lg-none btn btn-primary rounded-pill p-1 pt-0"
                        type="button">
                        <svg class="icon-20" width="20px" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                        </svg>
                    </button>
                    <a href="/" class="navbar-brand d-flex align-items-center">
                        <img src="{{ asset('img/bfp.webp') }}" alt="BFP Abuyog" class="text-primary icon-50"
                            width="50">
                        <h4 class="logo-title ms-2">BFP - Abuyog e-FSIC</h4>
                    </a>
                    <!-- Horizontal Menu Start -->
                    <nav id="navbar_main"
                        class="mobile-offcanvas nav navbar navbar-expand-xl hover-nav horizontal-nav mx-md-auto">
                        <div class="container-fluid">
                            <div class="offcanvas-header px-0">
                                <div class="navbar-brand ms- vx3">
                                    <img src="{{ asset('img/bfp.webp') }}" alt="BFP Abuyog"
                                        class="text-primary icon-50" width="50">
                                    <h4 class="logo-title">BFP - Abuyog e-FSIC</h4>
                                </div>
                                <button class="btn-close float-end"></button>
                            </div>
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="/e-FSIC">e-FSIC</a></li>
                                <li class="nav-item"><a class="nav-link" href="/establishment">Establishment</a></li>
                            </ul>
                        </div>
                    </nav>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/images/avatars/01.png') }}" alt="User-Profile"
                                        class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded"
                                        style="width: 40px">
                                    <div class="caption ms-3 d-none d-md-block">
                                        <h6 class="mb-0 caption-title">{{ optional(auth()->user())->getFullName() }}</h6>
                                        <p class="mb-0 caption-sub-title text-muted">{{ auth()->user()->role }}</p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('signin') }}"
                                    class="nav-link btn btn-primary px-4 py-2 text-white fw-semibold rounded-pill shadow-sm"
                                    style="background-color: #b22222;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </nav>
            <!-- Header Section -->
            <header class="bfp-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-9 col-12 logo-container">
                            <a href="https://bfp.gov.ph/" title="BFP : Bureau of Fire Protection" rel="home"
                                class="bfp-logo">
                                <img src="{{ asset('img/banner2024-v4.png') }}" alt="BFP Logo">
                            </a>
                        </div>
                        <div class="col-md-3 col-12 time-container">
                            <div class="time-label">Philippine Standard Time:</div>
                            <div id="pst-time" class="time-value"><a href="#"
                                    style="text-decoration: none; color: inherit;">Loading...</a></div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="container-fluid content-inner pb-5">
                <div class="row d-flex min-vh-100">
                    <div class="col-md-12 col-lg-8 d-flex flex-column">
                        @yield('APP-CONTENT')
                    </div>
                    <div class="col-md-12 col-lg-4 d-flex flex-column">
                        <div class="row g-3">
                            {{-- <div class="col-12">
                                <div class="card primary-gradient-card">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="font-weight-bold text-white">ABUYOG</h5>
                                                <p class="mb-0 text-white">Fire Station North Leyte</p>
                                            </div>
                                            <div class="master-card-content">
                                                <img src="{{ asset('img/bfp.webp') }}" alt="BFP Abuyog"
                                                    class="icon-60" width="60">
                                                <img src="{{ asset('img/dilg.webp') }}" alt="DILG Abuyog"
                                                    class="icon-60" width="60">
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <div class="card-number d-flex align-items-center">
                                                <i class="bi bi-telephone-fill fs-5 me-2 text-white"></i>
                                                <span class="fs-5 text-white">0916 908 5788</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <p class="mb-0 text-white fw-semibold">Email</p>
                                        </div>
                                        <div>
                                            <h6 class="text-white">abuyogfsnorthleyte@gmail.com</h6>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-l2">
                                <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
                                    <div class="pb-4 border-0 card-header">
                                        <div class="p-4 border rounded primary-gradient-card">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h5 class="font-weight-bold text-white">ABUYOG</h5>
                                                    <p class="mb-0 text-white">Fire Station North Leyte</p>
                                                </div>
                                                <div class="master-card-content">
                                                    <img src="{{ asset('img/bfp.webp') }}" alt="BFP Abuyog"
                                                        class="icon-60" width="60">
                                                    <img src="{{ asset('img/dilg.webp') }}" alt="DILG Abuyog"
                                                        class="icon-60" width="60">
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <div class="card-number d-flex align-items-center">
                                                    <i class="bi bi-telephone-fill fs-5 me-2 text-white"></i>
                                                    <span class="fs-5 text-white">0916 908 5788</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <p class="mb-0 text-white fw-semibold">Email</p>
                                            </div>
                                            <div>
                                                <h6 class="text-white">abuyogfsnorthleyte@gmail.com</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <a href="https://bfp.gov.ph/official-transparency-seal/">
                                            <img src="{{ asset('img/transparency_seal_2019-500x231.jpg') }}"
                                                alt="Transparency Seal" class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <a href="https://www.foi.gov.ph/requests?agency=BFP">
                                            <img src="{{ asset('img/FOI.jpg') }}" alt="Free of Information"
                                                class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <a href="https://bfp.gov.ph/bfp-citizens-charter/">
                                            <img src="{{ asset('img/citizens-charter.png') }}" alt="Citizen Charter"
                                                class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="fb-page" data-href="https://www.facebook.com/AbuyogPIS/"
                                            data-tabs="timeline" data-width="1200" data-height="260"
                                            data-small-header="false" data-adapt-container-width="true"
                                            data-hide-cover="false" data-show-facepile="true">
                                        </div>
                                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v18.0"
                                            nonce="your-nonce"></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <section class="bfp-section">
                                    <div class="bfp-overlay"></div>
                                    <div class="container position-relative">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12 text-center vision-mission">
                                                <a href="{{ asset('img/vision-mission.png') }}"
                                                    data-fslightbox="fsic-gallery" data-type="image">
                                                    <img src="{{ asset('img/vision-mission.png') }}"
                                                        alt="Vision & Mission" class="img-fluid">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Section -->
            <footer class="footer">
                <div class="container">
                    <div class="footer-body d-flex justify-content-between align-items-center flex-wrap">
                        <ul class="list-inline mb-0 p-0">
                            <li class="list-inline-item"><a href="#"
                                    class="text-decoration-none text-muted">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="#"
                                    class="text-decoration-none text-muted">Terms of Use</a></li>
                        </ul>
                        <div class="right-panel">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>, Made with
                            <i class="bi bi-heart-fill text-danger"></i> by <a href="#"
                                class="text-decoration-none text-muted">BFP Abuyog</a>.
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>
    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>
    <!-- Fslightbox Script -->
    <script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <!-- Time Script -->
    <script>
        function updateTime() {
            const now = new Date().toLocaleString("en-US", {
                timeZone: "Asia/Manila",
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                second: "2-digit",
                hour12: true
            });
            document.getElementById("pst-time").innerHTML =
                `<a href="#" style="text-decoration: none; color: inherit;">${now}</a>`;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
    @yield('APP-SCRIPT')
</body>

</html>
