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
            {{Carbon::parse(max($unity[0]['commit']['author']['date'], $web[0]['commit']['author']['date']))->tz('Asia/Yekaterinburg')->format('d M Y | H:i')}}
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
            <div class="input-glass m-2 p-5">
                <div>Some Announcement</div>
                <div>Announcement description</div>
                <div>Time of announcement</div>
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
                <div class="bg-glass w-100 d-flex profile-panel-bg">
                    <div class="d-flex m-3 align-self-end justify-content-between w-100 flex-wrap">
                        <div class="d-flex">
                            <x-user-profile name="{{Auth::user()->name}}" size="128" all="0" />
                            <div class="align-self-center mb-4">
                                <div class="fs-2">{{Auth::user()->name}}</div>
                                @if(Account::auth()->character()!=null)
                                    <div class="fs-5">Balance: {{Account::auth()->character()->gold}}₽</div>
                                @else
                                    <div class="fs-5">Character not created</div>
                                @endif
                            </div>
                        </div>
                        @if(Auth::user()->character())
                        <div class="bg-glass p-3 mb-3 daily-panel">
                            <h5 class="text-center">Daily Reward</h5>
                            @if(Carbon::parse(Auth::user()->setting('daily')) < Carbon::now()->subDay() or !Auth::user()->setting('daily'))
                                <form action="{{route('daily')}}" method="POST">
                                    @csrf
                                    <button class="input-glass py-2 my-2 w-100" type="submit">Claim</button>
                                </form>
                            @else
                                <button class="btn input-glass py-2 px-4 m-2 disabled w-100">Remain {{Carbon::now()->addDay()->diffInHours(Carbon::parse(Auth::user()->setting('daily')))}} hours</button>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
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
                             style="width: {{Character::online()->count()*10}}%"
                             aria-valuenow="{{Character::online()->count()}}"
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
                @foreach(Character::online() as $online_character)
                    <div class="my-1 p-2 input-glass">{{$online_character->name}} <span class="fw-bold">0 Hours</span></div>
                @endforeach
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
                <div class="input-glass me-2 w-25 prime-panel d-flex align-items-end pc-panel">
                    <div class="p-3">
                        <h5>Prime panel</h5>
                        <div>Some art idk</div>
                    </div>

                </div>
                <div class="w-100">
                    @if(Auth::user()->character()!=null)
                    <div class="input-glass h-50 prime-panel-parent d-flex align-items-end">
                        <div class="p-3">
                            <h3>Faction </h3>
                            <div><span class="text-uppercase">{{Account::auth()->character()->faction}}</span></div>
                        </div>
                    </div>
                    @else
                        <div class="input-glass h-50 prime-panel-parent d-flex align-items-end">
                            <div class="p-3">
                                <div>Factions</div>
                                <div>You can join faction in game</div>
                            </div>
                        </div>
                    @endif
                    <div class="d-flex flex-row prime-other-panels h-50 prime-panel-parent">
                        <div class="input-glass mt-2 w-50 prime-other-panel d-flex align-items-end">
                            <div class="p-3">
                                <div>Discord</div>
                                <div>https://discord.gg/JMhd6VtVv5</div>
                            </div>
                        </div>
                        <div class="input-glass mt-2 ms-2 w-50 prime-other-panel d-flex align-items-end">
                            <div class="p-3">
                                <div>Github</div>
                                <div>https://github.com/ExtevaXT</div>
                            </div>
                        </div>
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
                                    <div><span>{{ Carbon::parse($commit['commit']['author']['date'])->tz('Asia/Yekaterinburg')->format('d M Y | H:i') }}</span> {{ $commit['commit']['author']['name']}}</div>
                                    <div>{{ $commit['commit']['message']}}</div>
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
                                <div><span>{{ Carbon::parse($commit['commit']['author']['date'])->tz('Asia/Yekaterinburg')->format('d M Y | H:i') }}</span> {{ $commit['commit']['author']['name']}}</div>
                                <div>{{ $commit['commit']['message']}}</div>
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
