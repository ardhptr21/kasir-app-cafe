<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**----------------------------------------------
 * Auth Routes
 * Base Route: /auth
 * Description: Routes for handle authentication
 *
 *---------------------------------------------**/
Route::controller(AuthController::class)->prefix('/auth')->middleware('guest')->group(function () {
    Route::get('/login', 'login')->name('auth.login');
    Route::post('/login', 'logged')->name('auth.logged');
    Route::get('/logout', 'logout')->name('auth.logout')->withoutMiddleware('guest')->middleware('auth');
});

/**----------------------------------------------
 * Page Routes
 * Base Route: /
 * Description: Routes for the all pages
 *
 *---------------------------------------------**/
Route::controller(PagesController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/user', 'user')->name('user');
});

/**----------------------------------------------
 * product Routes
 * Base Route: /products
 * Description: Routes for the product
 *
 *---------------------------------------------**/
Route::resource('/products', ProductController::class)->middleware(['auth', 'can:admin'])->except(['show', 'create']);

/**----------------------------------------------
 * Shop Routes
 * Base Route: /shop
 * Description: Routes for shop
 *
 *---------------------------------------------**/
Route::controller(ShopController::class)->middleware(['auth', 'can:owner'])->prefix('/shop')->group(function () {
    Route::get('/', 'index')->name('shop.index');
    Route::put('/store', 'update')->name('shop.update');
});

/**----------------------------------------------
 * Category Routes
 * Base Route: /category
 * Description: Routes for category
 *
 *---------------------------------------------**/
Route::resource('/categories', CategoryController::class)->middleware(['auth', 'can:admin'])->only(['index', 'store', 'destroy']);

/**----------------------------------------------
 * User Routes
 * Base Route: /users
 * Description: Routes for users
 *
 *---------------------------------------------**/
Route::resource('/users', UserController::class)->middleware('auth')->except(['create', 'edit']);
Route::put('/users/{user}/change-password', [UserController::class, 'changePassword'])->middleware('auth')->name('users.change-password');

/**----------------------------------------------
 * Transactions Routes
 * Base Route: /transactions
 * Description: Routes for transactions
 *
 *---------------------------------------------**/
Route::controller(TransactionController::class)->prefix('/transactions')->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('transactions.index');
    Route::post('/', 'store')->name('transactions.store');
    Route::get('/create', 'create')->name('transactions.create');
    Route::get('/show', 'show')->name('transactions.show');
    Route::get('/export', 'export')->name('transactions.export');
    Route::post('/print', 'print')->name('transactions.print');
});

/**----------------------------------------------
 * Cart Routes
 * Base Route: /cart
 * Description: Routes for cart
 *
 *---------------------------------------------**/
Route::resource('/cart', CartController::class)->middleware('auth')->only(['store', 'update', 'destroy']);
Route::delete('/cart', [CartController::class, 'truncate'])->middleware('auth')->name('cart.truncate');
