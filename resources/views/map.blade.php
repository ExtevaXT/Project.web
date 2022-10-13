@extends('master')



@section('title', 'Map')
@section('style')
<link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}} ">
<style>
    #map {
        height: calc(100vh - 100px);
    }
</style>
@endsection

@section('content')


    <div id="map"></div>

    <script src="{{asset('leaflet/leaflet.js')}} "></script>
    <script>
        {{--let map = L.map('map', {--}}
        {{--    center: [40.75, -74.2],--}}
        {{--    zoom: 14,--}}
        {{--    minZoom: 13--}}
        {{--});--}}

        {{--let imageUrl = '{{asset('leaflet/map.svg')}}',--}}
        {{--    imageBounds = [--}}
        {{--        [40.712216, -74.22655],--}}
        {{--        [40.773941, -74.12544]--}}
        {{--    ];--}}

        {{--L.imageOverlay(imageUrl, imageBounds).addTo(map);--}}

        var southWest = L.latLng(0, -180),
            northEast = L.latLng(85, 0),
            bounds = L.latLngBounds(southWest, northEast);

        var map = L.map('map').setView([0, 0], 4);

        L.tileLayer('{{asset('leaflet/swamp')}}/{z}/{x}_{y}.png',{
            minZoom: 4,
            maxZoom: 7,
            attribution: '',
            tms: false
        }).addTo(map);
        map.setView(new L.LatLng(40.737, -73.923), 4);
        map.setMaxBounds(bounds)
        // map.on("contextmenu", function (event) {
        //     console.log("user right-clicked on map coordinates: " + event.latlng.toString());
        //     alert("user right-clicked on map coordinates: " + event.latlng.toString());
        //     L.marker(event.latlng).addTo(map);
        // });
        map.on('drag', function() {
            map.panInsideBounds(bounds, { animate: false });
        });

    </script>
@endsection
