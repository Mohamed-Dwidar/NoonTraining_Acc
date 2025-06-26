<?php

use Illuminate\Support\Facades\Route;
use Modules\LogModule\app\Http\Controllers\LogModuleController;

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
Route::prefix('logmodule')->group(function() {
    Route::get('/', 'LogModuleController@index');
});