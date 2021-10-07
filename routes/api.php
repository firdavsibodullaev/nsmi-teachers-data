<?php

use App\Http\Controllers\Api\ValuesController;
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
                Route::get('show/{record}', [ValuesController::class, 'show']);
                Route::get('{table}', [ValuesController::class, 'index']);
                Route::get('/{table}/{user}', [ValuesController::class, 'list']);
                Route::post('upload/{table}', [ValuesController::class, 'upload']);
                Route::put('upload/{record}', [ValuesController::class, 'uploadUpdate']);
                Route::post('{record?}', [ValuesController::class, 'store']);
                Route::put('update/{record}', [ValuesController::class, 'update']);
                Route::delete('{record}', [ValuesController::class, 'destroy']);
            });

            Route::group([
                'prefix' => 'constant'
            ], function () {
                Route::get('post', 'ConstantController@posts');
            });
        });
    });
});
