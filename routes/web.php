<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\RedakturController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\Redaktur;
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

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('/');

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::resource('employee', EmployeeController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('category', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('tag', TagController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('redaktur', RedakturController::class)->only(['index', 'store', 'update', 'destroy']);

require __DIR__.'/auth.php';