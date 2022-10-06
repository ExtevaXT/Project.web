@extends('master')



@section('title', 'Chat logger')
@section('style')

@endsection

@section('content')
    @auth()
        <div class="fs-5 p-1">UNITY LOGGER</div>
        <div class="content" style="overflow-y: scroll; height: 800px">
            @foreach($log as $message)
                <div>{{$message['content']}}</div>
            @endforeach
        </div>
    @endauth
@endsection
