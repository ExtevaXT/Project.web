@extends('master')



@section('title', 'Profile page')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/profile.css')}}">
    @if(($theme = $account->setting('styleTheme')) and ($account->setting('styleThemeShow') == 0 or $account->setting('styleThemeShow') == 2))
        <link rel="stylesheet" href="{{asset('css/themes/'.($theme != null ? $theme : 'default').'.css')}}">
    @endif
    <style>
        {{$account->setting('styleCSS')}}
    </style>
@endsection

@section('content')
    @if(session()->has('error'))
        <div class="alert alert-danger my-3">Something went wrong</div>
    @endif
    @if(session()->has('upload'))
        <div class="alert alert-success my-3">Picture uploaded successfully</div>
    @endif
<div class="">
    <div class="d-flex my-5 top-panel">
        <div class="pe-3">
            <x-user-profile name="{{$account->name}}" size="256" all="0"/>
            @if(Auth::user() !=null and Auth::user()->name == $account->name)
            <div class="d-flex gap-2 ms-2">
                <button class="p-2 input-glass" data-bs-toggle="modal" data-bs-target="#imageModal">
                    Upload picture
                </button>
                <form action="{{route('upload')}}" method="POST">
                    @csrf
                    <button class="py-2 px-4 input-glass" type="submit">Default</button>
                </form>

            </div>
            @endif
        </div>
        <div class="d-flex flex-column py-5 px-2">
            <div style="font-size: 50px; font-weight: bold">{{ $account['name'] }}</div>
            <div class="fs-5"><i class="icons mdi mdi-trophy mdi-18px"></i> {{ $character ? $character->trophies() : 0 }} <span class="fw-bold">@if($character) {{$account->setting('prefix') ?? $character->faction}} @else Character not created @endif</span></div>
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
                        <form method="post" action="{{route('friend.add')}}">
                            @csrf
                            <input type="hidden" name="friend" value="{{$account['name']}}">
                            <button class="input-glass p-2" type="submit">Add to friends</button>
                        </form>
                    </div>
                @endif







            @endauth
        </div>
    </div>





    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#profile">{{ $account['name'] }}</a>
        </li>
        @if($character and ((Auth::check() and Auth::user()->name == $account->name) or $character->talent('Extrovert')))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#inventory">Storage</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#activity">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#talents">Talents</a>
        </li>
        @endif
        @if(Auth::check() and Auth::user()->name == $account->name)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#friends">Friends</a>
        </li>
        @endif
        @if($character)
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
                            <div>Prestige {{$character->prestige()}}</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="fw-light">Remain {{100 - $character->level()}} levels for {{$character->prestige() + 1}} prestige</div>
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
                            <div>{{ $character->level() }} Level <span class="fw-light">{{ $character['experience'] }} exp</span></div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="fw-light">Remain 1000 exp for {{ $character->level()+1 }} level</div>
                        </div>
                        @endif
                        @if(Auth::check() and $character and Auth::user()->name == $account->name)
                            <div class="bg-glass p-2">
                                <div>Balance</div>
                                <div>{{$character['gold']}} ₽</div>
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
                            @isset($character->achievements()[$i])
                            <div class="bg-glass p-3 w-100 me-1 text-center achievement-collection-item">
                                <div class="m-1"><i class="icons mdi mdi-trophy mdi-48px"></i></div>
                                <div style="white-space: nowrap">{{$character->achievements()[$i]['name']}}</div>
                            </div>
                            @else
                            <div class="bg-glass p-3 w-100 me-1 text-center achievement-collection-item-placeholder"></div>
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
                                    <div>{{$character->skills()->health}} </div>
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
                                    <div>{{$character->skills()->endurance}}</div>
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
                                    <div>{{$character->skills()->nutrition}}</div>
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
                                    <div>{{$character->skills()->hydration}}</div>
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
                                    <div>{{$character->skills()->weight}}</div>
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
                                    <div>{{$character->skills()->radiation}}</div>
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
                                    <div>{{$character->skills()->biological}}</div>
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
                                    <div>{{$character->skills()->thermal}}</div>
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
                                    <div>{{$character->skills()->psycho}}</div>
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
                                    <div>{{$character->skills()->bleeding}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endif


                </div>
            </div>




        </div>


        @if($character and ((Auth::check() and Auth::user()->name == $account->name) or $character->talent('Extrovert')))
        <div class="tab-pane fade" id="inventory">
            <div class="fs-3 my-3">Personal Storage</div>
            <div class="d-flex inventory-parent">
{{--                72 SLOTS --}}
                <div class="d-grid w-50 inventory-panel">
                    @foreach($inventory as $item)

                        <div class="inventory-item bg-glass">
                            <div class="w-100 h-100"
                                 @if($item['name']!='')
                                 style="background:'/icon/{{$item['name']}}';background-size: cover;"
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
                        <button onclick="SellItem()" class="item-sell d-block w-100 p-2 my-2 input-glass text-center">Sell</button>
                        <button onclick="" class="item-trade d-block w-100 p-2 my-2 input-glass text-center">Trade</button>
                        <button onclick="" class="item-delete d-block w-100 p-2 my-2 input-glass text-center">Delete</button>
                    </div>

                </div>
            </div>

        </div>
            <div class="tab-pane fade" id="talents">
                <div class="fs-3 mt-3">Talents</div>
                <div class="fs-5">Unlock unique and unbalanced abilities</div>
                <div class="fs-5 mb-3">Prestige {{$character->prestige()}} Level {{$character->level()}}/100</div>
                <div class="d-grid talent-panel">
                    @foreach ($talent_data as $talent)
                        <div class="bg-glass p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div>{{$talent['m_Name']}}
                                    <span class="float-end rarity">
                                        @switch($talent['requirementLevel'])
                                            @case($talent['requirementLevel'] < 100) Common @break
                                            @case($talent['requirementLevel'] > 300) Rare @break
                                            @default Uncommon @break
                                        @endswitch
                                    </span>
                                </div>
                                <div>{{$talent['description']}}</div>
                            </div>
                            @if($character->level < $talent['requirementLevel'] )
                                <button class="btn text-center input-glass m-1 p-1 w-100 disabled">Need {{($prestige = $character->prestige($talent['requirementLevel'])) == 0 ? null : $prestige.' Prestige and'}} {{$character->level($talent['requirementLevel'])}} level</button>
                            @elseif(CharacterTalents::get($character->name, $talent['m_Name']))
                                <form method="POST" action="{{route('talent.toggle', ['name'=>$talent['m_Name']])}}">
                                    @csrf
                                    @if($character->talent($talent['m_Name']))
                                        <button type="submit" class="text-center input-glass bg-glass-danger m-1 p-1 w-100">Disable Talent</button>
                                    @else
                                        <button type="submit" class="text-center input-glass bg-glass-success m-1 p-1 w-100">Enable Talent</button>
                                    @endif
                                </form>
                            @else
                                <form method="POST" action="{{route('talent.unlock', ['name'=>$talent['m_Name']])}}">
                                    @csrf
                                    <button type="submit" class="text-center input-glass m-1 p-1 w-100">Unlock Talent</button>
                                </form>
                            @endif


                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="tab-pane fade" id="friends">
            <div class="fs-3 my-3">Friend list</div>
            <div class="d-grid friend-panel">
                {{-- SHOW YOUR FRIEND REQUESTS AND ACCEPTED --}}
                    @foreach($account->friends('account') as $friend)
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
                    @foreach($account->friends('friend') as $friend)
                    <div class="bg-glass p-3">
                        <div class="d-flex">
                            <x-user-profile name="{{$friend->account}}" size="64" all="0" />
                            <div>
                                <div>
                                    <div>{{$friend->account}}</div>
                                    @if($friend->accepted)
                                        <div class="text-success">Accepted</div>
                                    @else
                                        <div>
                                            <form method="post" action="{{route('friend.accept')}}">
                                                @csrf
                                                <input type="hidden" name="friend" value="{{$friend->account}}">
                                                <button class="input-glass p-2" type="submit">Accept request</button>
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
        @if($character!=null)
        <div class="tab-pane fade" id="achievements">
            <div class="fs-3 my-3">Achievements</div>
            @forelse($character->achievements() as $achievement)
                <div class="bg-glass mb-2 p-3">
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
<div class="modal fade" id="imageModal" tabindex="-3" role="dialog" aria-labelledby="imageLabel" aria-hidden="true">
    <div class="container">
        <div class="modal-dialog upload-modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="imageLabel">Upload profile picture</h5>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('upload') }}" class="d-flex flex-column" enctype="multipart/form-data">
                        @csrf
                        <input name="image" class="my-1 p-2 input-glass" type="file" required>
                        <input class="my-1 p-2 input-glass" type="submit" value="Upload">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>



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
                window.location.href = `{{route('lot.create')}}?slot=${selectedSlot}`;
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
