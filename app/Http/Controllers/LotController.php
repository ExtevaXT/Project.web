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
        $lots = Lot::all();
        //this shit starts on every item iterations 500+ files on disk
        if($filter) $lots = $lots->sort(fn($lot) => Resource::data('items/'.$filter)->firstWhere('m_Name', $lot->item()->name))->reverse();
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
        $validate['character'] = $character->name;
        $validate['bidder'] = $character->name;
        $tax = 1000;
        if(isset($request['price']))
            $tax = $request['price'] * 0.05;
        //Talents
        if($character->talent('Longevity')) $tax *= 3;
        if($character->talent('Auctioner')) $tax *= 2;
        if($character->talent('Government')) $tax = 0;

        if($character->gold < $request['bid'] + $tax) return back()->with(['currency'=>true]);

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
        $character->setGold($character->gold - (int)$tax);
        $lot = Lot::create($validate);

        AccountNotification::make('Auction', "Created lot ". $lot->item()->name);
        return redirect('/auction')->with(['lot'=>true]);
    }


    public function bid(Request $request)
    {
        $lot = Lot::find($request->id);
        $bidder = Auth::user()->character();
        $previousBidder = Character::all()->where('name', $lot->bidder)->first();

        //validation
        if($bidder->gold < $request['bid']) return 'Not enough currency';
        if($request['bid'] < $lot->bid) return 'Bid is too low';
        if($previousBidder->name == $bidder->name) return "Can't overwrite your bid";

        //Remove gold from bidder and give gold back to previous bidder
        $bidder->setGold($bidder->gold- $request['bid']);
        if($previousBidder->account != $lot->character){
            $previousBidder->setGold($previousBidder->gold + $lot->bid);
            AccountNotification::make('Balance update', 'Your bid was outbid', $previousBidder->account);
        }
        AccountNotification::make('Auction', "Made bid on lot ". $lot->item()->name);
        $lot->bid = $request->bid;
        $lot->bidder = $bidder->name;
        if($lot->save())
            return back()->with(['bid'=>true]);
        return back()->with(['error'=>true]);
    }
    public function buyout(Request $request)
    {
        $lot = Lot::find($request->id);
        $bidder = Auth::user()->character();
        $cps = Character_personal_storage::all()->where('character', $bidder->name);

        if($bidder->name == $lot->character) return 'Cannot buy your lot';
        if($bidder->gold < $lot->price) return 'Not enough currency';

        //give previous bidder money back if he exists
        $previousBidder = Character::all()->where('name', $lot->bidder)->first();
        if($previousBidder->account != $lot->character){
            $previousBidder->setGold($previousBidder->gold + $lot->bid);
            AccountNotification::make('Balance update', 'Your bid was outbid', $previousBidder->account);
        }

        //Remove buyout price from bidder
        $bidder->setGold($bidder->gold - $lot->price);
        //Add bid to lot price to remove display in blade
        $lot->bidder = $bidder->name;
        $lot->bid = $lot->price;
        $lot->save();
//        //Give item instantly
//        $bidder->claimItem($lot->item());
//        AccountNotification::make('Auction Delivery', "Item was added to your storage");
        return back()->with(['buyout'=>true]);
    }

    public function claimItem(Request $request)
    {
        $lot = Lot::find($request->id);
        if(Auth::user()->character()->claimItem($lot->item()))
            return back()->with(['item'=>true]);
        return back()->with(['error'=>true]);
    }
    public function claimMoney(Request $request)
    {
        $lot = Lot::find($request->id);
        $character = Auth::user()->character();
        $bid = $lot->bid;
        if($character->talent('Auctioner')) rand(0,100) > 10 ?: $bid *= 1.5;
        if($character->talent('Government')) $bid *= 0.75;
        $character->setGold($character->gold + $bid);
        $lot->claimed = true;
        $lot->save();
        //claim through notification like item
        return back()->with(['money'=>true]);
    }

}
