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


/* トップ画面 */
Route::get('/', function () {
    return view('home');
});
Route::get('/home',function(){
    return view('home');
});


Auth::routes();


/* 紹介ページ */
Route::get('/LP','lpController@viewLp')->name('viewLp');
//画面表示テスト用
//Route::get('/test','GameRallyController@test')->name('test');

//ISSチェイサー（未使用）
Route::get('/ISS','IssController@viewISS')->name('viewISS');


/////////////////////////////////////////////////////////////////////
//
//      コース作成
//
/////////////////////////////////////////////////////////////////////

Route::group(['prefix'=>'create'],function(){

    //ルート作成（完了まで一気に作成する）
    //ルート作成画面表示
    Route::get('/createRoute','CreateRallyController@createRoute')->name('createRoute');
    //ルート作成データ処理
    //ルート作成処理
    Route::get('/makeRoute','CreateRallyController@makeRoute')->name('makeRoute');
    Route::post('/makeRoute','CreateRallyController@makeRoute')->name('makeRoute');

    //ポイント選択画面表示
    Route::get('/selectPoint/{route_code}/{route_name}/{latitude?}/{longitude?}/{point_no}','CreateRallyController@selectPoint')->name('selectPoint');
    Route::post('/selectPoint/{route_code}/{route_name}/{latitude?}/{longitude?}/{point_no}','CreateRallyController@selectPoint')->name('selectPoint');
    //ポイント作成処理
    Route::get('/makePoint/{route_code}/{route_name}/{point_no}','CreateRallyController@makePoint')->name('makePoint');
    Route::post('/makePoint/{route_code}/{route_name}/{point_no}','CreateRallyController@makePoint')->name('makePoint');

    //ゴール設定画面表示
    Route::get('/settingGoal/{route_code}/{route_name}','CreateRallyController@settingGoal')->name('settingGoal');
    //ゴール設定画面
    Route::get('/makeGoal/{route_code}','CreateRallyController@makeGoal')->name('makeGoal');
    Route::post('/makeGoal/{route_code}','CreateRallyController@makeGoal')->name('makeGoal');

    //ポイント追加選択画面表示
    Route::get('/addPoint/{route_code}/{route_name}/{latitude?}/{longitude?}/{point_no}','CreateRallyController@addPoint')->name('addPoint');
    Route::post('/addPoint/{route_code}/{route_name}/{latitude?}/{longitude?}/{point_no}','CreateRallyController@addPoint')->name('addPoint');
    //ポイント選択画面からスタート選択画面へ戻る　※スタート設定時に作成したテーブルデータを削除
    Route::post('/reCreateRoute/{route_code}','CreateRallyController@reCreateRoute')->name('reCreateRoute');
    Route::post('/reSelectpoint','CreateRallyController@reSelectpoint')->name('reSelectPoint');



    //nowTravel(現地現地で作成するイメージのもの)
    //作成中の画面表示
    Route::get('/selectNowTravel','CreateRallyController@selectNowTravel')->name('selectNowTravel');
    //ルート作成画面表示
    Route::get('/createRouteNowTravel','CreateRallyController@createRouteNowTravel')->name('createRouteNowTravel');
    //ルート作成処理
    Route::get('/makeRouteNowTravel','CreateRallyController@makeRouteNowTravel')->name('makeRouteNowTravel');
    Route::post('/makeRouteNowTravel','CreateRallyController@makeRouteNowTravel')->name('makeRouteNowTravel');

    //ポイント作成画面表示
    Route::get('/selectPointNowTravel','CreateRallyController@selectPointNowTravel')->name('selectPointNowTravel');
    //ポイント作成処理
    Route::get('/makePointNowTravel/{route_code}/{pointNum}','CreateRallyController@makePointNowTravel')->name('makePointNowTravel');
    Route::post('/makePointNowTravel/{route_code}/{pointNum}','CreateRallyController@makePointNowTravel')->name('makePointNowTravel');

    //ゴール設定画面表示
    Route::get('/settingGoalNowTravel/{route_code}','CreateRallyController@settingGoalNowTravel')->name('settingGoalNowTravel');
    //ゴール設定画面
    Route::get('/makeGoalNowTravel/{route_code}','CreateRallyController@makeGoalNowTravel')->name('makeGoalNowTravel');
    Route::post('/makeGoalNowTravel/{route_code}','CreateRallyController@makeGoalNowTravel')->name('makeGoalNowTravel');
    //リセットnowTravel（ルート、ポイントを削除する)
    Route::get('/resetNowTravel','CreateRallyController@resetNowTravel')->name('resetNowTravel');
    //nowTravelここまで


    //ルート削除
    //画面表示
    Route::get('selectDeleteRoutes','CreateRallyController@selectDeleteRoutes')->name('selectDeleteRoutes');
    //削除確認
    Route::get('deleteDoubleCheck','CreateRallyController@deleteDoubleCheck')->name('deleteDoubleCheck');
    //削除処理
    Route::get('deleteRoute','CreateRallyController@deleteRoute')->name('deleteRoute');

});



/////////////////////////////////////////////////////////////////////
//
//     ゲーム進行・ルート進行
//
/////////////////////////////////////////////////////////////////////

Route::group(['prefix'=>'game'],function(){

    //game create score 選択画面
    Route::get('/selectMode','GameRallyController@selectMode')->name('selectMode');
    //createモードでの　作成　OR　削除　画面　ルートの途中編集は進行でおかしくなるので削除か作成のみ
    Route::get('/selectCreate','GameRallyController@selectCreate')->name('selectCreate');
    //ルート検索選択画面(全てのルート・キー検索両方を含む)
    Route::get('/searchRoutes','GameRallyController@searchRoutes')->name('searchRoutes');
    //進行中ルートを出す
    Route::get('/progressRoutes','GameRallyController@progressRoutes')->name('progressRoutes');

    //ルート選択画面
    Route::get('/selectRoute','GameRallyController@selectRoute')->name('selectRoute');
    //ポイントチェック画面
    Route::get('/checkPoint','GameRallyController@checkPoint')->name('checkPoint');
    Route::post('/checkPoint','GameRallyController@checkPoint')->name('checkPoint');

    //ポイントチェック処理
    Route::post('/pointJudge','GameRallyController@pointJudge')->name('pointJudge');
    //ゴール表示（モーダル画面に　名前とコメントをいれてもらう）
    Route::get('/pointComplete','GameRallyController@pointComplete')->name('pointComplete');
    Route::post('/pointComplete','GameRallyController@pointComplete')->name('pointComplete');
    //クリア後の処理
    Route::post('/clearRally','GameRallyController@clearRally')->name('clearRally');

    //スコア選択画面
    Route::get('selectScore','GameRallyController@selectScore')->name('selectScore');
    //マイスコア表示
    Route::get('showScore','GameRallyController@showScore')->name('showScore');
    //各ルートスコア選択
    Route::get('selectRouteScore','GameRallyController@selectRouteScore')->name('selectRouteScore');

});
