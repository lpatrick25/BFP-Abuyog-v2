@extends('layout.master')

@section('APP-TITLE')
    Audit and Historical Reports
@endsection

@section('marshall-reports')
    active
@endsection

@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Audit and Historical Reports</h4>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="application_id" class="form-label">Application ID</label>
                                <input type="number" name="application_id" id="application_id"
                                    value="{{ request('application_id') }}" class="form-control">
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </form>

                    <!-- Application History Table -->
                    <div class="table-responsive">
                        <table id="auditTable" class="table table-striped" data-toggle="table"
                            data-url="{{ route('reports.audit') }}" data-side-pagination="server" data-pagination="true"
                            data-page-size="10" data-server-sort="true" data-query-params="queryParams" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="application_number" data-sortable="true">Application Number</th>
                                    <th data-field="establishment_name" data-sortable="true">Establishment</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="remarks" data-sortable="true">Remarks</th>
                                    <th data-field="created_at" data-sortable="true" data-formatter="dateTimeFormatter">
                                        Created At</th>
                                    <th data-field="updated_at" data-sortable="true" data-formatter="dateTimeFormatter">
                                        Updated At</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script type="text/javascript">
        function queryParams(params) {
            return $.extend(params, {
                application_id: $('#application_id').val()
            });
        }

        function dateTimeFormatter(value) {
            return value ? new Date(value).toISOString().replace('T', ' ').split('.')[0] : 'N/A';
        }

        $(document).ready(function() {
            $('#back-btn').show();

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                $('#auditTable').bootstrapTable('refresh');
            });

            $('#auditTable').bootstrapTable({
                onLoadSuccess: function() {
                    // Optional: Handle successful data load
                }
            });
        });
    </script>
@endsection
