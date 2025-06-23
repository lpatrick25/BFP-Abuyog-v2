<!doctype html>
<html lang="en" dir="ltr" style="--bs-info: #366AF0;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | @yield('APP-TITLE')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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

    <!-- Data-table Css -->
    <link rel="stylesheet" href="{{ asset('css/data-table/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data-table/bootstrap-table-fixed-columns.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data-table/bootstrap-table-page-jump-to.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data-table/bootstrap-table-reorder-rows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data-table/bootstrap-table-sticky-header.css') }}">

    <!-- Touchspin Css -->
    <link rel="stylesheet" href="{{ asset('css/touchspin/jquery.bootstrap-touchspin.min.css') }}">

    <!-- leaflet CSS  -->
    <link rel="stylesheet" href="{{ asset('css/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leaflet/Control.Geocoder.css') }}">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">

    <!-- select2 CSS  -->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css') }}" />

    @yield('APP-CSS')
</head>

<body class="theme-color-red light">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    @include('layout.sidebar')
    <main class="main-content">
        <div class="position-relative iq-banner">
            @include('layout.navbar')
            <div class="iq-navbar-header" style="height: 215px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flex-wrap d-flex justify-content-between align-items-center">
                                <div>
                                    <h1>@yield('APP-TITLE')</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-header-img">
                    <img src="{{ asset('assets/images/dashboard/top-header.png') }}" alt="header"
                        class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('assets/images/dashboard/top-header1.png') }}" alt="header"
                        class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('assets/images/dashboard/top-header2.png') }}" alt="header"
                        class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('assets/images/dashboard/top-header3.png') }}" alt="header"
                        class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('assets/images/dashboard/top-header4.png') }}" alt="header"
                        class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
                    <img src="{{ asset('assets/images/dashboard/top-header5.png') }}" alt="header"
                        class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div> <!-- Nav Header Component End -->
            <!--Nav End-->
        </div>
        <div class="container-fluid content-inner mt-n5 py-0">
            @yield('APP-CONTENT')
        </div>
    </main>

    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3"></div>

    @php
        $profile = auth()->user()->getProfile();
    @endphp

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="profileForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">First Name</label>
                            <div class="form-control-plaintext view-mode" data-field="first_name">
                                {{ $profile?->first_name }}</div>
                            <input type="text" class="form-control edit-mode d-none" name="first_name"
                                value="{{ $profile?->first_name }}">
                        </div>

                        <!-- Middle Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Middle Name</label>
                            <div class="form-control-plaintext view-mode" data-field="middle_name">
                                {{ $profile?->middle_name }}</div>
                            <input type="text" class="form-control edit-mode d-none" name="middle_name"
                                value="{{ $profile?->middle_name }}">
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Last Name</label>
                            <div class="form-control-plaintext view-mode" data-field="last_name">
                                {{ $profile?->last_name }}</div>
                            <input type="text" class="form-control edit-mode d-none" name="last_name"
                                value="{{ $profile?->last_name }}">
                        </div>

                        <!-- Extension Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Extension Name</label>
                            <div class="form-control-plaintext view-mode" data-field="extension_name">
                                {{ $profile?->extension_name }}</div>
                            <input type="text" class="form-control edit-mode d-none" name="extension_name"
                                value="{{ $profile?->extension_name }}">
                        </div>

                        <!-- Contact Number -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Contact Number</label>
                            <div class="form-control-plaintext view-mode" data-field="contact_number">
                                {{ $profile?->contact_number }}</div>
                            <input type="text" class="form-control edit-mode d-none" name="contact_number"
                                value="{{ $profile?->contact_number }}">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <div class="form-control-plaintext view-mode" data-field="email">{{ $profile?->email }}
                            </div>
                            <input type="email" class="form-control edit-mode d-none" name="email"
                                value="{{ $profile?->email }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" form="profileForm" class="btn btn-success edit-mode d-none">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('assets/js/charts/dashboard.js') }}"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>

    <!-- Settings Script -->
    <script src="{{ asset('assets/js/plugins/setting.js') }}"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>

    <!-- Data-table Script -->
    <script src="{{ asset('js/data-table/bootstrap-table.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-auto-refresh.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-copy-rows.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-fixed-columns.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-i18n-enhance.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-mobile.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-multiple-sort.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-page-jump-to.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-pipeline.js') }}"></script>
    <script src="{{ asset('js/data-table/table-dragger.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-reorder-rows.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-sticky-header.js') }}"></script>
    <script src="{{ asset('js/data-table/bootstrap-table-toolbar.js') }}"></script>

    <!-- Input-mask Script -->
    <script src="{{ asset('js/jasny-bootstrap.min.js') }}"></script>

    <!-- touchspin JS -->
    <script src="{{ asset('js/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <!-- leaflet JS -->
    <script src="{{ asset('js/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('js/leaflet/Control.Geocoder.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    <!-- select2 JS -->
    <script src="{{ asset('js/select2/select2.full.min.js') }}"></script>

    <!-- Error Handler -->
    <script src="{{ asset('js/error-handler.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

    <script type="text/javascript">
        var timerInterval = null;

        function goBack() {
            if (document.referrer) {
                window.history.back(); // Go to the previous page if available
            } else {
                window.location.href = "/"; // Fallback: Redirect to homepage or any desired page
            }
        }

        function showLoadingDialog(title) {
            const startTime = Date.now();

            Swal.fire({
                title: title,
                html: 'Please wait... Time Taken: <b>0</b> seconds',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();

                    // Start timer
                    timerInterval = setInterval(() => {
                        const currentTime = Date.now();
                        const timeTaken = ((currentTime - startTime) / 1000).toFixed(2);
                        const swalContainer = Swal.getHtmlContainer();

                        if (swalContainer) {
                            const timerElement = swalContainer.querySelector('b');
                            if (timerElement) {
                                timerElement.textContent = timeTaken;
                            }
                        }
                    }, 1000);
                },
                willClose: () => {
                    // Stop the timer when modal is closed
                    clearInterval(timerInterval);
                }
            });

            return timerInterval;
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

        function toggleProfileMode(mode) {
            document.querySelectorAll('.view-mode').forEach(el => el.classList.toggle('d-none', mode === 'edit'));
            document.querySelectorAll('.edit-mode').forEach(el => el.classList.toggle('d-none', mode === 'view'));

            const modalTitle = document.getElementById('profileModalLabel');
            modalTitle.textContent = mode === 'edit' ? 'Edit Profile' : 'Profile Info';
        }

        $(document).ready(function() {
            // Setup CSRF Token for AJAX Requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Register Service Worker
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(function(registration) {
                        console.log('Service Worker registered with scope: ', registration.scope);
                    })
                    .catch(function(error) {
                        console.log('Service Worker registration failed: ', error);
                    });
            }

            // Request Notification Permission
            if (Notification.permission === "default") {
                Notification.requestPermission().then(function(permission) {
                    if (permission === "granted") {
                        console.log("Notification permission granted.");
                    } else {
                        console.log("Notification permission denied.");
                    }
                });
            }

            // Subscribe User to Push Notifications
            function subscribeUserToPush() {
                if (!('serviceWorker' in navigator)) {
                    console.log('Service workers are not supported by your browser.');
                    return;
                }

                navigator.serviceWorker.ready.then(function(registration) {
                        return registration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: '<Your VAPID Public Key>',
                        });
                    })
                    .then(function(subscription) {
                        // Send the subscription to your server to store it
                        fetch('/store-subscription', {
                                method: 'POST',
                                body: JSON.stringify(subscription),
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Subscription stored:', data);
                            })
                            .catch(error => {
                                console.error('Error storing subscription:', error);
                            });
                    });

                // Call the function to subscribe the user
                subscribeUserToPush();
            }

            $('#profileModal').on('hidden.bs.modal', function() {
                toggleProfileMode('view');
            });

            $('#profileForm').submit(function(event) {
                event.preventDefault();
                let timerInterval = showLoadingDialog('Updating User Account');

                let submitBtn = $('button[type="submit"]');
                submitBtn.prop('disabled', true).text('Processing...');

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.ajax({
                    method: 'POST',
                    url: '{{ route('update.profile') }}',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        clearInterval(timerInterval);
                        Swal.close();
                        showToast('success', 'Profile updated');

                        $('#userFullName').text(response.data.full_name);

                        const fields = ['first_name', 'middle_name', 'last_name',
                            'extension_name', 'contact_number', 'email'
                        ];

                        fields.forEach(field => {
                            let value = response.data[field] ?? '';
                            $(`[data-field="${field}"]`).text(value);
                            $(`[name="${field}"]`).val(value);
                        });

                        $('#profileModal').modal('hide');
                    },
                    error: handleAjaxError,
                    complete: function() {
                        submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });
        });
    </script>
    @yield('APP-SCRIPT')

    @if (auth()->check() && auth()->user()->role === 'Marshall')
        <style>
            /* Notification Container */
            .notification-container {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 400px;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                display: none;
                /* Hidden by default, shown via JS */
                animation: slideIn 0.5s ease-out;
            }

            /* Slide-in animation */
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Card Styling */
            .notification-card {
                padding: 15px;
                border-left: 5px solid #007bff;
                /* Blue accent */
            }

            /* User Image */
            .notification-img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid #f8d7da;
            }

            /* Close Button */
            .close-btn {
                background: none;
                border: none;
                font-size: 18px;
                color: #666;
                cursor: pointer;
                position: absolute;
                top: 10px;
                right: 10px;
            }

            /* Hover Effect */
            .close-btn:hover {
                color: #ff0000;
            }
        </style>
        <div class="notification-container" id="pushNotification" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <button class="close-btn" onclick="closeNotification()">×</button>
                    <div class="user-post-data">
                        <div class="d-flex flex-wrap">
                            <div class="media-support-user-img me-3">
                                <img class="rounded-circle p-1 bg-soft-danger img-fluid avatar-60"
                                    src="{{ asset('assets/images/avatars/02.png') }}" alt="User Avatar">
                            </div>
                            <div class="media-support-info mt-2">
                                <h5 class="mb-0 d-inline-block" id="applicationType">New Application</h5>
                                <p class="mb-0 text-primary" id="applicationDate">Just now</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p id="applicationMessage">Notification content will appear here.</p>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://js.pusher.com/8.3.0/pusher.min.js"></script>
        <script>
            var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
                encrypted: true
            });

            var channel = pusher.subscribe("marshall-notifications");

            channel.bind("new.application", function(data) {
                if (!data.application || !data.application.id) {
                    console.error("Invalid application data received:", data);
                    return;
                }

                let applicationId = data.application.id;
                console.log("New application submitted: " + applicationId);

                fetch(`/marshall/getApplication/${applicationId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(response => {
                        if (response.application && response.application.establishment) {
                            let application = response.application;
                            let establishment = application.establishment;
                            let client = establishment.client;

                            if (client) {
                                let client_name =
                                    `${client.first_name} ${client.middle_name ? client.middle_name + ' ' : ''}${client.last_name}`;
                                // let client_name = `${client.getFullName()}`;

                                let applicationTypeText = "";
                                switch (application.fsic_type) {
                                    case 0:
                                        applicationTypeText = "Application of Occupancy";
                                        break;
                                    case 1:
                                        applicationTypeText = "New Application for FSIC";
                                        break;
                                    case 2:
                                        applicationTypeText = "Renew Application for FSIC";
                                        break;
                                    default:
                                        applicationTypeText = "Unknown Application Type";
                                }

                                let message =
                                    `${client_name} has submitted a ${application.fsic_type} FSIC application for the establishment "${establishment.name}". The request is now pending review.`;

                                // Update Notification Content
                                document.getElementById("applicationType").textContent = applicationTypeText;
                                document.getElementById("applicationMessage").textContent = message;
                                document.getElementById("applicationDate").textContent = "Just now";

                                // Show Notification
                                document.getElementById("pushNotification").style.display = "block";

                                // Auto-close after 10 seconds
                                setTimeout(() => {
                                    closeNotification();
                                }, 10000);
                            } else {
                                console.warn("Client data not found in the response.");
                            }
                        } else {
                            console.warn("Invalid response structure:", response);
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching application details:", error);
                        showToast('error', 'Something went wrong while retrieving application details.');
                    });
            });

            // Function to Close Notification
            function closeNotification() {
                document.getElementById("pushNotification").style.display = "none";
            }
        </script>
    @endif

</body>

</html>
