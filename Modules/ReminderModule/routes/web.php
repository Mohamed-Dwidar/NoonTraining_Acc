<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — الأشعارات
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin/reminders', 'middleware' => ['auth:admin']], function () {

    Route::get('/', 'Admin\ReminderAdminController@index')->name('admin.reminders');
    Route::get('/add', 'Admin\ReminderAdminController@create')->name('admin.reminders.add');
    Route::post('/store', 'Admin\ReminderAdminController@store')->name('admin.reminders.store');
    Route::get('/show/{id}', 'Admin\ReminderAdminController@show')->name('admin.reminders.show');
    Route::get('/edit/{id}', 'Admin\ReminderAdminController@edit')->name('admin.reminders.edit');
    Route::post('/update', 'Admin\ReminderAdminController@update')->name('admin.reminders.update');
    Route::post('/delete', 'Admin\ReminderAdminController@destroy')->name('admin.reminders.delete');

    // AJAX (header icon)
    Route::post('/read', 'Admin\ReminderAdminController@markRead')->name('admin.reminders.read');
    Route::get('/latest', 'Admin\ReminderAdminController@latest')->name('admin.reminders.latest');
});

Route::group(['prefix' => 'user/reminders', 'middleware' => ['auth:user']], function () {

    Route::get('/', 'User\ReminderUserController@index')->name('user.reminders');
    Route::get('/add', 'User\ReminderUserController@create')->name('user.reminders.add');
    Route::post('/store', 'User\ReminderUserController@store')->name('user.reminders.store');
    Route::get('/show/{id}', 'User\ReminderUserController@show')->name('user.reminders.show');
    Route::get('/edit/{id}', 'User\ReminderUserController@edit')->name('user.reminders.edit');
    Route::post('/update', 'User\ReminderUserController@update')->name('user.reminders.update');
    Route::post('/delete', 'User\ReminderUserController@destroy')->name('user.reminders.delete');

    // AJAX (header icon)
    Route::post('/read', 'User\ReminderUserController@markRead')->name('user.reminders.read');
    Route::get('/latest', 'User\ReminderUserController@latest')->name('user.reminders.latest');
});
