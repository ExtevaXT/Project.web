<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterTalents extends Model
{
    use HasFactory;
    protected $table = 'character_talents';
    protected $fillable = ['character','enabled', 'name'];

    public static function get($character, $name)
    {
        return CharacterTalents::all()?->where('character', $character)?->where('name',$name)?->first();
    }
}
