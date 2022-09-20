<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotValidation;
use App\Models\Character;
use App\Models\Character_personal_storage;
use App\Models\Lot;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LotController extends Controller
{
    public function index()
    {
        return view('auction.index');
    }
    public function create()
    {
        $character = (array)DB::table('characters')->where('account',  Auth::user()->name)->first();
        $character_personal_storage = Character_personal_storage::all()->where('character', $character['name']);
        return view('auction.create', ['character_personal_storage' => $character_personal_storage]);
    }
    public function createPost(LotValidation $request)
    {
        $item = explode('.', $request['item']);
        $validate = $request->validated();
        $validate['character']= Character::all()->where('account',  Auth::user()->name)->first()->name;
        $validate['bidder']= Character::all()->where('account',  Auth::user()->name)->first()->name;

        $validate['item'] = $item[0];
        $validate['amount'] = $item[1];
        $validate['durability'] = $item[2];
        $validate['ammo'] = $item[3];
        $validate['metadata'] = $item[4];
        Lot::create($validate);
        return redirect('/auction');
    }

    public function bid(Request $request)
    {
        $lot = Lot::find($request->id);

        $bidder = Character::all()->where('account', Auth::user()->name)->first();
        $bidder->gold = $request['bid'];
        $bidder->save();
        $previousBidder = Character::all()->where('name', $lot->bidder)->first();
        $previousBidder->gold += $request->bid;
        $previousBidder->save();

        $lot->bid = $request->bid;

        $lot->bidder = $bidder->name;
        $lot->save();
        return $bidder;
    }

    public function lotRecieve(Request $request)
    {

    }
    public function buyout(Request $request)
    {
        $lot = Lot::find($request->id);
        $lot->bid = $lot->price;
        $lot->save();
        return $request;
    }

}
