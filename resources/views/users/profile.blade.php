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
            <div style="font-size: 50px; font-weight: bold">{{ $account['name'] }}</div>
            <div class="fs-5"><i class="icons mdi mdi-trophy mdi-18px"></i> {{ $trophies }} <span class="fw-bold">Prefix</span></div>
            <div>@if( $character!=null and $character['online']) <span class="text-success">Online</span> @else <span class="text-danger">Not online</span> @endif </div>
            @auth()
                {{--                TEST CLAUSE                   --}}
                @if(// Account doesnt have you in friends
                    $account_friend_start != $Auth::user()->name and
                    $account_friend_end != $Auth::user()->name and
                    // You doesnt have account in friends
                    $your_friend_start != $account->name and
                    $your_friend_end != $account->name and

                    // You cant add yourself
                    $account->name != $Auth::user()->name



                    )
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
            @if($character!=null)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#inventory">Inventory</a>
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
                    <div>Skills</div>
                    <div class="d-grid skill-panel">
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Vitality</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->health}} </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Endurance</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->endurance}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Metabolism</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->nutrition}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Hydration</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->hydration}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Strength</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->weight}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Radioresistance</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->radiation}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Immunity</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->biological}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Acclimatisation</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->thermal}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
                                <div class="w-100">
                                    <div>Intellect</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>{{$skills->psycho}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="border-primary border p-3">
                            <div class="d-flex">
                                <div class="p-2">Img</div>
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


        @if($Auth::user() !=null and $Auth::user()->name == $account->name)
            @if($character!=null)
        <div class="tab-pane fade" id="inventory">

            <div class="d-flex inventory-parent">
{{--                @for ($i = 0; $i <= 71; $i++)--}}
{{--                    <div>{{$character_personal_storage->get($i)}}</div>--}}
{{--                @endfor--}}


{{--                72 SLOTS --}}
                <div class="d-grid w-50 inventory-panel">
                    @foreach($inventory as $item)

                        <div class="inventory-item border-primary border">
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

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mx-5 inventory-selector">
                    <div class="p-5 border border-primary item-icon" style="background-size: cover; width: 256px; height: 256px"></div>
                    <div class="item-name">Name</div>
                    <div class="item-amount">Amount</div>
                    <div class="item-ammo">Ammo</div>
                    <div class="item-durability">Durability</div>
                    <div class="item-metadata">Metadata</div>

                    <div class="w-100">
                        <div onclick="SellItem()" class="item-sell p-2 my-1 border-primary border text-center">Sell</div>
                        <div onclick="" class="item-trade p-2 my-1 border-primary border text-center">Trade</div>
                        <div onclick="" class="item-delete p-2 my-1 border-primary border text-center">Delete</div>
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
            <div>Talents</div>
            <div>Talents general description</div>
            <div>Level {{$character->level}}/1000</div>
            <div class="d-grid talent-panel">
                @foreach ($talent_data as $talent)
                    <div class="border border-primary p-3">
                        <div>{{$talent['m_Name']}} <span class="float-end">Rarity</span></div>
                        <div>{{$talent['description']}}</div>
                        <div class="text-center border-primary border m-1 p-1">Need {{$talent['requirementLevel']}} level</div>
                    </div>

                @endforeach
            </div>



        </div>
            @endif
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
{{--                                        <div></div>--}}
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
                    </div>
                        @endforeach
            </div>


        </div>
        @endif
        @if($character!=null)
        <div class="tab-pane fade" id="achievements">
            <div>Achievements</div>
            @forelse($achievements as $achievement)
                <div class="border-primary border mb-1 p-3">
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
{{--                            <div onclick="SellItem()" class="item-sell p-2 my-1 border-primary border text-center">Sell</div>--}}
{{--                            <div onclick="" class="item-trade p-2 my-1 border-primary border text-center">Trade</div>--}}
{{--                            <div onclick="" class="item-delete p-2 my-1 border-primary border text-center">Delete</div>--}}
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


                name_out.forEach(x => x.innerHTML ='Name:' + selected.getAttribute('data-item'));
                amount_out.forEach(x => x.innerHTML ='Amount:' + selected.getAttribute('data-amount'));
                ammo_out.forEach(x => x.innerHTML ='Ammo:' + selected.getAttribute('data-ammo'));
                durability_out.forEach(x => x.innerHTML ='Durability:' + selected.getAttribute('data-durability'));
                metadata_out.forEach(x => x.innerHTML ='Meta:' + selected.getAttribute('data-metadata'));
                icon_out.forEach(x => x.style.backgroundImage = selected.style.backgroundImage);

                document.querySelectorAll('[data-slot]').forEach(x => x.classList.remove('selected'));
                selected.classList.add('selected');
            }
            function SellItem(){
                window.location.href = `{{route('lot_create')}}?slot=${selectedSlot}`;
            }
            function TradeItem(){

            }
            function DeleteItem(){

            }







        </script>
    <!-- Import the component -->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
@endsection
