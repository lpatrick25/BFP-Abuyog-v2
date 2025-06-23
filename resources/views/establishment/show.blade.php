@extends('layout.master')
@section('APP-TITLE')
    Establishment
@endsection
@section('client-establishment')
    active
@endsection
@section('client-gis')
    active
@endsection
@section('APP-CSS')
    <style type="text/css">
        /* Floating Action Button (FAB) */
        .floating-save-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 56px;
            height: 56px;
            background-color: #007bff;
            /* Bootstrap Primary Blue */
            color: white;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            /* Fully circular */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            /* Soft shadow */
            border: none;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        /* Hover Effect */
        .floating-save-btn:hover {
            background-color: #0056b3;
            /* Darker Blue on Hover */
            transform: scale(1.1);
            /* Slightly enlarge */
        }

        /* Responsive: Adjust size for mobile */
        @media (max-width: 576px) {
            .floating-save-btn {
                bottom: 15px;
                right: 15px;
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }
    </style>
@endsection
@section('APP-CONTENT')
    <form id="addForm" class="row">
        <div class="col-lg-4">
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Business Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="BIN">Business Identification Number: </label>
                            <p class="form-control">{{ $establishment->BIN }}</p>
                        </div>
                        <div class="form-group">
                            <label for="TIN">Tax Identification Number: </label>
                            <p class="form-control">{{ $establishment->TIN }}</p>
                        </div>
                        <div class="form-group">
                            <label for="DTI">Department of Trade and Industry: </label>
                            <p class="form-control">{{ $establishment->DTI }}</p>
                        </div>
                        <div class="form-group">
                            <label for="SEC">Security and Exchange Commission: </label>
                            <p class="form-control">{{ $establishment->SEC }}</p>
                        </div>
                        <div class="form-group">
                            <label for="nature_of_business">Nature of Business: </label>
                            <p class="form-control">{{ $establishment->nature_of_business }}</p>
                        </div>
                        <div class="form-group">
                            <label for="location_latitude">Latitude: </label>
                            <p class="form-control">{{ $establishment->location_latitude }}</p>
                        </div>
                        <div class="form-group">
                            <label for="location_longitude">Longitude: </label>
                            <p class="form-control">{{ $establishment->location_longitude }}</p>
                        </div>
                        <div style="width: 100%; height: 100%;">
                            <iframe width="100%" height="100%" frameborder="5" style="border:0"
                                src="https://www.google.com/maps?q={{ $establishment->location_latitude }},{{ $establishment->location_longitude }}&output=embed"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Establishment Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name">Establishment Name: </label>
                                    <p class="form-control">{{ $establishment->name }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group input-with-success">
                                    <label for="owner_name">Owner Name: </label>
                                    <p class="form-control">{{ $establishment->client->getFullName() }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="representative_name">Representative Name: <span
                                            class="text-danger"></span></label>
                                    <p class="form-control">{{ $establishment->representative_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="trade_name">Trade Name: <span class="text-danger"></span></label>
                                    <p class="form-control">{{ $establishment->trade_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="total_building_area">Total Building Area: <span
                                            class="text-danger">*</span></label>

                                    <p class="form-control">{{ $establishment->total_building_area }} SQM</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="number_of_occupant">Number of Occupant: <span
                                            class="text-danger">*</span></label>
                                    <p class="form-control">{{ $establishment->number_of_occupant }} PEOPLE</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="type_of_occupancy">Type of Occupancy: <span
                                            class="text-danger">*</span></label>
                                    <p class="form-control">{{ $establishment->type_of_occupancy }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="type_of_building">Type of Building: <span
                                            class="text-danger">*</span></label>
                                    <p class="form-control">{{ $establishment->type_of_building }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="high_rise">High Rise: </label>
                                    <p class="form-control">{{ $establishment->high_rise ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="eminent_danger">In Eminent Danger: <span
                                            class="text-danger">*</span></label>
                                    <p class="form-control">{{ $establishment->eminent_danger ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Address Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group input-with-success">
                                    <label for="region">Region: </label>
                                    <p class="form-control">REGION VII (EASTERN VISAYAS)</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group input-with-success">
                                    <label for="province">Province: </label>
                                    <p class="form-control">LEYTE</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group input-with-success">
                                    <label for="city_mun">City/Municipality: </label>
                                    <p class="form-control">ABUYOG</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="address_brgy">Barangay: </label>
                                    <p class="form-control">{{ $establishment->address_brgy }}</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="address_ex">Blk. No./ Street Name/ Building Name: <span
                                            class="text-danger"></span></label>
                                    <p class="form-control">{{ $establishment->address_ex ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Contact Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email Address: </label>
                                    <p class="form-control">{{ $establishment->email }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="landline">Landline: <span class="text-danger"></span></label>
                                    <p class="form-control">{{ $establishment->landline ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="contact_number">Mobile Number: </label>
                                    <p class="form-control">{{ $establishment->contact_number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#back-btn').show();

        });
    </script>
@endsection
