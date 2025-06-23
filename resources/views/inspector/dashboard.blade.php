@extends('layout.master')
@section('APP-TITLE')
    Inspector Dashboard
@endsection
@section('inspector-dashboard')
    active
@endsection
@section('APP-CSS')
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .iq-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .iq-card:hover {
            transform: translateY(-5px);
        }

        .iq-card-header {
            border-bottom: none;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .metric-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mb-4">
                <div class="col animate__animated animate__fadeIn" data-wow-delay="0.2s">
                    <div class="iq-card bg-white">
                        <div class="iq-card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Issued FSIC</h5>
                        </div>
                        <div class="iq-card-body text-center p-3">
                            <i class="fas fa-certificate metric-icon text-primary"></i>
                            <h4 class="counter text-dark">{{ $metrics['issued_fsics'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col animate__animated animate__fadeIn" data-wow-delay="0.3s">
                    <div class="iq-card bg-white">
                        <div class="iq-card-header bg-info text-white">
                            <h5 class="card-title mb-0">Pending FS</h5>
                        </div>
                        <div class="iq-card-body text-center p-3">
                            <i class="fas fa-circle metric-icon text-info"></i>
                            <h4 class="counter text-dark">{{ $metrics['pending_schedules'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col animate__animated animate__fadeIn" data-wow-delay="0.4s">
                    <div class="iq-card bg-white">
                        <div class="iq-card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Completed FS</h5>
                        </div>
                        <div class="iq-card-body text-center p-3">
                            <i class="fas fa-circle metric-icon text-primary"></i>
                            <h4 class="counter text-dark">{{ $metrics['completed_schedules'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col animate__animated animate__fadeIn" data-wow-delay="0.5s">
                    <div class="iq-card bg-white">
                        <div class="iq-card-header bg-info text-white">
                            <h5 class="card-title mb-0">Total Applications</h5>
                        </div>
                        <div class="iq-card-body text-center p-3">
                            <i class="fas fa-clipboard-list metric-icon text-info"></i>
                            <h4 class="counter text-dark">{{ $metrics['total_applications'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        $(document).ready(function() {
            // HopeUI animations are handled by its JS bundle
        });
    </script>
@endsection
