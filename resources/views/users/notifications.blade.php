@inject('Auth','\Illuminate\Support\Facades\Auth')
@extends('master')



@section('title', 'Notifications')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Guides/style.css')}}">
@endsection

@section('content')

    <div>All notifications</div>
    @foreach(AccountNotification::all()->where('account', $Auth::user()->name) as $notification)
            <div class="border border-primary p-1 mt-1">
                <div>{{$notification->title}} <span class="fw-light">{{$notification->created_at}}</span></div>
                <div>{{$notification->value}}</div>
            </div>
    @endforeach

@endsection
