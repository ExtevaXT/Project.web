<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character_personal_storage extends Model
{
    use HasFactory;
    protected $table = 'character_personal_storage';

    public $timestamps = false;
}
