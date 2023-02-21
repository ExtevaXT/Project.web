@extends('master')



@section('title', 'Registration')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/register.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Include script -->
    <x-captcha/>
    @livewireStyles
@endsection

@section('content')
    <div class="">

        <div class="">
            <div class="register-panel bg-glass ">
                <div class="fs-3">Registration</div>
                <div class="text-secondary">Registering, you accept our rules</div>
                <div class="mt-2">
                    <form id="form" method="post" action="{{ route('register') }}" class="d-block">
                        @csrf
                        <livewire:login-check/>
                        <x-input name="email" placeholder="E-Mail"/>
                        <x-input name="password" placeholder="Password" type="password"/>
                        <x-input name="password_confirmation" placeholder="Password confirm" type="password"/>
                        <input class="my-2 p-2 input-glass w-100" type="submit" value="Register">
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-glass p-5">
            Social link
        </div>
        <div class="bg-glass p-5 my-4">
            Social link
        </div>


    </div>
    @livewireScripts
@endsection
