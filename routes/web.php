<?php

use App\Http\Controllers\DostawaController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PlatnosciController;
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
Route::get('/dashboard', function (){
    return view('panels/dash');
});
Route::get('/admin/dashboard', function (){
    return view('panels/admindash');
});
Route::get('/klienci', [UserController::class, 'showUsers'])->name('usersindex');
Route::patch('/klienci/{id}/update-description', [UserController::class, 'updateDescription'])->name('updateUserDescription');



Route::get('/dostawy', [DostawaController::class, 'index'])->name('dostawy.index');
Route::post('/dostawy', [DostawaController::class, 'store'])->name('dostawy.store');
Route::put('/dostawy/update/{id}', [DostawaController::class, 'update'])->name('dostawy.update');
Route::delete('/dostawy/delete/{id}', [DostawaController::class, 'delete']);


Route::get('/platnosci', [PlatnosciController::class, 'index'])->name('platnosci.index');
Route::post('/platnosci', [PlatnosciController::class, 'store'])->name('platnosci.store');
Route::put('/platnosci/update/{id}', [PlatnosciController::class, 'update'])->name('platnosci.update');
Route::delete('/platnosci/delete/{id}', [PlatnosciController::class, 'delete']);

Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');
Route::post('/pages', [PagesController::class, 'store'])->name('pages.store');
Route::put('/pages/update/{id}', [PagesController::class, 'update'])->name('pages.update');
Route::delete('/pages/delete/{id}', [PagesController::class, 'delete']);

Route::get('/strona/{slug}', [PagesController::class, 'show'])->name('page.show');
use App\Http\Controllers\FooterContentController;

Route::get('/pages/{slug}', [FooterContentController::class, 'show'])->name('page.show');

