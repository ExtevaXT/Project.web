<div id="{{$id}}" class="BlockTable tab-pane fade show @if($id == 'all') active @endif ms-5">
    <div class="BlockTable-head">
        <div class="BlockTable-row" style="grid-template-columns: repeat(3,1fr);" >
            <div class="BlockTable-label"><div class="BlockTable-labelInner" style="margin-left: -50px; width: 500px">Item / Time</div></div>
            <div class="BlockTable-label"><div class="BlockTable-labelInner">Bid price</div></div>
            <div class="BlockTable-label"><div class="BlockTable-labelInner">Buyout price</div></div>
        </div>
    </div>
    <div class="BlockTable-body accordion accordion-flush" id="accordionFlush">
        @foreach($lots as $lot)
            @if(($lot->endTime() > Carbon::now()) and $lot->bid!=$lot->price )
                <div class="accordion-item @if($id == 'all' and Auth::check() and Account::auth()->character() and $lot->character == Account::auth()->character()->name) selected-item
                        @elseif($id == 'all' and Auth::check() and Account::auth()->character() and $lot->bidder == Account::auth()->character()->name) active-item @endif">
                    <div class="BlockTable-row accordion-header"
                         id="flush-heading{{$lot->id}}"
                         data-bs-toggle="collapse"
                         data-bs-target="#flush-collapse{{$lot->id}}"
                         aria-expanded="false"
                         aria-controls="flush-collapse{{$lot->id}}"
                         style="grid-template-columns: repeat(3,1fr);">
                        <div class="BlockTable-data">
                            <div class="d-flex justify-content-center">
                                <x-item size="72" name="{{$lot->item()->name}}"/>
                                <div class="mx-4 auction-name-count-item">
                                    <h5>{{$lot->item()->name}}</h5>
                                    <p id="{{$lot->id}}" class="data-countdown" data-countdown="{{$lot->endTime()->timestamp}}">
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
                    @if(!Auth::guest() and Account::auth()->character())
                        <div id="flush-collapse{{$lot->id}}"
                             class="accordion-collapse collapse"
                             aria-labelledby="flush-heading{{$lot->id}}"
                             data-bs-parent="#accordionFlush">
                            <div class="accordion-body d-flex justify-content-between"

                            @if($lot->character == Account::auth()->character()->name)
                                <form class="d-inline" method="post" action="{{ route('buyout') }}">
                                    @csrf
                                    <input name="id" type="hidden" value="{{$lot->id}}">
                                    <button class="btn btn-primary w-100">Remove</button>
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
