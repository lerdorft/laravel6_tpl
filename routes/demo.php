<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| DEMO Routes
|--------------------------------------------------------------------------
|
| Here is where you can register DEMO routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "demo" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['demo']], function () {
    //demo
    Route::get('/test/index', 'IndexController@index');

    //send email
    Route::any('/email/send', 'IndexController@emailSend');

    //json decode
    Route::any('/common/json-decode', 'CommonController@jsonDecode');

    //unserialize
    Route::any('/common/unserialize', 'CommonController@unserialize');
});
