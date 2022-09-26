<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotValidation;
use App\Models\Character;
use App\Models\Character_personal_storage;
use App\Models\Lot;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LotController extends Controller
{
    public function show()
    {
        if(Auth::check() and Character::where('account', Auth::user()->name)->first()!=null)
        {
            $character = Character::all()->where('account', Auth::user()->name)->first();
            $character_personal_storage = Character_personal_storage::all()->where('character', $character['name']);
            return view('auction', ['character_personal_storage' => $character_personal_storage]);
        }
        return view('auction');
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
        $previousBidder = Character::all()->where('name', $lot->bidder)->first();

        //not working WITH DB FROM UNITY WITHOUT ID
        $bidder->gold -= $request['bid'];
        $bidder->save();
        $previousBidder->gold += $request->bid;
        $previousBidder->save();

        //working
        $lot->bid = $request->bid;
        $lot->bidder = $bidder->name;
        $lot->save();

        return $request;
    }
    public function buyout(Request $request)
    {
        $lot = Lot::find($request->id);
        $bidder = Character::all()->where('account', Auth::user()->name)->first();
        $bidder->gold -= $lot->price;

        $lot->bid = $lot->price;
        $lot->save();

        //Give item
        $i = 0;
        foreach (Character_personal_storage::all()->where('character', $bidder->name) as $item){
            //add only in free slot
            if($i<=72) return 'Inventory full';
            if($i != $item->slot){
                Character_personal_storage::create([
                    'character' => $bidder,
                    'slot' => $i,
                    'name' => $lot->item,
                    'amount' => $lot->amount,
                    'durability' => $lot->durability,
                    'ammo' => $lot->ammo,
                    'metadata' => $lot->metadata,
                ]);
                break;
            }
            else{
                $i++;
            }

        }

        return $request;
    }

    public function lotRecieve(Request $request)
    {

    }

}
