<?php

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
Route::get('/category', function () {
    return view('category');
});
Route::get('/map', function () {
    return view('map');
});


Route::get('/auction', [LotController::class, 'index']);
Route::get('/lot', [LotController::class, 'create'])->name('lot_create');
Route::post('/lot', [LotController::class, 'createPost']);



Route::get('/user/{name}', function ($name) {
    $account = DB::table('accounts')->where('name', $name)->first();
    if($account==null) return redirect('/');
    $character = (array)DB::table('characters')->where('account', $name)->first();
//    $character_inventory = (array)DB::table('character_inventory')->where('character', '=' , $character['name']);
//    $character_personal_storage = (array)DB::table('character_personal_storage')->where('character', '=' , $character['name']);
    $character_personal_storage = \App\Models\Character_personal_storage::all()->where('character', $character['name']);
    return view('users.profile', [
        'account' => (array)$account,
        'character' => $character,
//        'character_inventory' => $character_inventory,
        'character_personal_storage'=> $character_personal_storage,
        ]);
});


Route::get('/login',[UserController::class, 'login'])->name('login');
Route::post('/login',[UserController::class, 'loginPost']);

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'registerPost']);

Route::get('/test', function () {
    return DB::select('select * from characters');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

