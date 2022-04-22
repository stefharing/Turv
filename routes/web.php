<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoginController;
use \App\Http\Controllers\RegistrationController;

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
    return view('welcome');
});

Route::get('/register', [RegistrationController::class, 'create']);
Route::post('register', [RegistrationController::class, 'store']);

Route::get('/login', [LoginController::class, 'create']);
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'destroy']);

Route::get('/account', [UserController::class, 'create']);

Route::get('/group/{id}', [GroupController::class, 'openGroup']);

Route::resource('members', MemberController::class);
Route::resource('groups', GroupController::class);

Route::post('/groups/filter', [GroupController::class, 'filter']);
Route::post('/members/filter/{group}', [MemberController::class, 'filter']);

Route::post('/member/increment', [MemberController::class, 'incrementPoints']);
Route::post('/member/decrement', [MemberController::class, 'decrementPoints']);
Route::post('/member/{id}/pay', [MemberController::class, 'pay']);
Route::post('/member/{id}/round', [MemberController::class, 'round']);

//Route::get("addmore",[ItemController::class, 'addMore']);
Route::post("addmoreitems",[ItemController::class, 'addMoreItems'])->name('addmoreItems');

