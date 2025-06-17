<?php

use Illuminate\Support\Facades\Route;

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

Route::get('docs/index-by-title', 'App\Http\Controllers\DocController@indexByTitle')->name('docs.indexByTitle');
Route::resource('docs', 'App\Http\Controllers\DocController')->only([
    'index',
    'create',
    'store',
    'show',
    'edit',
    'update',
    'destroy'
]);
