@extends('master')


@section('title', 'Auction')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
    <link rel="stylesheet" href="{{ asset('css/auction.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    @if(session()->has('remove'))
        <div class="alert bg-glass-success my-3">Lot was removed</div>
    @endif
    @if(session()->has('bid'))
        <div class="alert bg-glass-success my-3">Bid was placed</div>
    @endif
    @if(session()->has('buyout'))
        <div class="alert bg-glass-success my-3">Lot was bought</div>
    @endif
    @if(session()->has('lot'))
        <div class="alert bg-glass-success my-3">Lot was created</div>
    @endif
    @if(session()->has('currency'))
        <div class="alert bg-glass-danger my-3">Not enough currency</div>
    @endif
    @if(session()->has('bid-low'))
        <div class="alert bg-glass-danger my-3">Bid is too low</div>
    @endif
    @if(session()->has('bid-overwrite'))
        <div class="alert bg-glass-danger my-3">Can't overwrite your bid</div>
    @endif
    @if(session()->has('error'))
        <div class="alert bg-glass-danger my-3">Something went wrong</div>
    @endif
    <div class="top-filter my-3">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="p-3 nav-link active" data-bs-toggle="tab" href="#all">All lots</a></li>
            @if(Auth::check() and $character!=null)
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#my_lots">My lots</a></li>
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#my_bids">My bids</a></li>
            <li class="nav-item"><a class="p-3 nav-link" data-bs-toggle="tab" href="#history">History</a></li>
            <li class="nav-item create-lot-tab"><button class="create-lot-tab-btn btn btn-outline-light p-2 mt-2" data-bs-toggle="modal" data-bs-target="#lotModal">Create lot</button></li>
            @endif
        </ul>
    </div>
    <div class="main d-flex">
        <div class="side-filter">
            <form action="/auction" class="w-100">
                <input value="{{ app('request')->input('search') }}" name="search" class="w-100 p-2 mt-3 input-glass search" placeholder="Search" onchange="this.form.submit()">
            </form>
            <button class="p-2 mt-2 w-100 input-glass d-block text-start" onclick="window.location.href='/auction'">All</button>
            <button class="p-2 mt-2 w-100 input-glass d-block text-start" onclick="window.location.href='/auction?filter=equipment'">Equipment</button>
            <button class="p-2 mt-2 w-100 input-glass d-block text-start" onclick="window.location.href='/auction?filter=artefacts'">Artefacts</button>
            <button class="p-2 mt-2 w-100 input-glass d-block text-start" onclick="window.location.href='/auction?filter=weapons'">Weapons</button>
            <button class="p-2 mt-2 w-100 input-glass d-block text-start" onclick="window.location.href='/auction?filter=attachments'">Attachments</button>
        </div>
        <div class="tab-content">
            <x-auction-table id="all" :lots="$lots"/>

            @if(Auth::check() and $character)
                <x-auction-table id="my_lots" :lots="$lots"/>
                <x-auction-table id="my_bids" :lots="$lots"/>
            <div id="history" class="tab-pane fade ms-5">
                <table class="table text-white">
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
                                <form method="post" action="{{ route('lot.create') }}" class="d-flex flex-column">
                                    @csrf
                                    <select name="item" class="my-1 p-2 input-glass w-100 form-select">
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
                                    <input name="bid" class="my-1 p-2 input-glass w-100" type="number" placeholder="Bid price" required>
                                    <input name="price" class="my-1 p-2 input-glass w-100" type="number" placeholder="Buyout price">
                                    <select name="time" class="my-1 p-2 input-glass w-100 form-select">
                                        <option disabled selected>Select Time</option>
                                        <option value="12">12:00</option>
                                        <option value="24">24:00</option>
                                        <option value="36">36:00</option>
                                        <option value="48">48:00</option>
                                        @if(Auth::user()->character()->talent('Longevity'))
                                            <option value="60">60:00</option>
                                            <option value="72">72:00</option>
                                        @endif
                                    </select>

                                    <input class="my-1 p-2 input-glass w-100" type="submit" value="Create">
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
                } else
                document.getElementsByClassName('data-countdown')[i].innerHTML = Math.floor(diff/(3600*1000)) + ' hours ' + date.getMinutes() + ' minutes ' + date.getSeconds() + ' seconds remaining'
            }

        }
        setInterval(FuckingCountdown, 1000)
    </script>
@endsection
