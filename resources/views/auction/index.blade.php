@extends('master')



@section('title', 'Lot create')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Auction/style.css')}}">
@endsection

@section('content')
    <div class="top-filter d-flex">
        <div class="p-3">All lots</div>
        <div class="p-3">My lots</div>
        <div class="p-3">My bids</div>
        <div class="p-3">History</div>
    </div>
    <div class="main d-flex">
        <div class="side-filter">
            <div class="p-1 border border-primary">Search</div>
            <div class="p-3">All</div>
            <div class="p-3">Equipment</div>
            <div class="p-3">Artefacts</div>
            <div class="p-3">Weapons</div>
            <div class="p-3">Attachments</div>
        </div>
        <div>
            <table class=" mx-5 item-row">
                <thead class="">
                    <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Time</th>
                        <th scope="col">Bid price</th>
                        <th scope="col">Buyout price</th>
                    </tr>
                </thead>
                <tbody class="">
                @foreach(\App\Models\Lot::all() as $lot)
                    <tr class="border border-primary">
                        <td>{{$lot->item}}</td>
                        <td>{{$lot->time}}</td>
                        <td>{{$lot->min_price}}</td>
                        <td>{{$lot->max_price}}</td>
                    </tr>
                @endforeach

                </tbody>

            </table>


        </div>
    </div>




@endsection
