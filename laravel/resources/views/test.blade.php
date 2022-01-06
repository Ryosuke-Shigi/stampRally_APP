@extends('layouts.root')

<!--タイトル-->
@section('title')
ポイントチェック
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/test.css') }}" rel="stylesheet">
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
            <div class="mapKind">チェックしたいマーカーをクリック</div>
            <div class="map" id="map"></div>
        </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            <div id="modalIn" class="NONE"></div>
            <div id="backButton" class="backButton">別ラリーへ</div>
        </div>
    </div>

    <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="" enctype="multipart/form-data">
        @csrf
    </form>

    <!--モーダルウィンドウ　ラリー名・スタート詳細設定画面-->
    <div id="modalWindow" class="modalWindow">
        <div class="modalwrapper">
            <!-- 詳細設定部分 -->
            <div class="configContainer">
                <div class="sectorA">
                    <div class="titleSection"><div class="title">ラリー名・スタート位置詳細を設定してください</div></div>
                    <div class="configSection">
                    <form method="POST" id="nextActionA" action={{ route('makeStart') }} enctype="multipart/form-data">
                        @csrf
                        <div class="itemSection">

                            <!-- ラリーの名前 -->
                            <div class="singleText">
                                <div class="name">R A L L Y　N A M E（※必須）</div>
                                <div class="content"><input type="text" id="route_name" class="text" name="name" readonly></div>
                            </div>


                            <!-- 紹介メッセージ -->
                            <div class="multiText">
                                <div class="name">紹 介 メ ッ セ ー ジ（※必須）</div>
                                <div class="content"><textarea name="text" id="text" class="text" readonly></textarea></div>
                            </div>


                            <!-- 写真追加 -->
                            <div class="picture">
                                <div class="content"><img class="preview" id="picture"></div>
                                {{-- <img src="" id="picture"> --}}

                                <div class="buttonSection">
                                    <div class="pictButton" id="pictureSelect">チェック</div>
{{--                                     <input type="file" class="NONE" accept="img/*,.jpg,.jpeg,.png,.gif,.bmp" name="pict" id="pictureButton">
 --}}                                </div>
                            </div>

                        </div>
                        <!-- 緯度　経度　現在時間も送信する -->
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="nowTime" id="nowTime">
                    </form>
                    </div>
                </div>
            </div>
            <!--モーダルウィンドウ　ボタン部分-->
            <div class="buttonContainer">
                <div id="modalOut" class="backButton">Back</div>
            </div>
        </div>
        <?php
            dump($table);
            //dump(array('test'=>1,'test2'=2));
        ?>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.table = @json($table);

    </script>
@endsection
