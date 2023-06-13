<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminPanel\EditStonesController;
use App\Http\Controllers\AdminPanel\EditUsersController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\AdminMiddleware;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/main',[AuthController::class, 'showMeMain'])->name('main');

Route::get('/', function () {
    return view('home');
});


//rejestracja
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//logowanie
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



//uzytkownik
Route::get('/users/{id}', 'App\Http\Controllers\UsersController@show')->name('users.show');
Route::get('/users/{user}/edit', 'App\Http\Controllers\UsersController@edit')->name('user.edit');
Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
Route::put('/users/{user}/update-password', [UsersController::class, 'updatePassword'])->name('user.updatePassword');
Route::get('/users/{user}/edit-password', [UsersController::class, 'editPassword'])->name('user.editPassword');


//admin
Route::get('/editUsersAdmin', [EditUsersController::class, 'index'])->middleware(AdminMiddleware::class)->name('editUsers');
Route::delete('/delete-user/{id}', [EditUsersController::class, 'deleteUser'])->name('deleteUser');

Route::get('/editStonesAdmin', [EditStonesController::class, 'index'])->middleware(AdminMiddleware::class)->name('editStones');
Route::put('/stones/{stone}', [EditStonesController::class, 'update'])->name('stones.update');

Route::post('/editStonesAdmin', [EditStonesController::class, 'store'])->name('stones.store');
Route::delete('/delete-stone/{stoneId}', [EditStonesController::class, 'deleteStone'])->name('deleteStone');


//koszyk
Route::post('/cart/remove', [CartController::class, 'removeProduct'])->name('cart.remove');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart');

Route::get('/cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');



















