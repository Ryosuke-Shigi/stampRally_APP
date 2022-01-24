// googleMapsAPIを持ってくるときに,callback=initMapと記述しているため、initMap関数を作成
function initMap() {
    //変数宣言
    let mapObj;             //マップオブジェクト
    let player_position;      //初期位置 lat: lng:
    let player_marker;

    //非同期処理 初期化
    let getPosition = new Promise(function(resolve,reject){//promiseでgetPositionを作成
        //まず最初に現在地を取得　してからじゃないとちゃんと動かないので非同期処理
        navigator.geolocation.getCurrentPosition(   //一度だけ現在地取得　 //定期的にとる 　navigator.geolocation.watchPosition(  移動ルート取得するのに使いそう
            function(pos){
                //pos.coords.heading 方角
                player_position={lat:pos.coords.latitude,lng:pos.coords.longitude};//連想配列 "lat"=>現在の緯度 "lng"=>現在の経度 latLng
                //現在位置で、bladeにはいる緯度経度を初期化
                document.getElementById('latitude').value = pos.coords.latitude;
                document.getElementById('longitude').value = pos.coords.longitude;
                resolve();
                return 0;
            }
        );
    });


    //上記初期設定が終了したらこちらへ
    //Promiseオブジェクト
    getPosition.then(function(){    //成功resolve
        // mapインスタンス化用：オプションを設定 連想配列で作成
        let opt = {
            zoom: 3,                           //地図の縮尺を指定
            center: player_position,              //現在地からスタート
            disableDoubleClickZoom: true,       //ダブルクリックによるズームをさせない falseで可能になる
            mapTypeControl: false,              //地図・航空地図切り替えをなくす
            fullscreenControl: false,           //全体画面表示ボタンキャンセル
            streetViewControl: false            //ストリートビューボタンキャンセル
        };

        // 地図のインスタンスを作成します。第一引数にはマップを描画する領域、第二引数にはオプションを指定
        // mapはgooglemap.blade.phpのdivのid
        mapObj = new google.maps.Map(document.getElementById("map"), opt);
        //ボタン設置
        const input = document.getElementById("mapButton");
        //位置指定してマップにプッシュ
        mapObj.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(input);




        //ユーザのマーカーを設置
        player_marker = new google.maps.Marker({
            // ピンを差す位置を決めます。
            position: player_position,//経度・緯度で指定
            // ピンを差すマップを決めます。 上記の地図のインスタンス
            //17行目の作成した地図のインスタンス
            map: mapObj,
            // ホバーしたときに「tokyotower」と表示されるようにします。
            title: " ",
            animation: google.maps.Animation.BOUNCE,    //アニメーション
            icon: {
                fillColor: "#FF0000",                //塗り潰し色
                fillOpacity: 0.5,                    //塗り潰し透過率
                path: google.maps.SymbolPath.CIRCLE, //円を指定
                scale: 12,                           //円のサイズ
                strokeColor: "#000000",              //枠の色
                strokeWeight: 1.0                    //枠の透過率
            },
            label: {
                text: " ",
                color: '#FFFFFF',                    //文字の色
                fontSize: '10px'                     //文字のサイズ
            }
        });

        //定期的（自分の位置が移動していることを認識されたら）に
        //自分をさすマーカーを移動させる
        navigator.geolocation.watchPosition(function(pos){
            //pos.coords.heading 方角
            player_position={lat:pos.coords.latitude,lng:pos.coords.longitude};//連想配列 "lat"=>現在の緯度 "lng"=>現在の経度 latLng
            //mapObj.panTo(g_latLng);
            //BLADEのデータも更新する
            //これを利用してリアルタイムの座標を取得していく
            document.getElementById('latitude').value = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;
            //自分の位置のマーカーを更新する
            //ひとまずマーカーを消す
            player_marker.setMap(null);
            //新しくマーカーをつける
            player_marker=new google.maps.Marker({
                position:player_position,          //位置
                map:mapObj,                     //どの地図に入れるか
                title:" ",
                animation: google.maps.Animation.BOUNCE,    //アニメーション
                icon: {
                    fillColor: "#FF0000",                //塗り潰し色
                    fillOpacity: 0.5,                    //塗り潰し透過率
                    path: google.maps.SymbolPath.CIRCLE, //円を指定
                    scale: 12,                           //円のサイズ
                    strokeColor: "#000000",              //枠の色
                    strokeWeight: 1.0                    //枠の透過率
                },
                label: {
                    text: " ",
                    color: '#FFFFFF',                    //文字の色
                    fontSize: '10px'                     //文字のサイズ
                }
            });

        });
        //現在地更新
        setInterval(function(){
            navigator.geolocation.getCurrentPosition(
                function(pos){
                    //pos.coords.heading 方角
                    player_position={lat:pos.coords.latitude,lng:pos.coords.longitude};//連想配列 "lat"=>現在の緯度 "lng"=>現在の経度 latLng
                    //更新される度に、ブレードの値を変更
                    document.getElementById('latitude').value = pos.coords.latitude;
                    document.getElementById('longitude').value = pos.coords.longitude;
                    //mapObj.panTo(g_latLng);
                    player_marker.setMap(null);
                    //新しくマーカーをつける
                    player_marker=new google.maps.Marker({
                        position:player_position,          //位置
                        map:mapObj,                     //どの地図に入れるか
                        title:" ",
                        animation: google.maps.Animation.BOUNCE,    //アニメーション
                        icon: {
                            fillColor: "#FF0000",                //塗り潰し色
                            fillOpacity: 0.5,                    //塗り潰し透過率
                            path: google.maps.SymbolPath.CIRCLE, //円を指定
                            scale: 12,                           //円のサイズ
                            strokeColor: "#000000",              //枠の色
                            strokeWeight: 1.0                    //枠の透過率
                        },
                        //現在地アイコン
                        //map_icon_label:'<span class=""></span>',
                        label: {
                            text: " ",
                            color: '#FFFFFF',                    //文字の色
                            fontSize: '10px'                     //文字のサイズ
                        }
                    });
                }
            );
        },2130);//1秒ごとに




        //ISS（宇宙国際ステーションの位置をとり、マーカーで表示する
/*         var iss = new XMLHttpRequest();
        var iss_marker;
        iss.onload = function(){
            let data = this.response;
            data = JSON.parse(data);
            let g_lat=data.iss_position.latitude;
            let g_lng=data.iss_position.longitude;
            let g_latLng=new google.maps.LatLng(g_lat,g_lng);
            //alert(lat+lng);
            mapObj.panTo(g_latLng);
            if(iss_marker != null){
                iss_marker.setMap(null);
            }
            iss_marker=new google.maps.Marker({
                position:g_latLng,          //位置
                map:mapObj,                     //どの地図に入れるか
            });
        }
        setInterval(function(){
            iss.open('get','http://api.open-notify.org/iss-now.json');
            iss.send();
        },500);
 */

        //fetchを使用してISSデータ取得
        //heroku では httpsでアクセスしている
        //ISSはhttpであり、httpsからhttpへのアクセスは混在コンテンツとなりはじかれる
        var iss_marker;
        const ISSdata = new FormData();
        setInterval(function(){
            fetch('http://api.open-notify.org/iss-now.json')
            .then((response)=>{
                return response.json();
            })
            .then((json)=>{
                let data = json;
                let g_lat=data.iss_position.latitude;
                let g_lng=data.iss_position.longitude;
                let g_latLng=new google.maps.LatLng(g_lat,g_lng);
                //alert(lat+lng);
                mapObj.panTo(g_latLng);
                if(iss_marker != null){
                    iss_marker.setMap(null);
                }
                iss_marker=new google.maps.Marker({
                    position:g_latLng,          //位置
                    map:mapObj,                     //どの地図に入れるか
                });            })
            .catch((reason)=>{
                //エラー
            });
        },1500);



    });//非同期処理　Promise 終了






}//function init ここまで：
