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
        <div class="m-3 text-center bg-glass p-3">
            <img src="{{asset('img/icon/factions/stalker.png')}}" alt="" width="100" height="100">
            <div class="fs-4">Stalkers</div>
            <div>Description</div>
            <div class="text-center bg-glass m-1 p-2">Join faction in game</div>
        </div>
        <div class="m-3 text-center bg-glass p-3">
            <img src="{{asset('img/icon/factions/bandit.png')}}" alt="" width="100" height="100">
            <div class="fs-4">Bandits</div>
            <div>Description</div>
            <div class="text-center bg-glass m-1 p-2">Join faction in game</div>
        </div>
    </div>
    <div class="fs-3">Top faction players</div>
    <div class="d-flex main">
        <div>
            <div class="text-center fs-4">Stalkers</div>
            @for($i=0;$i<5;$i++)
            <div class="d-flex my-2 py-2 mx-1 px-4 bg-glass">
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
                <div class="d-flex my-2 py-2 mx-1 px-4 bg-glass">
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
            <x-item class="p-2 m-1 bg-glass" name="{{$reward['name']}}" amount="{{$reward['amount']}}"/>
        @endforeach
    </div>
    <div class="fs-3 mt-5">All game factions</div>
    <div class="d-flex main text-center">
        <div class="m-3 p-5 bg-glass">
            <img src="{{asset('img/icon/factions/stalker.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Stalker</div>
            <div>Description</div>
        </div>
        <div class="m-3 p-5 bg-glass">
            <img src="{{asset('img/icon/factions/bandit.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Bandit</div>
            <div>Description</div>
        </div>
        <div class="m-3 p-5 bg-glass">
            <img src="{{asset('img/icon/factions/covenant.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Covenant</div>
            <div>Description</div>
        </div>
        <div class="m-3 p-5 bg-glass">
            <img src="{{asset('img/icon/factions/duty.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Duty</div>
            <div>Description</div>
        </div>
        <div class="m-3 p-5 bg-glass">
            <img src="{{asset('img/icon/factions/freedom.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Freedom</div>
            <div>Description</div>
        </div>
        <div class="m-3 p-5 bg-glass">
            <img src="{{asset('img/icon/factions/mercenary.png')}}" alt=""  width="100" height="100">
            <div class="fs-4">Mercenary</div>
            <div>Description</div>
        </div>
    </div>


@endsection
