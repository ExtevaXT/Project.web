<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidation;
use App\Http\Requests\RegisterValidation;
use App\Models\Account;
use App\Models\AccountNotification;
use App\Models\Character;
use App\Models\Character_personal_storage;
use App\Models\Friend;
use App\Models\CharacterAchievement;
use Discord\Http\Http;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DiscordBotMessage;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Config;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TelegramBotHandler;
use NotificationChannels\Discord\Discord;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;
use NotificationChannels\Discord\DiscordServiceProvider;
use NotificationChannels\Telegram\Telegram;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramUpdates;
use Symfony\Component\Console\Helper\Table;
use Monolog\Logger;
use Symfony\Component\Yaml\Yaml;

class UserController extends Controller
{

    public function test()
    {
        return view('test');
    }

    public function profile($name)
    {
        //IMAGES ROUTES FOR ALL
        $item_icons = [];
        foreach ( Storage::disk('public_real')->directories('img/icon') as $category){
            foreach (Storage::disk('public_real')->files($category) as $icon){
                $item_icons[ basename($icon, '.png')] = $icon;
            }
        }
        $account = Account::all()->where('name', $name)->first();
        if($account==null) return back();
        $character = Character::all()->where('account', $name)->first();
        //Items for inventory
        $items = collect();

        $achievements = [];
        $achievement_data = [];
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
            $files = glob(resource_path().'/assets/achievements/*.*', GLOB_BRACE);
            $achievement_data = collect([]);
            foreach($files as $file) {
                $achievement_data->push(Yaml::parse(str_ireplace(config('app.trim'),'', file_get_contents($file)))['MonoBehaviour']);
            }
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


            //FRIEND HELPERS
            'account_friend_start' => $account_friend_start,
            'account_friend_end' => $account_friend_end,
            'your_friend_start' => $your_friend_start,
            'your_friend_end' => $your_friend_end

        ]);
    }
    public function upload(Request $request)
    {
        if($request['image']){
//            $filename = $request['image']->getClientOriginalName();
//            $request->image->storeAs('images',$filename,'public');
//            Auth()->user()->update(['image'=>$filename]);
            $user = Account::find(Auth::user()->id);
            //$request->file('image')->store('img/user' ,['disk' => 'public_real'])
            $user->image = Storage::disk('public_real')->put('img/user', $request->file('image'));

            $user->save();
            return back()->with(['success'=> 'Picture uploaded successfully']);
        }
        return $request;
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
            return redirect('/');
        }
        return 'not success ';
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
        AccountNotification::create($notification);
        Account::create($validation);
        Notification::route('discord', '1021763702741008435')
            ->notify(new DiscordBotMessage('User '.$validation['name'].' has been registered'));
        return back()->with(['success'=> 'Registered successfully']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate();
        return redirect('/');
    }
}
