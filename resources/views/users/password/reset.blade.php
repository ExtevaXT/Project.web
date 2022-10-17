@extends('master')



@section('title', 'Password reset')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
@endsection

@section('content')
    <div class="px-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="border border-primary p-5">
            <form method="POST" action="{{route('reset')}}">
                @csrf
                <div>Enter new password</div>
                <input name="password"
                       class="my-1 p-2 border border-primary form-control d-inline-block"
                       type="password"
                       placeholder="Password">
                <input name="password_confirmation"
                       class="my-1 p-2 border border-primary form-control d-inline-block"
                       type="password"
                       placeholder="Password confirm">
                <input name="token" type="hidden" value="{{$token}}">
                <input class="my-2 w-100 p-2 btn-outline-primary btn" type="submit" value="Submit">
            </form>
        </div>

    </div>
@endsection
