@inject('Auth','\Illuminate\Support\Facades\Auth')
@inject('Carbon','\Carbon\Carbon')
@extends('master')


@section('title', 'Auction')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Auction/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <div class="top-filter">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="p-3 nav-link active" data-bs-toggle="tab" href="#all">All lots</a></li>
            @if($Auth::check() and Character::where('account', $Auth::user()->name)->first()!=null)
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#my_lots">My lots</a></li>
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#my_bids">My bids</a></li>
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#history">History</a></li>
            @endif
        </ul>
    </div>
    <div class="main d-flex">
        <div class="side-filter">
            <input class="p-1 form-control border-primary" placeholder="Search">
            <div class="p-3">All</div>
            <div class="p-3">Equipment</div>
            <div class="p-3">Artefacts</div>
            <div class="p-3">Weapons</div>
            <div class="p-3">Attachments</div>
        </div>
        <div class="tab-content">
            <div id="all" class="BlockTable tab-pane fade show active">
                <div class="BlockTable-head">
                    <div class="BlockTable-row" style="grid-template-columns: repeat(3,1fr);" >
                        <div class="BlockTable-label"><div class="BlockTable-labelInner" style="margin-left: -50px; width: 500px">Item / Time</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Bid price</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Buyout price</div></div>
                    </div>
                </div>
                <div class="BlockTable-body accordion accordion-flush" id="accordionFlush">
                    @foreach(Lot::all() as $lot)
                        @if(($Carbon::parse($lot->created_at)->addHours($lot->time) > $Carbon::now()) and $lot->bid!=$lot->price )
                        <div class="accordion-item
                        @if(!$Auth::guest() and $lot->character == Character::where('account', $Auth::user()->name)->first()->name)
                            bg-opacity-10
                            bg-primary

                        @endif">
                            <div class="BlockTable-row accordion-header"
                                 id="flush-heading{{$lot->id}}"
                                 data-bs-toggle="collapse"
                                 data-bs-target="#flush-collapse{{$lot->id}}"
                                 aria-expanded="false"
                                 aria-controls="flush-collapse{{$lot->id}}"
                                 style="grid-template-columns: repeat(3,1fr);"
                                 data-item="2501" data-slot="" data-cat="14">
                                <div class="BlockTable-data">
                                    <div class="d-flex justify-content-center">
                                        <div class="p-4 border border-primary text-center" >Icon</div>
                                        <div class="mx-4 auction-name-count-item">
                                            <h5>{{$lot->item}}</h5>
                                            <p id="{{$lot->id}}" class="data-countdown" data-countdown="{{$Carbon::parse($lot->created_at)->addHours($lot->time)->timestamp}}">
    {{--                                            {{gmdate('H:i:s', Carbon\Carbon::parse($lot->created_at)->addHours($lot->time)->diffInSeconds(\Carbon\Carbon::now()))}}--}}
                                                0 hours 0 minutes 0 seconds
                                                remaining</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="BlockTable-data text-center">
                                    <div class="auction-name-count-item panel-price text-center">
                                        <p>{{$lot->bid}} ₽</p>
                                    </div>
                                </div>
                                <div class="BlockTable-data text-center">
                                    <div class="auction-name-count-item panel-price text-center">
                                        <p>{{$lot->price}} ₽</p>
                                    </div>
                                </div>
                            </div>
                            <div id="flush-collapse{{$lot->id}}"
                                 class="accordion-collapse collapse"
                                 aria-labelledby="flush-heading{{$lot->id}}"
                                 data-bs-parent="#accordionFlush">
                                    <div class="accordion-body d-grid" style="grid-template-columns: repeat(3,1fr); grid-column-gap: 20px">
                                        @if(!$Auth::guest() and $lot->character == Character::where('account', $Auth::user()->name)->first()->name)
                                            <form method="post" action="{{ route('buyout') }}">
                                                @csrf
                                                <input name="id" type="hidden" value="{{$lot->id}}">
                                                <button class="btn btn-primary">Remove</button>
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('bid') }}">
                                                @csrf
                                                <div class="w-50 p-2">Seller: {{$lot->character}}</div>
                                                <input name="id" type="hidden" value="{{$lot->id}}">
                                                <input name="bid" class="form-control" type="number" value="{{$lot->bid}}">
                                                <button class="btn btn-primary">Place bid</button>
                                            </form>
                                            @if($lot->price!=null)
                                                <form method="post" action="{{ route('buyout') }}">
                                                    @csrf
                                                    <input name="id" type="hidden" value="{{$lot->id}}">
                                                    <button class="btn btn-primary">Buyout</button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                            </div>
                        </div>
                        @endif

                    @endforeach
                </div>

            </div>
            @if($Auth::check() and Character::where('account', $Auth::user()->name)->first()!=null)
            <div id="my_lots" class="BlockTable tab-pane fade">
                <div class="BlockTable-head">
                    <div class="BlockTable-row" style="grid-template-columns: repeat(3,1fr);">
                        <div class="BlockTable-label"><div class="BlockTable-labelInner" style="margin-left: -50px; width: 500px">Item / Time</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Bid price</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Buyout price</div></div>
                    </div>
                </div>
                <div class="BlockTable-body accordion accordion-flush" id="accordionFlush1">
                    @foreach((Lot::all()->where('character', Character::where('account', $Auth::user()->name)->first()->name)) as $lot)

                        @if(($Carbon::parse($lot->created_at)->addHours($lot->time) > $Carbon::now()) and $lot->bid!=$lot->price )
                            <div class="accordion-item">
                                <div class="BlockTable-row accordion-header"
                                     id="flush-heading1{{$lot->id}}"
                                     data-bs-toggle="collapse"
                                     data-bs-target="#flush-collapse1{{$lot->id}}"
                                     aria-expanded="false"
                                     aria-controls="flush-collapse1{{$lot->id}}"
                                     style="grid-template-columns: repeat(3,1fr);"
                                     data-item="2501" data-slot="" data-cat="14">
                                    <div class="BlockTable-data">
                                        <div class="d-flex justify-content-center">
                                            <div class="p-4 border border-primary text-center" >Icon</div>
                                            <div class="mx-4 auction-name-count-item">
                                                <h5>{{$lot->item}}</h5>
                                                <p id="1{{$lot->id}}" class="data-countdown" data-countdown="{{$Carbon::parse($lot->created_at)->addHours($lot->time)->timestamp}}">
                                                    0 hours 0 minutes 0 seconds
                                                    remaining</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="BlockTable-data text-center">
                                        <div class="auction-name-count-item panel-price text-center">
                                            <p>{{$lot->bid}} ₽</p>
                                        </div>
                                    </div>
                                    <div class="BlockTable-data text-center">
                                        <div class="auction-name-count-item panel-price text-center">
                                            <p>{{$lot->price}} ₽</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="flush-collapse1{{$lot->id}}"
                                     class="accordion-collapse collapse"
                                     aria-labelledby="flush-heading1{{$lot->id}}"
                                     data-bs-parent="#accordionFlush1">
                                    <div class="accordion-body d-grid" style="grid-template-columns: repeat(3,1fr); grid-column-gap: 20px">
                                        @if($lot->character == Character::where('account', $Auth::user()->name)->first()->name)
                                            <form method="post" action="{{ route('buyout') }}">
                                                @csrf
                                                <input name="id" type="hidden" value="{{$lot->id}}">
                                                <button class="btn btn-primary">Remove</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endforeach
                </div>

            </div>
            <div id="my_bids" class="BlockTable tab-pane fade">
                <div class="BlockTable-head">
                    <div class="BlockTable-row" style="grid-template-columns: repeat(3,1fr);">
                        <div class="BlockTable-label"><div class="BlockTable-labelInner" style="margin-left: -50px; width: 500px">Item / Time</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Bid price</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Buyout price</div></div>
                    </div>
                </div>
                <div class="BlockTable-body accordion accordion-flush" id="accordionFlush2">
                    @foreach((Lot::all()->where('bidder', Character::where('account', $Auth::user()->name)->first()->name)) as $lot)

                        @if(($Carbon::parse($lot->created_at)->addHours($lot->time) > $Carbon::now()) and $lot->bid!=$lot->price and $lot->character != $lot->bidder)
                            <div class="accordion-item">
                                <div class="BlockTable-row accordion-header"
                                     id="flush-heading2{{$lot->id}}"
                                     data-bs-toggle="collapse"
                                     data-bs-target="#flush-collapse2{{$lot->id}}"
                                     aria-expanded="false"
                                     aria-controls="flush-collapse2{{$lot->id}}"
                                     style="grid-template-columns: repeat(3,1fr);"
                                     data-item="2501" data-slot="" data-cat="14">
                                    <div class="BlockTable-data">
                                        <div class="d-flex justify-content-center">
                                            <div class="p-4 border border-primary text-center" >Icon</div>
                                            <div class="mx-4 auction-name-count-item">
                                                <h5>{{$lot->item}}</h5>
                                                <p id="1{{$lot->id}}" class="data-countdown" data-countdown="{{$Carbon::parse($lot->created_at)->addHours($lot->time)->timestamp}}">
                                                    0 hours 0 minutes 0 seconds
                                                    remaining</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="BlockTable-data text-center">
                                        <div class="auction-name-count-item panel-price text-center">
                                            <p>{{$lot->bid}} ₽</p>
                                        </div>
                                    </div>
                                    <div class="BlockTable-data text-center">
                                        <div class="auction-name-count-item panel-price text-center">
                                            <p>{{$lot->price}} ₽</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="flush-collapse2{{$lot->id}}"
                                     class="accordion-collapse collapse"
                                     aria-labelledby="flush-heading2{{$lot->id}}"
                                     data-bs-parent="#accordionFlush2">
                                    <div class="accordion-body d-grid" style="grid-template-columns: repeat(3,1fr); grid-column-gap: 20px">
                                        <div>Seller: {{$lot->character}}</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endforeach
                </div>

            </div>



            @endif
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-2.0.0.min.js" integrity="sha256-1IKHGl6UjLSIT6CXLqmKgavKBXtr0/jJlaGMEkh+dhw=" crossorigin="anonymous"></script>
    <script>
        function FuckingCountdown(){
            for (let i = 0; i < document.getElementsByClassName('data-countdown').length; i++) {

                let diff = new Date(1000 * document.getElementsByClassName('data-countdown')[i].getAttribute('data-countdown')) - Date.now();
                let date = new Date(Math.floor(diff));
                document.getElementsByClassName('data-countdown')[i].innerHTML = Math.floor(diff/(3600*1000)) + ' hours ' + date.getMinutes() + ' minutes ' + date.getSeconds() + ' seconds remaining'
            }

        }
        setInterval(FuckingCountdown, 1000)
    </script>
@endsection
