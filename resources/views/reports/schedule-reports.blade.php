@extends('layout.master')

@section('APP-TITLE')
    Inspection Schedule Reports
@endsection

@section('marshall-reports')
    active
@endsection

@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Inspection Schedule Reports</h4>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">All</option>
                                    <option value="Ongoing" {{ request('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing
                                    </option>
                                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </form>

                    <!-- Inspection Schedule Table -->
                    <div class="table-responsive">
                        <table id="scheduleTable" class="table table-striped" data-toggle="table"
                            data-url="{{ route('reports.schedules') }}" data-side-pagination="server" data-pagination="true"
                            data-page-size="10" data-server-sort="true" data-query-params="queryParams" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="application_number" data-sortable="true">Application Number</th>
                                    <th data-field="establishment_name" data-sortable="true">Establishment</th>
                                    <th data-field="inspector_name" data-sortable="true">Inspector</th>
                                    <th data-field="schedule_date" data-sortable="true" data-formatter="dateFormatter">
                                        Schedule Date</th>
                                    <th data-field="status" data-sortable="true">Status</th>
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
                status: $('#status').val()
            });
        }

        function dateFormatter(value) {
            return value ? new Date(value).toISOString().split('T')[0] : 'N/A';
        }

        $(document).ready(function() {
            $('#back-btn').show();

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                $('#scheduleTable').bootstrapTable('refresh');
            });

            $('#scheduleTable').bootstrapTable({
                onLoadSuccess: function() {
                    // Optional: Handle successful data load
                }
            });
        });
    </script>
@endsection
