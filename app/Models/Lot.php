<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;
    protected $table = 'lots';
    protected $fillable = ['character', 'item','amount','durability','ammo','metadata','min_price','max_price','time','bidder','bid'];
}
