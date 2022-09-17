<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function friendAdd(Request $request)
    {
        Friend::create([
            'account' => Auth::user()->name,
            'friend' => $request['friend'],
        ]);
        return back();
    }
    public function friendAccept(Request $request)
    {
        $friend = Friend::all()->where('account', $request['friend'])->where('friend', Auth::user()->name)->first();
        $friend->accepted = true;
        $friend->save();
        return back();
    }
}
