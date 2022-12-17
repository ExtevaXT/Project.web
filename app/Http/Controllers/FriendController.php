<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function add(Request $request)
    {
        // 'Fair Referral' talent
        if($character = Auth::user()->character() and $character->talent('Fair Referral') and $character->gold > 1000)
            $character->setGold($character->gold - 1000);

        Friend::create([
            'account' => Auth::user()->name,
            'friend' => $request['friend'],
        ]);
        return back();
    }
    public function accept(Request $request)
    {
        // 'Fair Referral' talent
        if($character = Auth::user()->character() and $character->talent('Fair Referral'))
            $character->setGold($character->gold + 1000);

        $friend = Friend::all()->where('account', $request['friend'])->where('friend', Auth::user()->name)->first();
        $friend->accepted = true;
        $friend->save();
        return back();
    }
}
