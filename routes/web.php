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
Route::get('/', function () {
    return view('index', [
        'unity' => GitHub::repo()->commits()->all('ExtevaXT','Project.unity', []),
        'web' => GitHub::repo()->commits()->all('ExtevaXT','Project.web', []),
    ]);
});

Route::get('/guides', function () {
    return view('guides');
});
Route::get('/guides/{category}', [GuideController::class, 'category']);
Route::get('/guides/{category}/{item_name}', [GuideController::class, 'item']);

Route::get('/map', function () {
    return view('map');
});
Route::get('/log', [Controller::class, 'log']);
Route::post('/contact', [Controller::class, 'contact'])->name('contact');
Route::get('/ranking', [Controller::class, 'ranking']);
Route::get('/faction', function () {
    return view('faction');
});
//Route::get('/download', function () {
//    return response()->download('');
//});

//AUCTION
Route::get('/auction', [LotController::class, 'show']);
Route::get('/lot', [LotController::class, 'create'])->name('lot_create');
Route::post('/lot', [LotController::class, 'createPost']);

Route::post('/bid', [LotController::class, 'bid'])->name('bid');
Route::post('/buyout', [LotController::class, 'buyout'])->name('buyout');



//USER
Route::middleware('auth')->group(function() {
    Route::get('/notifications', function () {
        return view('users.notifications');
    });
    Route::get('/settings', function () {
        return view('users.settings');
    })->name('settings');
    Route::post('/settings', [UserController::class, 'settings']);
    Route::post('/upload', [UserController::class, 'upload'])->name('upload');

    Route::post('/friend_add', [FriendController::class, 'friendAdd'])->name('friend_add');
    Route::post('/friend_accept', [FriendController::class, 'friendAccept'])->name('friend_accept');

    Route::post('/password', [UserController::class, 'password'])->name('password');
    Route::post('/email', [UserController::class, 'email'])->name('email');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

});
Route::get('/user/{name}', [UserController::class, 'profile']);
Route::get('/test', [UserController::class, 'test']);

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginPost']);

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'registerPost']);

//RESET PASSWORD
Route::get('/forgot', function () {
    return view('users.password.forgot');
})->middleware('guest')->name('forgot');
Route::post('/forgot', [UserController::class, 'forgot'])->middleware('guest');

Route::get('/reset', function (Request $request) {
    $token = $request['token'];
    return view('users.password.reset', compact('token'));
})->middleware('guest')->name('reset');
Route::post('/reset', [UserController::class, 'reset'])->middleware('guest');
