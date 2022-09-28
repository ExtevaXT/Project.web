<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidation;
use App\Http\Requests\RegisterValidation;
use App\Models\Account;
use App\Models\AccountNotification;
use App\Models\Character;
use App\Models\Character_personal_storage;
use App\Models\Friend;
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

class UserController extends Controller
{

    public function test()
    {
        $url = 'https://discordapp.com/api/v9/channels/1023240443145764894/messages';

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => $url,
            CURLOPT_HTTPHEADER     => array('Authorization: Bot '. config('services.discord')['token']),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE        => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return view('chat',['log'=>array_reverse(json_decode($response, true))]);

// or when your server returns json
// $content = json_decode($response->getBody(), true);
    }
    public function profile($name)
    {
        $account = Account::all()->where('name', $name)->first();
        if($account==null) return back();
            $character = Character::all()->where('account', $name)->first();
        $character_personal_storage = [];
        if($character!=null)
            $character_personal_storage = Character_personal_storage::all()->where('character', $character['name']);
        return view('users.profile', [
            'account' => $account,
            'character' => $character,
            'character_personal_storage'=> $character_personal_storage,
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
