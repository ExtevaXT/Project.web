<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'accounts';
    protected $connection = 'sqlite';

    public function getAuthPassword()
    {
        return strtoupper(hash_pbkdf2('sha1', $this->password, 'at_least_16_byte'.$this->name, 10000, 40));
    }
    public function getRememberToken()
    {
        return $this->attributes[$this->getRememberTokenName()];
    }
    protected $fillable = ['name', 'password','email'];
    protected $guarded = ['id'];
    public $timestamps = false;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];
}
