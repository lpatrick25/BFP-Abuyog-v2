@extends('layout.master')

@section('APP-TITLE')
    Establishment Reports
@endsection

@section('marshall-reports')
    active
@endsection

@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Establishment Reports</h4>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="high_rise" class="form-label">High Rise</label>
                                <input type="checkbox" name="high_rise" id="high_rise"
                                    {{ request('high_rise') ? 'checked' : '' }} class="form-check-input">
                            </div>
                            <div class="col-md-3">
                                <label for="eminent_danger" class="form-label">Eminent Danger</label>
                                <input type="checkbox" name="eminent_danger" id="eminent_danger"
                                    {{ request('eminent_danger') ? 'checked' : '' }} class="form-check-input">
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </form>

                    <!-- Establishment Summary Table -->
                    <div class="table-responsive">
                        <table id="establishmentTable" class="table table-striped" data-toggle="table"
                            data-url="{{ route('reports.establishments') }}" data-side-pagination="server"
                            data-pagination="true" data-page-size="10" data-server-sort="true"
                            data-query-params="queryParams" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="trade_name" data-sortable="true">Trade Name</th>
                                    <th data-field="client_name" data-sortable="true">Client</th>
                                    <th data-field="total_building_area" data-sortable="true">Building Area</th>
                                    <th data-field="type_of_occupancy" data-sortable="true">Occupancy Type</th>
                                    <th data-field="address_brgy" data-sortable="true">Address</th>
                                    <th data-field="high_rise" data-sortable="true" data-formatter="booleanFormatter">High
                                        Rise</th>
                                    <th data-field="eminent_danger" data-sortable="true" data-formatter="booleanFormatter">
                                        Eminent Danger</th>
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
                high_rise: $('#high_rise').is(':checked') ? 1 : 0,
                eminent_danger: $('#eminent_danger').is(':checked') ? 1 : 0
            });
        }

        function booleanFormatter(value) {
            return value ? 'Yes' : 'No';
        }

        $(document).ready(function() {
            $('#back-btn').show();

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                $('#establishmentTable').bootstrapTable('refresh');
            });

            $('#establishmentTable').bootstrapTable({
                onLoadSuccess: function() {
                    // Optional: Handle successful data load
                }
            });
        });
    </script>
@endsection
