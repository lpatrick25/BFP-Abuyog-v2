@extends('layout.master')
@section('APP-TITLE')
    Marshall
@endsection
@section('admin-marshall')
    active
@endsection
@section('APP-CONTENT')
    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Marshall List</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="toolbar">
                            <button type="submit" class="btn btn-primary" id="add-btn">Add New Marshall</button>
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
@endsection
@section('APP-SCRIPT')
    <script type="text/javascript">
        function editMarshall(marshallId) {
            $.ajax({
                url: `/admin/${marshallId}/generate-session`,
                method: 'POST',
                success: function(response) {
                    if (response.sessionID) {
                        window.location.href = `/admin/marshall/${response.sessionID}/edit`;
                    } else {
                        showToast('danger', 'Failed to generate session.')
                    }
                },
                error: function() {
                    showToast('danger', 'Error generating session token.')
                }
            });
        }

        function deleteMarshall(marshallId) {
            $.ajax({
                method: 'DELETE',
                url: `/marshalls/${marshallId}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    $('#table1').bootstrapTable('refresh');
                    showToast('success', 'Success');
                },
                error: function(xhr) {
                    showToast('danger', xhr.responseJSON.message || 'Something went wrong.');
                }
            });
        }

        $(document).ready(function() {

            $('#add-btn').click(function(event) {
                event.preventDefault();
                window.location.href = '{{ route('marshall.add') }}';
            });

            var $table1 = $('#table1');

            $table1.bootstrapTable({
                url: '/marshalls',
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
                        field: 'full_name',
                        title: 'Name'
                    },
                    {
                        field: 'contact_number',
                        title: 'Contact Number'
                    },
                    {
                        field: 'email',
                        title: 'Email'
                    },
                    {
                        field: 'action',
                        title: 'Actions',
                        formatter: actionFormatter
                    }
                ]
            });

            function actionFormatter(value, row, index) {
                return `<button class="btn btn-sm btn-primary" onclick="editMarshall('${row.id}')"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger" onclick="deleteMarshall('${row.id}')"><i class="bi bi-trash-fill"></i></button>`;
            }

        });
    </script>
@endsection
