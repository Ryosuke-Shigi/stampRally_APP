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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//作成
Route::group(['prefix'=>'create'],function(){
    //スタート選択画面表示
    Route::get('/selectStart','CreateRallyController@selectStart')->name('selectStart');
    //ポイント選択画面表示
    Route::get('/selectPoint','CreateRallyController@selectPoint')->name('selectPoint');

    //スタート作成処理
    Route::post('/makeStart','CreateRallyController@makeStart')->name('makeStart');
    //ポイント作成処理
    Route::post('/makePoint','CreateRallyController@makePoint')->name('makePoint');

    //ポイント選択画面からスタート選択画面へ戻る　※スタート設定時に作成したテーブルデータを削除
    Route::post('/reSelectStart','CreateRallyController@reSelectStart')->name('reSelectStart');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
