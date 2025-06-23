@extends('layout.master')

@section('APP-TITLE')
    Statistical and Analytical Reports
@endsection

@section('marshall-reports')
    active
@endsection

@section('APP-CSS')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.css">
@endsection

@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Statistical and Analytical Reports</h4>
                </div>
                <div class="card-body">
                    <!-- Occupancy Type Distribution Chart -->
                    <div class="mb-4">
                        <h5>Occupancy Type Distribution</h5>
                        <canvas id="occupancyChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#back-btn').show();
            const ctx = document.getElementById('occupancyChart').getContext('2d');
            const data = {
                labels: [
                    @foreach ($occupancyDistribution as $item)
                        '{{ $item->type_of_occupancy }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Number of Establishments',
                    data: [
                        @foreach ($occupancyDistribution as $item)
                            {{ $item->count }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
@endsection
