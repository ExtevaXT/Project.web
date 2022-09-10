@extends('master')



@section('title', 'Registration')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Register/style.css')}}">
@endsection

@section('content')

    <div class="main-content">

        <div class="">
            <div class="my-4 p-5 border-primary border ">
                <div>Registration</div>
                <div>Registering, you accept our rules</div>
                <div>
                    <form method="post" action="{{ route('register') }}" class="d-block">
                        @csrf
                        <input name="name" class="my-1 p-2 border border-primary form-control d-inline-block w-75 border-end-0" type="text" placeholder="Login" required>
                        <span class="float-end border-primary border my-1 p-2 w-25 text-center">Check</span>
                        <input name="email" class="my-1 p-2 border border-primary form-control d-inline-block" type="text" placeholder="E-Mail" required>
                        <input name="password" class="my-1 p-2 border border-primary form-control d-inline-block" type="password" placeholder="Password" required>
                        <input name="password_confirmation" class="my-1 p-2 border border-primary form-control d-inline-block" type="password" placeholder="Password confirm" required>
                        <input class="my-1 p-2 btn-outline-primary btn w-100" type="submit" value="Register">
                    </form>
                </div>
            </div>
        </div>

        <div class="border border-primary p-5">
            Social link
        </div>
        <div class="border border-primary p-5 my-4">
            Social link
        </div>


    </div>

@endsection
