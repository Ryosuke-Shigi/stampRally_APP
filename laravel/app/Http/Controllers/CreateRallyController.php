<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\POSITION_SET;
//use Facade\FlareClient\Http\Client;
//guzzle ｗｅｂＡＰＩを叩く
use GuzzleHttp\Client;

class CreateRallyController extends Controller
{
    //ログイン等認証対象　コンストラクタ
    public function __construct()
    {
        $this->middleware('auth');
    }


    //　スタートポイント選択画面表示
    public function selectStart(){
        //ユーザIDの取得はこれでよい　２０２１　１２　１８
        $user_id=auth()->user()->user_id;
        return view('selectStart');
    }
    // ポイント選択画面表示
    public function selectPoint(){
        return view('selectPoint');
    }


    // スタートポイント選択画面からポイント選択画面へ　※テーブルにスタートデータを登録する
    public function makeStart(POSITION_SET $request){

        dump($request->name);
        dump($request->message);
        dump($request->latitude);
        dump($request->longitude);
        dump($request->nowTime);

        if(isset($request->picture) && $request->file('picture')->isValid()){
                dump($request->file("picture")->getPathname());
        }
        //スタートのテーブルデータ作成処理
        $user_id=auth()->user()->user_id;   //user_id取得

        //webAPI rallyapiを叩く
        $client = new Client();
/*         $url = "http://127.0.0.1:8075/api/start/delete/";
        //$response = $client->request('GET',$url);
        $param=array('name'=>$request->name,
                    'message'=>$request->message,
                    'latitude'=>$request->latitude,
                    'longitude'=>$request->longitude,
                    'time'=>$request->nowTime);
        $response = $client->request('get',$url,['json'=>"2"]);
        dump($response);
 */        $url = "http://127.0.0.1:8075/api/start/delete/";
        $response = $client->request('GET',$url);
        dump($response);

        //ポイント選択画面へ移動
        return redirect()->route('selectPoint');
    }
    // スタートポイント選択画面からポイント選択画面へ　※テーブルにスタートデータを登録する
    public function makePoint(){

        //ポイントのテーブルデータ作成処理
        $user_id=auth()->user()->user_id;   //user_id取得

        return redirect()->route('selectPoint');
    }



    //　ポイント選択画面から　戻るボタンをクリックした際の処理　（startで設定したテーブルデータを削除する）
    public function reSelectStart(REQUEST $request){

        //スタートのテーブルデータ削除


        return redirect()->route('selectStart');
    }

}
