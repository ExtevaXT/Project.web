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
        <div class="fs-3 my-3">Categories</div>
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
{{--        <a href="/guides/anomalies" class="border-primary border p-2 my-1 text-decoration-none d-flex">--}}
{{--            <div class="me-3" style="--}}
{{--                width: 48px;--}}
{{--                height: 48px;--}}
{{--                background-size: cover;--}}
{{--                background-position: center;--}}
{{--                filter: blur(0.6px);--}}
{{--                background-image:url('{{asset('img/icon/anomalies/anomaly.gif')}}')--}}
{{--                "></div>--}}
{{--            <div>--}}
{{--                <div>Anomalies</div>--}}
{{--                <div>Information about anomalies</div>--}}
{{--            </div>--}}

{{--        </a>--}}
        <a href="/guides/artefacts" class="border-primary border p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Crystal" size="64"/>
            <div>
                <div class="fs-4">Artefacts</div>
                <div>Information about artefacts</div>
            </div>

        </a>
        <a href="/guides/equipment" class="border-primary border p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Ghillie" size="64"/>
            <div>
                <div class="fs-4">Equipment</div>
                <div>Information about equipment</div>
            </div>

        </a>
        <a href="/guides/attachments" class="border-primary border p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Scope PSO-1" size="64"/>
            <div>
                <div class="fs-4">Attachments</div>
                <div>Information about attachments</div>
            </div>

        </a>
        <a href="/guides/weapons" class="border-primary border p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="AKM" size="64"/>
            <div>
                <div class="fs-4">Weapons</div>
                <div>Information about weapons</div>
            </div>

        </a>
        <a href="/guides/other" class="border-primary border p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Bandage" size="64"/>
            <div>
                <div class="fs-4">Other</div>
                <div>Information about other stuff</div>
            </div>

        </a>

    </div>
@endsection
