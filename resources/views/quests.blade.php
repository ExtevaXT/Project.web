@extends('master')



@section('title', 'Quests')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
@endsection

@section('content')
    @auth()
        <div>

        </div>
    @endauth
@endsection
