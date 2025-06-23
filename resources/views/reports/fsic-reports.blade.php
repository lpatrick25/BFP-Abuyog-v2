@extends('layout.master')

@section('APP-TITLE')
    FSIC Reports
@endsection

@section('marshall-reports')
    active
@endsection

@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">FSIC Reports</h4>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="expired" class="form-label">Show Expired FSICs</label>
                                <input type="checkbox" name="expired" id="expired"
                                    {{ request('expired') ? 'checked' : '' }} class="form-check-input">
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </form>

                    <!-- FSIC Issuance Table -->
                    <div class="table-responsive">
                        <table id="fsicTable" class="table table-striped" data-toggle="table"
                            data-url="{{ route('reports.fsics') }}" data-side-pagination="server" data-pagination="true"
                            data-page-size="10" data-server-sort="true" data-query-params="queryParams" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="fsic_no" data-sortable="true">FSIC Number</th>
                                    <th data-field="establishment_name" data-sortable="true">Establishment</th>
                                    <th data-field="issue_date" data-sortable="true" data-formatter="dateFormatter">Issue
                                        Date</th>
                                    <th data-field="expiration_date" data-sortable="true" data-formatter="dateFormatter">
                                        Expiration Date</th>
                                    <th data-field="amount" data-sortable="true" data-formatter="amountFormatter">Amount
                                    </th>
                                    <th data-field="or_number" data-sortable="true">OR Number</th>
                                    <th data-field="payment_date" data-sortable="true" data-formatter="dateFormatter">
                                        Payment Date</th>
                                    <th data-field="is_expired" data-sortable="true" data-formatter="booleanFormatter">
                                        Expired</th>
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
                expired: $('#expired').is(':checked') ? 1 : 0
            });
        }

        function dateFormatter(value) {
            return value ? new Date(value).toISOString().split('T')[0] : 'N/A';
        }

        function amountFormatter(value) {
            return value ? Number(value).toFixed(2) : 'N/A';
        }

        function booleanFormatter(value) {
            return value ? 'Yes' : 'No';
        }

        $(document).ready(function() {
            $('#back-btn').show();

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                $('#fsicTable').bootstrapTable('refresh');
            });

            $('#fsicTable').bootstrapTable({
                onLoadSuccess: function() {
                    // Optional: Handle successful data load
                }
            });
        });
    </script>
@endsection
