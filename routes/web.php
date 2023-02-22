<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LotController;
use Carbon\Carbon;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use NotificationChannels\Telegram\TelegramUpdates;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//MAIN
Route::get('/', [Controller::class, 'index']);

Route::get('/guides', function () {
    return view('guides');
});
Route::get('/guides/{category}', [GuideController::class, 'category']);
Route::get('/guides/{category}/{item_name}', [GuideController::class, 'item']);
Route::get('/item/{item}', [GuideController::class, 'find']);
Route::get('/icon/{item}', function ($item){
    return redirect(\App\Models\Resource::icon($item));
});

Route::get('/map', function () {
    return view('map');
});
Route::get('/log', [Controller::class, 'log']);
Route::get('/ping', [Controller::class, 'pingDomain']);

Route::post('/contact', [Controller::class, 'contact'])->name('contact');
Route::get('/ranking', [Controller::class, 'ranking']);
Route::get('/faction', [Controller::class, 'faction']);
Route::get('/download', function () {
    return response()->download(resource_path('game.zip'));
})->name('download');
Route::get('/auction', [LotController::class, 'show']);
Route::middleware('auth')->group(function() {
    Route::name('lot.')->prefix('lot')->group(function () {
        Route::get('/create', [LotController::class, 'create'])->name('create');
        Route::post('/create', [LotController::class, 'createPost']);
        Route::post('/bid', [LotController::class, 'bid'])->name('bid');
        Route::post('/buyout', [LotController::class, 'buyout'])->name('buyout');
        Route::name('claim.')->prefix('claim')->group(function () {
            Route::post('/item', [LotController::class, 'claimItem'])->name('item');
            Route::post('/money', [LotController::class, 'claimMoney'])->name('money');
        });
    });
    Route::post('/daily', [UserController::class, 'daily'])->name('daily');
    Route::get('/quests', [UserController::class, 'quests']);
    //Route::get('/ipa/notifications', fn(Request $request) => Auth::user()->notifications()->toJson());
    Route::get('/notifications', [UserController::class, 'notifications']);
    Route::get('/settings', fn() => view('users.settings'))->name('settings');
    Route::post('/settings', [UserController::class, 'settings']);
    Route::post('/upload', [UserController::class, 'upload'])->name('upload');
    Route::name('talent.')->prefix('talent')->group(function () {
        Route::post('/unlock', [UserController::class, 'talentUnlock'])->name('unlock');
        Route::post('/toggle', [UserController::class, 'talentToggle'])->name('toggle');

        Route::post('/delete', [UserController::class, 'delete'])->name('delete');
        Route::post('/changeFaction', [UserController::class, 'changeFaction'])->name('changeFaction');
        Route::post('/transferCharacter', [UserController::class, 'transferCharacter'])->name('transferCharacter');
        Route::post('/prefix', [UserController::class, 'prefix'])->name('prefix');
        Route::post('/changeName', [UserController::class, 'changeName'])->name('changeName');

    });
    Route::name('friend.')->prefix('friend')->group(function () {
        Route::post('/add', [FriendController::class, 'add'])->name('add');
        Route::post('/accept', [FriendController::class, 'accept'])->name('accept');
    });
    Route::post('/password', [UserController::class, 'password'])->name('password');
    Route::post('/email', [UserController::class, 'email'])->name('email');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/profile', fn() => redirect('/user/'.Auth::user()->name))->name('profile');
});
Route::get('/user/{name}', [UserController::class, 'profile']);
Route::get('/test', [UserController::class, 'test']);

Route::middleware('guest')->group(function() {
    Route::get('/login', fn() => view('users.login'))->name('login');
    Route::post('/login', [UserController::class, 'login']);

    Route::get('/register', fn() => view('users.register'))->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/forgot', fn() => view('users.password.forgot'))->name('forgot');
    Route::post('/forgot', [UserController::class, 'forgot']);

    Route::get('/reset', fn(Request $request) => view('users.password.reset', ['token'=>$request['token']]))->name('reset');
    Route::post('/reset', [UserController::class, 'reset']);
});

