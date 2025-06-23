@extends('layout.master')

@section('APP-TITLE')
    GIS Mapping
@endsection
@section('client-gis')
    active
@endsection
@section('APP-CONTENT')
    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded">
                <div class="card-content">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Establishment Mapping</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="map" class="shadow-reset" style="height: 700px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script>
        var iconPaths = {
            inspected: "{{ asset('css/leaflet/images/marker-icon-blue.png') }}",
            notInspected: "{{ asset('css/leaflet/images/marker-icon-red.png') }}",
            notApplied: "{{ asset('css/leaflet/images/marker-icon-yellow.png') }}",
            default: "{{ asset('css/leaflet/images/marker-icon-default.png') }}"
        };
    </script>

    <script src="{{ asset('js/abuyog-map.js') }}" defer></script>
    <script type="text/javascript">
        function showImagePopup(establishmentId) {
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

        function showMapWithCoordinates(coordinates) {
            if (!Array.isArray(coordinates) || coordinates.length === 0) {
                console.warn("No markers found!");
                return;
            }

            coordinates.forEach(function(coord) {
                if (!coord || coord.length < 3 || isNaN(coord[0]) || isNaN(coord[1])) {
                    console.warn("Invalid coordinate:", coord);
                    return;
                }

                let iconUrl;

                switch (coord[4]) {
                    case 'Inspected':
                        iconUrl = iconPaths.inspected;
                        break;
                    case 'Not Inspected':
                        iconUrl = iconPaths.notInspected;
                        break;
                    case 'Not Applied':
                        iconUrl = iconPaths.notApplied;
                        break;
                    default:
                        iconUrl = iconPaths.default;
                }

                const customIcon = L.icon({
                    iconUrl: iconUrl,
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [0, -35],
                });

                const marker = L.marker([parseFloat(coord[0]), parseFloat(coord[1])], {
                    icon: customIcon
                }).addTo(map);

                const popupContent = `<button type="button" class="btn btn-success btn-block"
                                onclick="showImagePopup('${coord[2]}');">
                                Show Establishment
                              </button>`;

                marker.bindPopup(L.popup().setContent(popupContent));
            });
        }

        $(document).ready(function() {
            let summary = @json($summary);
            let role = "{{ auth()->user()->role }}";

            var infoControl = L.control({
                position: 'topright'
            });

            infoControl.onAdd = function() {
                var div = L.DomUtil.create('div', 'info-control');
                let summaryContent = `
                    <h4>Establishment Summary</h4>
                    <p class="text-left" style="font-size: 18px; color: #0596db;">
                        <strong>Inspected:</strong> ${summary.inspected}
                    </p>
                    <p class="text-left" style="font-size: 18px; color: #ef7f7f;">
                        <strong>Not Inspected:</strong> ${summary.not_inspected}
                    </p>
                `;

                if (role === 'Client') {
                    summaryContent += `
                        <p class="text-left" style="font-size: 18px; color: #000;">
                            <strong>Not Applied:</strong> ${summary.not_applied}
                        </p>
                    `;
                }
                
                //alert(role);

                div.innerHTML = summaryContent;
                div.style.background = 'white';
                div.style.padding = '10px';
                div.style.border = '1px solid #ccc';
                div.style.borderRadius = '5px';
                return div;
            };

            infoControl.addTo(map);

            let markers = @json($response);
            showMapWithCoordinates(markers);
        });
    </script>
@endsection
