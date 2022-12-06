<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Lot extends Model
{
    use HasFactory;
    protected $table = 'lots';
    protected $fillable = ['character', 'item','price','time','bidder','bid'];

    public function item()
    {
        return ClaimItem::find($this->claim_item);
    }

    public function endTime()
    {
        return Carbon::parse($this->created_at)->addHours($this->time);
    }
}
