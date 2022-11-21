@extends('master')



@section('title', 'Ranking')
@section('style')
    <link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}} ">
    <link rel="stylesheet" href="{{asset('css/Custom/BlockTable.css')}}">
    <link rel="stylesheet" href="{{asset('css/Index/style.css')}}">
@endsection

@section('content')
    @auth()
        <div class="fs-3 p-1 text-center">Player ranking</div>
        <div class="main d-flex">
            <div class="side-filter">
                <form action="/ranking">
                    <input value="{{ app('request')->input('search') }}" name="search" class="p-1 form-control border-primary search" placeholder="Search" onchange="this.form.submit()">
                </form>
                <div class="py-2"><a class="nav-link sort" data-sort="level" href="/ranking?filter=level">Level</a></div>
                <div class="py-2"><a class="nav-link sort" data-sort=achievements" href="/ranking?filter=achievements">Achievements</a> </div>
                <div class="py-2"><a class="nav-link sort" data-sort="online" href="/ranking?filter=created_at">Online time</a></div>
                <div class="py-2"><a class="nav-link sort" data-sort="kda" href="/ranking?filter=kda">KDA</a></div>

            </div>
            <div class="BlockTable">
                <div class="BlockTable-body sort">
                    @foreach($characters as $player)
                        <div class="BlockTable-row BT-R4">
{{-- data-bs-placement="left" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="<em>Tooltip</em> <u>with</u> <b>HTML</b>" --}}
                            <div class="BlockTable-data">
                                <div class="d-flex">
                                    <x-user-profile name="{{$player->account}}" size="64" />
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    <div class="achievements">Achievements: {{ $player->achievements }}</div>
                                    <div class="trophies">Trophies: {{ $player->trophies }}</div>
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    <div class="online">Last save: {{$player->online}}</div>
                                    <div>Joined: {{$player->joined}}</div>
                                </div>
                            </div>
                            <div class="BlockTable-data">
                                <div>
                                    <div class="kda">KDA {{$player->kda}}</div>
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
    </script>
@endsection
