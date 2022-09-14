@extends('master')



@section('title', 'Map')
@section('style')
<link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}} ">
@endsection

@section('content')


    <div style="height: 850px" id="map"></div>

    <script src="{{asset('leaflet/leaflet.js')}} "></script>
    <script>
        let map = L.map('map', {
            center: [40.75, -74.2],
            zoom: 14,
            minZoom: 13
        });

        let imageUrl = '{{asset('leaflet/map.svg')}}',
            imageBounds = [
                [40.712216, -74.22655],
                [40.773941, -74.12544]
            ];

        L.imageOverlay(imageUrl, imageBounds).addTo(map);

    </script>
@endsection
