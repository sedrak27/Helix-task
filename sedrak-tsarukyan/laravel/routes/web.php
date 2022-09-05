<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::get('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login']);


Route::post('/registration', [AuthController::class, 'userRegistration'])->name('registration');

Route::post('/user_login', [AuthController::class, 'userLogin'])->name('user_login');
Route::get('/user_dashboard', [AuthController::class, 'dashboard'])->middleware('isLogged');
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/verify', [AuthController::class, 'verification']);


