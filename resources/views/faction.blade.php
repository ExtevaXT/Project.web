@extends('master')



@section('title', 'Faction')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    <div class="fs-1">Factions</div>
    <div class="fs-3">Some info about them</div>
    <div class="fs-5">Every month top 5 guys get nice rewards listed below</div>
    <div class="d-flex main">
        <div class="m-5 text-center">
            <img src="{{asset('img/icon/factions/stalker.png')}}" alt="" width="100" height="100">
            <div class="fs-4">Stalkers</div>
            <div>Description</div>
            <div class="text-center border-primary border m-1 p-1">Join faction in game</div>
        </div>
        <div class="m-5 text-center">
            <img src="{{asset('img/icon/factions/bandit.png')}}" alt="" width="100" height="100">
            <div class="fs-4">Bandits</div>
            <div>Description</div>
            <div class="text-center border-primary border m-1 p-1">Join faction in game</div>
        </div>
    </div>
    <div class="fs-3">Top faction players</div>
    <div class="d-flex main">
        <div>
            <div class="text-center fs-4">Stalkers</div>
            @for($i=0;$i<5;$i++)
            <div class="d-flex my-5 mx-4">
                <svg class="me-3" data-jdenticon-value="{{rand(1,100)}}" width="64" height="64"></svg>
                <div>
                    <div class="name">{{fake()->userName}}</div>
                    <div class="level">{{rand(1,100)}} level</div>
                </div>
            </div>
            @endfor
        </div>
        <div>
            <div class="text-center fs-4">Bandits</div>
            @for($i=0;$i<5;$i++)
                <div class="d-flex my-5 mx-4">
                    <svg class="me-3" data-jdenticon-value="{{rand(1,100)}}" width="64" height="64"></svg>
                    <div>
                        <div class="name">{{fake()->userName}}</div>
                        <div class="level">{{rand(1,100)}} level</div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
    <div class="fs-3">Possible rewards</div>
    <div class="d-flex" style="overflow-x: scroll">
        @foreach($rewards as $reward)
            <x-item class="m-3" name="{{$reward['name']}}" amount="{{$reward['amount']}}"/>
        @endforeach
    </div>
    <div class="fs-3 mt-5">All game factions</div>
    <div class="d-flex main text-center">
        <div class="m-5">
            <img src="{{asset('img/icon/factions/stalker.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Stalker</div>
            <div>Description</div>
        </div>
        <div class="m-5">
            <img src="{{asset('img/icon/factions/bandit.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Bandit</div>
            <div>Description</div>
        </div>
        <div class="m-5">
            <img src="{{asset('img/icon/factions/covenant.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Covenant</div>
            <div>Description</div>
        </div>
        <div class="m-5">
            <img src="{{asset('img/icon/factions/duty.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Duty</div>
            <div>Description</div>
        </div>
        <div class="m-5">
            <img src="{{asset('img/icon/factions/freedom.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Freedom</div>
            <div>Description</div>
        </div>
        <div class="m-5">
            <img src="{{asset('img/icon/factions/mercenary.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Mercenary</div>
            <div>Description</div>
        </div>
    </div>


@endsection
