<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidation;
use App\Http\Requests\Settings\EmailValidation;
use App\Http\Requests\RegisterValidation;
use App\Http\Requests\Settings\PasswordValidation;
use App\Http\Requests\Settings\SettingsValidation;
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
    public function daily()
    {
        $min = 500;
        $max = 25000;
        //1672665331
        if(Auth::user()->setting('daily') and Carbon::parse(Auth::user()->setting('daily')) < Carbon::now()->addDay()) return back()->with(['daily'=>false]);
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
        if($data = Account::auth()->character()->quests())
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
        return view('users.quests', compact('quests', 'quests_active', 'quests_success','vars'));
    }
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

    public function notifications()
    {
        $notifications = Auth::user()->notifications();
        return view('users.notifications', compact('notifications'));
    }

    public function profile($name)
    {
        //IMAGES ROUTES FOR ALL
        $item_icons = Resource::icons();
        $account = Account::all()->where('name', $name)->first();
        if($account==null) return abort(404);
        $character = $account->character();
        // Talent 'Introvert' feature
        if($character?->talent('Introvert')) return abort(404);
        //Achievements
        $achievement_data = Resource::data('achievements');;
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




        return view('users.profile', [
            'account' => $account,
            'character' => $character,
            'inventory'=> $items,
            'achievement_data' => $achievement_data,
            'icons' => $item_icons,
            'talent_data' => $talent_data,

            //FRIEND HELPERS
            'account_friend_start' => $account_friend_start,
            'account_friend_end' => $account_friend_end,
            'your_friend_start' => $your_friend_start,
            'your_friend_end' => $your_friend_end

        ]);
    }
    public function upload(Request $request)
    {
        $user = Account::auth();
        if($request['image']){
//            $filename = $request['image']->getClientOriginalName();
//            $request->image->storeAs('images',$filename,'public');
//            Auth()->user()->update(['image'=>$filename]);
            //$request->file('image')->store('img/user' ,['disk' => 'public_real'])
            $user->image = Storage::disk('public_real')->put('img/user', $request->file('image'));
            $user->save();
        }
        else{
            $user->image = 'user.png';
            $user->save();
        }

        return back()->with(['upload'=> true]);
    }

    //SETTINGS
    public function settings(SettingsValidation $request)
    {
        //return $request->validated();
        Account::auth()->settings($request->validated());
        return back()->with(['success'=>true]);
    }
    public function email(EmailValidation $request)
    {
        $validation = $request->validated();
        if (Hash::check($validation['password'],Auth::user()->password) and $validation['email'] == Auth::user()->email)
        {
            Account::auth()->update(['email' => $validation['emailNew']]);
            return back()->with(['success'=>true]);
        }
        return back()->withErrors(['message'=>'Email or password are incorrect']);
    }
    public function password(PasswordValidation $request)
    {
        $validation = $request->validated();
        if (Hash::check($validation['passwordOld'],Auth::user()->password))
        {
            Account::auth()->update(['password' => Hash::make($validation['password'])]);
            return back()->with(['success'=>true]);
        }
        return back()->withErrors(['message'=>'Password is incorrect']);
    }

    public function login(AuthValidation $authValidation)
    {

//        $user = DB::table('accounts')
//            ->where('password', strtoupper(hash_pbkdf2('sha1', $authValidation['password'], 'at_least_16_byte_with_login'.$authValidation['name'], 10000, 40)))
//            ->where('name',$authValidation['name'])
//            ->first();
        if(Auth::attempt($authValidation->validated())){
            $authValidation->session()->regenerate();
            return back();
        }
        return redirect()->route('login')->withErrors(['message'=>'Login or password are incorrect']);
    }
    public function register(RegisterValidation $registerValidation)
    {
        $validation = $registerValidation->validated();
//        $validation['password'] = strtoupper(hash_pbkdf2('sha1', $validation['password'], 'at_least_16_byte_with_login', 10000, 40));
        $validation['password'] = Hash::make($validation['password']);
        $notification = [
            'account' => $validation['name'],
            'title'=>'Welcome',
            'value'=>'You registered account',
        ];
        $validation['image'] ='https://www.gravatar.com/avatar/'. md5($validation['name']).'?d=identicon';
        AccountNotification::create($notification);
        Account::create($validation);
        Notification::route('discord', '1021763702741008435')
            ->notify(new DiscordBotMessage('User '.$validation['name'].' has been registered'));
        return redirect('/login')->with(['success'=> true]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate();
        return redirect('/');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $token = Str::random(60);
        if(DB::table('password_resets')->where('email', $request['email'])!=null)
            DB::table('password_resets')->where('email', $request['email'])->delete();
        DB::table('password_resets')->insert([
            'email' => $request['email'],
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        Mail::raw('https://external.su/reset?token='.$token, function($message) use ($request) {
            $message->to($request['email'])->subject('Password reset');
        });
        return back()->with(['success' => true]);
    }
    public function reset(Request $request)
    {
        //Validate input
        $request->validate([
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);
        $tokenData = DB::table('password_resets')->where('token', $request['token'])->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return back();
        // If 10 minutes passed not available
        if(Carbon::parse($tokenData->created_at)->addMinutes(10) < Carbon::now()) return redirect()->route('forgot')->withErrors(['timeout'=>'Reset link is not available, try again']);
        $user = Account::all()->where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user) return back()->withErrors(['email' => 'Email not found']);
        //Hash and update the new password
        $user->password = Hash::make($request['password']);
        $user->save();
        //Delete the token
        DB::table('password_resets')->where('token', $request['token'])->delete();
        Mail::raw('Password has been reset', function($message) use ($user) {
            $message->to($user->email)->subject('Password reset');
        });
        return redirect('/login')->with(['reset'=>true]);

    }

}
