// googleMapsAPIを持ってくるときに,callback=initMapと記述しているため、initMap関数を作成
function initMap() {

    //変数宣言
    let mapObj;             //マップオブジェクト
    let init_position;      //初期位置 lat: lng:
    let init_marker;        //現在位置用マーカー
    let activeMarker;       //位置指定中マーカー
    let markers = new Array();  //つけたポイントのマーカー保存
    let table = JSON.stringify(Laravel.table);
    table = JSON.parse(table);


    //現在地取得 ： Promise化
    //navigator.geolocation.getcurrentposition
    //中心の座標を取得
    /*var latlng=mapObj.getCenter(); */
    //返し値はないのでpromiseオブジェクトにまとめて、resolve,rejectを返す形に作る。
    //重要：：
    let getPosition = new Promise(function(resolve,reject){//promiseでgetPositionを作成

        //一度だけ通る（MAP初期　現在地を取得してセッティング
        //現在地を取得
        navigator.geolocation.getCurrentPosition(   //一度だけ現在地取得　 //定期的にとる 　navigator.geolocation.watchPosition(  移動ルート取得するのに使いそう
            function(pos){
                //pos.coords.heading 方角
                init_position={lat:pos.coords.latitude,lng:pos.coords.longitude};//連想配列 "lat"=>現在の緯度 "lng"=>現在の経度 latLng
                //現在位置で、bladeに保存する緯度経度を初期化
                //cords.latitude longitudeは現在位置での変数であることに注意！！
                document.getElementById('latitude').value = pos.coords.latitude;
                document.getElementById('longitude').value = pos.coords.longitude;
                document.getElementById('nowTime').value = pos.timestamp;


                resolve();
            }
        );
    });


    //初期設定　現在地設定
    //Promiseオブジェクト
    getPosition.then(function(){    //成功resolve
        let center_position;    //表示位置のセンター

        //緯度経度をBladeから受け取る
        //ルート選択直後はー１　以降は直前に登録したPOINTの緯度経度を取得する
        let init_latitude = JSON.stringify(Laravel.latitude);
        let init_longitude = JSON.stringify(Laravel.longitude);
        init_latitude = JSON.parse(init_latitude);
        init_longitude = JSON.parse(init_longitude);
        //初期緯度経度を取得　ー１であった場合　現在地を初期位置にする
        if(init_latitude == -1 && init_longitude == -1){
            center_position=init_position;  //初期位置を現在地に
        }else{
            center_position={lat:parseFloat(init_latitude),lng:parseFloat(init_longitude)};
        }
        console.log(center_position);


        // mapインスタンス化用：オプションを設定 連想配列で作成
        let opt = {
            zoom: 15,                           //地図の縮尺を指定
            center: center_position,              //現在地からスタート
            disableDoubleClickZoom: true,       //ダブルクリックによるズームをさせない falseで可能になる
            mapTypeControl: false,              //地図・航空地図切り替えをなくす
            fullscreenControl: false,           //全体画面表示ボタンキャンセル
            streetViewControl: false            //ストリートビューボタンキャンセル
        };


        // 地図のインスタンスを作成します。第一引数にはマップを描画する領域、第二引数にはオプションを指定

        // mapはgooglemap.blade.phpのdivのid
        mapObj = new google.maps.Map(document.getElementById("map"), opt);

        //マーカーを設置(初期位置に)
        init_marker = new google.maps.Marker({
            // ピンを差す位置を決めます。
            position: init_position,//経度・緯度で指定
            // ピンを差すマップを決めます。 上記の地図のインスタンス
            //17行目の作成した地図のインスタンス
            map: mapObj,
            // ホバーしたときに「tokyotower」と表示されるようにします。
            title: '現在地',
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
            map_icon_label:'<span class=""></span>',
            label: {
                text: '現',                           //ラベル文字
                color: '#FFFFFF',                    //文字の色
                fontSize: '10px'                     //文字のサイズ
            }
        });

        //定期的（自分の位置が移動していることを認識されたら）
        //自分をさすマーカーを移動させる
        navigator.geolocation.watchPosition(function(pos){
            //pos.coords.heading 方角
            init_position={lat:pos.coords.latitude,lng:pos.coords.longitude};//連想配列 "lat"=>現在の緯度 "lng"=>現在の経度 latLng
            //自分の位置のマーカーを更新する
            //ひとまずマーカーを消す
            init_marker.setMap(null);
            //新しくマーカーをつける
            init_marker=new google.maps.Marker({
                position:init_position,          //位置
                map:mapObj,                     //どの地図に入れるか
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
                    text: "",
                    color: '#FFFFFF',                    //文字の色
                    fontSize: '10px'                     //文字のサイズ
                }
            });

        });


        //シングルクリックでマーカー（どこを登録するか）作成
        google.maps.event.addListener(mapObj, 'click', function(pos)
        {
            //マーカーが存在していたら
            if(activeMarker != null){
                //指定中マーカーを消す
                activeMarker.setMap();
            }

            //現在日時取得
            let nowDate = new Date();

            //Bladeにチェックした位置を保存
            document.getElementById('latitude').value = pos.latLng.lat();
            document.getElementById('longitude').value = pos.latLng.lng();
            document.getElementById('nowTime').value = nowDate.getTime();

            //中心へ移動
            //mapObj.panTo(e.latLng);

            //指定中マーカー作成
            activeMarker=new google.maps.Marker({
                position:pos.latLng,          //位置
                map:mapObj,                     //どの地図に入れるか
                title:"経度："+pos.latLng.lat()+" 緯度："+pos.latLng.lng()+" チェック時間："+nowDate.getTime()         //マウスをホバーした時にでるタイトルDate(pos.timestamp)

            });
        });


                //////////////////////////////////////////////////////////////////
        /*
        /*      つけたポイントのマーカーを表示する
        */
        //テーブルで送られてきたデータ分　マーカーを設置する
        // tableデータ table マーカー保存用空配列 markers
        if(table != -1){
            for(let key in table){
                let tempLatLng=new google.maps.LatLng(table[key].latitude,table[key].longitude)
                //ルートマーカー設置(初期位置に)
                let tempMarker = new google.maps.Marker({
                    // ピンを差す位置を決めます。
                    position: tempLatLng,//経度・緯度で指定
                    // ピンを差すマップを決めます。 上記の地図のインスタンス
                    map: mapObj,
                    // ホバーしたときに
                    title: " ",
                    animation: google.maps.Animation.DROP,
                    icon: {
                        url:  'https://mt.googleapis.com/vt/icon/name=icons/onion/SHARED-mymaps-container_4x.png,icons/onion/1500-shape_square_4x.png&highlight=ff5252&scale=1.7', //円を指定
                    },
                    //現在地アイコン
                    //map_icon_label:'<span class=""></span>',
                    label: {
                        text:String(table[key].point_no),
                        //text: String(table[key].point_no),                           //ラベル文字
                        color: '#FF0000',                    //文字の色
                        fontSize: '15px'                     //文字のサイズ
                    }
                });
                markers.push(tempMarker);
            }
        }


        //検索窓の設置
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        //位置指定
        mapObj.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
        //地図の見えている範囲に変化があった時に発火
        //ビューポートの境界を取得
        mapObj.addListener("bounds_changed", () => {
            searchBox.setBounds(mapObj.getBounds());
        });

        //サーチボックスに変化があった時
        searchBox.addListener("places_changed", () => {
            ////"place_chaged"イベントはAutoCompleteクラスのイベント.
            const places = searchBox.getPlaces();
            ////"getPlaces"メソッドはクエリ(検索キーワード)を配列(PlaceResult)で返す。

            //検索した場所がどこにもなければなにもしない
            if (places.length == 0) {
                return;
            }

            //移動
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            ////"LatLngBounds"クラスは境界を作るインスンタンスを作成。引数は左下、右上の座標。
            places.forEach((place) => {
                if (place.geometry.viewport) {
                    ////viewport"メソッド
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                    ////"union"メソッドはLatLngBoundsクラスのメソッド。自身の境界に指定した境界を取り込んで合成する。
                    ////https://lab.syncer.jp/Web/API/Google_Maps/JavaScript/LatLngBounds/union/
                    } else {
                    bounds.extend(place.geometry.location);
                    ////"extend"メソッドはLatLngBoundsクラスのメソッド。自身の境界に新しく位置座標を追加する。
                    ////https://lab.syncer.jp/Web/API/Google_Maps/JavaScript/LatLngBounds/extend/
                    }
            });
            mapObj.fitBounds(bounds);
        });
        // 検索窓　ここまで





    });//非同期処理　Promise 終了






}//function init ここまで：
