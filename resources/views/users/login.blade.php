@extends('master')



@section('title', 'Authorization')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Register/style.css')}}">
@endsection

@section('content')

    <form method="post" action="{{ route('login') }}" class="d-flex flex-column">
        @csrf
        <input name="name" class="my-1 p-2 border border-primary form-control" type="text" placeholder="Login" required>
        <input name="password" class="my-1 p-2 border border-primary form-control" type="password" placeholder="Password" required>
        <input class="my-1 p-2 btn-outline-primary btn" type="submit" value="Login">
    </form>
@endsection
