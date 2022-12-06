@extends('master')



@section('title', 'Lot create')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/register.css')}}">
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
            @if(app('request')->input('slot') and  $character_personal_storage->where('slot', app('request')->input('slot'))->first())
                <option selected value="{{$character_personal_storage->where('slot', app('request')->input('slot'))->first()->slot }}">
                    {{$character_personal_storage->where('slot', app('request')->input('slot'))->first()->name }}
                </option>
            @else
                <option disabled selected>Select Item</option>
            @endif

            @foreach($character_personal_storage->forget(app('request')->input('slot')-1) as $item)
                <option value={{$item->slot}}>{{$item->name}}</option>
            @endforeach
        </select>
        <input name="bid" class="my-1 p-2 border border-primary form-control" type="number" placeholder="Bid price" required>
        <input name="price" class="my-1 p-2 border border-primary form-control" type="number" placeholder="Buyout price">
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
