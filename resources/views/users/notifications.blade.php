@extends('master')



@section('title', 'Notifications')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
@endsection

@section('content')

    <div class="fs-3">All Notifications</div>
    @foreach(AccountNotification::all()->where('account', Auth::user()->name) as $notification)
        @if($notification->title != 'Delivery')
            <div class="border border-primary p-3 mt-1">
                <div>{{$notification->title}} <span class="fw-light">{{$notification->created_at}}</span></div>
                <div>{{$notification->value}}</div>
            </div>
        @else
            <form action="{{route('claim')}}" method="POST" class="border border-primary p-3 mt-1 d-flex flex-row gap-3">
                <div>
                    <div>{{$notification->title}} <span class="fw-light">{{$notification->created_at}}</span></div>
                    <div>{{$notification->value}}</div>
                </div>
                <button class="btn btn-outline-primary px-5">Claim</button>
            </form>
        @endif
    @endforeach

@endsection
