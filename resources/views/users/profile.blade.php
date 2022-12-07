@extends('master')



@section('title', 'Profile page')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/profile.css')}}">
    @if($account->setting('styleTheme') and ($account->setting('styleThemeShow') == 0 or $account->setting('styleThemeShow') == 2))
    <link rel="stylesheet" href="{{asset('js/JS-Theme-Switcher-master/themes/'.$account->setting('styleTheme').'.css')}}">
    @endif
    <style>
        {{$account->setting('styleCSS')}}
    </style>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! session()->get('success') !!}</li>
            </ul>
        </div>
    @endif
<div class="">
    <div class="d-flex my-5 top-panel">
        <div class="pe-3">
            <x-user-profile name="{{$account->name}}" size="256" all="0"/>
            @if(Auth::user() !=null and Auth::user()->name == $account->name)
            <div class="d-flex gap-2 ms-2">
                <div class="p-2 btn btn-outline-primary bg-glass" data-bs-toggle="modal" data-bs-target="#imageModal">
                    Upload picture
                </div>
                <form action="{{route('upload')}}" method="POST">
                    @csrf
                    <button class="py-2 px-4 btn btn-outline-primary bg-glass" type="submit">Default</button>
                </form>

            </div>
            @endif
        </div>
        <div class="d-flex flex-column py-5 px-2">
            <div style="font-size: 50px; font-weight: bold">{{ $account['name'] }}</div>
            <div class="fs-5"><i class="icons mdi mdi-trophy mdi-18px"></i> {{ $trophies }} <span class="fw-bold">Prefix</span></div>
            <div>@if( $character!=null and $character['online']) <span class="text-success">Online</span> @else <span class="text-danger">Not online</span> @endif </div>
            @auth()
                {{--                TEST CLAUSE                   --}}
                @if(// Account doesnt have you in friends
                    $account_friend_start != Auth::user()->name and
                    $account_friend_end != Auth::user()->name and
                    // You doesnt have account in friends
                    $your_friend_start != $account->name and
                    $your_friend_end != $account->name and

                    // You cant add yourself
                    $account->name != Auth::user()->name



                    )
                    <div>
                        <form method="post" action="{{route('friend_add')}}">
                            @csrf
                            <input type="hidden" name="friend" value="{{$account['name']}}">
                            <button class="btn btn-primary" type="submit">Add to friends</button>
                        </form>
                    </div>
                @endif







{{--                @if((Auth::user()->name != $account->name) and (--}}
{{--                (Friend::all()->where('friend', Auth::user()->name)->first() == null) or--}}
{{--                (Friend::all()->where('account', Auth::user()->name)->first() == null)))--}}
{{--                    <div>--}}
{{--                        <form method="post" action="{{route('friend_add')}}">--}}
{{--                            @csrf--}}
{{--                            <input type="hidden" name="friend" value="{{$account['name']}}">--}}
{{--                            <button class="btn btn-primary" type="submit">Add to friends</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                @endif--}}
            @endauth
        </div>
    </div>






    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#profile">{{ $account['name'] }}</a>
        </li>
        @if(Auth::user() !=null and Auth::user()->name == $account->name)
            @if($character!=null)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#inventory">Storage</a>
        </li>
            @endif
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#activity">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#collection">Collection</a>
        </li>
            @if($character!=null)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#talents">Talents</a>
        </li>
            @endif
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#friends">Friends</a>
        </li>
        @endif
        @if($character!=null)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#achievements">Achievements</a>
        </li>
        @endif
    </ul>
    <div class="tab-content mb-5">
        <div class="tab-pane fade show active" id="profile">
            <div class="d-flex main">
                <div class="main-left d-flex flex-column w-50 m-2">
                    <div class="fs-3 my-3">General information</div>
                    <div class="d-grid info-panel">
                        <div class="bg-glass p-2">
                            <div>Registration</div>
                            <div>{{ $account['created'] }}</div>
                        </div>
                        <div class="bg-glass p-2">
                            <div>Last online</div>
                            <div>{{ $account['lastLogin'] }}</div>
                        </div>
                        @if($character!=null)
                        <div class="bg-glass p-2">
                            <div>Prestige</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div>0</div>
                        </div>
                        <div class="bg-glass p-2">
                            <div>Last game online</div>
                            <div>Time</div>
                        </div>
                        <div class="bg-glass p-2">
                            <div>Reputation</div>
                            <div>0</div>
                        </div>
                        <div class="bg-glass p-2">
                            <div>{{ $character['level'] }} Level <span class="fw-light">{{ $character['experience'] }} exp</span></div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="fw-light">Remain 1000 exp for {{ $character['level']+1 }} lvl</div>
                        </div>
                        @endif
                        @if(Auth::user() !=null and Auth::user()->name == $account->name)
                            <div class="bg-glass p-2">
                                <div>Balance</div>
                                <div>{{$character['gold']}}</div>
                            </div>
                            <div class="bg-glass p-2">
                                <div>Research Tokens</div>
                                <div>0</div>
                            </div>
                            <div class="bg-glass p-2">
                                <div>Hunting Tokens</div>
                                <div>0</div>
                            </div>
                        @endif
                    </div>


                    <div class="fs-3 my-3">Player statistics</div>
                    @if($character!=null)
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#server1">{{ $character['name'] }}</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        @for ($i = 1; $i <= 1; $i++)
                            <div class="tab-pane fade show active" id="server{{$i}}">
                                <div class="text-center">
                                    <model-viewer
                                        alt=""
{{--                                        src="{{asset('model/soldier.glb')}}"--}}
                                        ar
                                        shadow-intensity="1"
                                        shadow-softness="1"
                                        exposure="0.5"
                                        camera-controls
                                        touch-action="pan-y"
                                        class="model-size"
                                    >


                                    </model-viewer>
                                    <div>Server online time <span class="fw-bold">0 hours</span></div>
                                    <div>Full online time <span class="fw-bold">0 hours</span></div>
                                    <div>Week online time <span class="fw-bold">0 hours</span> </div>
                                </div>
                            </div>
                        @endfor

                    </div>
                    @else
                        <div class="text-center p-5 fs-3">Character is not created</div>
                    @endif


                </div>
                <div class="main-right d-flex flex-column w-50 m-2">
                    @if($character!=null)
                    <div class="fs-3 my-3">Achievement showcase</div>
                    <div class="d-flex achievement-panel">
                        @for ($i = 0; $i < 5; $i++)
                            @isset($achievements[$i])
                            <div class="bg-glass p-3 w-100 me-1 text-center achievement-collection-item">
                                <div class="m-1"><i class="icons mdi mdi-trophy mdi-48px"></i></div>
                                <div style="white-space: nowrap">{{$achievements[$i]['name']}}</div>
                            </div>
                            @else
                            <div class="border border-primary p-3 w-100 me-1 text-center achievement-collection-item-placeholder"></div>
                            @endisset
                        @endfor
                    </div>
                    @endif
{{--                    @if(Auth::user() !=null and Auth::user()->name == $account->name)--}}
{{--                    <div class="fs-3 my-3">Collection showcase</div>--}}
{{--                    <div class="d-flex collection-panel">--}}
{{--                        @for ($i = 1; $i <= 4; $i++)--}}
{{--                            <div class="bg-glass p-3 w-100 me-1">--}}
{{--                                <div>Img</div>--}}
{{--                                <div>Some collectible</div>--}}
{{--                            </div>--}}
{{--                        @endfor--}}
{{--                    </div>--}}
{{--                    @endif--}}
                    @if($character!=null)
                    <div class="fs-3 my-3">Skills</div>
                    <div class="d-grid skill-panel">
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-heart-pulse mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Vitality</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->health}} </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-lightning-bolt mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Endurance</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->endurance}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-food-drumstick mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Metabolism</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->nutrition}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-water mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Hydration</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->hydration}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-dumbbell mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Strength</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->weight}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-radioactive mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Radioresistance</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->radiation}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-shield mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Immunity</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->biological}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-heat-wave mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Acclimatisation</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->thermal}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-square-root mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Intellect</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->psycho}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-glass p-3">
                            <div class="d-flex">
                                <div class="mt-3 me-2"><i class="mdi mdi-water-off mdi-48px"></i></div>
                                <div class="w-100">
                                    <div>Hemostasis</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->bleeding}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endif


                </div>
            </div>




        </div>


        @if(Auth::user() !=null and Auth::user()->name == $account->name)
            @if($character!=null)
        <div class="tab-pane fade" id="inventory">
            <div class="fs-3 my-3">Personal Storage</div>
            <div class="d-flex inventory-parent">
{{--                72 SLOTS --}}
                <div class="d-grid w-50 inventory-panel">
                    @foreach($inventory as $item)

                        <div class="inventory-item bg-glass">
                            <div class="w-100 h-100"
                                 @if($item['name']!='')
                                 style="background-image:url('{{ asset(data_get($icons, $item['name'], 'img/icon/item.png')) }}');
                                     background-size: cover;"
                                 @endif
                                 data-slot="{{$item['slot']}}"
                                 data-item="{{$item['name']}}"
                                 data-amount="{{$item['amount']}}"
                                 data-ammo="{{$item['ammo']}}"
                                 data-durability="{{$item['durability']}}"
                                 data-metadata="{{$item['metadata']}}"

                                 onclick="SelectItem({{$item['slot']}})">
                                @if($item['name']!='' and $item['amount']!=1)
                                    <div class="float-end me-3">x{{$item['amount']}}</div>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mx-5 inventory-selector">
                    <div class="bg-glass"><div class="p-5 item-icon" style="background-size: cover; width: 256px; height: 256px"></div></div>

                    <div class="item-name">Name</div>
                    <div class="item-amount">Amount</div>
                    <div class="item-ammo">Ammo</div>
                    <div class="item-durability">Durability</div>
                    <div class="item-metadata">Metadata</div>

                    <div class="w-100">
                        <div onclick="SellItem()" class="item-sell p-2 my-2 bg-glass text-center">Sell</div>
                        <div onclick="" class="item-trade p-2 my-2 bg-glass text-center">Trade</div>
                        <div onclick="" class="item-delete p-2 my-2 bg-glass text-center">Delete</div>
                    </div>

                </div>
            </div>

        </div>
            @endif






        <div class="tab-pane fade" id="activity">

            <div class="d-flex flex-column">
                @for ($i = 1; $i <= 10; $i++)
                    <div class="p-3"><span class="me-2">Icon</span> Some activity <span class="fw-light mx-2">Time ago</span></div>
                @endfor
            </div>









        </div>
        <div class="tab-pane fade" id="collection">
            <div class="d-flex my-3 collection-tab">
                <ul class="nav nav-tabs flex-column d-flex collection-nav">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#collection-hats">Hats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#collection-items">Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#collection-cosmetic">Cosmetic</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#collection-accessories">Accessories</a>
                    </li>

                </ul>
                <div class="tab-content w-100">
                    <div class="tab-pane fade show active" id="collection-hats">
                        <div class="d-grid collection-panel">
                            @for ($i = 1; $i <= 10; $i++)
                                <div class="border border-primary p-3">
                                    <div>Img</div>
                                    <div>Some collectible</div>
                                    <div>Obtain time</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="tab-pane fade" id="collection-items">
                        <div class="d-grid collection-panel">
                            @for ($i = 1; $i <= 10; $i++)
                                <div class="border border-primary p-3">
                                    <div>Img</div>
                                    <div>Some collectible</div>
                                    <div>Obtain time</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="tab-pane fade" id="collection-cosmetic">
                        <div class="d-grid collection-panel">
                            @for ($i = 1; $i <= 10; $i++)
                                <div class="border border-primary p-3">
                                    <div>Img</div>
                                    <div>Some collectible</div>
                                    <div>Obtain time</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="tab-pane fade" id="collection-accessories">
                        <div class="d-grid collection-panel">
                            @for ($i = 1; $i <= 10; $i++)
                                <div class="border border-primary p-3">
                                    <div>Img</div>
                                    <div>Some collectible</div>
                                    <div>Obtain time</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>











        </div>
        @if($character!=null)
        <div class="tab-pane fade" id="talents">
            <div class="fs-3 mt-3">Talents</div>
            <div class="fs-5">Talents general description</div>
            <div class="fs-5 mb-3">Level {{$character->level}}/1000</div>
            <div class="d-grid talent-panel">
                @foreach ($talent_data as $talent)
                    <div class="bg-glass p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div>{{$talent['m_Name']}} <span class="float-end">Rarity</span></div>
                            <div>{{$talent['description']}}</div>
                        </div>
                        <div class="text-center bg-glass m-1 p-1 w-100">Need {{$talent['requirementLevel']}} level</div>
                    </div>

                @endforeach
            </div>



        </div>
            @endif
        <div class="tab-pane fade" id="inventory">

        </div>
        <div class="tab-pane fade" id="friends">
            <div class="fs-3 my-3">Friend list</div>
            <div class="d-grid friend-panel">
                {{-- SHOW YOUR FRIEND REQUESTS AND ACCEPTED --}}
                    @foreach(Friend::all()->where('account', Auth::user()->name) as $friend)
                    <div class="bg-glass p-3">
                        <div class="d-flex">
                            <x-user-profile name="{{$friend->friend}}" size="64" all="0" />
                            <div>
                                <div>{{$friend->friend}}</div>
                                @if($friend->accepted)
                                    <div class="text-success">Accepted</div>
                                @else
                                    <div class="text-danger">Not accepted</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                        {{-- SHOW OTHER FRIEND REQUESTS AND  --}}
                    @foreach(Friend::all()->where('friend', Auth::user()->name) as $friend)
                    <div class="bg-glass p-3">
                        <div class="d-flex">
                            <x-user-profile name="{{$friend->account}}" size="64" all="0" />
                            <div>
                                <div>
                                    <div>{{$friend->account}}</div>
                                    @if($friend->accepted)
{{--                                        <div></div>--}}
                                    @else
                                        <div>
                                            <form method="post" action="{{route('friend_accept')}}">
                                                @csrf
                                                <input type="hidden" name="friend" value="{{$friend->account}}">
                                                <button class="btn btn-primary" type="submit">Accept request</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                        @endforeach
            </div>


        </div>
        @endif
        @if($character!=null)
        <div class="tab-pane fade" id="achievements">
            <div class="fs-3 my-3">Achievements</div>
            @forelse($achievements as $achievement)
                <div class="bg-glass mb-1 p-3">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <i class="icons mdi mdi-trophy mdi-36px align-self-end mx-3 mb-1"></i>
                            <div>
                                <div>{{$achievement->name}}</div>
                                <div>{{$achievement_data->firstWhere('m_Name', $achievement->name)['description']}}</div>
                            </div>
                        </div>
                        <div class="align-self-center">
                            <i class="icons mdi mdi-trophy-outline"></i>
                            <span class="fs-4">{{$achievement_data->firstWhere('m_Name', $achievement->name)['reward']}}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div>No achievements</div>
            @endforelse
        </div>
        @endif
    </div>
</div>


<!-- UPLOAD PFP -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageLabel" aria-hidden="true">
    <div class="container">
        <div class="modal-dialog float-end w-50 authorization-panel" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title text-center" id="imageLabel">Upload profile picture</h5>

                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('upload') }}" class="d-flex flex-column" enctype="multipart/form-data">
                        @csrf
                        <input name="image" class="my-1 p-2 border border-primary form-control" type="file" required>
                        <input class="my-1 p-2 btn-outline-primary btn" type="submit" value="Upload">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
{{--<!-- MOBILE INVENTORY ITEM SELECTOR -->--}}
{{--<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemLabel" aria-hidden="true">--}}
{{--    <div class="">--}}
{{--        <div class="modal-dialog modal-fullscreen" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title text-center" id="itemLabel">Item selection</h5>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="m-5 inventory-selector">--}}
{{--                        <div class="p-5 border border-primary item-icon" style="background-size: cover; width: 256px; height: 256px"></div>--}}
{{--                        <div class="item-name">Name</div>--}}
{{--                        <div class="item-amount">Amount</div>--}}
{{--                        <div class="item-ammo">Ammo</div>--}}
{{--                        <div class="item-durability">Durability</div>--}}
{{--                        <div class="item-metadata">Metadata</div>--}}

{{--                        <div class="w-100">--}}
{{--                            <div onclick="SellItem()" class="item-sell p-2 my-1 bg-glass text-center">Sell</div>--}}
{{--                            <div onclick="" class="item-trade p-2 my-1 bg-glass text-center">Trade</div>--}}
{{--                            <div onclick="" class="item-delete p-2 my-1 bg-glass text-center">Delete</div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--</div>--}}



        <script>
            let slot_out = document.querySelectorAll('.item-slot');
            let name_out = document.querySelectorAll('.item-name');
            let amount_out = document.querySelectorAll('.item-amount');
            let ammo_out = document.querySelectorAll('.item-ammo');
            let durability_out = document.querySelectorAll('.item-durability');
            let metadata_out = document.querySelectorAll('.item-metadata');

            let icon_out = document.querySelectorAll('.item-icon');

            let item_sell = document.querySelectorAll('.item-sell');
            let item_trade = document.querySelectorAll('.item-trade');
            let item_delete = document.querySelectorAll('.item-delete');

            let selectedSlot = -1;

            // let description = document.querySelector('.item-description');

            function SelectItem(slot){
                let selected = document.querySelector(`[data-slot="${slot}"]`);
                selectedSlot = slot;


                name_out.forEach(x => x.innerHTML ='Name: ' + selected.getAttribute('data-item'));
                amount_out.forEach(x => x.innerHTML ='Amount: ' + selected.getAttribute('data-amount'));
                ammo_out.forEach(x => x.innerHTML ='Ammo: ' + selected.getAttribute('data-ammo'));
                durability_out.forEach(x => x.innerHTML ='Durability: ' + selected.getAttribute('data-durability'));
                metadata_out.forEach(x => x.innerHTML ='Meta: ' + selected.getAttribute('data-metadata'));
                icon_out.forEach(x => x.style.backgroundImage = selected.style.backgroundImage);

                document.querySelectorAll('[data-slot]').forEach(x => x.classList.remove('selected-item'));
                selected.classList.add('selected-item');
            }
            function SellItem(){
                window.location.href = `{{route('lot_create')}}?slot=${selectedSlot}`;
            }
            function TradeItem(){

            }
            function DeleteItem(){

            }
            //select first item
            Array.from(document.querySelectorAll('[data-item]')).some(function (x){
                if(x.getAttribute('data-item')!=null){
                    SelectItem(x.getAttribute('data-slot'))
                    return true
                }
            })







        </script>
    <!-- Import the component -->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
@endsection
