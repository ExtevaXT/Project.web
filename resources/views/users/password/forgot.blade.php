@extends('master')



@section('title', 'I forgor 💀')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
@endsection

@section('content')
    <div class="px-5">
        @if(session()->has('success'))
            <div class="alert alert-success">Password reset link was sent to email</div>
        @endif
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
            <form method="POST" action="{{route('forgot')}}">
                @csrf
                <div>Type your email to send email with password reset link</div>
                <input name="email" class="my-1 p-2 border border-primary form-control" type="text" placeholder="Email" required>
                <input class="my-2 w-100 p-2 btn-outline-primary btn" type="submit" value="Submit">
            </form>
        </div>

    </div>
@endsection
