<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — إعدادات النظام (admin only)
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin/settings', 'middleware' => ['auth:admin']], function () {

    Route::get('/', 'Admin\SettingAdminController@index')->name('admin.settings');

    // "تم التسجيل عن طريق" names list
    Route::get('/reg_by_employees', 'Admin\RegByEmployeeAdminController@index')->name('admin.settings.reg_by_employees');
    Route::post('/reg_by_employees/store', 'Admin\RegByEmployeeAdminController@store')->name('admin.settings.reg_by_employees.store');
    Route::get('/reg_by_employees/edit/{id}', 'Admin\RegByEmployeeAdminController@edit')->name('admin.settings.reg_by_employees.edit');
    Route::post('/reg_by_employees/update', 'Admin\RegByEmployeeAdminController@update')->name('admin.settings.reg_by_employees.update');
    Route::post('/reg_by_employees/delete', 'Admin\RegByEmployeeAdminController@destroy')->name('admin.settings.reg_by_employees.delete');

    // "طرق الدفع" payment methods list
    Route::get('/payment_methods', 'Admin\PaymentMethodAdminController@index')->name('admin.settings.payment_methods');
    Route::post('/payment_methods/store', 'Admin\PaymentMethodAdminController@store')->name('admin.settings.payment_methods.store');
    Route::get('/payment_methods/edit/{id}', 'Admin\PaymentMethodAdminController@edit')->name('admin.settings.payment_methods.edit');
    Route::post('/payment_methods/update', 'Admin\PaymentMethodAdminController@update')->name('admin.settings.payment_methods.update');
    Route::post('/payment_methods/delete', 'Admin\PaymentMethodAdminController@destroy')->name('admin.settings.payment_methods.delete');
});
