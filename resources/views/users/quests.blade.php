@extends('master')



@section('title', 'Quests')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    @if(Auth::check() and $quests)
        <h3>Active quests</h3>
        <div>
            {{$quests}}
        </div>
    @endif
@endsection
