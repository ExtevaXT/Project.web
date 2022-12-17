<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'accounts';
    protected $connection = 'sqlite';
    // User model
    public static function auth()
    {
        if(Auth::guest()) return null;
        return Account::find(Auth::user()->id);
    }
    public function character()
    {
        if($this->setting('character')!=null){
            return $this->characters()->values()[$this->setting('character')];
        }
        return $this->characters()->first();
    }
    public function characters()
    {
        return Character::all()->where('account', $this->name);
    }
    public function notifications()
    {
        return AccountNotification::all()->where('account', $this->name);
    }

    public function friends($where)
    {
        return Friend::all()->where($where, $this->name);
    }



    protected $casts = ["settings" => "array"];
    public function setting(string $name, $default = null)
    {
        if (array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }
        return $default;
    }
    /**
     * Update one or more settings and then optionally save the model.
     *
     */
    public function settings(array $revisions, bool $save = true) : self
    {
        $this->settings = array_merge($this->settings, $revisions);
        if ($save) {
            $this->save();
        }
        return $this;
    }


    protected $fillable = ['name', 'password', 'email'];
    protected $guarded = ['id'];
    protected $hidden = [
        'password'
    ];
}
