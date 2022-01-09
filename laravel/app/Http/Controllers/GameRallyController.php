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
    //table データをview(selectRoutes)に渡して表示させる
    //送られてくるkeywordによって内容を変えて表示など
    //ルート表示を共通化させる
    //キーワードで狭めたり、ユーザが進行中のもののみ　とか
    //制限をかけたテーブルデータを渡して表示を多様化させる

    //引数なしでも動きます

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


    //ポイント選択画面をマップ表示
    //新規に始める場合、『　自動的にstatusテーブルにデータが作成』　される
    //進行中であれば、stampで保存されていない、残りのチェックポイントが表示される
    //外部APIの扱い方で　次のポイントだけ　とか制限できそう

    //　connect_id と　route_code　が必要

    public function checkPoint(REQUEST $request){
        $client = new Client();
        //チェックするポイントの呼び出し
        $dataUrl = config('services.web.stamprally_API').'/point/callPoints';
        //必要なのはconnect_idとroute_code
        //外部APIで その人はそのルートを進行中か、進行中であれば残ったポイントを返す
        $param=array(
                        'connect_id'=>auth()->user()->connect_id,
                        'route_code'=>$request->route_code,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        return view('game.checkPoint',['route_code'=>$request->route_code,
                                        'table'=>json_decode($response->getBody()->getContents())->table
                                        ]);
    }

    /*
        クリックしたポイントをチェックする
        $requestで送られてくるもの
        point_no        ポイントNO
        route_code      ルートコード
        latitude        緯度
        longitude       経度
        nowTime         押した時間
    */
    public function pointJudge(REQUEST $request){
        //ポイントが距離内かの判断する外部API
        //OK　であれば   result TRUE  と remainPointNum 残りポイント数
        //FALSE であれば result FALSE と remainPointNum 残りポイント数
        //ポイント数が０であればゴールを取得表示して　ルート選択画面へ
        //ポイント数がまだ残っていれば　checkPointへ戻る


        //ポイントチェックしてOKが出て まだチェックしていないポイントがあれば
        //ポイントチェック画面へ戻る
        $client = new Client();
        //チェックするポイントの呼び出し
        $dataUrl = config('services.web.stamprally_API').'/game/pointJudge';
        //必要なのはconnect_idとroute_code
        //外部APIで その人はそのルートを進行中か、進行中であれば残ったポイントを返す
        $param=array(
                        'connect_id'=>auth()->user()->connect_id,
                        'route_code'=>$request->route_code,
                        'point_no'=>$request->point_no,
                        'latitude'=>$request->latitude,
                        'longitude'=>$request->longitude,
                        'nowTime'=>$request->nowTime
                    );
        $response = $client->request('GET',$dataUrl,['json'=>$param]);

        dump(json_decode($response->getBody()->getContents()));


        //testのため　ルートセレクト画面へもどす
        $param=array();
        $dataUrl = config('services.web.stamprally_API').'/route/allRoutes';
         //外部APIを叩く
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //取得したテーブルデータを返す
        //return view('game.selectRoute',['table'=>json_decode($response->getBody()->getContents())->table]);
        return redirect()->route('checkPoint',['route_code'=>$request->route_code]);


/*         return view('game.pointCheckResult',['route_code'=>$request->route_code,
                                        'table'=>json_decode($response->getBody()->getContents())->table
                                        ]); */


        //ポイントが全てチェック終了であれば
        //ゴールを表示して その後、selectRouteへ戻る
    }




/*     public function pointJudgeResult(REQUEST $request){


    } */

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
