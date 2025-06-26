<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentModule\app\Http\Controllers\StudentModuleController;

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

Route::group(['prefix' => 'admin/students', 'middleware' => ['auth:admin']], function () {

    Route::get('/', 'Admin\StudentAdminController@index')->name('admin.students');
    Route::get('/archived', 'Admin\StudentAdminController@indexArchived')->name('admin.students.archived');
    Route::get('add',  'Admin\StudentAdminController@add')->name('admin.students.add');
    Route::post('store',  'Admin\StudentAdminController@store')->name('admin.students.store');
    Route::get('/view/{id}', 'Admin\StudentAdminController@show')->name('admin.students.view');
    Route::get('/edit/{id}', 'Admin\StudentAdminController@edit')->name('admin.students.edit');
    Route::post('/update', 'Admin\StudentAdminController@update')->name('admin.students.update');
    Route::get('/delete/{id}', 'Admin\StudentAdminController@destroy')->name('admin.students.delete');

    Route::get('/restore/{id}', 'Admin\StudentAdminController@retrieveStudent')->name('admin.restore.student');
    Route::get('/deletestudent/{id}', 'Admin\StudentAdminController@deleteStudentArchive')->name('admin.deleteStudentFromArchive');

    Route::post('/sendStudentsMail', 'Admin\StudentAdminController@sendMailAjax')->name('admin.students.send_students_mail_ajax');
});


Route::group(['prefix' => 'user/students', 'middleware' => ['auth:user']], function () {

    Route::get('/', 'User\StudentUserController@index')->name('user.students');
    Route::get('/archived', 'User\StudentUserController@indexArchived')->name('user.students.archived');
    Route::get('add',  'User\StudentUserController@add')->name('user.students.add');
    Route::post('store',  'User\StudentUserController@store')->name('user.students.store');
    Route::get('/view/{id}', 'User\StudentUserController@show')->name('user.students.view');
    Route::get('/edit/{id}', 'User\StudentUserController@edit')->name('user.students.edit');
    Route::post('/update', 'User\StudentUserController@update')->name('user.students.update');
    Route::get('/delete/{id}', 'User\StudentUserController@destroy')->name('user.students.delete');

    Route::get('/restore/{id}', 'User\StudentUserController@retrieveStudent')->name('user.restore.student');
    Route::get('/deletestudent/{id}', 'User\StudentUserController@deleteStudentArchive')->name('user.deleteStudentFromArchive');

    Route::post('/sendStudentsMail', 'User\StudentUserController@sendMailAjax')->name('user.students.send_students_mail_ajax');
});
