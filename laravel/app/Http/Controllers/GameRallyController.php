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

    public function test(){
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


}
