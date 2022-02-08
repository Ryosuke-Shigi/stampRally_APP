<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ROUTE_SET;        //validate ルート名・紹介文・画像は可能な形式のみ
use App\Http\Requests\POSITION_SET;     //vlaidate 画像は可能な形式のみ
//use Facade\FlareClient\Http\Client;
use Storage;
//guzzle ｗｅｂＡＰＩを叩く
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;

class CreateRallyController extends Controller
{
    //ログイン等認証対象　コンストラクタ
    public function __construct(){$this->middleware('auth');}


    // ルート作成画面画面表示
    public function createRoute(){
        //ユーザIDの取得はこれでよい　２０２１　１２　１８
        return view('create.createRoute');
    }

    // ポイント選択画面表示
    public function selectPoint($route_code,$route_name,$latitude,$longitude,$point_no){
        $client = new Client();
        //存在するポイントの呼び出し
        $dataUrl = config('services.web.stamprally_API').'/point/callPoints';
        //必要なのはconnect_idとroute_code
        //外部APIで その人はそのルートを進行中か、進行中であれば残ったポイントを返す
        $param=array(
                        'connect_id'=>auth()->user()->connect_id,
                        'route_code'=>$route_code,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        return view('create.selectPoint')
                        ->with('route_code',$route_code)
                        ->with('route_name',$route_name)
                        ->with('latitude',$latitude)
                        ->with('longitude',$longitude)
                        ->with('table',json_decode($response->getBody()->getContents())->table)
                        ->with('point_no',$point_no);
    }

    // ゴール設定画面
    public function settingGoal($route_code,$route_name){
        return view('create.settingGoal')
                        ->with('route_code',$route_code)
                        ->with('route_name',$route_name);
    }
    //ポイント追加選択画面
    public function addPoint(REQUEST $request,$route_code,$route_name,$latitude,$longitude,$point_no){
        return view('create.addPoint')
                        ->with('route_code',$route_code)
                        ->with('route_name',$route_name)
                        ->with('latitude',$latitude)
                        ->with('longitude',$longitude)
                        ->with('point_no',$point_no+1);//ポイントNOを＋１する
    }


    // ルート作成画面からポイント選択画面へ　※テーブルにスタートデータを登録する
    public function makeRoute(ROUTE_SET $request){
        //画像が存在すれば・保存する　pathが必要なので一番最初に処理
        //webAPI rallyapiを叩く
        $client = new Client();
        //画像が存在しているか　また　アップロードは成功しているかどうか
        if($request->hasFile('pict')){
            //画像保存
            //画像を保存してＰＡＴＨを取得。　外部ＷＥＢで行うことで　ファイルの取扱を統一
            $pictUrl = config('services.web.stamprally_API')."/createPict";
            $picture = Utils::tryFopen($request->file('pict')->getPathname(), 'r');
            $pict = $client->request('POST',$pictUrl,['multipart'=>[['name'=>'name','contents'=>$request->file('pict')->getClientOriginalName()],
                                                                    ['name'=>'mimeType','contents'=>$request->file('pict')->getMimeType()],
                                                                    ['name'=>"pict",'contents'=>$picture]]]);
            $pictPath = json_decode($pict->getBody()->getContents())->path;
        }else{
            //画像がないときは　NULL　をいれる
            $pictPath = NULL;
        }
        //  ルート登録・スタート地点の保存
        //ルートコード初期化
        $route_code="";
        //外部APIより返ってきたレスポンス保存用
        $response=array();
        //ルートの保存
        $dataUrl = config('services.web.stamprally_API').'/route/create';
        $param=array(
                    'connect_id'=>auth()->user()->connect_id,
                    'name'=>$request->name,
                    'keyword'=>$request->keyword,
                    'pict'=>$pictPath,
                    'text'=>$request->text,
                    'mode'=>0,//通常作成
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //返ってきたルートコードを取得
        $route_code = json_decode($response->getBody()->getContents())->route_code;
        //ポイント選択画面へ移動
        //latitude longitudeを-1指定することで 値がない、現在地を初期位置にする処理を行う
        //作成するpoint_noが最初なので１を送る
        return redirect()->route('selectPoint',['route_code'=>$route_code,'route_name'=>$request->name,
                                                'latitude'=>-1,'longitude'=>-1,'table'=>-1,
                                                'point_no'=>1]);
    }


    // ポイント選択画面より ポイント登録処理 selectPoint
    public function makePoint(POSITION_SET $request,$route_code,$route_name,$point_no){
        $client = new Client();
        //画像が存在しているか　また　アップロードは成功しているかどうか
        if($request->hasFile('pict')){
            //画像保存
            //画像を保存してＰＡＴＨを取得。　外部ＷＥＢで行うことで　ファイルの取扱を統一
            $pictUrl = config('services.web.stamprally_API')."/createPict";
            $picture = Utils::tryFopen($request->file('pict')->getPathname(), 'r');
            $pict = $client->request('POST',$pictUrl,['multipart'=>[['name'=>'name','contents'=>$request->file('pict')->getClientOriginalName()],
                                                                    ['name'=>'mimeType','contents'=>$request->file('pict')->getMimeType()],
                                                                    ['name'=>"pict",'contents'=>$picture]]]);
            $pictPath = json_decode($pict->getBody()->getContents())->path;
        }else{
            //画像がないときは　NULL　をいれる
            $pictPath = NULL;
        }

        //ポイントの保存
        $dataUrl = config('services.web.stamprally_API').'/point/create';
        $param=array(
                    'connect_id'=>auth()->user()->connect_id,
                    'route_code'=>$route_code,
                    'latitude'=>$request->latitude,
                    'longitude'=>$request->longitude,
                    'point_no'=>$point_no,
                    'pict'=>$pictPath,
                    'text'=>$request->text,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //ポイント追加選択画面へ移動
        return redirect()->route('addPoint',['route_code'=>$route_code,'route_name'=>$route_name,
                                            'latitude'=>$request->latitude,'longitude'=>$request->longitude,
                                            'point_no'=>$point_no]);
    }

    //ゴール設定処理
    public function makeGoal(POSITION_SET $request,$route_code){
        $client = new Client();
        //画像が存在しているか　また　アップロードは成功しているかどうか
        if($request->hasFile('pict')){
            //画像保存
            //画像を保存してＰＡＴＨを取得。　外部ＷＥＢで行うことで　ファイルの取扱を統一
            $pictUrl = config('services.web.stamprally_API')."/createPict";
            $picture = Utils::tryFopen($request->file('pict')->getPathname(), 'r');
            $pict = $client->request('POST',$pictUrl,['multipart'=>[['name'=>'name','contents'=>$request->file('pict')->getClientOriginalName()],
                                                                    ['name'=>'mimeType','contents'=>$request->file('pict')->getMimeType()],
                                                                    ['name'=>"pict",'contents'=>$picture]]]);
            $pictPath = json_decode($pict->getBody()->getContents())->path;
        }else{
            //画像がないときは　NULL　をいれる
            $pictPath = NULL;
        }
        //ゴールの保存
        $dataUrl = config('services.web.stamprally_API').'/goal/create';
        $param=array(
                    'connect_id'=>auth()->user()->connect_id,
                    'route_code'=>$route_code,
                    'pict'=>$pictPath,
                    'text'=>$request->text,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        return redirect()->route('selectCreate');
    }




        //　ポイント選択画面から　戻るボタンをクリックした際の処理　（作成したルートを丸ごと削除）
    public function reCreateRoute(REQUEST $request){
        //routeDelete
        //外部制約でルート以下データが「丸ごと」削除される
        $client = new Client();
        $dataUrl = config('services.web.stamprally_API').'/route/delete';
        $param=array(
            'connect_id'=>auth()->user()->connect_id,
            'route_code'=>$request->route_code,
            );
        $client->request('GET',$dataUrl,['json'=>$param]);
        return redirect()->route('createRoute');
    }



    /////////////////////////////////////////////////////////////////////////////
    //
    //  NOW TRAVEL
    //
    /////////////////////////////////////////////////////////////////////////////


    //nowTravel選択画面
    //作成中であれば selectNowTravel へ
    //新規であれば   createRouteNowTravel へ
    //route_codeとconnect_idが必要
    public function selectNowTravel(REQUEST $request){
        //作成中のnowTravelがあるか確認
        $client = new Client();
        $dataUrl = config('services.web.stamprally_API').'/route/reasonNowTravelRoute';
        $param=array(
                    'connect_id'=>auth()->user()->connect_id,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        $response=json_decode($response->getBody()->getContents());

        //なければ ルート作成画面へ
        if($response->reason==false){
            //なければ新規作成
            return redirect()->route('createRouteNowTravel');
        }else{
            //あれば、nowTravel項目選択画面へ
            return view('route.selectNowTravel')
                    ->with('route_code',$response->route_code)
                    ->with('route_name',$response->route_name)
                    ->with('pointNum',$response->pointNum);
        }
    }

    //ルート作成画面
    public function createRouteNowTravel(){
        //nowTravel用ルート作成画面
        return view('create.createRouteNowTravel');
    }

    //nowTravelルート作成
    public function makeRouteNowTravel(ROUTE_SET $request){
        //画像が存在すれば・保存する　pathが必要なので一番最初に処理
        //画像保存処理
        $client = new Client();
        //画像が存在しているか　また　アップロードは成功しているかどうか
        if($request->hasFile('pict')){
            //画像保存
            //画像を保存してＰＡＴＨを取得。　外部ＷＥＢで行うことで　ファイルの取扱を統一
            $pictUrl = config('services.web.stamprally_API')."/createPict";
            $picture = Utils::tryFopen($request->file('pict')->getPathname(), 'r');
            $pict = $client->request('POST',$pictUrl,['multipart'=>[['name'=>'name','contents'=>$request->file('pict')->getClientOriginalName()],
                                                                    ['name'=>'mimeType','contents'=>$request->file('pict')->getMimeType()],
                                                                    ['name'=>"pict",'contents'=>$picture]]]);
            $pictPath = json_decode($pict->getBody()->getContents())->path;
        }else{
            //画像がないときは　NULL　をいれる
            $pictPath = NULL;
        }

        //  ルート登録・スタート地点の保存
        $route_code=""; //ルートコード初期化
        $response=array();//外部APIより返ってきたレスポンス保存用
        //ルートの保存
        $dataUrl = config('services.web.stamprally_API').'/route/create';
        $param=array(
                    'connect_id'=>auth()->user()->connect_id,
                    'name'=>$request->name,
                    'keyword'=>$request->keyword,
                    'pict'=>$pictPath,
                    'text'=>$request->text,
                    'mode'=>2,//nowTravel用ルート作成
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //返ってきたルートコードを取得
        $response = json_decode($response->getBody()->getContents());

        return redirect()->route('selectNowTravel');
    }

    //作成中ルート削除
    public function resetNowTravel(REQUEST $request){
        //routeDelete
        //外部制約でルート以下データが「丸ごと」削除される
        //画像の削除処理も行われる
        $client = new Client();
        $dataUrl = config('services.web.stamprally_API').'/route/delete';
        $param=array(
            'connect_id'=>auth()->user()->connect_id,
            'route_code'=>$request->route_code,
            );
        $client->request('GET',$dataUrl,['json'=>$param]);
        //クリエイト選択画面へ
        return redirect()->route('selectCreate');
    }


    //nowTravel用 ポイント作成画面移行処理
    //ルートコードが必要
    public function selectPointNowTravel(REQUEST $request){
        //とりあえずnowTravel用ポイント作成画面
        $client = new Client();
        //マップ上にポイントを表示するため、現存するポイントを抽出
        //published=2で引っ張り出すので connect_idだけでよい
        $dataUrl = config('services.web.stamprally_API').'/point/routePoints';
        //必要なのはconnect_id ※APIでpublished=2のルートを探す
        //外部APIで その人はそのルートを進行中か、進行中であれば残ったポイントを返す
        $param=array(
                        'connect_id'=>auth()->user()->connect_id,
                        'route_code'=>$request->route_code,
                    );
        //現存するポイントのテーブルデータを取り出す
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        $response=json_decode($response->getBody()->getContents());
        return view('create.selectPointNowTravel')
                        ->with('route_code',$request->route_code)
                        ->with('latitude',-1)//-1で現在地
                        ->with('longitude',-1)
                        ->with('table',$response->table)
                        ->with('pointNum',$response->pointNum+1);//ポイント数＋１（現在作成中ポイントNO）
    }

    // ポイント選択画面より ポイント登録処理 selectPoint
    public function makePointNowTravel(POSITION_SET $request,$route_code,$pointNum){
        $client = new Client();
        //画像が存在しているか　また　アップロードは成功しているかどうか
        if($request->hasFile('pict')){
            //画像保存
            //画像を保存してＰＡＴＨを取得。　外部ＷＥＢで行うことで　ファイルの取扱を統一
            $pictUrl = config('services.web.stamprally_API')."/createPict";
            $picture = Utils::tryFopen($request->file('pict')->getPathname(), 'r');
            $pict = $client->request('POST',$pictUrl,['multipart'=>[['name'=>'name','contents'=>$request->file('pict')->getClientOriginalName()],
                                                                    ['name'=>'mimeType','contents'=>$request->file('pict')->getMimeType()],
                                                                    ['name'=>"pict",'contents'=>$picture]]]);
            $pictPath = json_decode($pict->getBody()->getContents())->path;
        }else{
            //画像がないときは　NULL　をいれる
            $pictPath = NULL;
        }

        //ポイントの保存
        $dataUrl = config('services.web.stamprally_API').'/point/create';
        $param=array(
                    'connect_id'=>auth()->user()->connect_id,
                    'route_code'=>$route_code,
                    'latitude'=>$request->latitude,
                    'longitude'=>$request->longitude,
                    'point_no'=>$pointNum,
                    'pict'=>$pictPath,
                    'text'=>$request->text,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //ポイント追加選択画面へ移動
        return redirect()->route('selectNowTravel');
    }

    // ゴール設定画面
    public function settingGoalNowTravel($route_code){
        return view('create.settingGoalNowTravel')
                        ->with('route_code',$route_code);
    }
    //ゴール設定処理
    public function makeGoalNowTravel(POSITION_SET $request,$route_code){
        $client = new Client();
        //画像が存在しているか　また　アップロードは成功しているかどうか
        if($request->hasFile('pict')){
            //画像保存
            //画像を保存してＰＡＴＨを取得。　外部ＷＥＢで行うことで　ファイルの取扱を統一
            $pictUrl = config('services.web.stamprally_API')."/createPict";
            $picture = Utils::tryFopen($request->file('pict')->getPathname(), 'r');
            $pict = $client->request('POST',$pictUrl,['multipart'=>[['name'=>'name','contents'=>$request->file('pict')->getClientOriginalName()],
                                                                    ['name'=>'mimeType','contents'=>$request->file('pict')->getMimeType()],
                                                                    ['name'=>"pict",'contents'=>$picture]]]);
            $pictPath = json_decode($pict->getBody()->getContents())->path;
        }else{
            //画像がないときは　NULL　をいれる
            $pictPath = NULL;
        }
        //ゴールの保存 API内でpublishedは０になる
        $dataUrl = config('services.web.stamprally_API').'/goal/create';
        $param=array(
                    'connect_id'=>auth()->user()->connect_id,
                    'route_code'=>$route_code,
                    'pict'=>$pictPath,
                    'text'=>$request->text,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        return redirect()->route('selectCreate');
    }


    /////////////////////////////////////////////////////////////////////////////
    //
    //  NOW TRAVEL ここまで
    //
    /////////////////////////////////////////////////////////////////////////////




    ///////////////////////////////////////////////////////////////////////////////
    //
    //  ルート削除
    //
    ///////////////////////////////////////////////////////////////////////////////
    //  削除するルートを表示する（connect_idで自分のコースだけを取り出し、表示させる)
    //  なので引数は不要
    public function selectDeleteRoutes(REQUEST $request){
        $client = new Client();
        $param = array(
                        'connect_id'=>auth()->user()->connect_id,
                        );
        $dataUrl = config('services.web.stamprally_API').'/route/myRoutes';
        //外部APIを叩く
        $response = $client->request('POST',$dataUrl,['json'=>$param]);

        //取得したテーブルデータを返す
        return view('create.selectDeleteRoutes',['table'=>json_decode($response->getBody()->getContents())->table]);
    }
    //ルート削除確認チェック
    public function deleteDoubleCHeck(REQUEST $request){
        return view('create.deleteDoubleCheck')
                ->with("route_code",$request->route_code);
    }

    //ルート削除処理
    //引数 route_code
    public function deleteRoute(REQUEST $request){
        //routeDelete
        //外部制約でルート以下データが「丸ごと」削除される
        $client = new Client();
        $dataUrl = config('services.web.stamprally_API').'/route/delete';
        $param=array(
            'connect_id'=>auth()->user()->connect_id,
            'route_code'=>$request->route_code,
            );
        $client->request('GET',$dataUrl,['json'=>$param]);
        return redirect()->route('selectDeleteRoutes');//削除ルート選択画面へ戻る
    }

}
