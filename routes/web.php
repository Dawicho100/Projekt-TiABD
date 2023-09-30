<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForegetPasswordManager;


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

Route::get('/', function () {
    return view('main');
});
Route::get('/logowanie', function (){
    return view('logowanie');
});
Route::get('/rejestracja', [UserController::class, 'create']);

Route::get('/reset', function (){
    return view('/reset');
});
Route::post('/users', [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/logowanie', [UserController::class, 'login']);
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
Route::get("/reset", [ForegetPasswordManager::class, 'forgotPassword'])->name("forget.password");
Route::post("/reset", [ForegetPasswordManager::class, 'forgotPasswordPost'])->name("forget.password.post");
Route::get("/reset-password/{token}", [ForegetPasswordManager::class, 'resetPassword'])
    ->name("reset.password");
Route::post("/reset-password", [ForegetPasswordManager::class, "resetPasswordPost"])
    ->name("reset.password.post");
