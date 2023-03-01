<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidation;
use App\Http\Requests\Settings\EmailValidation;
use App\Http\Requests\RegisterValidation;
use App\Http\Requests\Settings\PasswordValidation;
use App\Http\Requests\Settings\SettingsValidation;
use App\Libs\SCDB\Converter;
use App\Models\Account;
use App\Models\AccountNotification;
use App\Models\Character;
use App\Models\Character_personal_storage;
use App\Models\CharacterQuests;
use App\Models\CharacterSkills;
use App\Models\CharacterTalents;
use App\Models\ClaimItem;
use App\Models\Friend;
use App\Models\CharacterAchievement;
use App\Models\Lot;
use App\Models\Resource;
use Discord\Http\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DiscordBotMessage;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PharIo\Manifest\Email;
use Symfony\Component\Yaml\Yaml;

class UserController extends Controller
{
    public function test()
    {
        for ($i = 0; $i<72;$i++) {
            $item = Resource::data('items/artefacts')->random();
            DB::table('character_personal_storage')->insert([
                'character' => Auth::user()->character()->name,
                'slot' => $i,
                'name' => $item['m_Name'],
                'amount' => rand(1, $item['maxStack']),
                'durability' => rand(1, $item['maxDurability']),
                'ammo' => 0,
                'metadata' => '00000',
            ]);
        }
        dd(Auth::user()->character()->cps());
    }

    public function daily()
    {
        $min = 500;
        $max = 25000;
        //1672665331
        //1673122553
        if(Auth::user()->setting('daily') and Carbon::parse(Auth::user()->setting('daily')) > Carbon::now()->subDay()) return back()->with(['error'=>true]);
        Auth::user()->settings(['daily'=>Carbon::now()->timestamp]);
        $character = Auth::user()->character();
        //Maybe make interpolation ((max - min) * level) / Character::max('level') + min
        $reward = min($min * $character->level, $max);
        //Talent 'Daily Planner'
        if($character->talent('Daily Planner')) {
            if(rand(1, 100) < 90){
                (int)$reward *= 1.5;
                AccountNotification::make('Daily Planner', 'Daily reward was multiplied');
            }
            else{
                $reward = 0;
                AccountNotification::make('Daily Planner', 'Daily reward was lost');
            }
        }
        //Talent 'Experienced Student'
        if($character->talent('Experienced Student')) {
            (int)$reward *= 0.9;
            $character->setExp($character->experience + 250);
            AccountNotification::make('Experienced Student', 'Got some experience');
        }
        //Talent 'PhD'
        if($character->talent('PhD')) {
            $reward *= -1;
            if(rand(1, 100) < 5){
                $character->setLevel($character->level++);
                AccountNotification::make('PhD', 'Got 1 level');
            }
        }
        $character->setGold($character->gold + (int)$reward);
        AccountNotification::make('Daily reward', "Claimed $reward ₽");
        return back()->with(['daily'=>true]);
    }
    public function quests()
    {
        //if not null
        if(!Account::auth()->character()) return back();
        $data = Account::auth()->character()->quests();
        $data = $data['data'];
        //some awesome logic for parsing custom data serialization type
        // ok so it is lua code
        // here is some pseudo parsing for it
        $asts = explode('; ' ,$data);
        $quests = array_filter($asts, fn($ast) => str_starts_with($ast, 'Item'));
        $quests_success = array_filter($asts, fn($ast) => str_contains($ast, 'State="success"'));
        $quests_active = array_filter($asts, fn($ast) => str_contains($ast, 'State="active"'));
        $vars = explode(', ',trim($asts[0], 'Variable={}'));
        $vars = array_filter($vars, fn($var) => str_contains($var, 'true'));
        return view('user.quests', compact('quests', 'quests_active', 'quests_success','vars'));
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications();
        return view('user.notifications', compact('notifications'));
    }

    public function profile($name)
    {
        $account = Account::all()->where('name', $name)->first();
        if($account==null) return abort(404);
        $character = $account->character();
        // Talent 'Introvert' feature
        if($character?->talent('Introvert')) return abort(404);
        //Achievements
        $achievement_data = Resource::data('Achievements');;
        //Skills always create with character (additional fields for character)
        //Talents
        $talent_data = Resource::data('talents');
        //Items for inventory
        $items = collect();
        if($character) {
            $character_personal_storage = Character_personal_storage::all()->where('character', $character['name']);
            //Logic from unity
            $items = collect(array_fill(0, 72, [
                'character' => $character->name,
                'slot' => 0,
                'name' => '',
                'amount' => 0,
                'ammo' => 0,
                'durability' => 0,
                'metadata' => '00000'
            ]));
            foreach ($character_personal_storage as $row){
                $items->put($row->slot, $row);
            }
        }


        // Some legacy code
        // if account friended somebody get his name
        $account_friend_start = null;
        if (Friend::all()->firstWhere('account', $account->name)!=null)
            $account_friend_start = Friend::all()->firstWhere('account', $account->name)->friend;
        // if account are friend of somebody get his name
        $account_friend_end = null;
        if (Friend::all()->firstWhere('friend', $account->name)!=null)
            $account_friend_end = Friend::all()->firstWhere('friend', $account->name)->account;
        // if you friended somebody get his name
        $your_friend_start = null;
        if (Auth::check() and Friend::all()->firstWhere('account', Auth::user()->name)!=null)
            $your_friend_start = Friend::all()->firstWhere('account', Auth::user()->name)->friend;
        // if you are friend of somebody get his name
        $your_friend_end = null;
        if (Auth::check() and Friend::all()->firstWhere('friend', Auth::user()->name)!=null)
            $your_friend_end = Friend::all()->firstWhere('friend', Auth::user()->name)->account;




        return view('user.profile', [
            'account' => $account,
            'character' => $character,
            'inventory'=> $items,
            'achievement_data' => $achievement_data,
            'talent_data' => $talent_data,

            //FRIEND HELPERS
            'account_friend_start' => $account_friend_start,
            'account_friend_end' => $account_friend_end,
            'your_friend_start' => $your_friend_start,
            'your_friend_end' => $your_friend_end

        ]);
    }


}
