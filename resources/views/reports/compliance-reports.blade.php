@extends('layout.master')

@section('APP-TITLE')
    Compliance and Risk Reports
@endsection

@section('marshall-reports')
    active
@endsection

@section('APP-CONTENT')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Compliance and Risk Reports</h4>
                </div>
                <div class="card-body">
                    <!-- Non-Compliant Establishments Table -->
                    <div class="table-responsive">
                        <table id="complianceTable" class="table table-striped" data-toggle="table"
                            data-url="{{ route('reports.compliance') }}" data-side-pagination="server"
                            data-pagination="true" data-page-size="10" data-server-sort="true" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="address_brgy" data-sortable="true">Address</th>
                                    <th data-field="contact_number" data-sortable="true">Contact Number</th>
                                    <th data-field="application_number" data-sortable="true">Application Number</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="fsic_no" data-sortable="true">FSIC Number</th>
                                    <th data-field="expiration_date" data-sortable="true" data-formatter="dateFormatter">
                                        Expiration Date</th>
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
        function dateFormatter(value) {
            return value ? new Date(value).toISOString().split('T')[0] : 'N/A';
        }

        $(document).ready(function() {
            $('#back-btn').show();

            $('#complianceTable').bootstrapTable({
                onLoadSuccess: function() {
                    // Optional: Handle successful data load
                }
            });
        });
    </script>
@endsection
