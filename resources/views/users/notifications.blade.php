@extends('master')



@section('title', 'Notifications')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
@endsection

@section('content')

    <div class="fs-3">All Notifications</div>
    @foreach(AccountNotification::all()->where('account', Auth::user()->name) as $notification)
        @if($notification->title != 'Delivery')
            <div class="bg-glass p-3 mt-2">
                <div><span class="fw-bold">{{$notification->title}}</span> <span class="fw-light">{{$notification->created_at}}</span></div>
                <div>{{$notification->value}}</div>
            </div>
        @else
            <form action="{{route('claim')}}" method="POST" class="bg-glass p-3 mt-2 d-flex flex-row gap-3">
                <div>
                    <div><span class="fw-bold">{{$notification->title}}</span> <span class="fw-light">{{$notification->created_at}}</span></div>
                    <div>{{$notification->value}}</div>
                </div>
                @if(!$notification->item()->claimed)
                    <button class="btn btn-outline-primary px-5">Claim</button>
                @else
                    <button class="btn btn-outline-primary px-5 disabled">Already claimed</button>
                @endif
            </form>
        @endif
    @endforeach

@endsection
