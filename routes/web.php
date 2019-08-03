<?php

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@show')->name('dashboard');
    Route::resource('/employees', 'EmployeeController');
    Route::resource('/companies', 'CompanyController');
});
