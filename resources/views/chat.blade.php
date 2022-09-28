@extends('master')



@section('title', 'Map')
@section('style')
    <link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}} ">
@endsection

@section('content')

    <div class="fs-5 p-1">UNITY LOGGER</div>
    <div class="content">
        @foreach($log as $message)
            <div>{{$message['content']}}</div>
        @endforeach
    </div>
@endsection
