<?php

use Illuminate\Support\Facades\Route;

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
Route::namespace('Api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::middleware('auth:api')->group(function () {
            // Auth
            Route::group(['prefix' => 'auth'], function () {
                Route::post('login', 'LoginController@login')->withoutMiddleware('auth:api');
                Route::post('logout', 'LoginController@logout');
            });
            // Факультет, Кафедра, Пользователи
            Route::get('field/list', 'FieldController@list');
            Route::get('field/types', 'FieldController@getFieldTypes');
            Route::apiResources([
                'faculty' => 'FacultyController',
                'department' => 'DepartmentController',
                'user' => 'UserController',
                'table' => 'TableController',
                'field' => 'FieldController',
            ]);

            Route::group([
                'prefix' => 'record',
                'as' => 'record.'
            ], function () {
                Route::get('{table}', [\App\Http\Controllers\Api\ValuesController::class, 'index']);
                Route::get('/{table}/{user}', [\App\Http\Controllers\Api\ValuesController::class, 'list']);
                Route::get('show/{record}', [\App\Http\Controllers\Api\ValuesController::class, 'show']);
                Route::post('upload', [\App\Http\Controllers\Api\ValuesController::class, 'upload']);
                Route::post('{record}', [\App\Http\Controllers\Api\ValuesController::class, 'store']);
                Route::put('update/{record}', [\App\Http\Controllers\Api\ValuesController::class, 'update']);
                Route::delete('{record}', [\App\Http\Controllers\Api\ValuesController::class, 'destroy']);
            });

            Route::group([
                'prefix' => 'constant'
            ], function () {
                Route::get('post', 'ConstantController@posts');
            });
        });
    });
});
