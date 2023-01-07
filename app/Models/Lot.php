<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Lot extends Model
{
    protected $table = 'lots';
    protected $fillable = ['character', 'item','price','time','bidder','bid', 'claimed'];

    public function item()
    {
        return ClaimItem::find($this->item);
    }

    public function endTime()
    {
        return Carbon::parse($this->created_at)->addHours($this->time);
    }

    public static function sold()
    {
        $character = Auth::user()->character()->name;
        return Lot::all()
            ->filter(fn($lot) => $lot->character == $character
                and $lot->bidder != $character
                and ($lot->endTime() < Carbon::now() or $lot->bid == $lot->price));
    }
    public static function expired()
    {
        $character = Auth::user()->character()->name;
        return Lot::all()
            ->filter(fn($lot) => $lot->character == $character
                and $lot->bidder == $character
                and $lot->endTime() < Carbon::now());
    }
    public static function bought()
    {
        $character = Auth::user()->character()->name;
        return Lot::all()
            ->filter(fn($lot) => $lot->character != $character
                and $lot->bidder == $character
                and ($lot->endTime() < Carbon::now() or $lot->bid == $lot->price));
    }

    public static function unclaimed()
    {
        //should check double for seller claiming and bidder claiming
        $lots = Lot::bought()->concat(Lot::expired())->concat(Lot::sold());
        $lots->filter(fn($lot)=> !$lot->claimed and !$lot->item()->claimed);
        return $lots->isEmpty();
    }
}
