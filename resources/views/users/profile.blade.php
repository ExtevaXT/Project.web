@inject('Auth','\Illuminate\Support\Facades\Auth')
@extends('master')



@section('title', 'Profile page')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Profile/style.css')}}">
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
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif
<div class="">
    <div class="d-flex my-5 top-panel">
        <div class="pe-3">
            <div class="border border-primary" style="width: 256px; height: 256px"><img style="object-fit: cover; width: 256px; height: 256px" src="{{ asset($account['image'])}}" alt=""></div>
            <div class="d-flex">
                <div class="p-2" data-bs-toggle="modal" data-bs-target="#imageModal">
                    Upload pic
                </div>
                <div class="p-2">Upload banner</div>
            </div>
        </div>
        <div class="d-flex flex-column py-5 px-2">
            <div style="font-size: 50px">{{ $account['name'] }}</div>
            <div>Rating <span class="fw-bold">Prefix</span></div>
            <div>@if( $character!=null and $character['online']) <span class="text-success">Online</span> @else <span class="text-danger">Not online</span> @endif </div>
            @auth()
                {{--SHOW ONLY IF ACCOUNT['NAME'] IS NOT AUTHED ACCOUNT FRIEND--}}
                {{--FRIENDS TABLE FIND COLUMN WITH ACCOUNT == AUTH ACCOUNT, FIRST FINDED FRIEND COLUMN NOT EQUALS PAGE NAME --}}
                {{-- NOW WORKS FROM ONE SIDE ONLY, REMOVE SECOND LINE IF NOT--}}
                @if(($Auth::user()->name != $account->name) and
                    (Friend::all()->where('account', $Auth::user()->name)->first() != null) and
                    (Friend::all()->where('account', $Auth::user()->name)->first()->friend != $account['name']))
                    <div>
                        <form method="post" action="{{route('friend_add')}}">
                            @csrf
                            <input type="hidden" name="friend" value="{{$account['name']}}">
                            <button class="btn btn-primary" type="submit">Add to friends</button>
                        </form>
                    </div>
                @endif
                @if(($Auth::user()->name != $account->name) and
                (Friend::all()->where('friend', $Auth::user()->name)->first() != null) and
                (Friend::all()->where('friend', $Auth::user()->name)->first()->account != $account['name']))
                    <div>
                        <form method="post" action="{{route('friend_add')}}">
                            @csrf
                            <input type="hidden" name="friend" value="{{$account['name']}}">
                            <button class="btn btn-primary" type="submit">Add to friends</button>
                        </form>
                    </div>
                @endif
{{--                @if(($Auth::user()->name != $account->name) and (--}}
{{--                (Friend::all()->where('friend', $Auth::user()->name)->first() == null) or--}}
{{--                (Friend::all()->where('account', $Auth::user()->name)->first() == null)))--}}
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
        @if($Auth::user() !=null and $Auth::user()->name == $account->name)
        <li class="nav-item">
            <a class="nav-link mobile-lock" data-bs-toggle="tab" href="#inventory">Inventory</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#activity">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#collection">Collection</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#talents">Talents</a>
        </li>
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
                    <div>General information</div>
                    <div class="d-grid info-panel">
                        <div class="border-primary border p-2">
                            <div>Registration</div>
                            <div>{{ $account['created'] }}</div>
                        </div>
                        <div class="border-primary border p-2">
                            <div>Last online</div>
                            <div>{{ $account['lastLogin'] }}</div>
                        </div>
                        @if($character!=null)
                        <div class="border-primary border p-2">
                            <div>Prestige</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div>0</div>
                        </div>
                        <div class="border-primary border p-2">
                            <div>Last game online</div>
                            <div>Time</div>
                        </div>
                        <div class="border-primary border p-2">
                            <div>Reputation</div>
                            <div>0</div>
                        </div>
                        <div class="border-primary border p-2">
                            <div>{{ $character['level'] }} Level <span class="fw-light">{{ $character['experience'] }} exp</span></div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="fw-light">Remain 1000 exp for {{ $character['level']+1 }} lvl</div>
                        </div>
                        @endif
                        @if($Auth::user() !=null and $Auth::user()->name == $account->name)
                            <div class="border-primary border p-2">
                                <div>Some currency</div>
                                <div>0</div>
                            </div>
                            <div class="border-primary border p-2">
                                <div>Some currency</div>
                                <div>0</div>
                            </div>
                            <div class="border-primary border p-2">
                                <div>Some currency</div>
                                <div>0</div>
                            </div>
                        @endif
                    </div>


                    <div>Player statistics</div>
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
                                        src="{{asset('model/soldier.glb')}}"
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
                        <div class="text-center p-5">Character is not created</div>
                    @endif


                </div>
                <div class="main-right d-flex flex-column w-50 m-2">
                    @if($character!=null)
                    <div>Achievement showcase</div>
                    <div class="d-flex achievement-panel">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="border-primary border p-3 w-100 me-1">
                                <div>Img</div>
                                <div>Some achievement</div>
                            </div>
                        @endfor
                    </div>
                    @endif
                    @if($Auth::user() !=null and $Auth::user()->name == $account->name)
                    <div>Collection showcase</div>
                    <div class="d-flex collection-panel">
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="border-primary border p-3 w-100 me-1">
                                <div>Img</div>
                                <div>Some collectible</div>
                            </div>
                        @endfor
                    </div>
                    @endif
                        @if($character!=null)
                    <div>Perks</div>
                    <div class="d-grid perk-panel">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="border-primary border p-3">
                                <div class="d-flex">
                                    <div class="p-2">Img</div>
                                    <div class="w-100">
                                        <div>Some perk</div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div>0 level</div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                        @endif


                </div>
            </div>

















        </div>


        @if($Auth::user() !=null and $Auth::user()->name == $account->name)
        <div class="tab-pane fade" id="inventory">

            <div class="d-flex">
{{--                72 SLOTS --}}
                <div class="d-grid w-50 inventory-panel">
                    @for ($i = 0; $i <= 71; $i++)
                        <div class="inventory-item border-primary border">
                            <div>
                                @foreach($character_personal_storage as $item)

                                    @if($item->slot==$i)
                                        <div>{{$item->name}}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="m-5 inventory-selector" >
                    <div class="p-5 border border-primary" style="width: 256px; height: 256px">Icon</div>
                    <div>Item name</div>
                    <div>Item description</div>
                    <div>Item tags</div>
                    <div class="w-100">
                        <div class="p-2 my-1 border-primary border text-center">Sell</div>
                        <div class="p-2 my-1 border-primary border text-center">Trade</div>
                        <div class="p-2 my-1 border-primary border text-center">Delete</div>
                    </div>





                </div>
            </div>

        </div>






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
        <div class="tab-pane fade" id="talents">
            <div>Talents</div>
            <div>Talents general description</div>
            <div>Level 0/1000</div>
            <div class="d-grid talent-panel">
                @for ($i = 1; $i <= 10; $i++)
                    <div class="border border-primary p-3">
                        <div>Some talent <span class="float-end">Rarity</span></div>
                        <div>Talent description</div>
                        <div class="text-center border-primary border m-1 p-1">Need 1 level</div>
                    </div>
                @endfor

            </div>



        </div>
        <div class="tab-pane fade" id="inventory">

        </div>
        <div class="tab-pane fade" id="friends">
            <div>Friends</div>
            <div class="d-grid friend-panel">
                {{-- SHOW YOUR FRIEND REQUESTS AND ACCEPTED --}}
                    @foreach(Friend::all()->where('account', $Auth::user()->name) as $friend)
                    <div class="border-primary border p-3">
                        <div class="d-flex">
                            <div class="border border-primary me-3" style="
                                width: 64px;
                                height: 64px;
                                background-size: cover;
                                background-position: center;
                                filter: blur(0.6px);
                                background-image:url('{{ asset(Account::all()->where('name', $friend->friend)->first()->image)}}')
                                "></div>
                            <div>
                            <div>
                                <div>{{$friend->friend}}</div>
                                @if($friend->accepted)
                                    <div>Message</div>
                                @else
                                    <div>Not accepted</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                        {{-- SHOW OTHER FRIEND REQUESTS AND  --}}
                    @foreach(Friend::all()->where('friend', $Auth::user()->name) as $friend)
                    <div class="border-primary border p-3">
                        <div class="d-flex">
                            <div class="border border-primary me-3" style="
                                width: 64px;
                                height: 64px;
                                background-size: cover;
                                background-position: center;
                                filter: blur(0.6px);
                                background-image:url('{{ asset(Account::all()->where('name', $friend->account)->first()->image)}}')
                                "></div>
                            <div>
                                <div>
                                    <div>{{$friend->account}}</div>
                                    @if($friend->accepted)
                                        <div>Message</div>
                                    @else
                                        <div>
                                            <form method="post" action="{{route('friend_accept')}}">
                                                @csrf
                                                <input type="hidden" name="friend" value="{{$friend->account}}">
                                                <button class="btn btn-primary" type="submit">Add to friends</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
            </div>


        </div>
        @endif
        <div class="tab-pane fade" id="achievements">
            <div>Achievements</div>


            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#achievements-general">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#achievements-progression">Progression</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#achievements-pvp">PVP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#achievements-pve">PVE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#achievements-craft">Crafting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#achievements-collections">Collections</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#achievements-skills">Skills</a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="achievements-general">
                    <div class="d-flex flex-column my-5">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="border-primary border mb-1 p-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="p-2">Img</div>
                                        <div>
                                            <div>Some achievement</div>
                                            <div>Achievement description</div>
                                        </div>
                                    </div>
                                    <div>Trophy amount</div>
                                </div>

                            </div>
                        @endfor
                    </div>

                </div>
                <div class="tab-pane fade" id="achievements-progression">
                    <div class="d-flex flex-column my-5">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="border-primary border mb-1 p-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="p-2">Img</div>
                                        <div>
                                            <div>Some achievement</div>
                                            <div>Achievement description</div>
                                        </div>
                                    </div>
                                    <div>Trophy amount</div>
                                </div>
                            </div>
                        @endfor


                    </div>
                </div>
                <div class="tab-pane fade" id="achievements-pvp">
                    <div class="d-flex flex-column my-5">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="border-primary border mb-1 p-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="p-2">Img</div>
                                        <div>
                                            <div>Some achievement</div>
                                            <div>Achievement description</div>
                                        </div>
                                    </div>
                                    <div>Trophy amount</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="tab-pane fade" id="achievements-pve">
                    <div class="d-flex flex-column my-5">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="border-primary border mb-1 p-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="p-2">Img</div>
                                        <div>
                                            <div>Some achievement</div>
                                            <div>Achievement description</div>
                                        </div>
                                    </div>
                                    <div>Trophy amount</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="tab-pane fade" id="achievements-craft">
                    <div class="d-flex flex-column my-5">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="border-primary border mb-1 p-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="p-2">Img</div>
                                        <div>
                                            <div>Some achievement</div>
                                            <div>Achievement description</div>
                                        </div>
                                    </div>
                                    <div>Trophy amount</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="tab-pane fade" id="achievements-collections">
                    <div class="d-flex flex-column my-5">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="border-primary border mb-1 p-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="p-2">Img</div>
                                        <div>
                                            <div>Some achievement</div>
                                            <div>Achievement description</div>
                                        </div>
                                    </div>
                                    <div>Trophy amount</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="tab-pane fade" id="achievements-skills">
                    <div class="d-flex flex-column my-5">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="border-primary border mb-1 p-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="p-2">Img</div>
                                        <div>
                                            <div>Some achievement</div>
                                            <div>Achievement description</div>
                                        </div>
                                    </div>
                                    <div>Trophy amount</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->
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
    <!-- Import the component -->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
@endsection
