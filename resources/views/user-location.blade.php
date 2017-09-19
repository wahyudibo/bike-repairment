@extends('layout.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/user-location.min.css') }}">
@endsection

@section('navbar')
@include('navbar.fixed-dark')
@endsection

@section('content')
<div id="map"></div>
@endsection

@section('scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapApiKey }}&callback=initMap">
</script>

<script>
    function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer({ suppressMarkers: true });
        var map;
        var bengkelSepedaLat = -7.775433;
        var bengkelSepedaLng = 110.377626;

        // Init map with Bengkel Sepeda location
        var bengkelSepeda = new google.maps.LatLng(bengkelSepedaLat, bengkelSepedaLng);
        var userLocation = new google.maps.LatLng({{ $repairment->latitude }}, {{ $repairment->longitude }});

        var mapCanvas = document.getElementById('map');
        var mapOptions = {
            center: bengkelSepeda,
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        map = new google.maps.Map(mapCanvas, mapOptions);
        directionsDisplay.setMap(map);

        var request = {
            origin: bengkelSepeda,
            destination: userLocation,
            travelMode: 'DRIVING'
        };

        var originMarker = new google.maps.Marker({
            position: bengkelSepeda,
            map: map,
        });

        var destinationMarker = new google.maps.Marker({
            position: userLocation,
            map: map,
        });

        var originInfoWindow = new google.maps.InfoWindow();
        var destinationInfoWindow = new google.maps.InfoWindow();

        directionsService.route(request, function(result, status) {
            if (status == 'OK') {
                directionsDisplay.setDirections(result);
                originInfoWindow.setContent('<strong>Bengkel Sepeda UGM</strong>');
                originInfoWindow.open(map, originMarker);

                destinationInfoWindow.setContent(
                    '<div id="content">' +
                    '<h5>Lokasi Pelapor</h5>' +
                    '<br/> <i class="fa fa-user"></i> {{ $repairment->name }}' +
                    '<br/> <i class="fa fa-phone"></i> {{ $repairment->phone }}</p>' +
                    '<p>Laporan: {{ $repairment->remark }}</p>' +
                    '</div>'
                );

                destinationInfoWindow.open(map, destinationMarker);
            }
        });
    }
</script>
@endsection