@extends('master')



@section('title', 'Project.web')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    @guest()
    <div class="text-center py-5 mt-5">
        <div class="fs-3">Project.web - Web interface for Project.unity</div>
        <div class="text-secondary fs-5">Last update
            {{Resource::date(max($unity[0]['commit']['author']['date'], $web[0]['commit']['author']['date']))}}
        </div>
        <button class="input-glass py-2 px-4 d-inline-block fs-5 mt-3" onclick="window.location.href='{{route('register')}}'">Register account</button>
        <br>
        <button class="input-glass py-2 px-4 d-inline-block mt-2" onclick="window.location.href='{{route('download')}}'">Download</button>
    </div>
    @endguest
    @if(session()->has('daily') and session()->get('daily') == false)
        <div class="alert alert-danger mt-4">Daily reward already claimed</div>
    @endif
    @if(session()->get('daily') == true)
        <div class="alert alert-success mt-4">Daily reward claimed</div>
    @endif
    <div class="@auth d-flex my-2 main @endauth">
        <div class="main-left d-flex flex-column @auth() w-50 @endauth ">
            @auth()
                @if(Auth::user()->setting('indexAnnouncements'))
            <div class="bg-glass m-2 p-4">
                <div class="m-1">
                    <h5 >{{$announcement['embeds'][0]['title'] }}</h5>
                    <div>
                        @if(str_contains($announcement['content'], 'http'))
                            <a href="{{$announcement['content']}}" class="text-link">
                                <!-- fucking html -->
                                <div class="d-flex gap-1">
                                    <div>{{$announcement['content'] }}</div>
                                    <div class="mt-1"><i class="mdi mdi-link"></i></div>
                                </div>
                            </a>
                        @else
                            {{$announcement['content'] }}
                        @endif
                    </div>
                    <div class="opacity-50">{{ Resource::date($announcement['timestamp'])  }}</div>
                </div>
            </div>
                @endif
            <div class="d-flex m-2 profile-panel">
                <div class="d-grid text-center profile-panel-nav">
                    <button onclick="location.href='/user/{{Auth::user()->name}}'" class="profile-panel-nav-item input-glass">
                        <i class="icons mdi mdi-slack"></i>
                        <div>Character</div>
                    </button>
                    <button onclick="location.href='/quests'" class="profile-panel-nav-item input-glass">
                        <i class="icons mdi mdi-creation"></i>
                        <div>Quests</div>
                    </button>
                    <button onclick="location.href='/auction'" class="profile-panel-nav-item input-glass">
                        <i class="icons mdi mdi-scale-balance"></i>
                        <div>Auction</div>
                    </button>
                    <button onclick="location.href='/ranking'" class="profile-panel-nav-item input-glass">
                        <i class="icons mdi mdi-trophy"></i>
                        <div>Ranking</div>
                    </button>
                </div>
               <livewire:profile-panel/>
            </div>
                <div class="d-flex flex-row m-2 link-panel">
                    <a class="text-decoration-none w-50" href="/user/{{Auth::user()->name}}"><div class="text-center px-5 py-2 input-glass">Profile</div></a>
                    <a class="text-decoration-none w-50" href="{{route('download')}}"><div class="ms-2 px-5 py-2 input-glass text-center">Download</div></a>
                </div>
            @endauth()
            <div class="d-flex flex-column m-2">
                <h3>Server status</h3>
                <div class="my-1 p-2 bg-glass">Main server @if($status) <span class="text-success">ONLINE</span> <span class="fw-bold">
                        {{Character::online()->count()}}
                        Players</span>
                    @else <span class="text-danger">OFFLINE</span> @endif
                    <div class="progress" style="background: transparent">
                        <div class="progress-bar bg-light"
                             role="progressbar"
                             style="width: {{ $status ? Character::online()->count()*10 : 0}}%"
                             aria-valuenow="{{$status ? Character::online()->count() : 0}}"
                             aria-valuemin="0"
                             aria-valuemax="10"></div>
                    </div>
                </div>
            </div>
            @auth
            @if(Auth::user()->setting('indexOnline'))
            <div class="d-flex flex-column m-2">
                @if((Character::online()->count()!=0))
                <h3>Online players</h3>
                @foreach(Character::online()->take(7) as $online_character)
                    <div class="my-1 p-2 input-glass">{{$online_character->name}} <span class="fw-bold">0 Hours</span></div>
                @endforeach
                    @if(Character::online()->count() > 7)
                        <div>And {{Character::online()->count() - 7}} other</div>
                    @endif
                @endif
            </div>
            @endif
            @endauth

        </div>
        <div class="main-right d-flex flex-column @auth() w-50 @endauth">
            @auth()
{{--            <div class="border-primary  border m-2 p-2">--}}
{{--                <div>Player: Some rupor</div>--}}
{{--            </div>--}}
            <div class="m-2 d-flex flex-row prime-panel2">
                <div class="bg-glass me-2 w-25 prime-panel d-flex align-items-end pc-panel">
                    <div class="p-3">
                        <h5>Version Control</h5>
                        <div>AV0.1.1</div>
                    </div>

                </div>
                <div class="w-100">
                    @if(Auth::user()->character()!=null)
                    <a class="input-glass h-50 prime-panel-parent d-flex align-items-end text-link d-block"
                       style="background:linear-gradient( rgba(177, 177, 177, 0.07), rgba(177, 177, 177, 0.07) ),
                           url('{{asset('img/icon/factions/'. strtolower(Account::auth()->character()->faction)).'.svg'}}') 50% / 250px no-repeat"
                    href="/faction">
                        <div class="p-3">
                            <h3>Faction</h3>
                            <div><span class="text-uppercase">{{Account::auth()->character()->faction}}</span></div>
                        </div>
                    </a>
                    @else
                        <div class="input-glass h-50 prime-panel-parent d-flex align-items-end">
                            <div class="p-3">
                                <h3>Faction</h3>
                                <div>You can join faction in game</div>
                            </div>
                        </div>
                    @endif
                    <div class="d-flex flex-row prime-other-panels h-50 prime-panel-parent">
                        <a class="input-glass mt-2 w-50 prime-other-panel d-flex align-items-end text-link d-block" href="https://discord.gg/JMhd6VtVv5">
                            <div class="p-3">
                                <h3>Discord</h3>
                            </div>
                        </a>
                        <a class="input-glass mt-2 ms-2 w-50 prime-other-panel d-flex align-items-end text-link d-block" href="https://github.com/ExtevaXT">
                            <div class="p-3">
                                <h3>Github</h3>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endauth
            <div class="m-2 @guest d-flex main gap-3 w-100 @endguest">
                @if(Auth::user()?->setting('indexWeb') or Auth::guest())
                <div class="@guest w-50 main-left @endguest">
                    <h3>Last changes .web</h3>
                    <div>
                        @foreach($web as $commit)
                            <a href="{{$commit['html_url']}}" class="d-block text-link">
                                <div class="input-glass change-item p-4 my-2" onclick="window.location.href='{{$commit['html_url']}}'">
                                    <div><span>{{ Resource::date($commit['commit']['author']['date']) }}</span> {{ $commit['commit']['author']['name']}}</div>
                                    <div title="{{$commit['commit']['message']}}">{{ explode("\n",$commit['commit']['message'])[0] }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
                    @if(Auth::user()?->setting('indexUnity') or Auth::guest())
                <div class="@guest w-50 main-right @endguest">
                    <h3>Last changes .unity</h3>
                    <div>
                        @foreach($unity as $commit)
                        <div class="input-glass change-item p-4 my-2">
                            <a href="{{$commit['html_url']}}" class="d-block text-link">
                                <div><span>{{ Resource::date($commit['commit']['author']['date']) }}</span> {{ $commit['commit']['author']['name']}}</div>
                                <div title="{{$commit['commit']['message']}}">{{ explode("\n",$commit['commit']['message'])[0] }}</div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                    @endif




            </div>




        </div>
    </div>
@endsection
