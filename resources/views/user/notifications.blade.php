@extends('master')



@section('title', 'Notifications')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
@endsection

@section('content')
    @if(session()->has('error'))
        <div class="alert bg-glass-danger mt-4">Something went wrong</div>
    @endif
    @if(session()->has('item'))
        <div class="alert bg-glass-success mt-4">Item was added to your storage</div>
    @endif
    @if(session()->has('money'))
        <div class="alert bg-glass-success mt-4">Balance was updated</div>
    @endif
    @if(Auth::user()->character())
    <h3 class="my-3">Deliveries</h3>
    @foreach(Lot::bought()->reverse() as $lot)
    <form action="{{route('lot.claim.item', ['id'=>$lot->id])}}" method="POST" class="bg-glass p-3 mt-2 d-flex flex-row gap-3">
        @csrf
        <div>
            <div>
                <span class="fw-bold">Auction Delivery</span>
                <span class="fw-light">{{$lot->endTime()}}</span>
            </div>
            <div title="{{$lot->id}}">Lot {{$lot->item()->name}} was bought</div>
        </div>
        @if(!$lot->item()->claimed)
            <button class="input-glass px-5 py-2">Claim {{$lot->item()->amount}}x {{$lot->item()->name }}</button>
        @else
            <button class="btn input-glass py-2 px-5 disabled">Already claimed</button>
        @endif
    </form>
    @endforeach
    @foreach(Lot::sold()->reverse() as $lot)
        <form action="{{route('lot.claim.money', ['id'=>$lot->id])}}" method="POST" class="bg-glass p-3 mt-2 d-flex flex-row gap-3">
            @csrf
            <div>
                <div>
                    <span class="fw-bold">Auction Delivery</span>
                    <span class="fw-light">{{$lot->endTime()}}</span>
                </div>
                <div title="{{$lot->id}}">Lot {{$lot->item()->name}} was sold</div>
            </div>
            @if(!$lot->claimed)
                <button class="input-glass px-5 py-2">Claim {{$lot->bid}} ₽</button>
            @else
                <button class="btn input-glass py-2 px-5 disabled">Already claimed</button>
            @endif
        </form>
    @endforeach
    @foreach(Lot::expired()->reverse() as $lot)
        <form action="{{route('lot.claim.item', ['id'=>$lot->id])}}" method="POST" class="bg-glass p-3 mt-2 d-flex flex-row gap-3">
            @csrf
            <div>
                <div>
                    <span class="fw-bold">Auction Delivery</span>
                    <span class="fw-light">{{$lot->endTime()}}</span>
                </div>
                <div title="{{$lot->id}}">Lot {{$lot->item()->name}} was expired</div>
            </div>
            @if(!$lot->item()->claimed)
                <button class="input-glass px-5 py-2">Claim {{$lot->item()->amount}}x {{$lot->item()->name }}</button>
            @else
                <button class="btn input-glass py-2 px-5 disabled">Already claimed</button>
            @endif
        </form>
    @endforeach
    @foreach(Lot::removed()->reverse() as $lot)
        <form action="{{route('lot.claim.item', ['id'=>$lot->id])}}" method="POST" class="bg-glass p-3 mt-2 d-flex flex-row gap-3">
            @csrf
            <div>
                <div>
                    <span class="fw-bold">Auction Delivery</span>
                    <span class="fw-light">{{$lot->endTime()}}</span>
                </div>
                <div title="{{$lot->id}}">Lot {{$lot->item()->name}} was removed</div>
            </div>
            @if(!$lot->item()->claimed)
                <button class="input-glass px-5 py-2">Claim {{$lot->item()->amount}}x {{$lot->item()->name }}</button>
            @else
                <button class="btn input-glass py-2 px-5 disabled">Already claimed</button>
            @endif
        </form>
    @endforeach
    @endif
    <h3 class="my-3">Info notifications</h3>
    @foreach($notifications->reverse() as $notification)
        <div class="bg-glass p-3 mt-2">
            <div><span class="fw-bold">{{$notification->title}}</span> <span class="fw-light">{{$notification->created_at}}</span></div>
            <div>{{$notification->value}}</div>
        </div>
    @endforeach

@endsection
