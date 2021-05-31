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
    return redirect('/home');
});

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/cron', 'closeController@close_automatic');

Auth::routes();

Route::middleware(['auth', 'device'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('client', 'userController', ['only' => ['create', 'show']])->middleware('close');
    Route::resource('client', 'userController', ['except' => ['create', 'show']]);
    Route::resource('payment', 'paymentController')->middleware('close');
    Route::get('payment-export', 'paymentController@export')->middleware('auth');
    Route::resource('cartera', 'carteraController')->middleware('close');
    Route::resource('summary', 'summaryController')->middleware('close');
    Route::resource('simulator', 'simulatorController');
    Route::resource('pending-pay', 'pendingPaymentController');
    Route::resource('route', 'routeController')->middleware('close');
    Route::resource('statistics', 'statisticsUserController');
    Route::resource('blacklists', 'blacklistsController');
    Route::resource('history', 'historyController');
    Route::resource('transaction', 'transactionController');
    Route::resource('bill', 'billController')->middleware('close');
    Route::resource('not-pay', 'NotPaymentController')->middleware('auth');
    Route::get('export', 'NotPaymentController@export')->middleware('auth');
});

Route::prefix('supervisor')->middleware(['device'])->group(function () {
    Route::resource('agent', 'agentController');
    Route::resource('close', 'closeController');
    Route::resource('client', 'clientController');
    Route::resource('tracker', 'trackerController');
    Route::resource('review', 'reviewController');
    Route::resource('statistics', 'statisticsController');
    Route::resource('cash', 'cashController');
    Route::resource('bill', 'billsupervisorController');
    Route::resource('credit', 'creditController');
    Route::resource('graph', 'graphController');
    Route::resource('summary', 'supervisorSummaryController');
    Route::resource('daily-report', 'dailyReportController');

    /*-----Sub Menu-----*/
    Route::prefix('menu')->middleware(['auth'])->group(function () {
        Route::resource('history', 'subHistoryController');
        Route::resource('transitions', 'subTransitionsController');
        Route::resource('route', 'subRouteController');
        Route::resource('bill', 'subBillController');
        Route::resource('close', 'subCloseController');
        Route::resource('edit', 'subEditController');
        Route::resource('report', 'subReportController');
        Route::resource('done', 'subDoneController');
    });
});

Route::prefix('admin')->middleware(['auth', 'device'])->group(function () {
    Route::resource('session', 'sessionController')->only([
        'store'
    ]);
});


Route::prefix('admin')->middleware(['admin', 'device'])->group(function () {
    Route::resource('user', 'adminUserController');
    Route::resource('session', 'sessionController')->only([
        'update'
    ]);
    Route::resource('route', 'adminRouteController');
    Route::resource('audit', 'auditController', ['only' => ['index']]);
});
