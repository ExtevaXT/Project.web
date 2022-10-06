@extends('master')



@section('title', 'Faction')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
@endsection

@section('content')
    @auth()
        <div>Your faction is <span>FACTION</span></div>
    @endauth
        <div>Factions</div>
        <div>Some info about them</div>
    <div class="d-flex main">
        <div class="w-50">
            <div>Faction 1</div>
            <div class="d-flex main">
                <div>
                    <div>Pros</div>
                    <ul>
                        <li>Something</li>
                        <li>Something</li>
                        <li>Something</li>
                    </ul>
                </div>
                <div>
                    <div>Cons</div>
                    <ul>
                        <li>Something</li>
                        <li>Something</li>
                        <li>Something</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="w-50">
            <div>Faction 2</div>
            <div class="d-flex main">
                <div>
                    <div>Pros</div>
                    <ul>
                        <li>Something</li>
                        <li>Something</li>
                        <li>Something</li>
                    </ul>
                </div>
                <div>
                    <div>Cons</div>
                    <ul>
                        <li>Something</li>
                        <li>Something</li>
                        <li>Something</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
