@extends('layout.master')
@section('APP-TITLE')
    Schedule
@endsection
@section('inspector-schedule')
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
                        <label for="schedule_date">Re-Schedule Date: <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="schedule_date" name="schedule_date"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="image_proof_reject">Proof: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image_proof_reject" name="image_proof_reject"
                            accept="image/*,.pdf">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks: <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="12"></textarea>
                        <div class="invalid-feedback"></div>
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
                        <input type="file" class="form-control" id="image_proof" name="image_proof"
                            accept="image/*,.pdf">
                        <div class="invalid-feedback"></div>
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
            let minDate = new Date(date);
            minDate.setDate(minDate.getDate() + 1);
            return minDate.toISOString().split('T')[0];
        }

        function applicationRemarks(applicationID, scheduleDate) {
            applicationId = applicationID;
            $('#schedule_date').attr('min', addOneDayToDate(scheduleDate));
            $('#remark').modal('show');
        }

        function approvedInspection(applicationID) {
            applicationId = applicationID;
            $('#proof').modal('show');
        }

        function rejectInspection(applicationID, scheduleDate) {
            applicationId = applicationID;
            $('#schedule_date').attr('min', addOneDayToDate(scheduleDate));
            $('#remark').modal('show');
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
                    },
                    {
                        field: 'action',
                        title: 'Actions',
                        formatter: actionFormatter
                    }
                ]
            });

            function actionFormatter(value, row, index) {
                return `
                    <button class="btn btn-sm btn-success" onclick="approvedInspection('${row.application_id}')" title="Approve Inspection"><i class="bi bi-check-circle"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="rejectInspection('${row.application_id}','${row.schedule_date}')" title="Reject Inspection"><i class="bi bi-x-circle"></i></button>`;
            }

            $table1.on('click-row.bs.table', function(e, row, $element) {
                if (!$element.data('click-bound')) {
                    $element.data('click-bound', true);
                    $element.find('td:not(:last)').on('click', function() {
                        locate(row.location_latitude, row.location_longitude);
                    });
                    $element.attr('title', `Show establishment location`).tooltip({
                        trigger: 'hover',
                        placement: 'top'
                    });
                }
            });

            // Disable weekends for schedule_date
            $('#schedule_date').on('input', function() {
                const selectedDate = new Date(this.value);
                const day = selectedDate.getDay(); // 0 = Sunday, 6 = Saturday
                if (day === 0 || day === 6) {
                    alert('Please select a weekday (Monday to Friday).');
                    this.value = '';
                }
            });

            $('#remarksForm').submit(function(event) {
                event.preventDefault();
                let timerInterval = showLoadingDialog('Notifying Establishment Owner');
                let submitBtn = $('button[type="submit"]', this);
                submitBtn.prop('disabled', true).text('Processing...');

                // Clear previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('').hide();

                // Client-side validation
                let isValid = true;
                const scheduleDate = $('#remarksForm #schedule_date').val().trim();
                const remarksText = $('#remarksForm #remarks').val().trim();
                const imageProof = $('#remarksForm #image_proof_reject')[0].files[0];

                if (!scheduleDate) {
                    $('#schedule_date').addClass('is-invalid').next('.invalid-feedback').text(
                        'Re-Schedule Date is required.').show();
                    isValid = false;
                }
                if (!remarksText) {
                    $('#remarks').addClass('is-invalid').next('.invalid-feedback').text(
                        'Remarks are required.').show();
                    isValid = false;
                }
                if (!imageProof) {
                    $('#image_proof_reject').addClass('is-invalid').next('.invalid-feedback').text(
                        'Proof file is required.').show();
                    isValid = false;
                }

                if (!isValid) {
                    clearInterval(timerInterval);
                    submitBtn.prop('disabled', false).text('Save');
                    Swal.close();
                    return;
                }

                // Prepare FormData for file upload
                let formData = new FormData(this);
                formData.append('_method', 'PUT');
                formData.append('status', 'Scheduled for Inspection');

                $.ajax({
                    method: 'POST', // Use POST for FormData with _method=PUT
                    url: `/applicationsStatus/${applicationId}`,
                    data: formData,
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $table1.bootstrapTable('refresh');
                        clearInterval(timerInterval);
                        showToast('success', response.message);
                        $('#remarksForm')[0].reset();
                        $('#remark').modal('hide');
                        Swal.close();
                    },
                    error: function(xhr) {
                        clearInterval(timerInterval);
                        Swal.close();
                        let errors = xhr.responseJSON?.errors || {
                            message: 'An error occurred.'
                        };
                        if (errors.message) {
                            showToast('danger', errors.message);
                        } else {
                            $.each(errors, function(field, messages) {
                                $(`#${field.replace('.', '_')}`).addClass('is-invalid')
                                    .next('.invalid-feedback').text(messages[0]).show();
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });

            $('#proofForm').submit(function(event) {
                event.preventDefault();
                let timerInterval = showLoadingDialog('Approving Establishment Inspection');
                let submitBtn = $('button[type="submit"]', this);
                submitBtn.prop('disabled', true).text('Processing...');

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('').hide();

                let formData = new FormData(this);
                formData.append('_method', 'PUT');
                formData.append('status', 'Certificate Approval Pending');
                formData.append('remarks', 'Establishment Complied');

                $.ajax({
                    method: 'POST',
                    url: `/applicationsStatus/${applicationId}`,
                    data: formData,
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        clearInterval(timerInterval);
                        $table1.bootstrapTable('refresh');
                        showToast('success', 'Success');
                        $('#proofForm')[0].reset();
                        $('#proof').modal('hide');
                        Swal.close();
                    },
                    error: function(xhr) {
                        clearInterval(timerInterval);
                        Swal.close();
                        let errors = xhr.responseJSON?.errors || {
                            message: 'An error occurred.'
                        };
                        if (errors.message) {
                            showToast('danger', errors.message);
                        } else {
                            $.each(errors, function(field, messages) {
                                $(`#${field.replace('.', '_')}`).addClass('is-invalid')
                                    .next('.invalid-feedback').text(messages[0]).show();
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });
        });
    </script>
@endsection
