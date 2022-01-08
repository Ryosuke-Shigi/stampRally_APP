<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Facade\FlareClient\Http\Client;
use Storage;
//guzzle ｗｅｂＡＰＩを叩く
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;


class GameRallyController extends Controller
{
    //ログイン等認証対象　コンストラクタ
    public function __construct()
    {
        $this->middleware('auth');
    }
    //ルート選択画面
    //なんであれ、table というデータを返す
    //送られてくるkeywordによって内容を変えて表示、共通化させる
    public function selectRoute(REQUEST $request){
        $client = new Client();
        $param = array();
        //キーワードが入っていなければ、全てのルートを返す
        if(isset($request->keyword)){
            $dataUrl = config('services.web.stamprally_API').'/route/keySearchRoutes';
            $param += array(
                            //'connect_id'=>auth()->user()->connect_id,
                            'keyword'=>$request->keyword
                            );
        }else{
            $dataUrl = config('services.web.stamprally_API').'/route/allRoutes';
        }
        //外部APIを叩く
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //取得したテーブルデータを返す
        return view('game.selectRoute',['table'=>json_decode($response->getBody()->getContents())->table]);
    }
    //ポイントをマップ表示
    //新規に始める場合、自動的にstatusテーブルにデータが作成される
    //進行中であれば、stampで保存されていない、残りのチェックポイントが表示される
    //外部APIの扱い方で　次のポイントだけ　とか制限できそう
    public function checkPoint(REQUEST $request){
        $client = new Client();
        //チェックするポイントの呼び出し
        $dataUrl = config('services.web.stamprally_API').'/point/callPoints';
        $param=array(
                        'connect_id'=>auth()->user()->connect_id,
                        'route_code'=>$request->route_code,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        return view('game.checkPoint',['table'=>json_decode($response->getBody()->getContents())->table]);
    }

    //チェックしたポイントが距離内にあるか判断してもらう（外部API）に
    public function handingCheckPoint(REQUEST $request){

        return ;
    }

/*     public function test(){
        $client = new Client();
        //ポイントの保存
        $dataUrl = config('services.web.stamprally_API').'/point/allPoints';
        $param=array(
                    //'connect_id'=>auth()->user()->connect_id,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //dump(json_decode($response->getBody()->getContents())->table);
        return view('test',['table'=>json_decode($response->getBody()->getContents())->table]);
    }
 */

}
