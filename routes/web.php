<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocController;

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
    return view('index');
});

// Resourceful routes for docs
Route::resource('docs', DocController::class);

// Custom route for sorting by title
Route::get('docs-title', [DocController::class, 'indexByTitle'])->name('docs.indexByTitle');

// Route for viewing a single doc in-app
Route::get('docs/{doc}/view', [DocController::class, 'show'])->name('docs.show');
