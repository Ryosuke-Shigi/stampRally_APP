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
        $lat1=	139.646218;
        $lng1= 	35.860984;
        $lat2=139.73707;
        $lng2=35.865436;
        $distance = $this->reDistance($lat1,$lng1,$lat2,$lng2);

        return view('test',['title'=>$distance]);
    }




    //二点間距離
    private function reDistance($lat1,$lng1,$lat2,$lng2){
        $GRS80_A = 6371008;
        $GRS80_E2 = 0.00669438002301188;
        $GRS80_MNUM = 6356752.314245;

        $mu_y = deg2rad($lat1 + $lat2)/2;
        $W = sqrt(1-$GRS80_E2*pow(sin($mu_y),2));
        $W3 = $W*$W*$W;
        $M = $GRS80_MNUM/$W3;
        $N = $GRS80_A/$W;
        $dx = deg2rad($lng1 - $lng2);
        $dy = deg2rad($lat1 - $lat2);

        // 距離をmで算出
        $dist = sqrt(pow($dy*$M,2) + pow($dx*$N*cos($mu_y),2));

        return $dist;
    }
}
