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
                        <input name="name"
                               class="@error('name') is-invalid @enderror my-1 p-2 border border-primary form-control d-inline-block w-75 border-end-0"
                               type="text"
                               placeholder="Login">
                        <span class="float-end border-primary border my-1 p-2 w-25 text-center">Check</span>
                        @error('name')
                            <div id="invalidName" class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                        <input name="email"
                               class="@error('email') is-invalid @enderror my-1 p-2 border border-primary form-control d-inline-block"
                               type="text"
                               placeholder="E-Mail">
                        @error('email')
                        <div id="invalidEmail" class="invalid-feedback"
                            {{$message}}
                        </div>
                        @enderror
                        <input name="password"
                               class="@error('password') is-invalid @enderror my-1 p-2 border border-primary form-control d-inline-block"
                               type="password"
                               placeholder="Password">
                        @error('password')
                        <div id="invalidPassword" class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <input name="password_confirmation"
                               class="@error('password_confirmation') is-invalid @enderror my-1 p-2 border border-primary form-control d-inline-block"
                               type="password"
                               placeholder="Password confirm">
                        @error('password_confirmation')
                        <div id="invalidPasswordConfirmation" class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
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
