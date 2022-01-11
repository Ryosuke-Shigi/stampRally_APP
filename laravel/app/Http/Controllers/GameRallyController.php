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
                                        'table'=>json_decode($response->getBody()->getContents())->table,
                                        'message'=>$request->message
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
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        $result = json_decode($response->getBody()->getContents());
        //result・成功か否か・TRUEorFALSE　remainPoint・残りポイント数　が返ってくる
        //チェック成功であれば(距離内でチェックを押していたら)
        if($result->result === 0){
            //残りチェックポイント数が０であれば処理へ
            if($result->remainPoint == 0){
                //クリア処理
                return redirect()->route('pointComplete',['route_code'=>$request->route_code]);
            }else{  //残りポイント数があればポイントチェック画面へ
                //ポイントチェック画面へ戻す
                return redirect()->route('checkPoint',['route_code'=>$request->route_code,
                                                        'message'=>"クリア！次を目指そう！"]);
            }
        }else{  //チェック失敗であれば　失敗画面へいってチェックポイント画面へ戻る
            //ポイントチェック画面へ戻す
            return redirect()->route('checkPoint',['route_code'=>$request->route_code,
                                                    'message'=>"もっとポイントへ近づこう！"]);
        }
    }


    /*
    //
    //  point全てチェック後
    //  route_code が必要
    //  クリア後のbladeを表示する
    //  なのでtableデータでgoalのデータを取得して
    //  bladeからclearRallyへ
    */
    public function pointComplete(ReQUEST $request){
        $client = new Client();
        //チェックするポイントの呼び出し
        $dataUrl = config('services.web.stamprally_API').'/game/callGoal';
        //必要なのはconnect_idとroute_code
        //外部APIで その人はそのルートを進行中か、進行中であれば残ったポイントを返す
        $param=array(
                        //'connect_id'=>auth()->user()->connect_id,
                        'route_code'=>$request->route_code,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);

        return view('test',['table'=>json_decode($response->getBody()->getContents())->table]);
    }
    /*
    //
    //  クリア後の名前とコメントを受け取って処理
    //  scoreレコードを作成して、ルート選択画面の手前まで戻る
    //
    */
    public function clearRally(REQUEST $request){
        //nameとtextを受け取ってクリア後処理の外部APIを叩く
        //終了後、ルート選択画面の手前へリダイレクト

        //クリア後処理
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
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        $result = json_decode($response->getBody()->getContents());



        return 0;
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
