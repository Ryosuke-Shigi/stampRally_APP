<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ROUTE_SET;        //ルート名・紹介文・画像は可能な形式のみ
use App\Http\Requests\POSITION_SET;     //画像は可能な形式のみ
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


    // スタートポイント選択画面表示
    public function selectStart(){
        //ユーザIDの取得はこれでよい　２０２１　１２　１８
        return view('create.selectStart');
    }



    // ルート作成画面画面表示
    public function createRoute(){
        //ユーザIDの取得はこれでよい　２０２１　１２　１８
        return view('create.createRoute');
    }

    // ポイント選択画面表示
    public function selectPoint($route_code,$route_name,$point_no){
        return view('create.selectPoint')
                        ->with('route_code',$route_code)
                        ->with('route_name',$route_name)
                        ->with('point_no',$point_no);
    }
    // ゴール設定画面
    public function settingGoal($route_code,$route_name){
        return view('create.settingGoal')
                        ->with('route_code',$route_code)
                        ->with('route_name',$route_name);
    }
    //ポイント追加選択画面
    public function addPoint(REQUEST $request,$route_code,$route_name,$point_no){
        return view('create.addPoint')
                        ->with('route_code',$route_code)
                        ->with('route_name',$route_name)
                        ->with('point_no',$point_no+1);
    }




    // スタートポイント選択画面からポイント選択画面へ　※テーブルにスタートデータを登録する
    public function makeStart(ROUTE_SET $request){
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
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        $route_code = json_decode($response->getBody()->getContents())->route_code;
        //スタートの保存
        $dataUrl = config('services.web.stamprally_API').'/start/create';
        $param=array(
                    'connect_id'=>auth()->user()->connect_id,
                    'route_code'=>$route_code,
                    'text'=>$request->text,
                    'latitude'=>$request->latitude,
                    'longitude'=>$request->longitude,
                    'pict'=>$pictPath,
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        $point_no = 0;  //start画面からまずselectpointへいく時はpoint_noは初期値の０である必要がある
        //ポイント選択画面へ移動
        return redirect()->route('selectPoint',['route_code'=>$route_code,'route_name'=>$request->name,'point_no'=>0]);
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
                    );
        $response = $client->request('POST',$dataUrl,['json'=>$param]);
        //返ってきたルートコードを取得
        $route_code = json_decode($response->getBody()->getContents())->route_code;
        //ポイント選択画面へ移動
        return redirect()->route('selectPoint',['route_code'=>$route_code,'route_name'=>$request->name,'point_no'=>1]);
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
        return redirect()->route('addPoint',['route_code'=>$route_code,'route_name'=>$route_name,'point_no'=>$point_no]);
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

        return redirect()->route('createRoute');
    }




        //　ポイント選択画面から　戻るボタンをクリックした際の処理　（作成したルートを丸ごと削除）
    public function reCreateRoute(REQUEST $request){
        //routeDelete
        //外部制約でルート以下データが丸ごと削除される
        $client = new Client();
        $dataUrl = config('services.web.stamprally_API').'/route/delete';
        $param=array(
            'connect_id'=>auth()->user()->connect_id,
            'route_code'=>$request->route_code,
            );
        $client->request('GET',$dataUrl,['json'=>$param]);
        return redirect()->route('createRoute');
    }


/*     //　ポイント選択画面から　戻るボタンをクリックした際の処理　（startで設定したテーブルデータを削除する）
    public function reSelectStart(REQUEST $request){
        //routeDelete
        $client = new Client();
        $dataUrl = config('services.web.stamprally_API').'/route/delete';
        $param=array(
            'connect_id'=>auth()->user()->connect_id,
            'route_code'=>$request->route_code,
            );
        $client->request('GET',$dataUrl,['json'=>$param]);
        return redirect()->route('selectStart');
    } */

}
