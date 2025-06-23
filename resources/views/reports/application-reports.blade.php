@extends('layout.master')

@section('APP-TITLE')
    Application Reports
@endsection

@section('marshall-reports')
    active
@endsection

@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Application Reports</h4>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="fsic_type" class="form-label">FSIC Type</label>
                                <select name="fsic_type" id="fsic_type" class="form-select">
                                    <option value="">All</option>
                                    @foreach (\App\Models\Application::FSIC_TYPE as $type)
                                        <option value="{{ $type }}"
                                            {{ request('fsic_type') == $type ? 'selected' : '' }}>{{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </form>

                    <!-- Application Status Table -->
                    <div class="table-responsive">
                        <table id="applicationTable" class="table table-striped" data-toggle="table"
                            data-url="{{ route('reports.applications') }}" data-side-pagination="server"
                            data-pagination="true" data-page-size="10" data-server-sort="true"
                            data-query-params="queryParams" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="application_number" data-sortable="true">Application Number</th>
                                    <th data-field="establishment_name" data-sortable="true">Establishment</th>
                                    <th data-field="fsic_type" data-sortable="true">FSIC Type</th>
                                    <th data-field="application_date" data-sortable="true" data-formatter="dateFormatter">
                                        Application Date</th>
                                    <th data-field="latest_status" data-sortable="true">Status</th>
                                    <th data-field="latest_remarks" data-sortable="true">Remarks</th>
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
                fsic_type: $('#fsic_type').val()
            });
        }

        function dateFormatter(value) {
            return value ? new Date(value).toISOString().split('T')[0] : 'N/A';
        }

        $(document).ready(function() {
            $('#back-btn').show();

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                $('#applicationTable').bootstrapTable('refresh');
            });

            $('#applicationTable').bootstrapTable({
                buttonsAlign: 'left',
                searchAlign: 'left',
                toolbarAlign: 'right',
                onLoadSuccess: function() {
                    // Optional: Handle successful data load
                }
            });
        });
    </script>
@endsection
