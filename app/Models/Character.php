<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Character extends Model
{
    use HasFactory;
    protected $table = 'characters';
    public $timestamps = false;
    protected $fillable = ['gold'];

    public static function online()
    {
        return Character::all()->where('online', true);
    }
    public function cps()
    {
        return Character_personal_storage::all()->where('character', $this->name);
    }
    public function skills()
    {
        return CharacterSkills::all()->where('character', $this->name);
    }
    public function achievements()
    {
        return CharacterAchievement::all()->where('character', $this->name);
    }
    public function quests()
    {
        return CharacterQuests::all()->firstWhere('character', $this->name);
    }
    public function talents()
    {
        return CharacterTalents::all()->where('character', $this->name);
    }


    public function claimItem(ClaimItem $item)
    {
        if ($item->claimed) return 'Already claimed';
        //Give item
        //IF CPS HAVE SOME ITEMS FIND FREE SLOT
        //NEED TO SOMEHOW FIND FREE SLOT
        $full_cps = collect();
        for ($i = 0; $i<72;$i++){
            //IDK HOW TO MAKE THIS FUCKING CLAUSE
            //
            //MAYBE TRY TO ADD ALL SLOTS?
            //
            $full_cps->push([
                'character' => $this->name,
                'slot' => $i,
                'name' => '',
                'amount' => 0,
                'durability' => 0,
                'ammo' => 0,
                'metadata' => '00000',
            ]);
        }
        foreach ($this->cps()->values() as $_item){
            $full_cps->put($_item->slot, $_item);
        }
        //THIS GORGEOUS CONSTRUCTION IS SOMEHOW WORKING THANKS VIS2K
        foreach ($full_cps as $_item){
            if($_item['amount']==0){
                DB::table('character_personal_storage')->insert([
                    'character' => $this->name,
                    'slot' => $_item['slot'],
                    'name' => $item->name,
                    'amount' => $item->amount,
                    'durability' => $item->durability,
                    'ammo' => $item->ammo,
                    'metadata' => $item->metadata,
                ]);
                $item->update(['claimed'=>true]);
                return "Added item to {$_item['slot']} slot";
            }
        }
        return 'Not success';
    }

}
