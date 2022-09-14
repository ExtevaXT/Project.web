@extends('master')



@section('title', 'Map')
@section('style')
<link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}} ">
@endsection

@section('content')


    <div style="height: 850px" id="map"></div>

    <script src="{{asset('leaflet/leaflet.js')}} "></script>
    <script>
        let map = L.map('map').setView([51.505, -0.09], 13);

        let bounds = [[0,0], [1000,1000]];
        let image = L.imageOverlay('uqm_map_full.png', bounds).addTo(map);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

    </script>
@endsection
