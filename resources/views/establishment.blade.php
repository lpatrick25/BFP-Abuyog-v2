<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abuyog Municipality - Establishment Map</title>
    <link href="{{ asset('css/leaflet/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('css/leaflet/Control.Geocoder.css') }}" rel="stylesheet">
    <style>
        :root {
            --bfp-red: #b22222;
            --bfp-dark: #2c3e50;
            --bfp-gray: #f8f9fa;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        body {
            background-color: var(--bfp-gray);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--bfp-dark);
        }

        .container {
            padding: 2rem 1rem;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(178, 34, 34, 0.1);
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--bfp-red);
            letter-spacing: 0.5px;
            margin-bottom: 0;
        }

        .card-body {
            padding: 2rem;
        }

        #map {
            height: 600px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background: #e9ecef;
            transition: opacity 0.5s ease;
        }

        .spinner-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.8);
            border-radius: var(--border-radius);
            padding: 2rem;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.4em;
            color: var(--bfp-red);
        }

        .toast-container {
            z-index: 1050;
        }

        .toast {
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .leaflet-popup-content-wrapper {
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .leaflet-popup-content .btn {
            background-color: var(--bfp-red);
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .leaflet-popup-content .btn:hover {
            background-color: var(--bfp-dark);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .card {
                margin: 0 1rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            #map {
                height: 500px;
            }
        }
    </style>
</head>

<body>
    @extends('app')

    @section('APP-CONTENT')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="header-title">
                            <h4 class="card-title">Abuyog Municipality - Establishment Map</h4>
                        </div>
                        <img src="{{ asset('img/bfp.webp') }}" alt="BFP Logo" style="height: 40px;">
                    </div>
                    <div class="card-body text-center">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="spinner-container" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Toast Container -->
        <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3"></div>
    @endsection

    @section('APP-SCRIPT')
        <script src="{{ asset('js/abuyog-map.js') }}" defer></script>
        <script src="{{ asset('js/leaflet/leaflet.js') }}"></script>
        <script src="{{ asset('js/leaflet/Control.Geocoder.js') }}"></script>
        <script>
            var timerInterval = null;

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

            function showImagePopup(establishmentId) {
                let timerInterval = showLoadingDialog('Getting establishment information');

                $.ajax({
                    url: `/admin/${establishmentId}/generate-session`,
                    method: 'POST',
                    success: function(response) {
                        clearInterval(timerInterval);
                        if (response.sessionID) {
                            window.location.href = `/admin/establishment/${response.sessionID}/show`;
                        } else {
                            showToast('danger', 'Failed to generate session.');
                        }
                        Swal.close();
                    },
                    error: function() {
                        clearInterval(timerInterval);
                        Swal.close();
                        showToast('danger', 'Error generating session token.');
                    }
                });
            }

            function showMapWithCoordinates(coordinates) {
                if (!Array.isArray(coordinates) || coordinates.length === 0) {
                    console.warn("No markers found!");
                    return;
                }

                coordinates.forEach(function(coord) {
                    if (!coord || coord.length < 3 || isNaN(coord[0]) || isNaN(coord[1])) {
                        console.warn("Invalid coordinate:", coord);
                        return;
                    }

                    const customIcon = L.icon({
                        iconUrl: "{{ asset('css/leaflet/images/marker-icon.png') }}",
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [0, -35],
                    });

                    const marker = L.marker([parseFloat(coord[0]), parseFloat(coord[1])], {
                        icon: customIcon
                    }).addTo(map);

                    const popupContent = `<button type="button" class="btn btn-success btn-block"
                                onclick="showImagePopup('${coord[2]}');">
                                Show Establishment
                              </button>`;

                    marker.bindPopup(L.popup().setContent(popupContent));
                });
            }

            $(document).ready(function() {

                let markers = @json($response);
                showMapWithCoordinates(markers);

            });
        </script>
    @endsection
</body>

</html>
