<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\IndexController;
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

Route::get('/signin', [SigninController::class, 'signin']);
Route::post('/login', [SigninController::class, 'login']);
Route::get('/logout', [SigninController::class, 'logout']);

Route::get('/index', [IndexController::class, 'index']);
