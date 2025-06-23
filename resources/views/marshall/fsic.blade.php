@extends('layout.master')
@section('APP-TITLE')
    Schedule
@endsection
@section('marshall-fsic')
    active
@endsection
@section('APP-CSS')
    <style type="text/css">
        /* 📄 PDF Canvas Styling */

        .pdf-view-container {
            background: white;
            border: 1px solid rgba(178, 34, 34, 0.2);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            max-width: 800px;
            margin: 0 auto;
            min-height: 400px;
            overflow: auto;
            box-shadow: var(--shadow);
            transition: opacity 0.5s ease;
        }

        .pdf-view-container.show {
            opacity: 1;
        }

        #certificate-content {
            font-size: 1rem;
            line-height: 1.6;
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
                            <h4 class="card-title">FSIC List</h4>
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
    <div class="modal fade" id="fsic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="fsicLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <form id="fsicForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fsicLabel">Fire Safety Inspection Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- HTML View Container -->
                    <div id="pdf-view" class="pdf-view-container">
                        <div id="certificate-content"></div>
                    </div>
                </div>
                <div class="modal-footer text-end">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.0/purify.min.js"></script>
    <script type="text/javascript">
        function viewFSIC(fsicNo) {
            let timerInterval = showLoadingDialog('Retrieving FSIC');

            $.ajax({
                method: 'GET',
                url: `/search-FSIC`,
                data: {
                    fsic_no: fsicNo
                },
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    console.log(response);

                    if (response.message) {
                        showToast('danger', response.message);
                        return;
                    }

                    if (!response.html || !response.file_url) {
                        showToast('danger', 'Invalid response from server.');
                        return;
                    }

                    // Sanitize and render HTML content
                    $('#certificate-content').html(DOMPurify.sanitize(response.html));

                    clearInterval(timerInterval);
                    Swal.close();
                    showToast('success', 'Success');

                    $('#fsic').modal('show');
                },
                error: handleAjaxError
            });
        }

        $(document).ready(function() {
            var $table1 = $('#table1');

            $table1.bootstrapTable({
                url: '/fsics',
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
                        field: 'fsic_no',
                        title: 'FSIC No.'
                    },
                    {
                        field: 'client',
                        title: 'Clint Name'
                    },
                    {
                        field: 'name',
                        title: 'Establishment Name'
                    },
                    {
                        field: 'nature_of_business',
                        title: 'Nature of Business'
                    },
                    {
                        field: 'issue_date',
                        title: 'Issue Date',
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
                        field: 'expiration_date',
                        title: 'Expiration Date',
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

            // Format the "Actions" column
            function actionFormatter(value, row, index) {
                return `
                    <button class="btn btn-sm btn-info" onclick="viewFSIC('${row.fsic_no}')"><i class="bi bi-calendar-check"></i></button>`;
            }

        });
    </script>
@endsection
