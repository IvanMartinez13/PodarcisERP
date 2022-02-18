<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ModuleController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//CUSTOMERS
Route::prefix('customers')->middleware('role:super-admin')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::put('/create', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/edit/{token}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/update', [CustomerController::class, 'update'])->name('customers.update');
});

//MODULES
Route::prefix('modules')->middleware('role:super-admin')->group(function () {
    Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/create', [ModuleController::class, 'create'])->name('modules.create');
    Route::put('/create', [ModuleController::class, 'store'])->name('modules.store');
    Route::get('/edit/{token}', [ModuleController::class, 'edit'])->name('modules.edit');
    Route::put('/update', [ModuleController::class, 'update'])->name('modules.update');
});

require __DIR__ . '/auth.php';
