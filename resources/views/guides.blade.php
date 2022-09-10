@extends('master')



@section('title', 'Guides page')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Guides/style.css')}}">
@endsection

@section('content')
    <div class="d-flex flex-column">
        <div class="my-2">
            <form class="form-inline my-2 d-flex">
                <input class="form-control my-2 border-primary rounded-0" type="search" placeholder="Search">
                <button class="btn btn-outline-primary my-2 rounded-0 border-start-0 px-5" type="submit">Search</button>
            </form>
        </div>
        <div>Categories</div>
        @for($i = 0; $i < 7; $i++)
        <a href="/guides/category" class="border-primary border p-2 px-5 my-1 text-decoration-none">
            <div>Some category</div>
            <div>Category description</div>
        </a>
        @endfor
    </div>
@endsection
