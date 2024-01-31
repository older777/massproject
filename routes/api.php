<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Order;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "api" middleware group. Make something great!
 * |
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/requests', 'App\Http\Controllers\OrderController@submitOrder')->name('submit.order');

Route::middleware('auth')->group(function () {
    Route::put('/requests/{id}', 'App\Http\Controllers\OrderController@orderProcess')->name('order.update');
    Route::get('/requests', function () {
        inertia('Dashboard', [
            'orders' => Order::all(),
        ]);
    })->name('get.orders');
});