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
use App\Models\Resource;
use Discord\Http\Http;
use Github\Api\User;
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
    public function quests()
    {
        //if not null
        if($quests = CharacterQuests::all()->firstWhere('character', Character::all()->firstWhere('account', Auth::user()->name)))
            $quests = $quests['data'];
        //some awesome logic for parsing custom data serialization type

        return view('users.quests', compact('quests'));
    }

    public function changeCharacter(Request $request)
    {
        $character = Account::auth()->characters()->where('name', $request->validate(['name'=>'required'])['name']);
        $characters = Account::auth()->characters()->whereNotIn('name', $character->name);
        //Need to swap db
    }



    public static function AuthSetting($setting)
    {
        return Account::find(Auth::user()->id)->setting($setting);
    }
    public function test()
    {

        dd(Resource::attachments('12345'));
    }

    public function profile($name)
    {
        //IMAGES ROUTES FOR ALL
        $item_icons = Resource::icons();
        $account = Account::all()->where('name', $name)->first();
        if($account==null) return abort(404);
        $character = $account->character();
        //Items for inventory
        $items = collect();

        $achievements = null;
        $achievement_data = null;
        $trophies = 0;
        $skills = null;
        $talents = null;
        $talent_data = null;
        if($character!=null) {
            $character_personal_storage = Character_personal_storage::all()->where('character', $character['name']);
            //Logic from unity
            for($i = 0; $i<72; $i++){
                $items->push([
                    'character'=> $character->name,
                    'slot'=> $i,
                    'name' => '',
                    'amount' => 0,
                    'ammo' => 0,
                    'durability' => 0,
                    'metadata' =>'00000',
                ]);
            }
            foreach ($character_personal_storage as $row){
                $items->put($row->slot, $row);
            }
            //Achievements
            $achievements = CharacterAchievement::all()->where('character', $character->name);
            $achievement_data = Resource::data('achievements');;
            foreach ($achievements as $achievement){
                $trophies += $achievement->reward;
            }
            //Skills always create with character (additional fields for character)
            $skills = CharacterSkills::all()->firstWhere('character', $character->name);

            //Talents
            $talents = CharacterTalents::all()->where('character', $character->name);
            $talent_data = Resource::data('talents');

        }





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
            'achievements' => $achievements,
            'achievement_data' => $achievement_data,
            'icons' => $item_icons,
            'trophies' => $trophies,
            'skills' => $skills,
            'talents' => $talents,
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

        return back()->with(['success'=> 'Picture saved successfully']);
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


    public function login()
    {
        return view('users.login');
    }
    public function loginPost(AuthValidation $authValidation)
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

    public function register()
    {
        return view('users.register');
    }
    public function registerPost(RegisterValidation $registerValidation)
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
