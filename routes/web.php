<?php

use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', 'App\Http\Controllers\HomeController@home')->name('home');

Route::get('/ticket', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('ticket');

Route::get('/contacts', function (Request $request) {
    return Inertia::render('Contacts', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('contacts');

Route::get('/search', 'App\Http\Controllers\HomeController@search')->name('search');
Route::get('/product/{product}', 'App\Http\Controllers\HomeController@product')->name('product');

Route::get('/dashboard', function (Request $request) {
    return Inertia::render('Dashboard', [
        'orders' => Inertia::lazy(function () use ($request) {
            if ($request->input('sort')) {
                return Order::orderBy($request->sort)->get();
            } else {
                return Order::all();
            }
        }),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/requests', 'App\Http\Controllers\OrderController@submitOrder')->name('submit.order');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
