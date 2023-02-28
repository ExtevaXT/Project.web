<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Character;
use App\Models\CharacterTalents;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TalentController extends Controller
{
    public function talentUnlock(Request $request)
    {
        if(!(Auth::user()?->character()?->level < Resource::data('talents')?->firstWhere('m_Name', $request->name))) return back();
        CharacterTalents::create([
            'character' => Auth::user()->character()->name,
            'name' => $request->name,
            'enabled' => false,
        ]);
        return back()->with(['talentUnlock'=>true]);
    }
    public function talentToggle(Request $request)
    {
        $talent = CharacterTalents::get(Auth::user()->character()->name, $request->name);

        DB::table('character_talents')->where('character',$talent->character)->where('name',$talent->name)->update(['enabled'=>!$talent->enabled]);
        return back()->with(['talentToggle'=>true]);
    }
    public function delete()
    {
        //Talent 'Eraser'
        $characters = Auth::user()->characters();
        //cascade for weaklings
        foreach ($characters as $character)
            foreach (Character::tables() as $table)
                DB::delete("DELETE FROM $table WHERE character = ".$character->name);
        DB::delete('DELETE FROM notifications WHERE account = '.Auth::user()->name);
        DB::delete('DELETE FROM characters WHERE account = '.Auth::user()->name);
        Auth::user()->delete();
    }
    public function changeFaction()
    {
        //Talent 'Renegate'
        $character = Auth::user()->character();
        DB::table('characters')->where('name',$character->name)
            ->update(['faction'=> $character->faction == 'Stalker' ? 'Bandit' : 'Stalker']);
    }
    public function transferCharacter(Request $request)
    {
        //Talent 'Soul Trader'
        DB::table('characters')->where('name',Auth::user()->character()->name)
            ->update(['account'=>$request->validate(['account'=>'required'])['account']]);
    }
    public function prefix(Request $request)
    {
        //Talent 'Megalomania'
        Account::auth()->settings($request->validate(['prefix'=>'required']));
        return back()->with(['success'=>true]);
    }
    public function changeName(Request $request)
    {
        //Talent 'Many Faces'
        $name = $request->validate(['name'=>'required'])['name'];
        $character = Auth::user()->character();
        foreach (Character::tables() as $table)
            DB::table($table)->where('name',$character->name)->update(['character'=>$name]);
        DB::table('characters')->where('name',$character->name)->update(['name'=>$name]);
    }
}
