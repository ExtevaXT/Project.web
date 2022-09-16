@extends('master')



@section('title', 'Guides page')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Guides/style.css')}}">
@endsection

@section('content')
    <div class="d-flex flex-column">
        <div class="my-2">
            <form class="form-inline my-2 d-flex">
                <input class="form-control my-2 border-primary rounded-0" type="search" placeholder="Search">
                <button class="btn btn-outline-primary my-2 rounded-0 border-start-0 px-5" type="submit">Search</button>
            </form>
        </div>
        <div>Categories</div>
{{--        <a href="/guides/achievements" class="border-primary border p-2 px-5 my-1 text-decoration-none">--}}
{{--            <div>Achievements</div>--}}
{{--            <div>Information about achievements</div>--}}
{{--        </a>--}}
{{--        <a href="/guides/talents" class="border-primary border p-2 px-5 my-1 text-decoration-none">--}}
{{--            <div>Talents</div>--}}
{{--            <div>Information about talents</div>--}}
{{--        </a>--}}
{{--        <a href="/guides/ranking" class="border-primary border p-2 px-5 my-1 text-decoration-none">--}}
{{--            <div>Ranking</div>--}}
{{--            <div>Information about level and experience</div>--}}
{{--        </a>--}}
{{--        <a href="/guides/auction" class="border-primary border p-2 px-5 my-1 text-decoration-none">--}}
{{--            <div>Auction</div>--}}
{{--            <div>Information about auction</div>--}}
{{--        </a>--}}

        <a href="/guides/anomalies" class="border-primary border p-2 px-5 my-1 text-decoration-none">
            <div>Anomalies</div>
            <div>Information about anomalies</div>
        </a>
        <a href="/guides/artefacts" class="border-primary border p-2 px-5 my-1 text-decoration-none">
            <div>Artefacts</div>
            <div>Information about artefacts</div>
        </a>
        <a href="/guides/equipment" class="border-primary border p-2 px-5 my-1 text-decoration-none">
            <div>Equipment</div>
            <div>Information about equipment</div>
        </a>
        <a href="/guides/attachments" class="border-primary border p-2 px-5 my-1 text-decoration-none">
            <div>Attachments</div>
            <div>Information about attachments</div>
        </a>
        <a href="/guides/weapons" class="border-primary border p-2 px-5 my-1 text-decoration-none">
            <div>Weapons</div>
            <div>Information about weapons</div>
        </a>
        <a href="/guides/other" class="border-primary border p-2 px-5 my-1 text-decoration-none">
            <div>Other</div>
            <div>Information about other stuff</div>
        </a>

    </div>
@endsection
