@extends('master')



@section('title', 'Quests')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    @if(Auth::check() and $quests)
        <div>Active quests</div>
        <div>
            {{$quests}}
        </div>
    @endif
@endsection
