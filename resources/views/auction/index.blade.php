@extends('master')



@section('title', 'Auction')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Auction/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <div class="top-filter d-flex">
        <div class="p-3">All lots</div>
        <div class="p-3">My lots</div>
        <div class="p-3">My bids</div>
        <div class="p-3">History</div>
    </div>
    <div class="main d-flex">
        <div class="side-filter">
            <div class="p-1 border border-primary">Search</div>
            <div class="p-3">All</div>
            <div class="p-3">Equipment</div>
            <div class="p-3">Artefacts</div>
            <div class="p-3">Weapons</div>
            <div class="p-3">Attachments</div>
        </div>
        <div class="BlockTable">
            <div class="BlockTable-head">
                <div class="BlockTable-row">
                    <div class="BlockTable-label"><div class="BlockTable-labelInner" style="margin-left: -50px">Item / Time</div></div>
                    <div class="BlockTable-label"><div class="BlockTable-labelInner">Bid price</div></div>
                    <div class="BlockTable-label"><div class="BlockTable-labelInner">Buyout price</div></div>
                </div>
            </div>
            <div class="BlockTable-body accordion accordion-flush" id="accordionFlush">
                @foreach(\App\Models\Lot::all() as $lot)
                    @if(\Carbon\Carbon::parse($lot->created_at)->addHours($lot->time) > \Carbon\Carbon::now())
                    <div class="accordion-item">
                        <div class="BlockTable-row accordion-header" id="flush-heading{{$lot->id}}"
                             data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$lot->id}}" aria-expanded="false" aria-controls="flush-collapse{{$lot->id}}"
                             data-item="2501" data-slot="" data-cat="14">
                            <div class="BlockTable-data">
                                <div class="d-flex justify-content-center">
                                    <div class="p-4 border border-primary text-center" >Icon</div>
                                    <div class="mx-4 auction-name-count-item">
                                        <h5>{{$lot->item}}</h5>
                                        <p id="{{$lot->id}}" class="data-countdown" data-countdown="{{Carbon\Carbon::parse($lot->created_at)->addHours($lot->time)->timestamp}}">
{{--                                            {{gmdate('H:i:s', Carbon\Carbon::parse($lot->created_at)->addHours($lot->time)->diffInSeconds(\Carbon\Carbon::now()))}}--}}
                                            0 hours 0 minutes 0 seconds
                                            remaining</p>
                                    </div>
                                </div>
                            </div>
                            <div class="BlockTable-data text-center">
                                <div class="auction-name-count-item panel-price text-center">
                                    <p>{{$lot->min_price}} ₽</p>
                                </div>
                            </div>
                            <div class="BlockTable-data text-center">
                                <div class="auction-name-count-item panel-price text-center">
                                    <p>{{$lot->max_price}} ₽</p>
                                </div>
                            </div>
                        </div>
                        <div id="flush-collapse{{$lot->id}}" class="accordion-collapse collapse"
                             aria-labelledby="flush-heading{{$lot->id}}" data-bs-parent="#accordionFlush">
                            <div class="accordion-body d-grid" style="grid-template-columns: repeat(3,1fr); grid-column-gap: 20px">
                                <div class="d-flex">
                                    <div class="w-50 p-2">Seller: {{$lot->character}}</div>
                                    <input class="form-control" type="number" value="{{$lot->min_price}}">
                                </div>
                                <button class="btn btn-primary">Place bid</button>
                                <button class="btn btn-primary">Buyout</button>
                            </div>
                        </div>
                    </div>
                    @endif

                @endforeach
            </div>


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
