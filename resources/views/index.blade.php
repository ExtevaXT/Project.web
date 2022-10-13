@inject('Carbon','\Carbon\Carbon')
@inject('Auth','\Illuminate\Support\Facades\Auth')
@extends('master')



@section('title', 'Main page')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
@endsection

@section('content')
    @guest()
    <div class="text-center py-5 mt-5">
        <div class="fs-3">Project.web - Web interface for Project.unity</div>
{{--        <div>Project was created at 2022</div>--}}
        <div class="text-secondary fs-5">Last update
            {{$Carbon::parse(max($unity[0]['commit']['author']['date'], $web[0]['commit']['author']['date']))->tz('Asia/Yekaterinburg')}}
        </div>
        <div class="border-primary border py-2 px-4 d-inline-block fs-5 mt-3"><a class="text-decoration-none" href="{{route('register')}}">Register account</a></div>
        <br>
        <div class="border-primary border py-2 px-4 d-inline-block mt-2"><a class="text-decoration-none" href="">Download</a></div>
    </div>
    <div class="d-flex flex-column m-2">
        <div>Server status</div>
        <div class="my-1 p-2 border-primary  border">Main server <span class="fw-bold">
                        {{Character::all()->where('online', true)->count()}}
                        Players</span><div class="progress">
                <div class="progress-bar"
                     role="progressbar"
                     style="width: {{Character::all()->where('online', true)->count()*10}}%"
                     aria-valuenow="{{Character::all()->where('online', true)->count()}}"
                     aria-valuemin="0"
                     aria-valuemax="10"></div>
            </div>
        </div>
    </div>
    @endguest
    <div class="d-flex my-2 main">
        <div class="main-left d-flex flex-column w-50">
            @auth()
            <div class="border-primary  border m-2 p-5">
                <div>Some Announcement</div>
                <div>Announcement description</div>
                <div>Time of announcement</div>
            </div>
            <div class="d-flex m-2 profile-panel">
                <div class="d-grid text-center profile-panel-nav">
                    <div onclick="location.href='/user/{{$Auth::user()->name}}'" class="profile-panel-nav-item border border-primary">
                        <i class="icons mdi mdi-slack"></i>
                        <div>Character</div>
                    </div>
                    <div onclick="location.href='/quests'" class="profile-panel-nav-item border border-primary">
                        <i class="icons mdi mdi-creation"></i>
                        <div>Quests</div>
                    </div>
                    <div onclick="location.href='/auction'" class="profile-panel-nav-item border border-primary">
                        <i class="icons mdi mdi-scale-balance"></i>
                        <div>Auction</div>
                    </div>
                    <div onclick="location.href='/ranking'" class="profile-panel-nav-item border border-primary">
                        <i class="icons mdi mdi-trophy"></i>
                        <div>Ranking</div>
                    </div>
                </div>
                <div class="border-primary border w-100 d-flex profile-panel-bg">
                    <div class="d-flex m-3 align-self-end">
                        @if($Auth::user()->image !='user.png')
                            <div class="border border-primary me-3" style="
                                width: 128px;
                                height: 128px;
                                background-size: cover;
                                background-position: center;
                                filter: blur(0.6px);
                                background-image:url('{{ asset($Auth::user()->image)}}')
                                "></div>
                        @else
                            <svg class="me-3" data-jdenticon-value="{{$Auth::user()->name}}" width="128" height="128"></svg>
                        @endif
                        <div>
                            <div class="fs-2">{{$Auth::user()->name}}</div>
                            @if(Character::all()->firstWhere('account', $Auth::user()->name)!=null)
                            <div class="fs-5">Balance: {{Character::all()->firstWhere('account', $Auth::user()->name)->gold}}₽</div>
                            @else
                            <div class="fs-5">Character not created</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
                <div class="d-flex flex-row m-2 link-panel">
                    <div class="text-center w-50 px-5 py-2 border-primary  border"><a class="text-decoration-none" href="/user/{{$Auth::user()->name}}">Profile</a></div>
                    <div class="ms-1 w-50 px-5 py-2 border-primary  border text-center">Download</div>
                </div>

            <div class="d-flex flex-column m-2">
                <div>Server status</div>
                <div class="my-1 p-2 border-primary  border">Main server <span class="fw-bold">
                        {{Character::all()->where('online', true)->count()}}
                        Players</span><div class="progress">
                        <div class="progress-bar"
                             role="progressbar"
                             style="width: {{Character::all()->where('online', true)->count()*10}}%"
                             aria-valuenow="{{Character::all()->where('online', true)->count()}}"
                             aria-valuemin="0"
                             aria-valuemax="10"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column m-2">
                @if(Character::all()->where('online', true)->count()!=0)
                <div>Online players</div>
                @foreach(Character::all()->where('online', true) as $online_character)
                    <div class="my-1 p-2 border-primary  border">{{$online_character->name}} <span class="fw-bold">0 Hours</span></div>
                @endforeach
                @endif

            </div>
            @endauth
                @guest()
                    <div class="m-2">
{{--                        <div>News</div>--}}
{{--                        <div class="d-grid news-panel">--}}
{{--                            @foreach($updates as $update)--}}
{{--                                @if($loop->index<=3)--}}
{{--                                    <div class="border-primary  border p-4">--}}
{{--                                        <div>{{ $update['channel_post']['text']}}</div>--}}
{{--                                        <div>{{ $Carbon::parse($update['channel_post']['date'])}}</div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
                        <div class="d-flex flex-column">
                            <div>Last changes .web</div>
                            <div class="overflow-auto" style="max-height: 310px">
                                @foreach($web as $commit)
                                    <div class="border-primary change-item border p-4 my-1">
                                        <div><span>{{ $Carbon::parse($commit['commit']['author']['date'])->tz('Asia/Yekaterinburg') }}</span> {{ $commit['commit']['author']['name']}}</div>
                                        <div>{{ $commit['commit']['message']}}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                @endguest

        </div>
        <div class="main-right d-flex flex-column w-50">
            @auth()
{{--            <div class="border-primary  border m-2 p-2">--}}
{{--                <div>Player: Some rupor</div>--}}
{{--            </div>--}}
            <div class="m-2 d-flex flex-row prime-panel2">
                <div class="border-primary  border p-5 me-1 w-25 prime-panel">Prime panel</div>
                <div class="w-100">
                    @if(Character::all()->firstWhere('account', $Auth::user()->name)!=null)
                    <div class="border-primary border p-5 h-50 prime-panel-parent">
                        <div>Faction <span class="text-uppercase">{{Character::all()->firstWhere('account', $Auth::user()->name)->faction}}</span></div>
                        <div></div>
                    </div>
                    @else
                        <div class="border-primary border p-5 h-50 prime-panel-parent">
                            <div>Factions</div>
                            <div>You can join faction in game</div>
                        </div>
                    @endif
                    <div class="d-flex flex-row prime-other-panels h-50 prime-panel-parent">
                        <div class="border-primary border p-5 mt-1 w-50 prime-other-panel">
                            <div>Discord</div>
                            <div>https://discord.com/</div>
                        </div>
                        <div class="border-primary  border p-5 mt-1 ms-1 w-50 prime-other-panel">
                            <div>Github</div>
                            <div>https://github.com/ExtevaXT</div>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
            <div class="d-flex flex-column m-2">
                @auth()
{{--                <div>News</div>--}}
{{--                <div class="d-grid news-panel">--}}
{{--                    @foreach($updates as $update)--}}
{{--                            @if($loop->index<=3)--}}
{{--                                <div class="border-primary  border p-4">--}}
{{--                                    <div>{{ $update['channel_post']['text']}}</div>--}}
{{--                                    <div>{{ $Carbon::parse($update['channel_post']['date'])}}</div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                    @endforeach--}}
{{--                </div>--}}
                    <div class="d-flex flex-column">
                        <div>Last changes .web</div>
                        <div class="overflow-auto" style="max-height: 310px">
                            @foreach($web as $commit)
                                <div class="border-primary change-item border p-4 my-1">
                                    <div><span>{{ $Carbon::parse($commit['commit']['author']['date'])->tz('Asia/Yekaterinburg') }}</span> {{ $commit['commit']['author']['name']}}</div>
                                    <div>{{ $commit['commit']['message']}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endauth
                <div class="d-flex flex-column">
                    <div>Last changes .unity</div>
                    <div class="overflow-auto" style="max-height: 310px">
                        @foreach($unity as $commit)
                        <div class="border-primary change-item border p-4 my-1">
                            <div><span>{{ $Carbon::parse($commit['commit']['author']['date'])->tz('Asia/Yekaterinburg') }}</span> {{ $commit['commit']['author']['name']}}</div>
                            <div>{{ $commit['commit']['message']}}</div>
                        </div>
                        @endforeach
                    </div>
                </div>




            </div>




        </div>
    </div>
@endsection
