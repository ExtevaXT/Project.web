@extends('master')



@section('title', 'Ranking')
@section('style')
    <link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}} ">
    <link rel="stylesheet" href="{{asset('css/Custom/BlockTable.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/ranking.css')}}">
@endsection

@section('content')
    @auth()
        <div class="fs-3 p-1 text-center my-3">Player ranking</div>
        <div class="main d-flex">
            <div class="side-filter main-left me-3">
                <form action="/ranking">
                    <input value="{{ app('request')->input('search') }}" name="search" class="p-2 form-control bg-glass search" placeholder="Search" onchange="this.form.submit()">
                </form>
                <div class="py-2"><a class="nav-link sort" data-sort="level" href="/ranking?filter=level">Level</a></div>
                <div class="py-2"><a class="nav-link sort" data-sort=achievements" href="/ranking?filter=achievements">Achievements</a> </div>
                <div class="py-2"><a class="nav-link sort" data-sort="online" href="/ranking?filter=created_at">Online time</a></div>
                <div class="py-2"><a class="nav-link sort" data-sort="kda" href="/ranking?filter=kda">KDA</a></div>

            </div>
            <div class="BlockTable main-right">
                <div class="BlockTable-head">
                    <div class="BlockTable-row BT-R4 bg-glass">
                        <div class="BlockTable-label fs-5"><div class="BlockTable-labelInner label-player">Player / Level</div></div>
                        <div class="BlockTable-label fs-5"><div class="BlockTable-labelInner label-achievements">Achievements / Trophies</div></div>
                        <div class="BlockTable-label fs-5"><div class="BlockTable-labelInner label-online">Last save / Joined</div></div>
                        <div class="BlockTable-label fs-5"><div class="BlockTable-labelInner">KDA</div></div>
                    </div>
                </div>
                <div class="BlockTable-body sort">
                    @foreach($characters as $player)
                        <div class="BlockTable-row BT-R4 text-center bg-glass">
{{-- data-bs-placement="left" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="<em>Tooltip</em> <u>with</u> <b>HTML</b>" --}}
                            <div class="BlockTable-data row-player">
                                <div class="d-flex">
                                    <x-user-profile name="{{$player->account}}" size="64" />
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    @if($player->achievements==0)
                                        <div class="fs-6">None</div>
                                    @else
                                    <div class="achievements fs-6">{{ $player->achievements}} <i class="mdi mdi-star mdi-18px"></i></div>
                                    <div class="trophies fs-6">{{ $player->trophies }} <i class="mdi mdi-trophy mdi-18px"></i></div>
                                    @endif
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    <div class="online">{{$player->online}}</div>
                                    <div>{{$player->joined}}</div>
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    <div class="kda">{{$player->kda}}</div>
                                    <div></div>
                                </div>
                            </div>
                        </div>


                    @endforeach
                </div>
            </div>

        </div>
    @endauth
    <script src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip()
        })
        if(window.matchMedia( "(max-width: 1000px)" ).matches){
            document.querySelector('.label-online').innerHTML = 'Online'
            document.querySelector('.label-player').innerHTML = 'Player'
            document.querySelector('.label-achievements').innerHTML = 'Achievements'
        }
    </script>
@endsection
