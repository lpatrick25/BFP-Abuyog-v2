<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFP: e-Fire Safety Inspection Certificate</title>
    <style>
        :root {
            --bfp-red: #b22222;
            --bfp-gray: #f8f9fa;
            --bfp-dark: #2c3e50;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        body {
            background-color: var(--bfp-gray);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--bfp-dark);
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
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--bfp-red);
            letter-spacing: 0.5px;
        }

        .card-body {
            padding: 2rem;
        }

        .floating-label {
            position: relative;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .floating-label .form-control {
            border: 2px solid var(--bfp-red);
            border-radius: 8px;
            padding: 1.25rem 1rem 0.75rem;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .floating-label .form-control:focus {
            border-color: var(--bfp-dark);
            box-shadow: 0 0 8px rgba(44, 62, 80, 0.2);
            outline: none;
        }

        .floating-label .form-label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            font-size: 1rem;
            color: #6c757d;
            transition: all 0.3s ease;
            pointer-events: none;
            background: transparent;
        }

        .floating-label .form-control:focus+.form-label,
        .floating-label .form-control:not(:placeholder-shown)+.form-label {
            top: 0.5rem;
            transform: translateY(0) scale(0.85);
            color: var(--bfp-red);
            background: white;
            padding: 0 0.25rem;
        }

        .btn-search {
            background-color: var(--bfp-red);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-search:hover {
            background-color: var(--bfp-dark);
            transform: scale(1.05);
        }

        .pdf-view-container {
            background: white;
            border: 1px solid rgba(178, 34, 34, 0.2);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            max-width: 800px;
            margin: 0 auto;
            min-height: 400px;
            overflow: auto;
            box-shadow: var(--shadow);
            transition: opacity 0.5s ease;
        }

        .pdf-view-container.show {
            opacity: 1;
        }

        #certificate-content {
            font-size: 1rem;
            line-height: 1.6;
        }

        .spinner-container {
            min-height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.4em;
        }

        .toast-container {
            z-index: 1050;
        }

        .toast {
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        @media (max-width: 768px) {
            .card {
                margin: 0 1rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .floating-label {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-search {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @extends('app')

    @section('APP-CONTENT')
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="header-title">
                            <h4 class="card-title">Abuyog Municipality - Establishment Map</h4>
                        </div>
                        <img src="{{ asset('img/bfp.webp') }}" alt="BFP Logo" style="height: 40px;">
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <div class="floating-label d-flex align-items-center gap-3 mb-4">
                            <div class="position-relative flex-grow-1">
                                <input type="text" class="form-control" id="search" placeholder=" " required>
                                <label for="search" class="form-label">Search FSIC Number</label>
                            </div>
                            <button type="button" class="btn btn-search" id="search-btn">
                                <i class="bi bi-search me-2"></i>Search
                            </button>
                        </div>

                        <!-- HTML View Container -->
                        <div id="pdf-view" class="pdf-view-container" style="display: none; opacity: 0;">
                            <div id="certificate-content"></div>
                        </div>

                        <!-- Loading Spinner -->
                        <div id="loading-spinner" class="spinner-container" style="display: none;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Container -->
        <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3"></div>
    @endsection

    @section('APP-SCRIPT')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.0/purify.min.js"></script>
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
                        timerInterval = setInterval(() => {
                            const currentTime = Date.now();
                            const timeTaken = ((currentTime - startTime) / 1000).toFixed(2);
                            const timerElement = Swal.getHtmlContainer()?.querySelector('b');
                            if (timerElement) {
                                timerElement.textContent = timeTaken;
                            }
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }

            function showToast(type, message) {
                const toastClass = type === 'success' ? 'bg-success' : 'bg-danger';
                const toastHtml = `
                    <div class="toast align-items-center text-white ${toastClass} border-0 show" role="alert">
                        <div class="d-flex">
                            <div class="toast-body text-center w-100">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>`;
                $('.toast-container').html(toastHtml);
                const toastElement = new bootstrap.Toast($('.toast')[0], {
                    delay: 5000
                });
                toastElement.show();
            }

            $(document).ready(function() {
                $('#search-btn').click(function(event) {
                    event.preventDefault();

                    const fsicNo = $('#search').val().trim();
                    if (!fsicNo) {
                        showToast('danger', 'Please enter an FSIC number.');
                        return;
                    }

                    // Show loading spinner
                    $('#loading-spinner').show();
                    $('#pdf-view').hide().css('opacity', 0);
                    showLoadingDialog('Loading Certificate');

                    $.ajax({
                        method: 'GET',
                        url: '/search-FSIC',
                        data: {
                            fsic_no: fsicNo
                        },
                        dataType: 'json',
                        cache: false,
                        success: function(response) {
                            $('#loading-spinner').hide();
                            Swal.close();

                            if (response.message) {
                                showToast('danger', response.message);
                                return;
                            }

                            if (!response.html || !response.file_url) {
                                showToast('danger', 'Invalid response from server.');
                                return;
                            }

                            // Sanitize and render HTML content
                            $('#certificate-content').html(DOMPurify.sanitize(response.html));
                            $('#pdf-view').show().animate({
                                opacity: 1
                            }, 500);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $('#loading-spinner').hide();
                            Swal.close();
                            showToast('danger', 'An error occurred while processing your request.');
                        }
                    });
                });

                // Auto-trigger search if fsicNo is provided
                var fsicNo = {!! json_encode($fsicNo ?? '') !!};
                if (fsicNo) {
                    $('#search').val(fsicNo);
                    setTimeout(function() {
                        $('#search-btn').trigger('click');
                    }, 500);
                }

                // Accessibility: Allow search with Enter key
                $('#search').on('keypress', function(e) {
                    if (e.which === 13) {
                        $('#search-btn').trigger('click');
                    }
                });
            });
        </script>
    @endsection
</body>

</html>
