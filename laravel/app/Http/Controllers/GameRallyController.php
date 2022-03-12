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
    public function __construct(){$this->middleware('auth');}


    /////////////////////////////////////////////////////////////
    //
    //      選択・移動・表示
    //
    /////////////////////////////////////////////////////////////
    //play game score選択画面
    public function selectMode(){return view('route.selectMode');}
    //ＥＤＩＴ選択画面
    public function selectCreate(){return view('route.selectCreate');}
    //ルート検索画面
    public function searchRoutes(){return view('route.searchRoutes');}
    //スコア表示選択画面
    public function selectScore(){return view('route.selectScore');}



    //ルートスコア表示選択画面（全ての公開ルートを表示する)
    public function selectRouteScore(){
        $client = new Client();
        $param = array();
        $dataUrl = config('services.web.stamprally_API').'/route/allRoutes';
        //外部APIを叩く
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //取得したテーブルデータを返す
        return view('route.selectRouteScore',['table'=>json_decode($response->getBody()->getContents())->table]);
    }


    ///////////////////////////////////////////////////////////
    //
    //  ルート選択画面（ALLとキーワード検索両方）
    //
    //  ※ キーワードも送られてくると、キーワード検索をかけて値を返す
    //
    ///////////////////////////////////////////////////////////

    public function selectRoute(REQUEST $request){
        $client = new Client();
        $param = array();
        //もしキーワードが入っていればキーワード検索
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

    //進行中ルートを表示する
    public function progressRoutes(REQUEST $request){
        //進行中ルートがクリア状態か判断(途中戻る等をおして、処理途中でおわった場合のための対応)



        //クリア状態でなければ
        $client = new Client();
        $param = array();
        $dataUrl = config('services.web.stamprally_API').'/route/progressRoutes';
        $param += array(
                        'connect_id'=>auth()->user()->connect_id,
                        );
        //外部APIを叩く
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //取得したテーブルデータを返す
        return view('game.selectRoute',['table'=>json_decode($response->getBody()->getContents())->table]);
    }




    //////////////////////////////////////////////////////////////////////////////////
    //
    //  ポイント選択画面表示（マップ表示）
    //
    //  新規に始める場合、『　自動的にstatusテーブルにデータが作成』　される
    //  進行中であれば、stampで保存されていない、残りのチェックポイントが表示される
    //  外部APIの扱い方で　次のポイントだけ　とか制限できそう
    //
    ///////////////////////////////////////////////////////////////////////////////////

    public function checkPoint(REQUEST $request){
        //変数宣言
        $client = new Client();
        $remainPoint = 0;//残りポイント数

        //表示前に、そのコースがクリア済みであるかどうかを確認（途中処理分断で残っている場合を想定）
        $dataUrl = config('services.web.stamprally_API').'/point/remainPoint';
        $param=array(
            'connect_id'=>auth()->user()->connect_id,
            'route_code'=>$request->route_code,
        );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        $remainPoint=json_decode($response->getBody()->getContents())->remainPoint;



        //もし、ポイントを全部クリアしていれば（変なエラーで２つ以上あった場合を想定してマイナスも考慮にいれる）
        if($remainPoint <= 0){
            //クリア処理
            return redirect()->route('pointComplete',['route_code'=>$request->route_code]);
        }





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



    ///////////////////////////////////////////////////////////////////////////////////////////////
    /*
        クリックしたポイントをチェックする
        $requestで送られてくるもの
        point_no        ポイントNO
        route_code      ルートコード
        latitude        緯度
        longitude       経度
        nowTime         押した時間
    */
    ////////////////////////////////////////////////////////////////////////////////////////////////
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
        if($result->result == 0){
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




    ///////////////////////////////////////////////////////////////////////////////////////
    /*
    //  スタンプラリー 攻略後処理
    */
    //////////////////////////////////////////////////////////////////////////////////////
    public function pointComplete(ReQUEST $request){
        $client = new Client();
        //ゴールの情報を取得 必要なのはroute_codeのみ
        $dataUrl = config('services.web.stamprally_API').'/goal/callGoal';
        //必要なのはconnect_idとroute_code
        //外部APIで その人はそのルートを進行中か、進行中であれば残ったポイントを返す
        $param=array(
                        //'connect_id'=>auth()->user()->connect_id,
                        'route_code'=>$request->route_code,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        return view('game.showGoal',['table'=>json_decode($response->getBody()->getContents())->table,
                                    'route_code'=>$request->route_code]);
    }
    //  クリア後の名前とコメントを受け取って処理
    //  ルート選択画面の手前まで戻る
    public function clearRally(REQUEST $request){
        //クリア後処理
        $client = new Client();
        //攻略後の名前と一言コメントを作成させる
        $dataUrl = config('services.web.stamprally_API').'/score/create';
        $param=array(
                        'connect_id'=>auth()->user()->connect_id,
                        'route_code'=>$request->route_code,
                        'name'=>$request->name,
                        'text'=>$request->text
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        $result = json_decode($response->getBody()->getContents());
        //ルート検索画面へ戻る
        return redirect()->route('searchRoutes');
    }





    ///////////////////////////////////////////////////////////////////////////////
    //
    //  スコア表示画面
    //  引数が何もなければ、自分自身のスコア
    //          route_codeがはいっていれば、そのルートのスコアを返す
    //
    ///////////////////////////////////////////////////////////////////////////////
    public function showScore(REQUEST $request){
        $client = new Client();
        $param = array();
        //接続先API
        $dataUrl = "";

        if(isset($request->route_code)){
            $dataUrl = config('services.web.stamprally_API').'/score/showRouteScore';
            $param += array(
                'route_code'=>$request->route_code,
                );
        }else{
            $dataUrl = config('services.web.stamprally_API').'/score/showScore';
            $param += array(
                'connect_id'=>auth()->user()->connect_id,
                );
        }
        //外部APIを叩く
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //取得したテーブルデータを返す
        return view('route.showScore',['table'=>json_decode($response->getBody()->getContents())->table]);
    }

}
