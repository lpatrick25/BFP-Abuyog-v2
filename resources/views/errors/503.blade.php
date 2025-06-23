<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} | We’ll be back soon!</title>

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

    <style class="fslightbox-styles">
        .fslightbox-absoluted {
            position: absolute;
            top: 0;
            left: 0
        }

        .fslightbox-fade-in {
            animation: fslightbox-fade-in .3s cubic-bezier(0, 0, .7, 1)
        }

        .fslightbox-fade-out {
            animation: fslightbox-fade-out .3s ease
        }

        .fslightbox-fade-in-strong {
            animation: fslightbox-fade-in-strong .3s cubic-bezier(0, 0, .7, 1)
        }

        .fslightbox-fade-out-strong {
            animation: fslightbox-fade-out-strong .3s ease
        }

        @keyframes fslightbox-fade-in {
            from {
                opacity: .65
            }

            to {
                opacity: 1
            }
        }

        @keyframes fslightbox-fade-out {
            from {
                opacity: .35
            }

            to {
                opacity: 0
            }
        }

        @keyframes fslightbox-fade-in-strong {
            from {
                opacity: .3
            }

            to {
                opacity: 1
            }
        }

        @keyframes fslightbox-fade-out-strong {
            from {
                opacity: 1
            }

            to {
                opacity: 0
            }
        }

        .fslightbox-cursor-grabbing {
            cursor: grabbing
        }

        .fslightbox-full-dimension {
            width: 100%;
            height: 100%
        }

        .fslightbox-open {
            overflow: hidden;
            height: 100%
        }

        .fslightbox-flex-centered {
            display: flex;
            justify-content: center;
            align-items: center
        }

        .fslightbox-opacity-0 {
            opacity: 0 !important
        }

        .fslightbox-opacity-1 {
            opacity: 1 !important
        }

        .fslightbox-scrollbarfix {
            padding-right: 17px
        }

        .fslightbox-transform-transition {
            transition: transform .3s
        }

        .fslightbox-container {
            font-family: Arial, sans-serif;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(rgba(30, 30, 30, .9), #000 1810%);
            touch-action: pinch-zoom;
            z-index: 1000000000;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-tap-highlight-color: transparent
        }

        .fslightbox-container * {
            box-sizing: border-box
        }

        .fslightbox-svg-path {
            transition: fill .15s ease;
            fill: #ddd
        }

        .fslightbox-nav {
            height: 45px;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0
        }

        .fslightbox-slide-number-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            height: 100%;
            font-size: 15px;
            color: #d7d7d7;
            z-index: 0;
            max-width: 55px;
            text-align: left
        }

        .fslightbox-slide-number-container .fslightbox-flex-centered {
            height: 100%
        }

        .fslightbox-slash {
            display: block;
            margin: 0 5px;
            width: 1px;
            height: 12px;
            transform: rotate(15deg);
            background: #fff
        }

        .fslightbox-toolbar {
            position: absolute;
            z-index: 3;
            right: 0;
            top: 0;
            height: 100%;
            display: flex;
            background: rgba(35, 35, 35, .65)
        }

        .fslightbox-toolbar-button {
            height: 100%;
            width: 45px;
            cursor: pointer
        }

        .fslightbox-toolbar-button:hover .fslightbox-svg-path {
            fill: #fff
        }

        .fslightbox-slide-btn-container {
            display: flex;
            align-items: center;
            padding: 12px 12px 12px 6px;
            position: absolute;
            top: 50%;
            cursor: pointer;
            z-index: 3;
            transform: translateY(-50%)
        }

        @media (min-width:476px) {
            .fslightbox-slide-btn-container {
                padding: 22px 22px 22px 6px
            }
        }

        @media (min-width:768px) {
            .fslightbox-slide-btn-container {
                padding: 30px 30px 30px 6px
            }
        }

        .fslightbox-slide-btn-container:hover .fslightbox-svg-path {
            fill: #f1f1f1
        }

        .fslightbox-slide-btn {
            padding: 9px;
            font-size: 26px;
            background: rgba(35, 35, 35, .65)
        }

        @media (min-width:768px) {
            .fslightbox-slide-btn {
                padding: 10px
            }
        }

        @media (min-width:1600px) {
            .fslightbox-slide-btn {
                padding: 11px
            }
        }

        .fslightbox-slide-btn-container-previous {
            left: 0
        }

        @media (max-width:475.99px) {
            .fslightbox-slide-btn-container-previous {
                padding-left: 3px
            }
        }

        .fslightbox-slide-btn-container-next {
            right: 0;
            padding-left: 12px;
            padding-right: 3px
        }

        @media (min-width:476px) {
            .fslightbox-slide-btn-container-next {
                padding-left: 22px
            }
        }

        @media (min-width:768px) {
            .fslightbox-slide-btn-container-next {
                padding-left: 30px
            }
        }

        @media (min-width:476px) {
            .fslightbox-slide-btn-container-next {
                padding-right: 6px
            }
        }

        .fslightbox-down-event-detector {
            position: absolute;
            z-index: 1
        }

        .fslightbox-slide-swiping-hoverer {
            z-index: 4
        }

        .fslightbox-invalid-file-wrapper {
            font-size: 22px;
            color: #eaebeb;
            margin: auto
        }

        .fslightbox-video {
            object-fit: cover
        }

        .fslightbox-youtube-iframe {
            border: 0
        }

        .fslightbox-loader {
            display: block;
            margin: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 67px;
            height: 67px
        }

        .fslightbox-loader div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 54px;
            height: 54px;
            margin: 6px;
            border: 5px solid;
            border-color: #999 transparent transparent transparent;
            border-radius: 50%;
            animation: fslightbox-loader 1.2s cubic-bezier(.5, 0, .5, 1) infinite
        }

        .fslightbox-loader div:nth-child(1) {
            animation-delay: -.45s
        }

        .fslightbox-loader div:nth-child(2) {
            animation-delay: -.3s
        }

        .fslightbox-loader div:nth-child(3) {
            animation-delay: -.15s
        }

        @keyframes fslightbox-loader {
            0% {
                transform: rotate(0)
            }

            100% {
                transform: rotate(360deg)
            }
        }

        .fslightbox-source {
            position: relative;
            z-index: 2;
            opacity: 0
        }
    </style>
</head>

<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader animate__animated animate__fadeOut d-none">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <div class="container-fluid p-0">
            <div class="iq-maintenance text-center">
                <img src="{{ asset('assets/images/error/01.png') }}" class="img-fluid mb-4" alt="">
                <div class="maintenance-bottom text-white pb-0">

                    <div class="bg-primary" style="background: transparent; height: 320px;">
                        <div class="gradient-bottom">
                            <div class="bottom-text general-zindex">
                                <h1 class="mb-2 text-white">Hang on! We are under maintenance</h1>
                                <p>It will not take a long time till we get the error fiked. We wii live again in</p>
                                <ul class="countdown d-flex justify-content-center align-items-center list-inline"
                                    data-date="Aug 02 2022 20:20:22">
                                    <li>
                                        <span data-days="">-977</span>Days
                                    </li>
                                    <li>
                                        <span data-hours="">16</span>Hours
                                    </li>
                                    <li>
                                        <span data-minutes="">60</span>Minutes
                                    </li>
                                    <li>
                                        <span data-seconds="">58</span>Seconds
                                    </li>
                                </ul>
                                <div class="w-50 mx-auto mt-2">
                                    <div class="input-group search-input search-input">
                                        <input type="text" class="form-control" placeholder="Enter your mail">
                                        <a href="#" class="btn bg-white text-primary ms-2 rounded">Notify Me</a>
                                    </div>
                                </div>
                            </div>
                            <div class="c xl-circle">
                                <div class="c lg-circle">
                                    <div class="c md-circle">
                                        <div class="c sm-circle">
                                            <div class="c xs-circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sign-bg">
                <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.05">
                        <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                            transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF"></rect>
                        <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                            transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF"></rect>
                        <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                            transform="rotate(45 61.9355 138.545)" fill="#3B8AFF"></rect>
                        <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                            transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF"></rect>
                    </g>
                </svg>
            </div>
        </div>
    </div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- AOS Animation Plugin-->

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

</body>

</html>
