@extends('layout.master')
@section('APP-TITLE')
    Application
@endsection
@section('client-application')
    active
@endsection
@section('APP-CSS')
    <style>
        .thumbnail-link img {
            transition: transform 0.2s ease-in-out;
        }

        .thumbnail-link img:hover {
            transform: scale(1.1);
            cursor: pointer;
        }

        #applicationStatus .iq-timeline0 ul {
            max-height: 50vh;
            overflow-y: auto;
            padding-right: 10px;
            position: relative;
            scrollbar-width: thin;
            /* Firefox */
            scrollbar-color: #d9534f #f8d7da;
            /* Thumb (Red), Track (Light Red) */
            perspective: 800px;
            /* Parallax effect */
        }

        /* Webkit Scrollbar */
        #applicationStatus .iq-timeline0 ul::-webkit-scrollbar {
            width: 8px;
        }

        #applicationStatus .iq-timeline0 ul::-webkit-scrollbar-track {
            background: #f8d7da;
            border-radius: 4px;
        }

        #applicationStatus .iq-timeline0 ul::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #d9534f, #c9302c);
            border-radius: 4px;
            transition: background 0.3s;
        }

        #applicationStatus .iq-timeline0 ul::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #c9302c, #a91d22);
        }
    </style>
@endsection
@section('APP-CONTENT')
    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Application List</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="toolbar">
                            <button type="submit" class="btn btn-primary" id="add-btn">Add New Application</button>
                        </div>
                        <table id="table1" data-toggle="data-bs-toggle" data-fixed-columns="true" data-fixed-number="1" data-fixed-right-number="1"
                            data-i18n-enhance="true" data-mobile-responsive="true" data-multiple-sort="true"
                            data-page-jump-to="true" data-pipeline="true" data-reorder-rows="true" data-sticky-header="true"
                            data-toolbar="#toolbar" data-pagination="true" data-search="true" data-show-refresh="true"
                            data-show-copy-rows="true" data-show-columns="true" data-url="">
                        </table>
                    </div>
                    <div class="card-footer text-end">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="applicationStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="applicationStatusLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applicationStatusLabel">Application Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                        <ul class="list-inline p-0 m-0">
                        </ul>
                    </div>
                </div>
                <div class="modal-footer text-end">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reUploadRequirements" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="reUploadRequirementsLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <form id="reUploadForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reUploadRequirementsLabel">Application Requirements</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="fileUploadContainer"></div>
                </div>
                <div class="modal-footer text-end">
                    <button type="submit" id="submit-btn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="requirements" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="requirementsLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requirementsLabel">Application Requiments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="requirementsContainer"></div>
                </div>
                <div class="modal-footer text-end">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        let applicationId;

        // Redirect to the edit page with a session token
        function reuploadFSICRequirements(applicationID, fsicType) {
            applicationId = applicationID;
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
                let requiredText = req.required ? '<span class="text-danger"></span>' : '';

                fileInputs += `<div class="form-group">
                    <label class="form-label">${req.name} ${requiredText}</label>
                    <input type="file" name="${inputName}" class="form-control">
                </div>`;
            });

            $("#fileUploadContainer").html(fileInputs);
            $('#reUploadRequirements').modal('show');
        }

        function viewFSICRequirements(applicationId) {
            $.ajax({
                method: 'GET',
                url: `/applications/${applicationId}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response && response.length > 0) {
                        let count = 1;
                        let html = '<ul class="list-group list-group-flush">';

                        response.forEach((req, index) => {
                            let displayName = req.name.replace(/_/g,
                                ' '); // Convert underscores to spaces

                            html += `
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="text-capitalize fw-medium">${count}. ${displayName}</span>
                                    <a href="${req.url}" data-fslightbox="fsic-gallery" data-type="image" class="thumbnail-link">
                                        <img src="${req.thumbnail}" alt="Thumbnail" class="img-thumbnail shadow-sm rounded" width="60">
                                    </a>
                                </li>`;
                            count++;
                        });

                        html += '</ul>';
                        $('#requirementsContainer').html(html);

                        // Refresh FS Lightbox to register new elements
                        refreshFsLightbox();
                    } else {
                        $('#requirementsContainer').html(
                            '<p class="text-muted text-center">No requirements found.</p>');
                    }

                    $('#requirements').modal('show'); // Show the modal
                },
                error: function(xhr) {
                    showToast('danger', xhr.responseJSON.error || 'Something went wrong.');
                }
            });
        }

        function deleteApplication(applicationId) {
            let timerInterval = showLoadingDialog('Cancelling Application');
            $.ajax({
                method: 'DELETE',
                url: `/applications/${applicationId}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    clearInterval(timerInterval);
                    $('#table1').bootstrapTable('refresh');
                    showToast('success', 'Success');
                    Swal.close();
                },
                error: handleAjaxError
            });
        }

        $(document).ready(function() {

            $('#add-btn').click(function(event) {
                event.preventDefault();
                window.location.href = '{{ route('application.add') }}';
            });

            var $table1 = $('#table1');

            $table1.bootstrapTable({
                url: '/applications',
                method: 'GET',
                pagination: true,
                sidePagination: 'server',
                pageSize: 10,
                pageList: [5, 10, 25, 50, 100],
                search: true,
                buttonsAlign: 'left',
                searchAlign: 'left',
                toolbarAlign: 'right',
                queryParams: function(params) {
                    return {
                        limit: params.limit,
                        page: params.offset / params.limit + 1
                    };
                },
                responseHandler: function(res) {
                    return {
                        total: res.pagination.total,
                        rows: res.rows
                    };
                },
                columns: [{
                        field: 'id',
                        title: 'ID'
                    },
                    {
                        field: 'application_number',
                        title: 'Application Number'
                    },
                    {
                        field: 'application_date',
                        title: 'Application Date',
                        formatter: function(value, row, index) {
                            if (!value) return 'N/A'; // Handle empty values

                            let date = new Date(value);
                            return date.toLocaleDateString('en-US', {
                                month: 'long',
                                day: 'numeric',
                                year: 'numeric'
                            });
                        }
                    },
                    {
                        field: 'establishment_name',
                        title: 'Establishment Name'
                    },
                    {
                        field: 'fsic_type',
                        title: 'FSIC Type',
                        formatter: function(value, row, index) {
                            const FSIC_TYPES = {
                                0: 'Occupancy',
                                1: 'New Business',
                                2: 'Renewal Business'
                            };

                            return FSIC_TYPES[value] || 'Unknown';
                        }
                    },
                    {
                        field: 'application_statuses',
                        title: 'Status',
                        formatter: function(value, row, index) {
                            if (!value || value.length === 0) {
                                return 'No Status';
                            }

                            // Find the latest status based on 'updated_at'
                            let latestStatus = value.reduce((latest, status) => {
                                return new Date(status.updated_at) > new Date(latest
                                    .updated_at) ? status : latest;
                            });

                            return latestStatus.status;
                        }
                    },
                    {
                        field: 'application_statuses',
                        title: 'Remarks',
                        formatter: function(value, row, index) {
                            if (!value || value.length === 0) {
                                return 'No Remarks';
                            }

                            // Sort the statuses by 'updated_at' in descending order (latest first)
                            let sortedStatuses = value.sort((a, b) => new Date(b.updated_at) -
                                new Date(a.updated_at));

                            // Check if there is a second-latest status
                            if (sortedStatuses.length > 1) {
                                return sortedStatuses[1].remarks || 'No Remarks';
                            } else {
                                return 'No Previous Remarks'; // If there's only one status, no previous remark exists
                            }
                        }
                    },
                    {
                        field: 'action',
                        title: 'Actions',
                        formatter: actionFormatter
                    }
                ]
            });

            // Format the "Actions" column
            function actionFormatter(value, row, index) {
                // Check if there are statuses
                if (!row.application_statuses || row.application_statuses.length === 0) {
                    return ''; // No statuses, so no buttons
                }

                // Find the latest status (based on updated_at)
                let latestStatus = row.application_statuses.reduce((latest, status) => {
                    return new Date(status.updated_at) > new Date(latest.updated_at) ? status : latest;
                });

                // Default action buttons
                let actionButtons = '';

                if (latestStatus.status === "Under Review") {
                    // If "Under Review", add "Reupload Requirements" button
                    actionButtons += `
                        <button class="btn btn-sm btn-warning" onclick="reuploadFSICRequirements('${row.id}', '${row.fsic_type}')">
                            <i class="bi bi-upload"></i>
                        </button>`;
                    actionButtons += `
                        <button class="btn btn-sm btn-danger" onclick="deleteApplication('${row.id}')">
                            <i class="bi bi-trash"></i>
                        </button> `;
                }

                actionButtons += `
                    <button class="btn btn-sm btn-info" onclick="viewFSICRequirements('${row.id}')">
                        <i class="bi bi-eye"></i>
                    </button>`;

                return actionButtons;
            }

            // Click event for the table rows
            $table1.on('click-row.bs.table', function(e, row, $element) {
                // Prevent multiple event bindings
                if (!$element.data('click-bound')) {
                    $element.data('click-bound', true);

                    // Attach click event to all <td> except the last column (Actions)
                    $element.find('td:not(:last)').on('click', function() {
                        // Open the modal
                        $('#applicationStatus').modal('show');

                        // Sort statuses from OLDEST to NEWEST
                        let sortedStatuses = row.application_statuses.sort((a, b) =>
                            new Date(a.updated_at) - new Date(b.updated_at)
                        );

                        // Find the earliest status date (if available) or use today's date for "Application Submitted"
                        let submittedDate = sortedStatuses.length > 0 ? sortedStatuses[0]
                            .updated_at : new Date();

                        // Clear previous content
                        let timelineContainer = $('#applicationStatus .iq-timeline0 ul');
                        timelineContainer.empty();

                        // Define available colors
                        let colors = ['text-primary', 'text-success', 'text-danger',
                        'text-warning'];

                        // Map statuses to Bootstrap Icons
                        let statusIcons = {
                            "Application Submitted": "bi-file-earmark-text",
                            "Under Review": "bi-eye",
                            "Scheduled for Inspection": "bi-calendar-check",
                            "In Progress": "bi-arrow-repeat",
                            "Approved": "bi-hand-thumbs-up",
                            "Certificate Approval Pending": "bi-hourglass-split",
                            "Certificate Issued": "bi-award",
                            "Completed": "bi-check-circle",
                            "Closed": "bi-x-circle",
                            "Error": "bi-exclamation-circle"
                        };

                        // Add "Application Submitted" as the first timeline entry
                        let formattedSubmittedDate = new Date(submittedDate).toLocaleDateString(
                            'en-US', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                        let submittedHTML = `
                            <li>
                                <div class="timeline-dots1 border-primary text-primary">
                                    <i class="icon-20 bi ${statusIcons["Application Submitted"]}"></i>
                                </div>
                                <h6 class="float-left mb-1">Application Submitted</h6>
                                <small class="float-right mt-1">${formattedSubmittedDate}</small>
                                <div class="d-inline-block w-100">
                                    <p>Initial submission of application.</p>
                                </div>
                            </li>
                        `;
                        timelineContainer.append(submittedHTML); // Ensure it's always first

                        // Clone sorted statuses to avoid modifying the original array
                        let augmentedStatuses = [...sortedStatuses];

                        // Insert "Approved" if necessary
                        if (
                            sortedStatuses.length >= 2 &&
                            sortedStatuses[sortedStatuses.length - 2].status ===
                            "Scheduled for Inspection" &&
                            sortedStatuses[sortedStatuses.length - 1].status ===
                            "Certificate Approval Pending"
                        ) {
                            augmentedStatuses.splice(sortedStatuses.length - 1, 0, {
                                status: "Approved",
                                updated_at: new Date(sortedStatuses[sortedStatuses.length -
                                    1].updated_at), // Use same date
                                remarks: "Application has been reviewed and approved.",
                            });
                        }

                        // Insert "Completed" and "Closed" if the latest status is "Certificate Issued"
                        if (sortedStatuses.length > 0 && sortedStatuses[sortedStatuses.length - 1]
                            .status === "Certificate Issued") {
                            augmentedStatuses.push({
                                status: "Completed",
                                updated_at: new Date(sortedStatuses[sortedStatuses.length -
                                    1].updated_at), // Use same date
                                remarks: "Process completed successfully.",
                            });
                            augmentedStatuses.push({
                                status: "Closed",
                                updated_at: new Date(sortedStatuses[sortedStatuses.length -
                                    1].updated_at), // Use same date
                                remarks: "Application process is now closed.",
                            });
                        }

                        // Loop through augmentedStatuses instead of sortedStatuses
                        augmentedStatuses.forEach((status, index) => {
                            let remarksText = status.remarks ? `<p>${status.remarks}</p>` :
                                '';

                            // Format date
                            let formattedDate = new Date(status.updated_at)
                                .toLocaleDateString('en-US', {
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                });

                            let assignedColor = colors[index % colors
                            .length]; // Assign colors sequentially
                            let statusIcon = statusIcons[status.status] ||
                                "bi-question-circle"; // Default icon if not found

                            let statusHTML = `
                                <li>
                                    <div class="timeline-dots1 border-primary ${assignedColor}">
                                        <i class="icon-20 bi ${statusIcon}"></i>
                                    </div>
                                    <h6 class="float-left mb-1">${status.status}</h6>
                                    <small class="float-right mt-1">${formattedDate}</small>
                                    <div class="d-inline-block w-100">
                                        ${remarksText}
                                    </div>
                                </li>
                            `;

                            timelineContainer.append(statusHTML);
                        });
                    });

                    // Initialize tooltip once
                    $element.attr('title', `Show application status`).tooltip({
                        trigger: 'hover',
                        placement: 'top'
                    });
                }
            });

            $('#reUploadForm').submit(function(event) {
                event.preventDefault();
                let timerInterval = showLoadingDialog('Uploading FISC Requirements');

                let submitBtn = $('button[id="submit-btn"]');
                submitBtn.prop('disabled', true).text('Processing...');

                // Remove previous error messages and invalid classes
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                const formData = new FormData(this);

                // Add `_method: PUT` to simulate a PUT request
                formData.append('_method', 'PUT');

                $.ajax({
                    method: 'POST',
                    url: `/applications/${applicationId}`,
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: 'JSON',
                    enctype: "multipart/form-data",
                    success: function(response) {
                        clearInterval(timerInterval);
                        $("#fileUploadContainer").html('');
                        showToast('success', 'Success');
                        $('#reUploadRequirements').modal('hide');
                        Swal.close();
                    },
                    error: handleAjaxError,
                    complete: function() {
                        submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });


        });
    </script>
@endsection
