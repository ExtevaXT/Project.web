<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LotController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
Route::get('/guides/search', fn() => view('guides.search'));
Route::get('/guides/info', fn() => abort(404)); //view('guides.info'));

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
    Route::get('/settings', fn() => view('user.settings'))->name('settings');
    Route::post('/settings', [AccountController::class, 'settings']);
    Route::post('/upload', [AccountController::class, 'upload'])->name('upload');
    Route::name('talent.')->prefix('talent')->group(function () {
        Route::post('/unlock', [TalentController::class, 'talentUnlock'])->name('unlock');
        Route::post('/toggle', [TalentController::class, 'talentToggle'])->name('toggle');

        Route::post('/delete', [TalentController::class, 'delete'])->name('delete');
        Route::post('/changeFaction', [TalentController::class, 'changeFaction'])->name('changeFaction');
        Route::post('/transferCharacter', [TalentController::class, 'transferCharacter'])->name('transferCharacter');
        Route::post('/prefix', [TalentController::class, 'prefix'])->name('prefix');
        Route::post('/changeName', [TalentController::class, 'changeName'])->name('changeName');

    });
    Route::name('friend.')->prefix('friend')->group(function () {
        Route::post('/add', [FriendController::class, 'add'])->name('add');
        Route::post('/accept', [FriendController::class, 'accept'])->name('accept');
    });
    Route::post('/password', [AccountController::class, 'password'])->name('password');
    Route::post('/email', [AccountController::class, 'email'])->name('email');
    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    Route::get('/profile', fn() => redirect('/user/'.Auth::user()->name))->name('profile');
});
Route::get('/user/{name}', [UserController::class, 'profile']);
Route::get('/test', [UserController::class, 'test']);

Route::middleware('guest')->group(function() {
    Route::get('/login', fn() => view('user.account.login'))->name('login');
    Route::post('/login', [AccountController::class, 'login']);

    Route::get('/register', fn() => view('user.account.register'))->name('register');
    Route::post('/register', [AccountController::class, 'register']);
    Route::get('/verify/{token}', [AccountController::class, 'verify']);

    Route::get('/forgot', fn() => view('user.password.forgot'))->name('forgot');
    Route::post('/forgot', [AccountController::class, 'forgot']);

    Route::get('/reset', fn(Request $request) => view('user.password.reset', ['token'=>$request['token']]))->name('reset');
    Route::post('/reset', [AccountController::class, 'reset']);
});

