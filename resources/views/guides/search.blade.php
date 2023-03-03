@extends('master')



@section('title', 'Search')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
@endsection

@section('content')
    <livewire:guide-search/>
@endsection
