@extends('layout.master')
@section('APP-TITLE')
    Schedule
@endsection
@section('inspector-inspected')
    active
@endsection
@section('APP-CONTENT')
    <div class="row" id="addForm">
        <div class="col-lg-12">
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Schedule List</h4>
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
    <div class="modal fade" id="remark" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="remarksLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <form id="remarksForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remarksLabel">Application Remarks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="remarks">Remarks: <span class="text-danger">*</span></label>
                        <select name="remarks" id="remarks" class="form-control">
                            <option value="disabled" selected disabled>Select Remarks</option>
                            <option value="Issue Notice to Comply">Issue Notice to Comply</option>
                            <option value="Issue Notice to Correct Violation">Issue Notice to Correct Violation</option>
                            <option value="Issue Abatement Order">Issue Abatement Order</option>
                            <option value="Issue Stoppage of Operation">Issue Stoppage of Operation</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="schedule_date">Re-Schedule Date: <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="schedule_date" name="schedule_date"
                            min="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="schedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="scheduleLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <form id="scheduleForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleLabel">Inspection Re-scheduled</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reschedule_date">Re-Schedule Date: <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="reschedule_date" name="reschedule_date"
                            min="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="proof" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="proofLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <form id="proofForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="proofLabel">Proof of Investigation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="image_proof">Proof: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image_proof" name="image_proof">
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        adding = false;
        let applicationId;

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
                    showToast('danger', 'Failed to load the map view.');
                }
            });
        }

        function addOneDayToDate(date) {
            // Convert date to a Date object and add one day
            let minDate = new Date(date);
            minDate.setDate(minDate.getDate() + 1);

            // Format it back to YYYY-MM-DD for the input field
            let formattedMinDate = minDate.toISOString().split('T')[0];

            return formattedMinDate
        }

        function applicationRemarks(applicationID, scheduleDate) {
            applicationId = applicationID;

            $('#schedule_date').attr('min', addOneDayToDate(scheduleDate));
            $('#remark').modal('show');
        }

        function applicationSchedule(applicationID, scheduleDate) {
            applicationId = applicationID;

            $('#reschedule_date').attr('min', addOneDayToDate(scheduleDate));
            $('#schedule').modal('show');
        }

        function approvedInspection(applicationID) {
            applicationId = applicationID;

            $('#proof').modal('show');
        }

        $(document).ready(function() {
            var $table1 = $('#table1');

            $table1.bootstrapTable({
                url: '/schedules',
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
                        page: params.offset / params.limit + 1,
                        filter: 'Inspected',
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
                        title: 'Application #'
                    },
                    {
                        field: 'establishment_name',
                        title: 'Establishment Name'
                    },
                    {
                        field: 'inspector',
                        title: 'Inspector Name'
                    },
                    {
                        field: 'status',
                        title: 'Status'
                    },
                    {
                        field: 'schedule_date',
                        title: 'Schedule Date',
                        formatter: function(value, row, index) {
                            if (!value) return 'N/A';

                            let date = new Date(value);
                            return date.toLocaleDateString('en-US', {
                                month: 'long',
                                day: 'numeric',
                                year: 'numeric'
                            });
                        }
                    }
                ]
            });

            // Format the "Actions" column
            function actionFormatter(value, row, index) {
                // return `
            //     <button class="btn btn-sm btn-info" onclick="applicationSchedule('${row.application_id}', '${row.schedule_date}')"><i class="bi bi-calendar-check"></i></button>
            //     <button class="btn btn-sm btn-success" onclick="applicationRemarks('${row.application_id}', '${row.schedule_date}')"><i class="bi bi-card-checklist"></i></button>`;
                return `
                    <button class="btn btn-sm btn-success" onclick="approvedInspection('${row.application_id}')"><i class="bi bi-check-circle"></i></button>`;
            }

            // Click event for the table rows
            $table1.on('click-row.bs.table', function(e, row, $element) {
                // Prevent multiple event bindings
                if (!$element.data('click-bound')) {
                    $element.data('click-bound', true);

                    // Attach click event to all <td> except the last column (Actions)
                    $element.find('td:not(:last)').on('click', function() {
                        locate(row.location_latitude, row.location_longitude);
                    });

                    // Initialize tooltip once
                    $element.attr('title', `Show establishment location`).tooltip({
                        trigger: 'hover',
                        placement: 'top'
                    });
                }
            });

        });
    </script>
@endsection
