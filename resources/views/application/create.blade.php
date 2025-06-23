@extends('layout.master')
@section('APP-TITLE')
    New Application
@endsection
@section('client-application')
    active
@endsection
@section('APP-CONTENT')
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Establishment Application Wizard</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-wizard1" class="mt-3 text-center">
                        <ul id="top-tab-list" class="p-0 row list-inline">
                            <li class="mb-2 col-lg-3 col-md-6 text-start active" id="establishment">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Establishment</span>
                                </a>
                            </li>
                            <li id="application" class="mb-2 col-lg-3 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Application</span>
                                </a>
                            </li>
                            <li id="requirements" class="mb-2 col-lg-3 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Requirements</span>
                                </a>
                            </li>
                            <li id="confirm" class="mb-2 col-lg-3 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Finish</span>
                                </a>
                            </li>
                        </ul>
                        <!-- fieldsets -->
                        <fieldset>
                            <div class="form-card text-start">
                                <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4">Establishment Information:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 1 - 4</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Establishment: *</label>
                                            <select class="form-control" name="establishment_id" id="establishment_id">
                                                @foreach ($establishments as $establishment)
                                                    <option value="{{ $establishment->id }}">{{ $establishment->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Type of Building: </label>
                                            <p class="form-control" id="type_of_building">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nature of Business: </label>
                                            <p class="form-control" id="nature_of_business">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Type of Occupancy: </label>
                                            <p class="form-control" id="type_of_occupancy">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Number of Occupant: </label>
                                            <p class="form-control" id="number_of_occupant">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Business Address: </label>
                                            <p class="form-control" id="establishment_address">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" name="next" class="btn btn-primary next action-button float-end"
                                value="Next">Next</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card text-start">
                                <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4">Application Information:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 2 - 4</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">FSIC Application: <span
                                                    class="text-danger">*</span></label>
                                            <select name="fsic_type" id="fsic_type" class="form-control">
                                                <option value="0">FSIC FOR CERTIFICATE OF OCCUPANCY</option>
                                                <option value="1">FSIC FOR BUSINESS PERMIT (NEW BUSINESS)</option>
                                                <option value="2">FSIC FOR BUSINESS PERMIT (RENEWAL BUSINESS)</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="FSIC_0" style="display: none;">
                                            <h3 class="mb-3">FSIC FOR CERTIFICATE OF OCCUPANCY REQUIREMENTS</h3>
                                            <ul class="list-group">
                                                <li class="list-group-item">• ENDORSEMENT FROM OFFICE OF THE BUILDING
                                                    OFFICAL (OBO)
                                                </li>
                                                <li class="list-group-item">• CERTIFICATE OF COMPLETION</li>
                                                <li class="list-group-item">• CERTIFIED TRUE COPY OF ASSESMENT FEE FOR
                                                    CERTIFICATE
                                                    OCCUPANCY
                                                    FROM OBO</li>
                                                <li class="list-group-item">• AS-BUILD PLAN (IF NECESSARY)</li>
                                                <li class="list-group-item">• ONE (1) SET OF FIRE SAFETY COMPLIANCE AND
                                                    COMMISIONING
                                                    REPORT
                                                    (FSCCR) (IF NECESSARY)</li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="FSIC_1" style="display: none;">
                                            <h3 class="mb-3">FSIC FOR BUSINESS PERMIT (NEW BUSINESS) REQUIREMENTS</h3>
                                            <ul class="list-group">
                                                <li class="list-group-item">• CERTIFIED TRUE COPY OF VALID CERTIFICATE OF
                                                    OCCUPANCY
                                                </li>
                                                <li class="list-group-item">• ASSESSMENT OF BUSINESS PERMIT FEE/TAX<br>
                                                    ASSESSMENT
                                                    BILL FROM
                                                    BPLO</li>
                                                <li class="list-group-item">• AFFIDAVIT OF UNDERTAKING THAT THERE WAS NO
                                                    SUBSTANTIAL
                                                    CHANGES
                                                    MADE ON BUILDING/ESTABLISHMENT</li>
                                                <li class="list-group-item">• COPY OF FIRE INSURANCE (IF NESSARY)</li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="FSIC_2" style="display: none;">
                                            <h3 class="mb-3">FSIC FOR BUSINESS PERMIT (RENEWAL BUSINESS) REQUIREMENTS
                                            </h3>
                                            <ul class="list-group">
                                                <li class="list-group-item">• ASSESSMENT OF THE BUSINESS PERMIT FEE/TAX<br>
                                                    ASSESSMENT BILL
                                                    FROM BPLO</li>
                                                <li class="list-group-item">• COPY OF FIRE INSURANCE (IF NECESSARY)</li>
                                                <li class="list-group-item">• ONE (1) SET OF FIRE SAFETY MAINTENANCE REPORT
                                                    (FSMR)
                                                    (IF
                                                    NECESSARY)</li>
                                                <li class="list-group-item">• FIRE SAFETY CLEARANCE FOR WELDING, CUTTING,
                                                    AND OTHER
                                                    HOT WORK
                                                    OPERATIONS (IF REQUIRED)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" name="next" class="btn btn-primary next action-button float-end"
                                value="Next">Next</button>
                            <button type="button" name="previous"
                                class="btn btn-dark previous action-button-previous float-end me-1"
                                value="Previous">Previous</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card text-start">
                                <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4">Requirements Upload:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 3 - 4</h2>
                                    </div>
                                </div>
                                <div id="fileUploadContainer"></div>
                            </div>
                            <button type="button" name="next" class="btn btn-primary next action-button float-end"
                                value="Submit">Submit</button>
                            <button type="button" name="previous"
                                class="btn btn-dark previous action-button-previous float-end me-1"
                                value="Previous">Previous</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4 text-left">Finish:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 4 - 4</h2>
                                    </div>
                                </div>
                                <br><br>
                                <h2 class="text-center text-success"><strong>SUCCESS !</strong></h2>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/images/pages/img-success.png') }}" class="img-fluid"
                                            alt="fit-image">
                                    </div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                    <div class="text-center col-7">
                                        <h5 class="text-center purple-text">Your application has been submitted</h5>
                                    </div>
                                </div>

                                <div class="progress mt-4">
                                    <div id="progress-bar" class="progress-bar bg-success" role="progressbar"
                                        style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <!-- Form Wizard Script -->
    <script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>
    <script type="text/javascript">
        function loadFileInputs(fsicType) {
            let requirements = {
                0: [ // Occupancy
                    {
                        name: "ENDORSEMENT FROM OFFICE OF THE BUILDING OFFICIAL (OBO)",
                        required: true
                    },
                    {
                        name: "CERTIFICATE OF COMPLETION",
                        required: true
                    },
                    {
                        name: "CERTIFIED TRUE COPY OF ASSESSMENT FEE FOR CERTIFICATE OCCUPANCY FROM OBO",
                        required: true
                    },
                    {
                        name: "AS-BUILT PLAN (IF NECESSARY)",
                        required: false
                    },
                    {
                        name: "FIRE SAFETY COMPLIANCE AND COMMISSIONING REPORT (FSCCR) (IF NECESSARY)",
                        required: false
                    }
                ],
                1: [ // New Business
                    {
                        name: "CERTIFIED TRUE COPY OF VALID CERTIFICATE OF OCCUPANCY",
                        required: true
                    },
                    {
                        name: "ASSESSMENT OF BUSINESS PERMIT FEE/TAX ASSESSMENT BILL FROM BPLO",
                        required: true
                    },
                    {
                        name: "AFFIDAVIT OF UNDERTAKING NO SUBSTANTIAL CHANGES",
                        required: true
                    },
                    {
                        name: "COPY OF FIRE INSURANCE (IF NECESSARY)",
                        required: false
                    }
                ],
                2: [ // Renewal Business
                    {
                        name: "ASSESSMENT OF THE BUSINESS PERMIT FEE/TAX ASSESSMENT BILL FROM BPLO",
                        required: true
                    },
                    {
                        name: "COPY OF FIRE INSURANCE (IF NECESSARY)",
                        required: false
                    },
                    {
                        name: "FIRE SAFETY MAINTENANCE REPORT (FSMR) (IF NECESSARY)",
                        required: false
                    },
                    {
                        name: "FIRE SAFETY CLEARANCE HOT WORK OPERATIONS (IF REQUIRED)",
                        required: false
                    }
                ]
            };

            let fileInputs = "";
            requirements[fsicType].forEach(req => {
                let inputName = req.name
                    .toLowerCase()
                    .replace(/\s+/g, '_') // Convert spaces to underscores
                    .replace(/[()]/g, '') // Remove parentheses
                    .replace(/\//g, '_'); // Replace slashes with underscores

                let requiredTag = req.required ? 'required' : '';
                let requiredText = req.required ? '<span class="text-danger">*</span>' : '';

                fileInputs += `<div class="form-group">
                    <label class="form-label">${req.name} ${requiredText}</label>
                    <input type="file" name="${inputName}" class="form-control" ${requiredTag}>
                </div>`;
            });

            $("#fileUploadContainer").html(fileInputs);
        }

        $(document).ready(function() {

            $('#back-btn').show();

            $('#establishment_id').change(function() {
                let establishmentId = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: `/establishments/${establishmentId}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        let establishment = response.data;
                        $('#type_of_building').text(establishment.type_of_building);
                        $('#nature_of_business').text(establishment.nature_of_business);
                        $('#type_of_occupancy').text(establishment.type_of_occupancy);
                        $('#number_of_occupant').text(establishment.number_of_occupant);
                        $('#establishment_address').text(`Brgy. ${establishment.address_brgy}, Abuyog, Leyte`);
                    },
                    error: function(xhr) {
                        showToast('danger', xhr.responseJSON.message ||
                            'Something went wrong.');
                    }
                });
            });

            // $('#establishment_id').click();
            $('#establishment_id').trigger('change');

            $('#fsic_type').change(function() {
                // Hide all elements first
                $('#FSIC_0, #FSIC_1, #FSIC_2').hide();

                // Show the selected element
                $('#FSIC_' + $(this).val()).show();

                let fsicType = $(this).val();
                loadFileInputs(fsicType);
            });

            $("select").select2({
                placeholder: 'Select Establishment',
                width: '100%'
            });

        });
    </script>
@endsection
