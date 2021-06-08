<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('oauth/token', 'Auth\AccessTokenController@issueToken');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/ping', function (Request $request) {
        return response()->json(['message' => 'Working']);
    });

    Route::get('/services', 'ServicesController@list');
    Route::get('/employee-types', 'EmployeeTypesController@list');
    Route::get('/schools', 'SchoolsController@list');

    Route::group(['prefix' => 'address'], function () {
        Route::get('/', 'AddressController@list');
        Route::post('/', 'AddressController@store');
        Route::get('/{id}', 'AddressController@get');
        Route::put('/{id}', 'AddressController@update');
        Route::delete('/{id}', 'AddressController@delete');
    });

    Route::group(['prefix' => 'subjects'], function () {
        Route::get('/', 'SubjectsController@list');
        Route::post('/', 'SubjectsController@store');
        Route::patch('/', 'SubjectsController@patch');
        Route::delete('/{id}', 'SubjectsController@delete');

        Route::get('/user/{id}', 'SubjectsController@getByUser');
    });
    
    Route::get('/user/permissions', 'UsersController@simplifiedPermissions');
    Route::put('/user/change-password', 'UsersController@changePassword');
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UsersController@list');
        Route::post('/', 'UsersController@store');
        Route::get('/{id}', 'UsersController@get');
        Route::put('/{id}', 'UsersController@update');
        Route::delete('/{id}', 'UsersController@delete');
        
        Route::get('/send-created-mail/{id}', 'UsersController@sendCreatedMail');
    });

    Route::group(['prefix' => 'configs'], function () {
        Route::get('/', 'ConfigsController@list');
        Route::post('/', 'ConfigsController@store');
        Route::delete('/{id}', 'ConfigsController@delete');

        Route::get('/user/{id}', 'ConfigsController@userConfigs');
        Route::patch('/user/{id}', 'ConfigsController@userPatch');
        Route::put('/user/{id}/{slug}', 'ConfigsController@updateUserConfig');
    });
    
    Route::group(['prefix' => 'employees'], function () {
        Route::get('/', 'EmployeesController@list');
        Route::get('/{id}', 'EmployeesController@get');
        Route::post('/', 'EmployeesController@store');
        Route::put('/{id}', 'EmployeesController@update');
        Route::delete('/{id}', 'EmployeesController@delete');
    });
    
    Route::get('/teachers', 'EmployeesController@listTeachers');

    Route::group(['prefix' => 'families'], function () {
        Route::get('/', 'FamiliesController@list');
        Route::post('/', 'FamiliesController@store');
        Route::get('/{id}', 'FamiliesController@get');
        Route::put('/{id}', 'FamiliesController@update');
        Route::delete('/{id}', 'FamiliesController@delete');
        
        Route::get('/responsibles/{id}', 'FamiliesController@listResponsibles');
    });

    Route::group(['prefix' => 'relatives'], function () {
        Route::get('/', 'RelativesController@list');
        Route::post('/', 'RelativesController@store');
        Route::put('/{id}', 'RelativesController@update');
        Route::delete('/{id}', 'RelativesController@delete');
    });

    Route::group(['prefix' => 'studants'], function () {
        Route::get('/', 'StudantsController@list');
        Route::post('/', 'StudantsController@store');
        Route::get('/{id}', 'StudantsController@get');
        Route::put('/{id}', 'StudantsController@update');
        Route::delete('/{id}', 'StudantsController@delete');
    });

    Route::group(['prefix' => 'schedules'], function () {
        Route::get('/', 'SchedulesController@list');
        Route::post('/', 'SchedulesController@store');
        Route::get('/{id}', 'SchedulesController@get');
        Route::put('/{id}', 'SchedulesController@update');
        Route::delete('/{id}', 'SchedulesController@delete');

        Route::get('/{id}/studants', 'SchedulesController@listStudants');
        Route::post('/{id}/studant', 'SchedulesController@storeStudant');
        Route::get('/studant/{id}', 'SchedulesController@getStudant');
        Route::put('/studant/{id}', 'SchedulesController@updateStudant');
        Route::delete('/studant/{id}', 'SchedulesController@deleteStudant');
    });
});