@extends('master')



@section('title', 'Faction')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
@endsection

@section('content')
    <div class="fs-1">Factions</div>
    <div class="fs-3">Some info about them</div>
    <div class="d-flex main">
        <div class="m-5">
            <img src="{{asset('img/icon/factions/stalker.png')}}" alt="">
            <div>Faction name</div>
            <div>Description</div>
            <div class="text-center border-primary border m-1 p-1">Join faction in game</div>
        </div>
        <div class="m-5">
            <img src="{{asset('img/icon/factions/bandit.png')}}" alt="">
            <div>Faction name</div>
            <div>Description</div>
            <div class="text-center border-primary border m-1 p-1">Join faction in game</div>
        </div>
    </div>
    <div>Top faction players</div>
    <div class="d-flex main">
        <div>
            <div>Faction name</div>
            @for($i=0;$i<5;$i++)
            <div class="d-flex m-5">
                <svg class="me-3" data-jdenticon-value="{{\Nette\Utils\Random::generate()}}" width="64" height="64"></svg>
                <div>
                    <div class="name">Player name</div>
                    <div class="level">0 level</div>
                </div>
            </div>
            @endfor
        </div>
        <div>
            <div>Faction name</div>
            @for($i=0;$i<5;$i++)
                <div class="d-flex m-5">
                    <svg class="me-3" data-jdenticon-value="{{\Nette\Utils\Random::generate()}}" width="64" height="64"></svg>
                    <div>
                        <div class="name">Player name</div>
                        <div class="level">0 level</div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
    <div>Possible rewards</div>
    <div class="d-flex" style="overflow-x: scroll">
        @for($i=0;$i<15;$i++)
            <div class="m-3">
                <svg class="me-3" data-jdenticon-value="{{\Nette\Utils\Random::generate()}}" width="64" height="64"></svg>
                <div class="name">Item name</div>
            </div>
        @endfor
    </div>
    <div>All factions</div>
    <div class="d-flex main">
        @for($i=0;$i<8;$i++)
        <div class="m-5">
            <div>Img</div>
            <div>Faction name</div>
            <div>Description</div>
        </div>
        @endfor
    </div>


@endsection
