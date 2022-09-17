<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LotController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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
    return view('index');
});

Route::get('/guides', function () {
    return view('guides');
});
Route::get('/guides/{category}', [GuideController::class, 'category']);
Route::get('/guides/{category}/{item_name}', [GuideController::class, 'item']);




Route::get('/map', function () {
    return view('map');
});


Route::get('/auction', [LotController::class, 'index']);



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


Route::get('/user/{name}', [UserController::class, 'profile']);


Route::get('/login',[UserController::class, 'login'])->name('login');
Route::post('/login',[UserController::class, 'loginPost']);

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'registerPost']);

Route::get('/test', function () {
    return DB::select('select * from characters');
});


