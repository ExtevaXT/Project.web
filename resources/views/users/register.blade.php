@extends('master')



@section('title', 'Registration')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Register/style.css')}}">
@endsection

@section('content')

    <div class="">

        <div class="">
            <div class="register-panel border-primary border ">
                <div>Registration</div>
                <div>Registering, you accept our rules</div>
                <div class="mt-2">
                    <form method="post" action="{{ route('register') }}" class="d-block">
                        @csrf
                        <div class="mb-2">
                            <input name="name"
                                   class="@error('name') is-invalid @enderror p-2 border border-primary form-control d-inline-block w-75 border-end-0"
                                   type="text"
                                   placeholder="Login"
                                   autocomplete="off">
                            <span class="float-end border-primary border p-2 w-25 text-center">Check</span>
                            @error('name')
                            <div id="invalidName" class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <input name="email"
                                   class="@error('email') is-invalid @enderror p-2 border border-primary form-control d-inline-block"
                                   type="text"
                                   placeholder="E-Mail"
                                   autocomplete="off">
                            @error('email')
                            <div id="invalidEmail" class="invalid-feedback"
                            {{$message}}
                        </div>
                    @enderror
                        </div>

                        <div class="mb-2">
                            <input name="password"
                                   class="@error('password') is-invalid @enderror p-2 border border-primary form-control d-inline-block"
                                   type="password"
                                   placeholder="Password">
                            @error('password')
                            <div id="invalidPassword" class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <input name="password_confirmation"
                                   class="@error('password_confirmation') is-invalid @enderror p-2 border border-primary form-control d-inline-block"
                                   type="password"
                                   placeholder="Password confirm">
                            @error('password_confirmation')
                            <div id="invalidPasswordConfirmation" class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        {!! htmlFormSnippet() !!}
                        <input class="my-2 p-2 btn-outline-primary btn w-100" type="submit" value="Register">
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
