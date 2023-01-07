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
        <div class="bg-glass p-5 my-3">
            <h3 class="mb-3">Lot creation</h3>
            <form method="post" action="{{ route('lot.create') }}" class="d-flex flex-column">
                @csrf
                <select name="item" class="my-1 p-2 input-glass w-100 form-select">
                    @if(app('request')->input('slot') and  Auth::user()->character()->cps()->where('slot', app('request')->input('slot'))->first())
                        <option selected value="{{Auth::user()->character()->cps()->where('slot', app('request')->input('slot'))->first()->slot }}">
                            {{Auth::user()->character()->cps()->where('slot', app('request')->input('slot'))->first()->name }}
                        </option>
                    @else
                        <option disabled selected>Select Item</option>
                    @endif

                    @foreach(Auth::user()->character()->cps()->forget(app('request')->input('slot')-1) as $item)
                        <option value={{$item->slot}}>{{$item->name}}</option>
                    @endforeach
                </select>
                <input name="bid" class="my-1 p-2 input-glass w-100" type="number" placeholder="Bid price" required>
                <input name="price" class="my-1 p-2 input-glass w-100" type="number" placeholder="Buyout price">
                <select name="time" class="my-1 p-2 input-glass w-100 form-select">
                    <option disabled selected>Select Time</option>
                    <option value="12">12:00</option>
                    <option value="24">24:00</option>
                    <option value="36">36:00</option>
                    <option value="48">48:00</option>
                    @if(Auth::user()->character()->talent('Longevity'))
                        <option value="60">60:00</option>
                        <option value="72">72:00</option>
                    @endif
                </select>

                <input class="my-1 p-2 input-glass w-100" type="submit" value="Create">
            </form>

    @endauth
@endsection
