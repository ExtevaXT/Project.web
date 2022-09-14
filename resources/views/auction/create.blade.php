@extends('master')



@section('title', 'Lot create')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Register/style.css')}}">
@endsection

@section('content')
    @guest()
        <div class="my-1 p-2">Must be authorized</div>
    @endguest
    @auth()
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <form method="post" action="{{ route('lot_create') }}" class="d-flex flex-column">
        @csrf
        <select name="item" class="my-1 p-2 border border-primary form-control">
            <option disabled selected>Select Item</option>
            @foreach($character_personal_storage as $item)
                <option value={{$item->name.'.'.$item->amount.'.'.$item->durability.'.'.$item->ammo.'.'.$item->metadata}}>{{$item->name}}</option>
            @endforeach
        </select>
        <input name="min_price" class="my-1 p-2 border border-primary form-control" type="number" placeholder="Bid price" required>
        <input name="max_price" class="my-1 p-2 border border-primary form-control" type="number" placeholder="Buyout price">
        <select name="time" class="my-1 p-2 border border-primary form-control">
            <option disabled selected>Select Time</option>
            <option value="12">12:00</option>
            <option value="24">24:00</option>
            <option value="36">36:00</option>
            <option value="48">48:00</option>
        </select>

        <input class="my-1 p-2 btn-outline-primary btn" type="submit" value="Create">
    </form>
    @endauth
@endsection
