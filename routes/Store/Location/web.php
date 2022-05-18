<?php

use App\Http\Controllers\Store\Location\LocationController;
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
    ->get('/create', [LocationController::class, 'create']);

Route::name('save')
    ->post('/create', [LocationController::class, 'store']);

Route::name('queue')
    ->get('/{locationUuid}', [LocationController::class, 'queue']);

Route::name('shopperSave')
    ->post('/shopperSave', [LocationController::class, 'shopperSave']);

Route::name('checkout')
    ->post('/checkout', [LocationController::class, 'checkout']);

Route::name('updateLimit')
    ->post('/updateLimit', [LocationController::class, 'updateLimit']);
