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
use mysql_xdevapi\Table;

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
        $character = Character::all()->where('account',  Auth::user()->name)->first();
        $character_personal_storage = Character_personal_storage::all()->where('character', $character['name']);
        return view('auction.create', ['character_personal_storage' => $character_personal_storage]);
    }
    public function createPost(LotValidation $request)
    {
//        $item = explode('.', $request['item']);
        $character = Character::all()->where('account',  Auth::user()->name)->first();
        $cps = Character_personal_storage::all()->where('character', $character->name);
        $item = $cps->where('slot', $request['item'])->first();

        $validate = $request->validated();
        $validate['character']= $character->name;
        $validate['bidder']= $character->name;

        $validate['item'] = $item->name;
        $validate['amount'] = $item->amount;
        $validate['durability'] = $item->durability;
        $validate['ammo'] = $item->ammo;
        $validate['metadata'] = $item->metadata;
        //FACADE FOR UPDATING
        DB::table('characters')->where('name',$character->name)->update(['gold'=>$character->gold-$request['bid']]);
        //RAW SQL FOR DELETING
        $q = 'DELETE FROM character_personal_storage WHERE character = ? AND slot = ?';
        DB::delete($q, [$character->name, $item->slot]);

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
