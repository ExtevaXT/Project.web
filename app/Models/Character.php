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
    public static function tables()
    {
        return [
            'characters',
            'character_achievements',
            'character_dialoguesystem',
            'character_equipment',
            'character_hotbar',
            'character_hotbar_selection',
            'character_inventory',
            'character_personal_storage',
            'character_skills',
            'character_talents'
        ];
    }
    // New high end code for convenience
    public function level($level = null)
    {
        $level ??= $this->level;
        return strlen($level)>2 ? (int)substr($level,1) : $level;
    }
    public function prestige($level = null)
    {
        $level ??= $this->level;
        return strlen($level)>2 ? substr($level,0,1) : 0;
    }
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
        return CharacterSkills::all()->firstWhere('character', $this->name);
    }
    public function achievements()
    {
        return CharacterAchievement::all()->where('character', $this->name);
    }
    public function trophies()
    {
        $trophies = $this->achievements()->sum('reward');
        // 'Extrovert' and 'Introvert' talents
        if($this->talent('Extrovert')) $trophies*=1.05;
        if($this->talent('Introvert')) $trophies*=0.9;
        return round($trophies);
    }

    public function setGold($gold)
    {
        DB::table('characters')->where('name',$this->name)->update(['gold'=>$gold]);
    }
    public function setLvl($level)
    {
        DB::table('characters')->where('name',$this->name)->update(['level'=>$level]);
    }
    public function setExp($exp)
    {
        //if($this->experience >= 1000){
        //    DB::table('characters')->where('name',$this->name)->update(['experience'=>$exp]);
        //}
        DB::table('characters')->where('name',$this->name)->update(['experience'=>$exp]);
    }
    public function quests()
    {
        return CharacterQuests::all()->firstWhere('character', $this->name);
    }
    public function talents()
    {
        return CharacterTalents::all()->where('character', $this->name);
    }
    public function talent($name)
    {
        if($talent = $this->talents()->firstWhere('name', $name))
            return $talent->enabled;
        return false;
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
                    // fuck this shit, this shouldn't be personal
                    'personal' => true,
                ]);
                $item->update(['claimed'=>true]);
                return "Added item to {$_item['slot']} slot";
            }
        }
        return 'Not success';
    }

}
