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
Route::get('/report/probando', ['as' => ' probando_coneccion', 'uses' => 'ApiReportController@localprobando_coneccion']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/report/request', ['as' => 'report_request', 'uses' => 'ApiRequestController@report_request']);

    Route::get('/report/download', ['as' => 'report_download', 'uses' => 'ApiRequestController@report_download']);

    Route::get('/process/campaign/summary', ['as' => 'execute_campaign_summary_report', 'uses' => 'ApiReportController@execute_campaign_summary_report']);

    Route::get('/process/campaign/daily', ['as' => 'execute_campaign_daily_report', 'uses' => 'ApiReportController@execute_campaign_daily_report']);

    Route::get('/process/advertiser/summary', ['as' => 'execute_advertiser_summary_report', 'uses' => 'ApiReportController@execute_advertiser_summary_report']);

    Route::get('/process/campaign/metrics', ['as' => 'execute_metrics_report', 'uses' => 'ApiReportController@execute_metrics_report']);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});