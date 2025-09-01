@if(!isset($addressFieldName))
    @php $addressFieldName = 'address' @endphp
@endif
<div class="form-group">
   
        <input type="text"
               placeholder="Search Location"
               class="form-control jqv-input jqv-required"
               name="{{ $addressFieldName }}" id="map_address"
               value="">
        <div id="location_append">
            <ul></ul>
        </div>
    <div id="map" style="height: 400px; width: 100%;"></div>
    <br>
    <input type="hidden" id="latitude" name="latitude" >
    <input type="hidden" id="longitude" name="longitude" >
    @if(!isset($mapOnly))
        <button onclick="getLocation()" type="button" class="btn btn-primary">Get Current Location</button>
    @endif
</div>

<script
    src="//maps.googleapis.com/maps/api/js?key={{ config('app.MAP_API_KEY') }}&v=weekly&libraries=drawing,places&callback=initAutocomplete&v=3.45.8"
    async defer></script>
<script>
    var map, marker, geocoder;

    function initAutocomplete() {
        var latitude = parseFloat(document.getElementById("latitude").value) || 25.204819;
        var longitude = parseFloat(document.getElementById("longitude").value) || 55.270931;
        var myLatLng = { lat: latitude, lng: longitude };

        map = new google.maps.Map(document.getElementById("map"), {
            center: myLatLng,
            zoom: 15,
            mapTypeControl: false,
            mapTypeId: "roadmap",
        });

        marker = new google.maps.Marker({
            draggable: true,
            position: myLatLng,
            map: map,
        });

        geocoder = new google.maps.Geocoder();

        google.maps.event.addListener(marker, "dragend", function () {
            geocodePosition(marker.getPosition());
        });

        google.maps.event.addListener(map, "click", function (event) {
            marker.setPosition(event.latLng);
            geocodePosition(event.latLng);
        });

        var input = document.getElementById("map_address");
        var searchBox = new google.maps.places.SearchBox(input);
    //    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        searchBox.addListener("places_changed", function () {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                marker.setPosition(place.geometry.location);
                map.setCenter(place.geometry.location);
                map.setZoom(15);
                geocodePosition(place.geometry.location);

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        @if(empty($lat) || empty($lng))
        getLocation();
        @endif
    }

    function geocodePosition(pos) {
        geocoder.geocode({ latLng: pos }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    document.getElementById("map_address").value = results[0].formatted_address;
                    document.getElementById("latitude").value = pos.lat();
                    document.getElementById("longitude").value = pos.lng();
                }
            }
        });
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
                marker.setPosition(pos);
                geocodePosition(pos);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
</script>
