<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\POSITION_SET;
//use Facade\FlareClient\Http\Client;
use Storage;
//guzzle ｗｅｂＡＰＩを叩く
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;

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

        //画像が存在しているか　また　アップロードは成功しているかどうか
        if($request->hasFile('pict') && $request->file('pict')->isValid()){
            //webAPI rallyapiを叩く
            $client = new Client();
            //画像保存
            //画像を保存してＰＡＴＨを取得。　外部ＷＥＢで行うことで　ファイルの取扱を統一
            $pictUrl = \WebApi::API_ADRESS."/createPict";
            $picture = Utils::tryFopen($request->file('pict')->getPathname(), 'r');
            //$picture = fopen($request->file('pict')->getPathname(),'r');

            $pictPath = $client->request('POST',$pictUrl,['multipart'=>[['name'=>'name','contents'=>$request->file('pict')->getClientOriginalName()],
                                                                        ['name'=>'mimeType','contents'=>$request->file('pict')->getMimeType()],
                                                                        ['name'=>"pict",'contents'=>$picture]]]);

            dump($request->file('pict'));

            //スタート地点の保存
            $dataUrl = \WebApi::API_ADRESS.'/start/create';
            $param=array(
                        'user_id'=>auth()->user()->user_id,
                        'name'=>$request->name,
                        'introduction'=>$request->introduction,
                        'latitude'=>$request->latitude,
                        'longitude'=>$request->longitude,
                        'time'=>$request->nowTime,
                        'pict'=>$pictPath,
                        );

            $response = $client->request('POST',$dataUrl,['json'=>$param]);

            dump($response);
        }else{
            dump('画像がないときの処理');
        }

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
