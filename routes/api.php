<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Unprotected Routes
Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', 'App\Http\Controllers\Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register', 'App\Http\Controllers\Auth\ApiAuthController@register')->name('register.api');
});

// Protected Routes
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/articles', 'App\Http\Controllers\ArticleController@index')->name('articles');
    Route::post('/logout', 'App\Http\Controllers\Auth\ApiAuthController@logout')->name('logout.api');

    // Specially For Admin
    Route::get('/articles/admin', 'App\Http\Controllers\ArticleController@index')->middleware('api.admin')->name('articles.admin');

    // Specially For Super Admin
    Route::get('/articles/superadmin', 'App\Http\Controllers\ArticleController@index')->middleware('api.superAdmin')->name('articles.superadmin');
});
