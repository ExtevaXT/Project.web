@extends('master')



@section('title', 'Password reset')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    <div class="my-3">
        @if ($errors->any())
            <div class="alert bg-glass-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bg-glass p-5">
            <form method="POST" action="{{route('reset')}}">
                @csrf
                <h4>Enter new password</h4>
                <input name="password"
                       class="my-1 p-2 input-glass w-100 d-inline-block"
                       type="password"
                       placeholder="Password">
                <input name="password_confirmation"
                       class="my-1 p-2 input-glass w-100 d-inline-block"
                       type="password"
                       placeholder="Password confirm">
                <input name="token" type="hidden" value="{{$token}}">
                <input class="my-2 w-100 p-2 input-glass" type="submit" value="Submit">
            </form>
        </div>

    </div>
@endsection
