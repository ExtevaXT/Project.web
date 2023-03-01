@extends('master')



@section('title', 'Authorization')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/register.css')}}">
@endsection

@section('content')
    @if(session()->has('reset'))
        <div class="alert alert-success">Password has been reset</div>
    @endif
    @if(session()->has('verify'))
        <div class="alert alert-success my-3">Verification link was sent to <a href="https://{{explode('@', session()->get('verify'))[1]}}">your email</a></div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success my-3">Registered successfully</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger my-3">{{$errors->first()}}</div>
    @endif
    <div class="register-panel bg-glass ">
        <div class="fs-3 mb-4">Authorization</div>
        <div class="mt-2">
            <form method="post" action="{{ route('login') }}" class="d-flex flex-column">
                @csrf
                <x-input name="name" placeholder="Login"/>
                <x-input name="password" placeholder="Password" type="password"/>
                <input class="my-1 p-2 input-glass" type="submit" value="Login">
            </form>
        </div>
    </div>
@endsection
