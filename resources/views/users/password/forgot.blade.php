@extends('master')



@section('title', 'I forgor 💀')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    <div class="">
        @if(session()->has('success'))
            <div class="alert alert-success">Password reset link was sent to email</div>
        @endif
        @if ($errors->has('email'))
            <div class="alert alert-danger">
                {{$errors->first()}}
            </div>
        @endif
        <div class="border border-primary px-5 py-4">
            <form method="POST" action="{{route('forgot')}}">
                @csrf
                <div class="my-3">Type your email to send email with password reset link</div>
                <input autocomplete="off" name="email" class="mb-3 p-2 border border-primary form-control" type="text" placeholder="Email" required>
                {!! htmlFormSnippet() !!}
                <input class="my-3 w-100 p-2 btn-outline-primary btn" type="submit" value="Submit">
            </form>
        </div>

    </div>
@endsection
