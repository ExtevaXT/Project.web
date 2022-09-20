<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidation;
use App\Http\Requests\RegisterValidation;
use App\Models\Account;
use App\Models\AccountNotification;
use App\Models\Character;
use App\Models\Character_personal_storage;
use App\Models\Friend;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DiscordBotMessage;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Monolog\Handler\TelegramBotHandler;
use NotificationChannels\Discord\Discord;
use NotificationChannels\Discord\DiscordMessage;
use NotificationChannels\Discord\DiscordServiceProvider;
use NotificationChannels\Telegram\Telegram;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramUpdates;
use Symfony\Component\Console\Helper\Table;

class UserController extends Controller
{

    public function test()
    {
        Notification::route('discord', '1006396129153392742')
            ->notify(new DiscordBotMessage('Test 2'));



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
            $user->image = $request->file('image')->store('img/user' ,['disk' => 'public_real']);

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
