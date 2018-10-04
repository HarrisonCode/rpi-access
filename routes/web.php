<?php

use App\Http\Controllers\DashboardController;

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



Route::get('/', 'AppController@index')->name('index');
Route::get('/validate/{key}', 'AppController@key')->where(['key' => '[0-9]+'])->name('validate');
Route::get('/code/{id}/{code}', 'AppController@code')->where(['id' => '[0-9]+', 'code' => '[0-9]+'])->name('code');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
DashboardController::routes();
// Route::get('/', function () {
    // return view('test');
// });