@extends('master')



@section('title', 'Registration')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/register.css')}}">
@endsection

@section('content')

    <div class="">

        <div class="">
            <div class="register-panel bg-glass ">
                <div class="fs-3">Registration</div>
                <div class="text-secondary">Registering, you accept our rules</div>
                <div class="mt-2">
                    <form method="post" action="{{ route('register') }}" class="d-block">
                        @csrf
                        <div class="mb-3">
                            <input name="name"
                                   class="@error('name') is-invalid @enderror p-2 bg-glass form-control d-inline-block w-75 border-end-0"
                                   type="text"
                                   placeholder="Login"
                                   autocomplete="off">
                            <span class="float-end bg-glass p-2 w-25 text-center">Check</span>
                            @error('name')<div id="invalidName" class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                        <x-input name="email" placeholder="E-Mail"/>
                        <x-input name="password" placeholder="Password" type="password"/>
                        <x-input name="password_confirmation" placeholder="Password confirm" type="password"/>
                        {{--Need to remove this shit--}}
                        {!! htmlFormSnippet() !!}
                        <input class="my-2 p-2 btn-outline-primary bg-glass btn w-100" type="submit" value="Register">
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

@endsection
