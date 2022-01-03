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



/////////////////////////////////////////////////////////////////////
//
//      コース作成
//
/////////////////////////////////////////////////////////////////////

Route::group(['prefix'=>'create'],function(){

    //画面表示

    //スタート選択画面表示
    Route::get('/selectStart','CreateRallyController@selectStart')->name('selectStart');
    //ポイント選択画面表示
    Route::get('/selectPoint/{route_code}/{route_name}/{point_no}','CreateRallyController@selectPoint')->name('selectPoint');
    //ポイント追加選択画面表示
    Route::get('/addPoint/{route_code}/{route_name}/{point_no}','CreateRallyController@addPoint')->name('addPoint');
    //ゴール設定画面表示
    Route::get('/settingGoal/{route_code}/{route_name}','CreateRallyController@settingGoal')->name('settingGoal');


    //データ処理

    //スタート作成処理
    Route::get('/makeStart','CreateRallyController@makeStart')->name('makeStart');
    Route::post('/makeStart','CreateRallyController@makeStart')->name('makeStart');
    //ポイント作成処理
    Route::get('/makePoint/{route_code}/{route_name}/{point_no}','CreateRallyController@makePoint')->name('makePoint');
    Route::post('/makePoint/{route_code}/{route_name}/{point_no}','CreateRallyController@makePoint')->name('makePoint');
    //ゴール設定画面
    Route::get('/makeGoal/{route_code}','CreateRallyController@makeGoal')->name('makeGoal');
    Route::post('/makeGoal/{route_code}','CreateRallyController@makeGoal')->name('makeGoal');




    //ポイント選択画面からスタート選択画面へ戻る　※スタート設定時に作成したテーブルデータを削除
    Route::post('/reSelectStart/{route_code}','CreateRallyController@reSelectStart')->name('reSelectStart');
    //ポイント設定完了ORポイント追加選択画面
    Route::post('/reSelectpoint','CreateRallyController@reSelectpoint')->name('reSelectPoint');

});





Route::get('/home', 'HomeController@index')->name('home');


//画面表示テスト用
Route::get('/test',function(){
    return view('test');
});
