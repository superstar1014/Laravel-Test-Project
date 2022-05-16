<?php

use App\Http\Controllers\Shopper\ShopperController;
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

Route::name('create')
    ->get('/create', [ShopperController::class, 'create']);

Route::name('save')
    ->post('/create', [ShopperController::class, 'store']);

Route::name('store')
    ->get('/{store}', [ShopperController::class, 'show']);
