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
    return view('home');
});

Auth::routes();

/* Route::get('/home', 'HomeController@index')->name('home'); */

Route::get('/test',function(){
    return view('test');
});
//画面表示テスト用
//Route::get('/test','GameRallyController@test')->name('test');


/////////////////////////////////////////////////////////////////////
//
//      コース作成
//
/////////////////////////////////////////////////////////////////////

Route::group(['prefix'=>'create'],function(){

    //画面表示

    //ルート作成画面表示
    Route::get('/createRoute','CreateRallyController@createRoute')->name('createRoute');
    //ポイント選択画面表示
    Route::get('/selectPoint/{route_code}/{route_name}/{latitude?}/{longitude?}/{point_no}','CreateRallyController@selectPoint')->name('selectPoint');
    Route::post('/selectPoint/{route_code}/{route_name}/{latitude?}/{longitude?}/{point_no}','CreateRallyController@selectPoint')->name('selectPoint');
    //ポイント追加選択画面表示
    Route::get('/addPoint/{route_code}/{route_name}/{latitude?}/{longitude?}/{point_no}','CreateRallyController@addPoint')->name('addPoint');
    Route::post('/addPoint/{route_code}/{route_name}/{latitude?}/{longitude?}/{point_no}','CreateRallyController@addPoint')->name('addPoint');
    //ゴール設定画面表示
    Route::get('/settingGoal/{route_code}/{route_name}','CreateRallyController@settingGoal')->name('settingGoal');
    //ルート作成データ処理
    //ルート作成処理
    Route::get('/makeRoute','CreateRallyController@makeRoute')->name('makeRoute');
    Route::post('/makeRoute','CreateRallyController@makeRoute')->name('makeRoute');
    //ポイント作成処理
    Route::get('/makePoint/{route_code}/{route_name}/{point_no}','CreateRallyController@makePoint')->name('makePoint');
    Route::post('/makePoint/{route_code}/{route_name}/{point_no}','CreateRallyController@makePoint')->name('makePoint');
    //ゴール設定画面
    Route::get('/makeGoal/{route_code}','CreateRallyController@makeGoal')->name('makeGoal');
    Route::post('/makeGoal/{route_code}','CreateRallyController@makeGoal')->name('makeGoal');
    //ルート作成  Back処理
    //ポイント選択画面からスタート選択画面へ戻る　※スタート設定時に作成したテーブルデータを削除
    Route::post('/reCreateRoute/{route_code}','CreateRallyController@reCreateRoute')->name('reCreateRoute');
    //ポイント設定完了ORポイント追加選択画面
    Route::post('/reSelectpoint','CreateRallyController@reSelectpoint')->name('reSelectPoint');

});

Route::group(['prefix'=>'game'],function(){

    //ルート選択画面
    Route::get('/selectRoute','GameRallyController@selectRoute')->name('selectRoute');
    //ポイントチェック画面
    Route::get('/checkPoint','GameRallyController@checkPoint')->name('checkPoint');
    Route::post('/checkPoint','GameRallyController@checkPoint')->name('checkPoint');


    //ポイントチェック処理
    Route::post('/pointJudge','GameRallyController@pointJudge')->name('pointJudge');
    //ゴール表示（モーダル画面に　名前とコメントをいれてもらう）
    Route::post('/pointComplete','GameRallyController@pointComplete')->name('pointComplete');
    //ゴール後処理（stateとstampを削除して、scoreを作成。 ルート選択画面前まで戻す)
    Route::post('/clearRally','GameRallyController@clearRally')->name('clearRally');


});
