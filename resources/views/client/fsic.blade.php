@extends('layout.master')
@section('APP-TITLE')
    Schedule
@endsection
@section('client-fsic')
    active
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
    <div class="modal fade" id="fsic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="fsicLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <form id="fsicForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fsicLabel">Fire Safety Inspection Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="fsicContent"></div>
                </div>
                <div class="modal-footer text-end">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        function viewFSIC(fsicId) {
            let timerInterval = showLoadingDialog('Retrieving FSIC');

            $.ajax({
                method: 'GET',
                url: `/fsics/${fsicId}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    clearInterval(timerInterval);
                    showToast('success', 'Success');

                    // Filter to get the first PDF file
                    let pdfFile = response.find(file => file.url.endsWith('.pdf'));

                    if (pdfFile) {
                        const pdfEmbed =
                            `<iframe src="${pdfFile.url}" width="100%" height="500px" style="border: none;"></iframe>`;
                        $('#fsicContent').html(pdfEmbed);
                        $('#fsic').modal('show');
                    } else {
                        showToast('warning', 'No PDF found.');
                    }

                    Swal.close();
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
                    <button class="btn btn-sm btn-info" onclick="viewFSIC('${row.id}')"><i class="bi bi-calendar-check"></i></button>`;
            }

        });
    </script>
@endsection
