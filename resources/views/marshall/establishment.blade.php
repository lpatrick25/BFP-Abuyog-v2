@extends('layout.master')
@section('APP-TITLE')
    Establishment
@endsection
@section('marshall-establishment')
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
    <div class="row" id="addForm">
        <div class="col-lg-12">
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Establishment List</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="toolbar">
                        </div>
                        <table id="table1" data-toggle="data-bs-toggle" data-fixed-columns="true" data-fixed-number="1"
                            data-fixed-right-number="1" data-i18n-enhance="true" data-mobile-responsive="true"
                            data-multiple-sort="true" data-page-jump-to="true" data-pipeline="true" data-reorder-rows="true"
                            data-sticky-header="true" data-toolbar="#toolbar" data-pagination="true" data-search="true"
                            data-show-refresh="true" data-show-copy-rows="true" data-show-columns="true" data-url="">
                        </table>
                    </div>
                    <div class="card-footer text-end">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="map-content"></div>
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
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        let adding = false;

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
                    console.error('Error:', xhr.responseText);
                    showToast('danger', xhr.responseText || 'Something went wrong.');
                    Swal.close();
                }
            });
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

        $(document).ready(function() {

            var $table1 = $('#table1');

            $table1.bootstrapTable({
                url: '/establishments', // Laravel API endpoint
                method: 'GET',
                pagination: true,
                sidePagination: 'server', // Enable server-side pagination
                pageSize: 10, // Default records per page
                pageList: [5, 10, 25, 50, 100], // Page size options
                search: true, // Enable search
                buttonsAlign: 'left',
                searchAlign: 'left',
                toolbarAlign: 'right',
                queryParams: function(params) {
                    return {
                        limit: params.limit, // Number of records per page
                        page: params.offset / params.limit + 1 // Page number
                    };
                },
                responseHandler: function(res) {
                    return {
                        total: res.pagination.total, // Set total count
                        rows: res.rows // Set data rows
                    };
                },
                columns: [{
                        field: 'id',
                        title: 'ID'
                    },
                    {
                        field: 'name',
                        title: 'Name'
                    },
                    {
                        field: 'nature_of_business',
                        title: 'Nature of Business'
                    },
                    {
                        field: 'type_of_occupancy',
                        title: 'Type of Occupancy'
                    },
                    {
                        field: 'type_of_building',
                        title: 'Type of Building'
                    },
                    {
                        field: 'total_building_area',
                        title: 'Building Area'
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
                let actionButton =
                    `<button class="btn btn-sm btn-primary" onclick="locate('${row.location_latitude}', '${row.location_longitude}')"><i class="bi bi-geo-alt-fill"></i></button>
                    <button class="btn btn-sm btn-info" onclick="viewFSICRequirements('${row.application_id}')"><i class="bi bi-card-checklist"></i></button>`;
                return actionButton;
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

                        console.log(sortedStatuses.length === 0);

                        // Find the earliest status date (if available) or use today's date for "Application Submitted"
                        let submittedDate = sortedStatuses.length > 0 ? sortedStatuses[0]
                            .updated_at : new Date();

                        // Clear previous content
                        let timelineContainer = $('#applicationStatus .iq-timeline0 ul');
                        timelineContainer.empty();

                        // Define available colors
                        let colors = ['text-primary', 'text-success', 'text-danger',
                            'text-warning'
                        ];

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

                        if (sortedStatuses.length !== 0) {
                            timelineContainer.append(submittedHTML); // Ensure it's always first
                        } else {
                            timelineContainer.append(
                                `
                                    <li>
                                        <div class="timeline-dots1 border-primary text-primary">
                                            <i class="icon-20 bi ${statusIcons["Closed"]}"></i>
                                        </div>
                                        <h6 class="float-left mb-1" style="margin-top: 10px;">No Application Submitted</h6>
                                    </li>
                                `
                            );
                        }

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

        });
    </script>
@endsection
