@extends('layout.master')

@section('APP-TITLE')
    Reports
@endsection

@section('marshall-reports')
    active
@endsection

@section('APP-CONTENT')
    <div class="container py-5">
        {{-- <h1 class="mb-5 text-center fw-bold" style="color: #b22222;">Reports Dashboard</h1> --}}
        <div class="row g-4">
            @php
                $reports = [
                    [
                        'route' => 'establishments.reports',
                        'title' => 'Establishment Reports',
                        'desc' => 'View details about establishments, including summaries and risk flags.',
                        'icon' => 'building',
                    ],
                    [
                        'route' => 'applications.reports',
                        'title' => 'Application Reports',
                        'desc' => 'Track application statuses and volumes.',
                        'icon' => 'file-earmark-text',
                    ],
                    [
                        'route' => 'schedules.reports',
                        'title' => 'Inspection Schedule Reports',
                        'desc' => 'Review inspection schedules and inspector assignments.',
                        'icon' => 'calendar-check',
                    ],
                    [
                        'route' => 'fsics.reports',
                        'title' => 'FSIC Reports',
                        'desc' => 'Monitor FSIC issuances and expirations.',
                        'icon' => 'file-earmark-check',
                    ],
                    [
                        'route' => 'compliance.reports',
                        'title' => 'Compliance and Risk Reports',
                        'desc' => 'Identify non-compliant establishments and risks.',
                        'icon' => 'shield-exclamation',
                    ],
                    // [
                    //     'route' => 'audit.reports',
                    //     'title' => 'Audit & Historical Reports',
                    //     'desc' => 'Track application history and deleted records.',
                    //     'icon' => 'journal-text',
                    // ],
                    // [
                    //     'route' => 'statistical.reports',
                    //     'title' => 'Statistical & Analytical Reports',
                    //     'desc' => 'Analyze occupancy types and approval rates.',
                    //     'icon' => 'bar-chart',
                    // ],
                ];
            @endphp

            @foreach ($reports as $report)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route($report['route']) }}"
                        class="card h-100 border-0 shadow-lg hover-shadow position-relative text-decoration-none text-dark transition-all"
                        style="border-radius: 12px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3 d-flex align-items-center">
                                <i class="bi bi-{{ $report['icon'] }} fs-2" style="color: #b22222;"></i>
                            </div>
                            <h5 class="card-title fw-semibold mb-2" style="color: #333;">{{ $report['title'] }}</h5>
                            <p class="card-text text-muted small">{{ $report['desc'] }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 py-3">
                            <span class="text-maroon small fw-medium">View Report <i
                                    class="bi bi-arrow-right ms-1"></i></span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .card-title {
            font-size: 1.25rem;
        }

        .card-text {
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .text-maroon {
            color: #b22222 !important;
        }

        .card-footer {
            background: linear-gradient(to top, rgba(178, 34, 34, 0.05), transparent);
        }
    </style>
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
        $(document).ready(function() {
            // Smooth hover animation for cards
            $('.hover-shadow').hover(
                function() {
                    $(this).addClass('shadow-lg').css('transform', 'translateY(-5px)');
                },
                function() {
                    $(this).removeClass('shadow-lg').css('transform', 'translateY(0)');
                }
            );
        });
    </script>
@endsection
