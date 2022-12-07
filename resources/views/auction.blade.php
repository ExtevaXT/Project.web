@extends('master')


@section('title', 'Auction')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
    <link rel="stylesheet" href="{{ asset('css/auction.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <div class="top-filter my-3">
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
                <input value="{{ app('request')->input('search') }}" name="search" class="p-2 mt-3 form-control bg-glass search" placeholder="Search" onchange="this.form.submit()">
            </form>
            <div class="p-3" onclick="window.location.href='/auction'">All</div>
            <div class="p-3" onclick="window.location.href='/auction?filter=equipment'">Equipment</div>
            <div class="p-3" onclick="window.location.href='/auction?filter=artefacts'">Artefacts</div>
            <div class="p-3" onclick="window.location.href='/auction?filter=weapons'">Weapons</div>
            <div class="p-3" onclick="window.location.href='/auction?filter=attachments'">Attachments</div>
        </div>
        <div class="tab-content">
            <x-auction-table id="all" :lots="$lots"/>

            @if(Auth::check() and $character!=null)
                <x-auction-table id="my_lots" :lots="$lots"/>
                <x-auction-table id="my_bids" :lots="$lots"/>
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
                            <td>{{$lot->item()->name}}</td>
                            <td>{{$lot->character}}</td>
                            <td>@if($lot->bidder != $lot->character) {{ $lot->bidder}} @else <span class="text-danger">None</span>  @endif</td>
                            <td>{{$lot->bid}}</td>
                            <td>{{$lot->price}}</td>
                            <td>{{$lot->created_at}}</td>
                            <td>{{$lot->endTime()}}</td>
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
                                        @if(app('request')->input('slot') and  $character_personal_storage->where('slot', app('request')->input('slot'))->first())
                                            <option selected value="{{$character_personal_storage->where('slot', app('request')->input('slot'))->first()->slot }}">
                                                {{$character_personal_storage->where('slot', app('request')->input('slot'))->first()->name }}
                                            </option>
                                        @else
                                            <option disabled selected>Select Item</option>
                                        @endif

                                        @foreach($character_personal_storage->forget(app('request')->input('slot')-1) as $item)
                                            <option value={{$item->slot}}>{{$item->name}}</option>
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
