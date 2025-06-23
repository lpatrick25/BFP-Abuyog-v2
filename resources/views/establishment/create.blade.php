@extends('layout.master')
@section('APP-TITLE')
    Establishment
@endsection
@section('client-establishment')
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

        /* Accordion styling for better spacing */
        .accordion-item {
            margin-bottom: 1rem;
            border-radius: 0.25rem !important;
        }

        .accordion-button {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: #007bff;
        }
    </style>
@endsection
@section('APP-CONTENT')
    <form id="addForm" class="row">
        <div class="col-lg-12">
            <div class="accordion" id="establishmentAccordion">
                <!-- Business Information -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingBusiness">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseBusiness" aria-expanded="true" aria-controls="collapseBusiness">
                            Business Information
                        </button>
                    </h2>
                    <div id="collapseBusiness" class="accordion-collapse collapse show" aria-labelledby="headingBusiness"
                        data-bs-parent="#establishmentAccordion">
                        <div class="accordion-body">
                            <div class="form-group">
                                <label for="BIN">Business Identification Number: <span
                                        class="text-danger"></span></label>
                                <input type="text" id="BIN" name="BIN" class="form-control"
                                    data-mask="99999-99999">
                            </div>
                            <div class="form-group">
                                <label for="TIN">Tax Identification Number: <span class="text-danger"></span></label>
                                <input type="text" id="TIN" name="TIN" class="form-control"
                                    data-mask="999-999-999-99999">
                            </div>
                            <div class="form-group">
                                <label for="DTI">Department of Trade and Industry: <span
                                        class="text-danger"></span></label>
                                <input type="text" id="DTI" name="DTI" class="form-control"
                                    data-mask="99999999">
                            </div>
                            <div class="form-group">
                                <label for="SEC">Security and Exchange Commission: <span
                                        class="text-danger"></span></label>
                                <input type="text" id="SEC" name="SEC" class="form-control"
                                    data-mask="PG999999999" placeholder="PG">
                            </div>
                            <div class="form-group">
                                <label for="nature_of_business">Nature of Business: <span
                                        class="text-danger">*</span></label>
                                <select id="nature_of_business" name="nature_of_business" class="form-control">
                                    <option value="">Select Nature of Business</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Wholesale">Wholesale</option>
                                    <option value="Manufacturing">Manufacturing</option>
                                    <option value="Service">Service</option>
                                    <option value="Construction">Construction</option>
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Food and Beverage">Food and Beverage</option>
                                    <option value="Healthcare">Healthcare</option>
                                    <option value="Education">Education</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Real Estate">Real Estate</option>
                                    <option value="Transportation">Transportation</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Tourism">Tourism</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary w-100 mb-3" id="mapModalBtn">SET MAP
                                LOCATION</button>
                            <div class="form-group">
                                <label for="location_latitude">Latitude: <span class="text-danger">*</span></label>
                                <input type="text" id="location_latitude" name="location_latitude" class="form-control"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="location_longitude">Longtitude: <span class="text-danger">*</span></label>
                                <input type="text" id="location_longitude" name="location_longitude" class="form-control"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Establishment Information -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEstablishment">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseEstablishment" aria-expanded="false"
                            aria-controls="collapseEstablishment">
                            Establishment Information
                        </button>
                    </h2>
                    <div id="collapseEstablishment" class="accordion-collapse collapse"
                        aria-labelledby="headingEstablishment" data-bs-parent="#establishmentAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">Establishment Name: <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group input-with-success">
                                        <label for="owner_name">Owner Name: <span class="text-danger">*</span></label>
                                        <input type="text" id="owner_name" name="owner_name" class="form-control"
                                            value="{{ optional(auth()->user()->client)->first_name }}{{ optional(auth()->user()->client)->middle_name ? ' ' . optional(auth()->user()->client)->middle_name[0] : '' }} {{ optional(auth()->user()->client)->last_name }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="representative_name">Representative Name: <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="representative_name" name="representative_name"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="trade_name">Trade Name: <span class="text-danger"></span></label>
                                        <input type="text" id="trade_name" name="trade_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_building_area">Total Building Area: <span
                                                class="text-danger">*</span></label>
                                        <input type="number" id="total_building_area" name="total_building_area"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="number_of_occupant">Number of Occupant: <span
                                                class="text-danger">*</span></label>
                                        <input type="number" id="number_of_occupant" name="number_of_occupant"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="type_of_occupancy">Type of Occupancy: <span
                                                class="text-danger">*</span></label>
                                        <select name="type_of_occupancy" id="type_of_occupancy" class="form-control">
                                            <option value="">Select Type of Occupancy</option>
                                            <option value="Commercial">Commercial</option>
                                            <option value="Industrial">Industrial</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="type_of_building">Type of Building: <span
                                                class="text-danger">*</span></label>
                                        <select name="type_of_building" id="type_of_building" class="form-control">
                                            <option value="">Select Type of Building</option>
                                            <option value="wood">Wood</option>
                                            <option value="concret">Concret</option>
                                            <option value="steel">Steel</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="number_of_storey">Number of Storeys: <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="number_of_storey"
                                            name="number_of_storey" min="0"
                                            value="{{ old('number_of_storey', $establishment->number_of_storey ?? 0) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="eminent_danger">In Eminent Danger: <span
                                                class="text-danger">*</span></label>
                                        <div class="form-check">
                                            <label for="eminent_danger1" class="form-check-label">
                                                <input class="form-check-input" type="radio" value="1"
                                                    id="eminent_danger1" name="eminent_danger">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label for="eminent_danger2" class="form-check-label">
                                                <input class="form-check-input" type="radio" value="0"
                                                    id="eminent_danger2" name="eminent_danger">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Address Information -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingAddress">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseAddress" aria-expanded="false" aria-controls="collapseAddress">
                            Address Information
                        </button>
                    </h2>
                    <div id="collapseAddress" class="accordion-collapse collapse" aria-labelledby="headingAddress"
                        data-bs-parent="#establishmentAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group input-with-success">
                                        <label for="region">Region: <span class="text-danger">*</span></label>
                                        <input type="text" id="region" name="region" class="form-control"
                                            value="REGION VII (EASTERN VISAYAS)" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group input-with-success">
                                        <label for="province">Province: <span class="text-danger">*</span></label>
                                        <input type="text" id="province" name="province" class="form-control"
                                            value="LEYTE" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group input-with-success">
                                        <label for="city_mun">City/Municipality: <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="city_mun" name="city_mun" class="form-control"
                                            value="ABUYOG" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="address_brgy">Barangay: <span class="text-danger">*</span></label>
                                        <input type="text" id="address_brgy" name="address_brgy" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="address_ex">Blk. No./ Street Name/ Building Name: <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="address_ex" name="address_ex" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact Information -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingContact">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseContact" aria-expanded="false" aria-controls="collapseContact">
                            Contact Information
                        </button>
                    </h2>
                    <div id="collapseContact" class="accordion-collapse collapse" aria-labelledby="headingContact"
                        data-bs-parent="#establishmentAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="email">Email Address: <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="landline">Landline: <span class="text-danger"></span></label>
                                        <input type="text" id="landline" name="landline" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="contact_number">Mobile Number: <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="contact_number" name="contact_number"
                                            class="form-control" data-mask="9999-999-9999" placeholder="09xx-xxx-xxxx"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" value="" id="user_owner"> <i></i> Use owner
                                            email address and mobile number
                                        </label>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Floating Save Button -->
        <button type="button" id="submit-btn" class="btn btn-primary floating-save-btn">
            💾
        </button>
    </form>
    <div id="map-content"></div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        let adding = true;

        function locate(lat, lng) {
            $('#map-content').html("");
            let timerInterval = showLoadingDialog('Loading GIS Module');

            $.ajax({
                method: 'GET',
                url: '{{ route('loadMap') }}',
                data: {
                    latitude: lat,
                    longitude: lng
                },
                success: function(response) {
                    clearInterval(timerInterval);
                    $('#map-content').html(response);
                    $('#addForm').hide();
                    Swal.close();
                },
                error: function(xhr) {
                    clearInterval(timerInterval);
                    Swal.close();
                    console.error('Error:', xhr.responseText);
                    alert('Failed to load the map view.');
                }
            });
        }

        $(document).ready(function() {
            $('#back-btn').show();

            $("#total_building_area").TouchSpin({
                min: 1,
                max: 10000000,
                postfix: ' SQM',
                verticalbuttons: true,
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $("#number_of_occupant").TouchSpin({
                min: 1,
                max: 10000000,
                postfix: ' PERSON',
                verticalbuttons: true,
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $('#mapModalBtn').click(function(event) {
                event.preventDefault();
                const lat = $('#location_latitude').val();
                const long = $('#location_longitude').val();
                locate(lat, long);
            });

            $('#user_owner').click(function() {
                if ($(this).prop('checked')) {
                    var email = "{{ optional(auth()->user()->client)->email ?? '' }}";
                    var contact_number = "{{ optional(auth()->user()->client)->contact_number ?? '' }}";
                    $('#email').val(email).prop('readonly', true);
                    $('#contact_number').val(contact_number).prop('readonly', true);
                } else {
                    $('#email').val('').prop('readonly', false);
                    $('#contact_number').val('').prop('readonly', false);
                }
            });

            $('#submit-btn').click(function(event) {
                event.preventDefault();
                let timerInterval = showLoadingDialog('Saving Establishment Information');
                let submitBtn = $('button[id="submit-btn"]');
                submitBtn.prop('disabled', true).html('<i class="bi bi-arrow-repeat spin-animation"></i>');

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.ajax({
                    method: 'POST',
                    url: '/establishments',
                    data: $('#addForm').serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        clearInterval(timerInterval);
                        $('html, body').animate({
                            scrollTop: 0
                        }, 'slow');
                        showToast('success', 'Success');
                        $('#addForm')[0].reset();
                        setTimeout(() => {
                            goBack();
                        }, 1000);
                    },
                    error: handleAjaxError,
                    complete: function() {
                        submitBtn.prop('disabled', false).text('💾');
                    }
                });
            });
        });
    </script>
@endsection
