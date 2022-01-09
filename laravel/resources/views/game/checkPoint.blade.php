@extends('layouts.root')

<!--タイトル-->
@section('title')
近くのポイントをチェックしよう
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/checkPoint.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/mapStartSearch.js') }}" defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyD15q_WbENit79VC9VYY1FWhX92r7Vj_w0&callback=initMap" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!--コンテンツ部分-->
@section('contents')

    <!-- マップ表示　座標選択画面 -->
    <div class="wrapper">
        <!-- 地図部分 -->
        <div class="mapContainer">
            <div class="mapKind">ポイントに近づいてクリック！</div>
            <div class="map" id="map"></div>
        </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            <div id="modalIn" class="NONE"></div>
            <div id="backButton" class="backButton">to Route</div>
        </div>
    </div>

    <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="{{ route('selectRoute') }}" enctype="multipart/form-data">
        @csrf
    </form>

    <!--モーダルウィンドウ　ラリー名・スタート詳細設定画面-->
    <div id="modalWindow" class="modalWindow">
        <div class="modalwrapper">
            <!-- 詳細設定部分 -->
            <div class="configContainer">
                <div class="sectorA">
                    <div class="titleSection"><div class="title">ポイントカード</div></div>
                    <div class="configSection">
                        <div class="itemSection">

                            <!-- 紹介メッセージ表示 -->
                            <div class="multiText">
                                <div class="name">メッセージ</div>
                                <div class="content"><textarea name="text" id="text" class="text" readonly></textarea></div>
                            </div>
                            <!-- 画像とチェックボタン -->

                            <div class="picture">
                                <div class="content"><img class="preview" id="picture"></div>
                                <div class="buttonSection">
                                    <div class="checkButton" id="nextButtonA">ＣＨＥＣＫ</div>
                                </div>
                            </div>

                        </div>
                        <!--
                                緯度　経度　現在時間も送信する
                                この経度緯度情報もおくることで、外部APIでチェックするかどうか等、判断する
                                nowTimeはいらないかも
                        -->
                    </div>
                </div>
            </div>
            <!--モーダルウィンドウ　ボタン部分-->
            <div class="buttonContainer">
                <div id="modalOut" class="backButton">to MAP</div>
            </div>
        </div>

        <!--次のpointJudgeへ送る値-->
        <form method="POST" id="nextActionA" action={{ route('pointJudge') }} enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="point_no" id="point_no">
            <input type="hidden" name="route_code" value="{{ $route_code }}">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="nowTime" id="nowTime">
        </form>
    </div>
    <script>
        /*googlemapAPI(javascript)へポイントのデータを送る*/
        window.Laravel = {};
        window.Laravel.table = @json($table);
    </script>
@endsection
