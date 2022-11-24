@extends('master')


@section('title', 'Auction')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Auction/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <div class="top-filter">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="p-3 nav-link active" data-bs-toggle="tab" href="#all">All lots</a></li>
            @if(Auth::check() and $character!=null)
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#my_lots">My lots</a></li>
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#my_bids">My bids</a></li>
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#history">History</a></li>
            <li class="nav-item create-lot-tab"><button class="create-lot-tab-btn btn btn-outline-primary p-2 mt-2" data-bs-toggle="modal" data-bs-target="#lotModal">Create lot</button></li>
            @endif
        </ul>
    </div>
    <div class="main d-flex">
        <div class="side-filter">
            <form action="/auction">
                <input value="{{ app('request')->input('search') }}" name="search" class="p-2 mt-3 form-control border-primary search" placeholder="Search" onchange="this.form.submit()">
            </form>
            <div class="p-3" onclick="window.location.href='/auction'">All</div>
            <div class="p-3" onclick="window.location.href='/auction?filter=equipment'">Equipment</div>
            <div class="p-3" onclick="window.location.href='/auction?filter=artefacts'">Artefacts</div>
            <div class="p-3" onclick="window.location.href='/auction?filter=weapons'">Weapons</div>
            <div class="p-3" onclick="window.location.href='/auction?filter=attachments'">Attachments</div>
        </div>
        <div class="tab-content">
            <div id="all" class="BlockTable tab-pane fade show active ms-5">
                <div class="BlockTable-head">
                    <div class="BlockTable-row" style="grid-template-columns: repeat(3,1fr);" >
                        <div class="BlockTable-label"><div class="BlockTable-labelInner" style="margin-left: -50px; width: 500px">Item / Time</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Bid price</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Buyout price</div></div>
                    </div>
                </div>
                <div class="BlockTable-body accordion accordion-flush" id="accordionFlush">
                    @foreach($lots as $lot)
                        @if((Carbon::parse($lot->created_at)->addHours($lot->time) > Carbon::now()) and $lot->bid!=$lot->price )
                        <div class="accordion-item @if(!Auth::guest() and $character!=null and $lot->character == $character->name) selected-item @endif">
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
{{--                                        <div class="p-4 border border-primary text-center" >Icon</div>--}}
                                        <x-item size="72" name="{{$lot->item}}"/>
                                        <div class="mx-4 auction-name-count-item">
                                            <h5>{{$lot->item}}</h5>
                                            <p id="{{$lot->id}}" class="data-countdown" data-countdown="{{Carbon::parse($lot->created_at)->addHours($lot->time)->timestamp}}">
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
                            @if(!Auth::guest() and $character!=null)
                            <div id="flush-collapse{{$lot->id}}"
                                 class="accordion-collapse collapse"
                                 aria-labelledby="flush-heading{{$lot->id}}"
                                 data-bs-parent="#accordionFlush">
                                    <div class="accordion-body d-flex justify-content-between"

                                        @if($lot->character == $character->name)
                                            <form class="d-inline" method="post" action="{{ route('buyout') }}">
                                                @csrf
                                                <input name="id" type="hidden" value="{{$lot->id}}">
                                                <button class="btn btn-primary">Remove</button>
                                            </form>
                                        @else
                                            <form class="form-bid" method="post" action="{{ route('bid') }}">
                                                @csrf
                                                <div class="seller">Seller: {{$lot->character}}</div>
                                                <input name="id" type="hidden" value="{{$lot->id}}">
                                                <div class="d-flex form-bid-child">
                                                    <input name="bid" class="form-control input-bid" type="number" value="{{$lot->bid + 1}}">
                                                    <button class="btn btn-primary btn-bid">Bid</button>
                                                </div>

                                            </form>
                                            @if($lot->price!=null)
                                                <form class="form-buyout" method="post" action="{{ route('buyout') }}">
                                                    @csrf
                                                    <input name="id" type="hidden" value="{{$lot->id}}">
                                                    <button class="btn btn-primary d-inline btn-buyout">Buyout</button>
                                                </form>
                                            @endif
                                        @endif

                                    </div>
                            </div>
                                @endif
                        </div>
                        @endif

                    @endforeach
                </div>

            </div>
            @if(Auth::check() and $character!=null)
            <div id="my_lots" class="BlockTable tab-pane fade ms-5">
                <div class="BlockTable-head">
                    <div class="BlockTable-row" style="grid-template-columns: repeat(3,1fr);">
                        <div class="BlockTable-label"><div class="BlockTable-labelInner" style="margin-left: -50px; width: 500px">Item / Time</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Bid price</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Buyout price</div></div>
                    </div>
                </div>
                <div class="BlockTable-body accordion accordion-flush" id="accordionFlush1">
                    @foreach($my_lots as $lot)

                        @if((Carbon::parse($lot->created_at)->addHours($lot->time) > Carbon::now()) and $lot->bid!=$lot->price )
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
                                                <p id="1{{$lot->id}}" class="data-countdown" data-countdown="{{Carbon::parse($lot->created_at)->addHours($lot->time)->timestamp}}">
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
                                        @if($lot->character == $character->name)
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
            <div id="my_bids" class="BlockTable tab-pane fade ms-5">
                <div class="BlockTable-head">
                    <div class="BlockTable-row" style="grid-template-columns: repeat(3,1fr);">
                        <div class="BlockTable-label"><div class="BlockTable-labelInner" style="margin-left: -50px; width: 500px">Item / Time</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Bid price</div></div>
                        <div class="BlockTable-label"><div class="BlockTable-labelInner">Buyout price</div></div>
                    </div>
                </div>
                <div class="BlockTable-body accordion accordion-flush" id="accordionFlush2">
                    @foreach($my_bids as $lot)

                        @if((Carbon::parse($lot->created_at)->addHours($lot->time) > Carbon::now()) and $lot->bid!=$lot->price and $lot->character != $lot->bidder)
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
                                                <p id="1{{$lot->id}}" class="data-countdown" data-countdown="{{Carbon::parse($lot->created_at)->addHours($lot->time)->timestamp}}">
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
            <div id="history" class="tab-pane fade ms-5">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Item</th>
                        <th scope="col">Seller</th>
                        <th scope="col">Bidder</th>
                        <th scope="col">Bid</th>
                        <th scope="col">Price</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Remove time</th>
                        <th scope="col">Result</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Lot::where('character', $character->name)->orWhere('bidder',$character->name)->get() as $lot)
                        <tr>
                            <td>{{$lot->id}}</td>
                            <td>{{$lot->item}}</td>
                            <td>{{$lot->character}}</td>
                            <td>@if($lot->bidder != $lot->character) {{ $lot->bidder}} @else <span class="text-danger">None</span>  @endif</td>
                            <td>{{$lot->bid}}</td>
                            <td>{{$lot->price}}</td>
                            <td>{{$lot->created_at}}</td>
                            <td>{{Carbon::parse($lot->created_at)->addHours($lot->time)}}</td>
                            @if($lot->bidder != $character->name and $lot->price == $lot->bid)
                                <td><i class="mdi mdi-check-all"></i></td>
                            @elseif($lot->bidder != $character->name)
                                <td><i class="mdi mdi-check"></i></td>
                            @else
                                <td><i class="mdi mdi-close"></i></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>



            </div>



            @endif
    </div>







    @if(Auth::check() and $character!=null)
    <!-- LOT CREATE -->
    <div class="modal fade" id="lotModal" tabindex="-1" role="dialog" aria-labelledby="lotModalLabel" aria-hidden="true">
        <div class="container">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title text-center" id="lotModalLabel">Create lot</h5>

                    </div>
                    <div class="modal-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post" action="{{ route('lot_create') }}" class="d-flex flex-column">
                                @csrf
                                <select name="item" class="my-1 p-2 border border-primary form-control">
                                    <option disabled selected>Select Item</option>
                                    @foreach($character_personal_storage as $item)
                                        <option value={{$item->name.'.'.$item->amount.'.'.$item->durability.'.'.$item->ammo.'.'.$item->metadata}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <input name="bid" class="my-1 p-2 border border-primary form-control" type="number" placeholder="Bid price" required>
                                <input name="price" class="my-1 p-2 border border-primary form-control" type="number" placeholder="Buyout price">
                                <select name="time" class="my-1 p-2 border border-primary form-control">
                                    <option disabled selected>Select Time</option>
                                    <option value="12">12:00</option>
                                    <option value="24">24:00</option>
                                    <option value="36">36:00</option>
                                    <option value="48">48:00</option>
                                </select>

                                <input class="my-1 p-2 btn-outline-primary btn" type="submit" value="Create">
                            </form>






                    </div>
                </div>
            </div>
        </div>

    </div>
    @endif





    <script src="https://code.jquery.com/jquery-2.0.0.min.js" integrity="sha256-1IKHGl6UjLSIT6CXLqmKgavKBXtr0/jJlaGMEkh+dhw=" crossorigin="anonymous"></script>
    <script>
        function FuckingCountdown(){
            for (let i = 0; i < document.getElementsByClassName('data-countdown').length; i++) {

                let diff = new Date(1000 * document.getElementsByClassName('data-countdown')[i].getAttribute('data-countdown')) - Date.now();
                let date = new Date(Math.floor(diff));
                if (matchMedia('only screen and (max-width: 1000px)').matches) {
                    document.getElementsByClassName('data-countdown')[i].innerHTML = Math.floor(diff/(3600*1000)) + ':' + date.getMinutes() + ':' + date.getSeconds() + ''
                    // smartphone/iphone... maybe run some small-screen related dom scripting?
                } else
                document.getElementsByClassName('data-countdown')[i].innerHTML = Math.floor(diff/(3600*1000)) + ' hours ' + date.getMinutes() + ' minutes ' + date.getSeconds() + ' seconds remaining'
            }

        }
        setInterval(FuckingCountdown, 1000)
    </script>
@endsection
