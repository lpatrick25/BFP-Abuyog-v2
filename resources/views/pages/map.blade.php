<div class="card rounded">
    <div class="card-content">
        <div class="card-body">
            <div id="map" style="height: 700px;"></div>
        </div>
    </div>
</div>
<input type="hidden" id="locate-lat" value="{{ $location['latitude'] }}">
<input type="hidden" id="locate-long" value="{{ $location['longitude'] }}">
{{-- <script src="{{ asset('js/abuyog-map.js') }}" defer></script> --}}
<script type="text/javascript">
    $(document).ready(function() {

        var marker;
        var southWest = L.latLng(10.5084, 125.2613);
        var northEast = L.latLng(10.7684, 124.8709);
        var bounds = L.latLngBounds(southWest, northEast);

        // Initialize the map
        var map = L.map('map', {
            center: [10.744123, 125.012301], // Center around Abuyog
            zoom: 12,
            minZoom: 12,
            maxZoom: 17,
            maxBounds: bounds,
            maxBoundsViscosity: 1.0
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Bureau Of Fire Protection Abuyog'
        }).addTo(map);

        // Add a custom control button in the upper right corner

        const CustomControl = L.Control.extend({
            options: {
                position: 'topright'
            },
            onAdd: function(map) {
                const container = L.DomUtil.create('div',
                    'leafconst-bar leaflet-control leaflet-control-custom');
                container.style.backgroundColor = '#d9534f';
                container.style.width = '34px';
                container.style.height = '34px';
                container.style.display = 'flex';
                container.style.alignItems = 'center';
                container.style.justifyContent = 'center';
                container.style.cursor = 'pointer';
                container.title = 'Close Map';
                container.innerHTML =
                    `<i class="bi bi-x-circle-fill" style="font-size: 18px; color: white"></i>`;

                L.DomEvent.on(container, 'click', function(e) {
                    L.DomEvent.stopPropagation(e);
                    $('#addForm').show();
                    $('#map-content').html("");
                });

                return container;
            },
        });

        map.addControl(new CustomControl());

        // Add the Geocoder control
        const geocoderControl = L.Control.geocoder({
                defaultMarkGeocode: true,
            })
            .on('markgeocode', function(e) {
                const center = e.geocode.center;

                if (!bounds.contains(center)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Location Out of Bounds',
                        text: 'The searched location is outside the allowable area. Please search within the Abuyog boundaries.',
                    });
                    return;
                }

                L.marker(center).addTo(map)
                    .bindPopup(e.geocode.name)
                    .openPopup();
                map.setView(center, 14);
            })
            .addTo(map);

        function onMapClick(e) {
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker(e.latlng).addTo(map);
            marker.bindPopup("Latitude: " + e.latlng.lat.toFixed(6) + "<br>Longitude: " + e.latlng.lng.toFixed(
                    6))
                .openPopup();

            // Reverse Geocoding to get Barangay name
            const reverseGeocodeURL =
                `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${e.latlng.lat}&lon=${e.latlng.lng}`;

            // Fetch Barangay details
            fetch(reverseGeocodeURL)
                .then(response => response.json())
                .then(data => {
                    const address = data.address;
                    console.log(address);

                    // Attempt to get Barangay
                    const barangay = address.quarter || address.village || address.hamlet ||
                        "Unknown Barangay";
                    const municipality = address.town || "Unknown Municipality";
                    const province = address.state || "Unknown Province";
                    const postcode = address.postcode || "Unknown Postal Code";
                    const street = address.road || "";

                    const location = "Brgy. " + barangay + ", " + municipality + ", " + province + ", " +
                        postcode;

                    // Validate Barangay and Municipality
                    if (municipality !== "Abuyog") {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Location Out of Bounds',
                            html: `
                        <label style="font-weight: bolder;">The selected location is outside the allowable area.</label><br>
                        <label class="text-danger" style="font-weight: bolder; border-bottom: 1px solid black;">${location}</label>
                    `
                        });
                        return;
                    }

                    // Show Swal with Barangay details
                    Swal.fire({
                        icon: 'question',
                        title: 'Lock location?',
                        html: `
                    <label style="font-weight: bolder;">Selected Address</label><br>
                    <label class="text-danger" style="font-weight: bolder; border-bottom: 1px solid black;">${location}</label>
                    <label style="font-weight: bold; display: block; margin-top: 10px;">
                        <small>(If this barangay seems incorrect, just change the brgy manually)</small>
                    </label>
                `,
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: false,
                        confirmButtonText: `<i class="fa fa-lock"></i> Lock!`,
                        cancelButtonText: `<i class="fa fa-times"></i> Cancel`,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#location_latitude').val(e.latlng.lat.toFixed(6));
                            $('#location_longitude').val(e.latlng.lng.toFixed(6));
                            $('#address_brgy').val(barangay);
                            //$('#address_ex').val(street);
                            $('#mapModalBtn').text("CHANGE LOCATION");
                            $('#mapModalBtn').prop("class", "btn btn-success btn-lg w-100 mb-3");
                            $('#addForm').show();
                            $('#map-content').html("");
                        }
                    });
                })
                .catch(error => {
                    console.error("Error fetching reverse geocoding data:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to fetch Barangay details. Please try again later.',
                    });
                });
        }

        function loadMap(lat, lng, enableZoom) {
            // Ensure lat and lng are numbers
            lat = parseFloat(lat);
            lng = parseFloat(lng);

            // Check if lat and lng are valid numbers
            if (isNaN(lat) || isNaN(lng)) {
                showToast('danger', 'Invalid latitude or longitude values.');
                return;
            }

            // Remove existing marker if any
            if (marker) {
                map.removeLayer(marker);
            }

            // Create a new marker at the specified location
            marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup("Latitude: " + lat.toFixed(6) + "<br>Longitude: " + lng.toFixed(6))
                .openPopup();

            // Center the map on the specified coordinates
            map.setView([lat, lng], 20); // Adjust zoom level as needed

            // Enable or disable zoom
            if (enableZoom) {
                map.scrollWheelZoom.enable(); // Enable zoom
                map.doubleClickZoom.enable(); // Enable double-click zoom
            } else {
                map.scrollWheelZoom.disable(); // Disable zoom
                map.doubleClickZoom.disable(); // Disable double-click zoom
            }
        }

        const latitude = $('#locate-lat').val();
        const longitude = $('#locate-long').val();
        if (latitude !== 0 && longitude !== 0 && adding === false) {
            map.off("click", onMapClick);
            loadMap(latitude, longitude, false); // Zoom disabled
        } else {
            map.on("click", onMapClick);
            loadMap(latitude, longitude, true); // Zoom enabled
        }

        if (latitude === "0" && longitude === "0") {
            map.on("click", onMapClick);
            map.setView([10.744123, 125.012301], 12); // Default location
        }
    });
</script>
