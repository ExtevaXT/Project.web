<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidation;
use App\Http\Requests\RegisterValidation;
use App\Http\Requests\Settings\EmailValidation;
use App\Http\Requests\Settings\PasswordValidation;
use App\Http\Requests\Settings\SettingsValidation;
use App\Models\Account;
use App\Models\AccountNotification;
use App\Notifications\DiscordBotMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function upload(Request $request)
    {
        $user = Account::auth();
        if($request['image']){
            $user->image = Storage::disk('public_real')->put('img/user', $request->file('image'));
            $user->save();
        }
        else{
            $user->image = 'user.png';
            $user->save();
        }
        return back()->with(['upload'=> true]);
    }

    #region Settings
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
    #endregion

    #region Authentication
    public function login(AuthValidation $authValidation)
    {
        if(Auth::attempt($authValidation->validated())){
            $authValidation->session()->regenerate();
            return back();
        }
        return redirect()->route('login')->withErrors(['message'=>'Login or password are incorrect']);
    }
    public function register(RegisterValidation $registerValidation)
    {
        $validation = $registerValidation->validated();
        $validation['password'] = Hash::make($validation['password']);

        $token = Str::random(60);
        if(DB::table('accounts_verify')->where('email', $validation['email'])!=null)
            DB::table('accounts_verify')->where('email', $validation['email'])->delete();
        DB::table('accounts_verify')->insert([
            'email' => $validation['email'],
            'name' => $validation['name'],
            'password' => $validation['password'],
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        Mail::raw('https://external.su/verify/'.$token, function($message) use ($validation) {
            $message->to($validation['email'])->subject('Account verification');
        });
        return redirect('/login')->with(['verify'=> $validation['email']]);
    }
    public function verify($token, Request $request)
    {
        $data = DB::table('accounts_verify')->where('token', $token)->first();
        // Redirect the user back to the form if the token is invalid
        if (!$data) return redirect()->route('login')->withErrors(['message'=>'Link is not available']);
        // If 10 minutes passed not available
        if(Carbon::parse($data->created_at)->addMinutes(10) < Carbon::now()) return redirect()->route('register')->withErrors(['timeout'=>'Verification link is not available, try again']);
        $user = [
            'email' => $data->email,
            'name' => $data->name,
            'password' => $data->password,
        ];
        $notification = [
            'account' => $data->name,
            'title'=>'Welcome',
            'value'=>'You registered account',
        ];
        //$validation['image'] ='https://www.gravatar.com/avatar/'. md5($validation['name']).'?d=identicon';
        AccountNotification::create($notification);
        Account::create($user);
        Notification::route('discord', '1021763702741008435')
            ->notify(new DiscordBotMessage('User '.$data->name.' has been registered'));

        //Delete the token
        DB::table('accounts_verify')->where('token', $token)->delete();
        Mail::raw('Account has been registered', function($message) use ($data) {
            $message->to($data->email)->subject('Account registration');
        });
        return redirect()->route('login')->with(['success'=>true]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate();
        return redirect('/');
    }
    #endregion

    #region Recovery
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
    #endregion

}
