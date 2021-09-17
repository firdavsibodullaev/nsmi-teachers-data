<?php

use Illuminate\Support\Facades\Route;

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
Route::get('pass', function() {
    \App\Models\User::query()->create([
        'FirstName' => 'Firdavs',
        'LastName' => 'Ibodullayev',
        'Patronymic' => 'Qaxramon o\'g\'li',
        'Phone' => '998931588585',
        'Username' => 'admin',
        'Password' => \Illuminate\Support\Facades\Hash::make('admin'),
        'Birth' => '1999-05-07',
        'FacultyId' => 1,
        'DepartmentId' => 1,
        'Post' => 'super_admin'
    ]);
});
