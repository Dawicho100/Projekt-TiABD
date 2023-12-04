<?php

use App\Http\Controllers\DostawaController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PlatnosciController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForegetPasswordManager;
use App\Http\Controllers\ProductsController;


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
Route::get('/', [ProductsController::class, 'index2'])->name('products.index2');

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

Route::get('/pages/{slug}', [FooterContentController::class, 'show'])->name('pages.show');
use App\Http\Controllers\CategoriesController;

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
Route::put('/categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
Route::delete('/categories/delete/{id}', [CategoriesController::class, 'delete']);
use App\Http\Controllers\ParametersController;

Route::get('/parameters', [ParametersController::class, 'index'])->name('parameters.index');
Route::post('/parameters', [ParametersController::class, 'store'])->name('parameters.store');
Route::put('/parameters/update/{id}', [ParametersController::class, 'update'])->name('parameters.update');
Route::delete('/parameters/delete/{id}', [ParametersController::class, 'delete']);

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
Route::put('/products/update/{id}', [ProductsController::class, 'update'])->name('products.update');
Route::delete('/products/delete/{id}', [ProductsController::class, 'destroy'])->name('products.delete');
Route::post('/products/uploadImage', [ProductsController::class, 'uploadImage'])->name('products.uploadImage');
Route::post('/images/upload', [ProductsController::class, 'upload'])->name('images.upload');
use App\Http\Controllers\OrderController;
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::get('/orders/edit/{id}', [OrderController::class, 'editOrder'])->name('edit-order');
Route::put('/orders/update/{id}', [OrderController::class, 'updateOrder']);
Route::delete('/orders/delete/{id}', [OrderController::class, 'deleteOrder']);
 // panel usera
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

Route::get('/orders1', [OrderController::class, 'index1'])->name('orders.index');
use App\Http\Controllers\FavoriteProductsController;
Route::get('/favorite-products', [FavoriteProductsController::class, 'index'])->name('favorite-products.index');
Route::get('/products/{category}', [ProductsController::class, 'index1'])->name('products.index1');

Route::get('/product/{id}', [ProductsController::class, 'show1'])->name('product.show1');

Route::post('/favorite/{product}', [FavoriteProductsController::class, 'toggleFavorite'])->name('favorite.toggle');

use App\Http\Controllers\CartController;

// Trasy dla koszyka
    Route::post('/addToCart/{productId}/{quantity}', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::post('/remove/{productId}', [CartController::class, 'removeFromCart']);
    Route::get('/view', [CartController::class, 'getCart']);
    Route::get('/show', [CartController::class, 'showCart'])->name('cart.show');

use App\Http\Controllers\PaymentController;


Route::get('/user-data-form', [OrderController::class, 'userDataForm'])->name('user-data-form');
Route::post('/process-order', [OrderController::class, 'processOrder'])->name('process-order');
Route::get('/order-summary', [OrderController::class, 'orderSummary'])->name('order-summary');
Route::any('/place-order', [OrderController::class, 'placeOrder'])->name('place-order');
Route::get('/success', [OrderController::class, 'successpage'])->name('success-page');
Route::post('/paymentpage', [PaymentController::class, 'showPaymentForm'])->name('payment-page');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process-payment');
Route::get('/session', [PaymentController::class, 'session'])->name('session');
// Dodaj nową trasę dla akcji success w PaymentController
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
