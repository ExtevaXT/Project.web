<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AccountNotification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = ['account', 'value', 'title', 'created_at'];

    public static function make(string $title, string $value, string $account = null)
    {
        $account ??= Auth::user()->name;
        return AccountNotification::create([
            'account' => $account,
            'title' => $title,
            'value' => $value,
        ]);
    }
    public function lot()
    {
        return Lot::find($this->lot);
    }
}
