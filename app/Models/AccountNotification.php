<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountNotification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = ['account', 'value', 'title', 'item', 'created_at'];
    public function item()
    {
        return ClaimItem::find($this->claim_item);
    }
}
