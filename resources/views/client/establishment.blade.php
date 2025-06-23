@extends('layout.master')
@section('APP-TITLE')
    Establishment
@endsection
@section('client-establishment')
    active
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
                            <button type="submit" class="btn btn-primary" id="add-btn">Add New Establishment</button>
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
    <div id="map-content"></div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        let adding = false;

        // Redirect to the edit page with a session token
        function editEstablishment(establishmentId) {
            let timerInterval = showLoadingDialog('Getting establishment information');

            $.ajax({
                url: `/client/${establishmentId}/generate-session`, // Corrected URL
                method: 'POST', // Changed to match the route
                success: function(response) {
                    clearInterval(timerInterval);
                    if (response.sessionID) {
                        window.location.href = `/client/establishment/${response.sessionID}/edit`;
                    } else {
                        showToast('danger', 'Failed to generate session.');
                    }
                    Swal.close();
                },
                error: function() {
                    clearInterval(timerInterval);
                    Swal.close();
                    showToast('danger', 'Error generating session token.');
                }
            });
        }

        function deleteEstablishment(establishmentId) {
            let timerInterval = showLoadingDialog('Removing establishment');

            $.ajax({
                method: 'DELETE',
                url: `/establishments/${establishmentId}`,
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

        function showEstablishment(establishmentId) {
            let timerInterval = showLoadingDialog('Getting establishment information');

            $.ajax({
                url: `/client/${establishmentId}/generate-session`,
                method: 'POST',
                success: function(response) {
                    clearInterval(timerInterval);
                    if (response.sessionID) {
                        window.location.href = `/client/establishment/${response.sessionID}/show`;
                    } else {
                        showToast('danger', 'Failed to generate session.');
                    }
                    Swal.close();
                },
                error: function() {
                    clearInterval(timerInterval);
                    Swal.close();
                    showToast('danger', 'Error generating session token.');
                }
            });
        }

        $(document).ready(function() {

            $('#add-btn').click(function(event) {
                event.preventDefault();
                window.location.href = '{{ route('establishment.add') }}';
            });

            var $table1 = $('#table1');

            $table1.bootstrapTable({
                url: '/establishments',
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
                let actionButton = '';
                let hasApplication = row.has_application;

                if (hasApplication) {
                    actionButton =
                        `<button class="btn btn-sm btn-primary" onclick="showEstablishment('${row.id}')"><i class="bi bi-eye"></i></button>`;
                } else {
                    actionButton =
                        `<button class="btn btn-sm btn-primary" onclick="editEstablishment('${row.id}')"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="deleteEstablishment('${row.id}')"><i class="bi bi-trash"></i></button>`;
                }
                return actionButton;
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
