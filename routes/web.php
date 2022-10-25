<?php

use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\AutheticationController;
use App\Http\Controllers\HomePage;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegisterController;
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

//GROUP DE ROTAS COM MIDDLEWARE PARA USUARIO AUTENTICADO
Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', HomePage::class)->name('home');
    Route::post('/logout', [AutheticationController::class, 'logout'])->name('logout');
    Route::resource('admin/posts', PostsController::class);
});

//Route::get('/home', HomePage::class)->name('home')->middleware('auth'); // Rota com middleare

Route::get('/', function () {
    return view('welcome');
});

//GROUP DE ROTAS COM MIDDLEWARE PARA USUARIOS NAO AUTENTICADO
Route::group(['middleware' => 'guest'], function(){

    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
    
    Route::get('/login', [AutheticationController::class, 'login'])->name('login.form');
    Route::post('/login', [AutheticationController::class, 'logar'])->name('login');

    Route::get('/forget-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forget-password', [PasswordResetController::class, 'email'])->name('password.email');

    Route::get('/reset-password', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');

    

});



