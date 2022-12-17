<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotValidation;
use App\Models\Account;
use App\Models\AccountNotification;
use App\Models\Character;
use App\Models\Character_personal_storage;
use App\Models\ClaimItem;
use App\Models\Lot;
use App\Models\Resource;
use Carbon\Carbon;
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
        $lots = Lot::all()->sort(fn($lot) => Resource::data('items/'.$filter)->firstWhere('m_Name', $lot->item()->name))->reverse();
        // Search
        if($search) $lots = $lots->filter(fn($lot) => false !== stristr($lot->item()->name, $search));
        // other legacy logic
        $character = null;
        $character_personal_storage = null;
        if(Auth::check() and $character = Account::auth()->character())
            $character_personal_storage = $character->cps();
        return view('auction', compact('character', 'character_personal_storage', 'lots'));
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
        $character = Account::auth()->character();
        $cps = $character->cps();
        $item = $cps->where('slot', $request['item'])->first();

        $validate = $request->validated();
        $validate['character']= $character->name;
        $validate['bidder']= $character->name;

        $claim_item = ClaimItem::create([
            'name'=>$item->name,
            'amount'=>$item->amount,
            'durability'=>$item->durability,
            'ammo'=>$item->ammo,
            'metadata'=>$item->metadata,
            'claimed'=>false,
        ]);
        $validate['item'] = $claim_item->id;
        //FACADE FOR UPDATING
        DB::table('characters')->where('name',$character->name)->update(['gold'=>$character->gold-$request['bid']]);
        //RAW SQL FOR DELETING
        $q = 'DELETE FROM character_personal_storage WHERE character = ? AND slot = ?';
        DB::delete($q, [$character->name, $item->slot]);

        $lot = Lot::create($validate);


        AccountNotification::create([
            'account'=>Auth::user()->name,
            'title' => 'Delivery',
            'value' =>'Your lot was expired',
            'item' => $claim_item->id,
            'created_at' => $lot->endTime(),
        ]);
        return redirect('/auction')->with(['lot'=>true]);
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

        //Remove gold from bidder and give gold back to previous bidder
        $bidder->setGold($bidder->gold- $request['bid']);
        $previousBidder->setGold($previousBidder->gold + $request['bid']);
        AccountNotification::make('Balance update', 'Your bid was outbid', $previousBidder->account);

        $lot->bid = $request->bid;
        $lot->bidder = $bidder->name;
        if($lot->save()){
            return back()->with(['bid'=>true]);
        }
        return back()->with(['error'=>true]);
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

    public function lotReceive(Request $request)
    {
        if(Auth::user()->character()->claimItem($request->id)) return redirect()->route('profile');
        return back();
    }

}
