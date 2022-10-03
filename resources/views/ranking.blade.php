@extends('master')



@section('title', 'Ranking')
@section('style')
    <link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}} ">
    <link rel="stylesheet" href="{{asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    @auth()
        <div class="fs-3 p-1 text-center">Player ranking</div>
        <div class="main d-flex">
            <div class="side-filter">
                <input class="p-1 form-control border-primary" placeholder="Search">
                <div class="p-3">Level</div>
                <div class="p-3">Achievements</div>
                <div class="p-3">Online time</div>
                <div class="p-3">KDA</div>
            </div>
            <div class="BlockTable ms-5">
                <div class="BlockTable-body">
                    @foreach(Character::all() as $player)
                        <div class="BlockTable-row BT-R4">
                            <div class="BlockTable-data">
                                <div class="d-flex">
                                    <div class="border border-primary me-3"
                                         style="
                                             width: 64px;
                                             height: 64px;
                                             background-size: cover;
                                             background-position: center;
                                             filter: blur(0.6px);
                                             background-image:url('{{ asset(Account::all()->where('name', $player->account)->first()->image)}}')
                                             "
                                    ></div>
                                    <div>
                                        <div>{{$player->name}}</div>
                                        <div>{{$player->level}} level</div>
                                    </div>
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    <div>Achievements unlocked</div>
                                    <div>Trophy amount</div>
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    <div>Online time</div>
                                    <div>Full online</div>
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    <div>KDA</div>
                                    <div>Or something</div>
                                </div>
                            </div>
                        </div>


                    @endforeach
                </div>
            </div>

        </div>
    @endauth
@endsection
