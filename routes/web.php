<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LotController;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use NotificationChannels\Telegram\TelegramUpdates;

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

Route::get('/', function () {
    $tg = TelegramUpdates::create()->get();
    $updates = [];
    foreach (array_reverse($tg['result']) as $update){
        if ($tg['ok'] and array_key_exists('channel_post',$update)){
//            str_replace(['#', '&b', 'b&', '&Img'],
//                ['<br>', '<b>', '</b>', '<img src="">'],
//                $update['channel_post']['text']);
            $updates[] = $update;
        }

    }

    return view('index', [
        'unity' => GitHub::repo()->commits()->all('ExtevaXT','Project.unity', []),
        'web' => GitHub::repo()->commits()->all('ExtevaXT','Project.web', []),
        'updates' =>  $updates
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


Route::get('/auction', [LotController::class, 'show']);



Route::get('/lot', [LotController::class, 'create'])->name('lot_create');
Route::post('/lot', [LotController::class, 'createPost']);

Route::post('/bid', [LotController::class, 'bid'])->name('bid');
Route::post('/buyout', [LotController::class, 'buyout'])->name('buyout');
Route::get('/notifications', function () {
    return view('users.notifications');
});
Route::post('/upload', [UserController::class, 'upload'])->name('upload');

Route::post('/friend_add', [FriendController::class, 'friendAdd'])->name('friend_add');
Route::post('/friend_accept', [FriendController::class, 'friendAccept'])->name('friend_accept');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/test', [UserController::class, 'test']);

Route::get('/user/{name}', [UserController::class, 'profile']);


Route::get('/login',[UserController::class, 'login'])->name('login');
Route::post('/login',[UserController::class, 'loginPost']);

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'registerPost']);




