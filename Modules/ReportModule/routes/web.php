<?php

use Illuminate\Support\Facades\Route;
use Modules\ReportModule\app\Http\Controllers\ReportModuleController;

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


Route::group(['prefix' => 'admin/reports', 'middleware' => ['auth:admin']], function () {

    Route::get('/', 'Admin\ReportAdminController@index')->name('admin.reports');
    Route::get('ReportStudentsNotPaid', 'Admin\ReportAdminController@reportStudentsNotPaid')->name('admin.reports.students_not_paid');
    Route::get('ReportStudentsInstallmentPay', 'Admin\ReportAdminController@reportStudentsInstallmentPay')->name('admin.reports.students_installment_pay');
    Route::get('ReportStudentsExamNotPaid', 'Admin\ReportAdminController@reportStudentsExamNotPaid')->name('admin.reports.students_exam_mot_paid');
    Route::get('ReportStudentsPaid', 'Admin\ReportAdminController@reportStudentsPaid')->name('admin.reports.students_paid');
    Route::get('ReportStudentsReciveCert', 'Admin\ReportAdminController@reportStudentsReciveCert')->name('admin.reports.students_recive_cert');
    Route::get('ReportStudentsNotReciveCert', 'Admin\ReportAdminController@reportStudentsNotReciveCert')->name('admin.reports.students_not_recive_cert');
    Route::get('ReportStudentsByCompany', 'Admin\ReportAdminController@reportStudentsByCompany')->name('admin.reports.students_by_company');
    Route::get('ReportAllStudents', 'Admin\ReportAdminController@ReportAllStudents')->name('admin.reports.students_all');
    Route::get('ReportAllCourses', 'Admin\ReportAdminController@ReportAllCourses')->name('admin.reports.courses');
    Route::get('ReportAllCourseStudents/{id}', 'Admin\ReportAdminController@ReportAllCourseStudents')->name('admin.reports.course_students');
    Route::get('ReportStudentsLeave', 'Admin\ReportAdminController@reportStudentsLeave')->name('admin.reports.students_leave');
    Route::get('ReportUsersLog', 'Admin\ReportAdminController@usersLog')->name('admin.reports.users_log');
});

Route::group(['prefix' => 'user/reports', 'middleware' => ['auth:user']], function () {
    Route::group(
        ['middleware' => ['permission:Show Reports']],
        function () {
            Route::get('/', 'User\ReportUserController@index')->name('user.reports');
            Route::get('ReportStudentsNotPaid', 'User\ReportUserController@reportStudentsNotPaid')->name('user.reports.students_not_paid');
            Route::get('ReportStudentsInstallmentPay', 'User\ReportUserController@reportStudentsInstallmentPay')->name('user.reports.students_installment_pay');
            Route::get('ReportStudentsExamNotPaid', 'User\ReportUserController@reportStudentsExamNotPaid')->name('user.reports.students_exam_mot_paid');
            Route::get('ReportStudentsPaid', 'User\ReportUserController@reportStudentsPaid')->name('user.reports.students_paid');
            Route::get('ReportStudentsReciveCert', 'User\ReportUserController@reportStudentsReciveCert')->name('user.reports.students_recive_cert');
            Route::get('ReportStudentsNotReciveCert', 'User\ReportUserController@reportStudentsNotReciveCert')->name('user.reports.students_not_recive_cert');
            Route::get('ReportStudentsByCompany', 'User\ReportUserController@reportStudentsByCompany')->name('user.reports.students_by_company');
            Route::get('ReportAllStudents', 'User\ReportUserController@ReportAllStudents')->name('user.reports.students_all');
            Route::get('ReportAllCourses', 'User\ReportUserController@ReportAllCourses')->name('user.reports.courses');
            Route::get('ReportAllCourseStudents/{id}', 'User\ReportUserController@ReportAllCourseStudents')->name('user.reports.course_students');
            Route::get('ReportStudentsLeave', 'User\ReportUserController@reportStudentsLeave')->name('user.reports.students_leave');
            Route::get('ReportUsersLog', 'User\ReportUserController@usersLog')->name('user.reports.users_log');
        }
    );
});
