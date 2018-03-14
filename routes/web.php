<?php

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
Route::get('/404', function () {
    return view('404');
})->name('404');
Route::get('/405', function () {
    return view('405');
})->name('405');

Route::get('login', 'User\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'User\Auth\LoginController@login');
Route::post('logout', 'User\Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'User\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('clientid/get', 'User\Auth\LoginController@showClientRequestForm')->name('clientid.get');
Route::post('password/email', 'User\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'User\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'User\Auth\ResetPasswordController@reset');
Route::get('check-client-id/{id}', 'User\Auth\LoginController@checkClientId');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'User\UserController@index')->name('dashboard');
    Route::get('/profile', 'User\UserController@profile')->name('profile');
    Route::post('/profile/update/avatar', 'User\UserController@profileUpdateAvatar')->name('profile.update.avatar');
    Route::post('/profile/update/cover', 'User\UserController@profileUpdateCover')->name('profile.update.avatar');
    Route::get('profile/username/validater/{newusername}', 'User\UserController@usernameValidate');
    Route::get('profile/email/validater/{newemail}', 'User\UserController@emailValidate');
    Route::post('profile/update/unique', 'User\UserController@updateEmployeeUnique');
    Route::post('profile/update/info', 'User\UserController@updateEmployeeInfo');
    Route::post('profile/update/password', 'User\UserController@updateEmployeePassOwn');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'User\UserController@index')->name('dashboard');
});

Route::prefix('admin')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');

        // profile section
        Route::get('profile/admin/{unique}', 'Admin\AdminProfileController@showProfileAdmin');
        Route::post('profile/admin/{unique}/update/avatar', 'Admin\AdminProfileController@updateAdminAvatar');
        Route::post('profile/admin/{unique}/update/cover', 'Admin\AdminProfileController@updateAdminCover');
        Route::get('profile/username/validater/{newusername}', 'Admin\AdminProfileController@usernameValidate');
        Route::get('profile/email/validater/{newemail}', 'Admin\AdminProfileController@emailValidate');
        Route::post('profile/admin/{unique}/update/unique', 'Admin\AdminProfileController@updateAdminUnique');
        Route::post('profile/admin/{unique}/update/info', 'Admin\AdminProfileController@updateAdminInfo');
        Route::post('profile/admin/{unique}/update/password', 'Admin\AdminProfileController@updateAdminPassword');
        Route::post('profile/{unique}/update/password', 'Admin\AdminProfileController@updateAdminPassOwn');
        Route::post('profile/{unique}/update/password/force', 'Admin\AdminProfileController@updateAdminPassForce');
        // user profile
        Route::get('profile/employee/{unique}', 'Admin\AdminProfileController@showProfileEmployee');
        Route::post('profile/employee/{unique}/update/avatar', 'Admin\AdminProfileController@updateEmployeeAvatar');
        Route::post('profile/employee/{unique}/update/cover', 'Admin\AdminProfileController@updateEmployeeCover');
        Route::post('profile/employee/{unique}/update/unique', 'Admin\AdminProfileController@updateEmployeeUnique');
        Route::post('profile/employee/{unique}/update/info', 'Admin\AdminProfileController@updateEmployeeInfo');
        Route::post('profile/employee/{unique}/update/password/force', 'Admin\AdminProfileController@updateEmployeePassForce');
        // end profile section
        //admin manage section
        Route::get('manage/admins', 'Admin\AdminManageController@index')->name('admin.manage.admins');
        Route::get('manage/admins/getdatas', 'Admin\AdminManageController@getAdminData');
        Route::get('manage/username/check', 'Admin\AdminManageController@usernameCheck');
        Route::get('manage/email/check', 'Admin\AdminManageController@emailCheck');
        Route::post('manage/new/admin', 'Admin\AdminManageController@storeAdmin')->name('admin.add.new.admin');
        Route::get('manage/delete/admin/{uniqueid}', 'Admin\AdminManageController@deleteAdmin');
        //end
        //employee management
        Route::get('manage/employee', 'Admin\AdminManageController@viewEmployee')->name('admin.manage.employee');
        Route::get('manage/employee/getdatas', 'Admin\AdminManageController@getEmployeeData');
        Route::post('manage/new/employee', 'Admin\AdminManageController@storeEmployee')->name('admin.add.new.employee');
        Route::get('manage/delete/employee/{uniqueid}', 'Admin\AdminManageController@deleteEmployee');
        //end
        //contract type Management
        Route::get('manage/contract', 'Admin\AdminManageController@viewContract')->name('admin.manage.contract');
        Route::get('manage/contract/getdatas', 'Admin\AdminManageController@getContractData');
        Route::post('manage/contract/store', 'Admin\AdminManageController@storeContract')->name('admin.manage.contract.store');
        Route::post('manage/contract/update', 'Admin\AdminManageController@updateContract')->name('admin.manage.contract.update');
        Route::get('manage/contract/getsingle_data/{id}', 'Admin\AdminManageController@getSingleContract');
        Route::get('manage/contract/delete/{id}', 'Admin\AdminManageController@destroySingleContract');
        //end
        //manage holiday
        Route::get('manage/holiday', 'Admin\adminController@viewHoliday')->name('admin.manage.holiday');
        Route::get('manage/holiday/getAlldays', 'Admin\adminController@getAllHoliday');
        Route::get('manage/holiday/checkDate/{date}', 'Admin\adminController@checkholiday');
        Route::post('manage/holiday/store', 'Admin\adminController@storeHoliday')->name('admin.manage.holiday.store');
        Route::post('manage/holiday/update', 'Admin\adminController@updateHoliday')->name('admin.manage.holiday.update');
        Route::get('manage/holiday/destroy/{id}', 'Admin\adminController@destroyHoliday');
        //end
        //setting
        Route::get('setting/appearance', 'Admin\SettingController@index')->name('admin.setting.appearance');
        Route::post('setting/update/name', 'Admin\SettingController@update_name')->name('admin.setting.update.name');
        Route::post('setting/update/logo', 'Admin\SettingController@update_logo')->name('admin.setting.update.logo');
        Route::post('setting/update/fav', 'Admin\SettingController@update_fav')->name('admin.setting.update.fav');
    });

    Route::get('login', 'Admin\Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\Auth\AdminLoginController@login');
    Route::post('logout', 'Admin\Auth\AdminLoginController@logout')->name('admin.logout');

    // Password Reset Routes...
    Route::get('password/reset', 'Admin\Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'Admin\Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'Admin\Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});
