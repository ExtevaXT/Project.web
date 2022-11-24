<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotValidation;
use App\Models\Character;
use App\Models\Character_personal_storage;
use App\Models\Lot;
use App\Models\Resource;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;

class LotController extends Controller
{
    public function show(Request $request)
    {
        // Sorting and searching features
        $filter = $request->query('filter');
        $search = $request->query('search');
        //sort by category from resources
        $lots = Lot::all()->sort(function ($lot) use ($filter){
            $item = Resource::data('items/'.$filter)->firstWhere('m_Name', $lot['item']);
            return $item;
        })->reverse();
        // Search
        if($search!=null){
            $lots = $lots->filter(function ($lot) use ($search) {
                // replace stristr with your choice of matching function
                return false !== stristr($lot->item, $search);
            });
        }
        // other legacy logic
        $character = null;
        $character_personal_storage = null;
        $my_lots = null;
        $my_bids = null;

        if(Auth::check() and Character::where('account', Auth::user()->name)->first()!=null)
        {
            $character = Character::all()->where('account', Auth::user()->name)->first();
            $character_personal_storage = Character_personal_storage::all()->where('character', $character['name']);
            $my_lots = Lot::all()->where('character', $character->name);
            $my_bids = Lot::all()->where('bidder', $character->name);
        }
        return view('auction', compact('character',
            'character_personal_storage',
            'my_lots',
            'my_bids',
            'lots'
        ));
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

        //validation
        if($bidder->gold < $request['bid']) return 'Not enough currency';
        if($request['bid'] < $lot->bid) return 'Bid is too low';
        if($previousBidder->name == $bidder->name) return "Can't overwrite your bid";

        //not working WITH DB FROM UNITY WITHOUT ID
//        $bidder->gold -= $request['bid'];
//        $bidder->save();
//        $previousBidder->gold += $request->bid;
//        $previousBidder->save();

        //Remove gold from bidder and give gold back to previous bidder
        DB::table('characters')->where('name',$bidder->name)->update(['gold'=>$bidder->gold - $request['bid']]);
        DB::table('characters')->where('name',$previousBidder->name)->update(['gold'=>$previousBidder->gold + $request['bid']]);




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
        $cps = Character_personal_storage::all()->where('character', $bidder->name);
//        $bidder->gold -= $lot->price;

        //Remove buyout price from bidder
        DB::table('characters')->where('name',$bidder->name)->update(['gold'=>$bidder->gold - $lot->price]);

        //Add bid to lot price to remove display in blade
        $lot->bid = $lot->price;
        $lot->save();

        //Give item
        //IF CPS HAVE SOME ITEMS FIND FREE SLOT
        //NEED TO SOMEHOW FIND FREE SLOT
        $full_cps = collect([]);
        for ($i = 0; $i<72;$i++){
            //IDK HOW TO MAKE THIS FUCKING CLAUSE
            //
            //MAYBE TRY TO ADD ALL SLOTS?
            //
            $full_cps->push([
                'character' => $bidder->name,
                'slot' => $i,
                'name' => '',
                'amount' => 0,
                'durability' => 0,
                'ammo' => 0,
                'metadata' => '00000',
            ]);
        }
        foreach ($cps->values() as $item){
            $full_cps->put($item->slot, $item);
        }
        //THIS GORGEOUS CONSTRUCTION IS SOMEHOW WORKING THANKS VIS2K
        foreach ($full_cps as $item){
            if($item['amount']==0){
                DB::table('character_personal_storage')->insert([
                    'character' => $bidder->name,
                    'slot' => $item['slot'],
                    'name' => $lot->item,
                    'amount' => $lot->amount,
                    'durability' => $lot->durability,
                    'ammo' => $lot->ammo,
                    'metadata' => $lot->metadata,
                ]);
                return "Added item to {$item['slot']} slot";
            }
        }
        return 'Not success';
    }

    public function lotRecieve(Request $request)
    {

    }

}
