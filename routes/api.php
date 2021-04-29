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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'agente', 'middleware' => ['jwt.auth']], function () {
    /** Rutas Protegidas */
    Route::get('/home', 'Api\HomeController@index')->name('home');
    Route::resource('client', 'Api\userController', ['only' => ['create', 'show']])->middleware('close');
    Route::resource('client', 'Api\userController', ['except' => ['create', 'show']]);
    Route::resource('payment', 'Api\paymentController')->middleware('close');
    Route::resource('summary', 'Api\summaryController')->middleware('close');
    Route::resource('simulator', 'Api\simulatorController');
    Route::resource('route', 'Api\routeController')->middleware('close');
    Route::resource('history', 'Api\historyController');
    Route::resource('transaction', 'Api\transactionController');
    Route::resource('bill', 'Api\billController')->middleware('close');
});

Route::post('login', 'Api\loginApiController@loginApi');
//Route::resource('close', 'cronController', ['only' => ['index']]);