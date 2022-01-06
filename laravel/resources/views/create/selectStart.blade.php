@extends('layouts.root')

<!--タイトル-->
@section('title')
CREATE [start]
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/selectStart.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/createMap.js') }}" defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyBMKajpItMT-Hy-YgCTAvSO13Eefz2OVnY&callback=initMap" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!--コンテンツ部分-->
@section('contents')

    <!-- マップ表示　座標選択画面 -->
    <div class="wrapper">
        <!-- 地図部分 -->
        <div class="mapContainer">
            <div class="mapKind">スタート位置を設定してください MAPクリック後、SETをクリック</S></div>
            <div class="map" id="map"></div>
        </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            <div id="modalIn" class="setButton">SET</div>
            <div id="backButton" class="backButton">Back</div>
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
                                <div class="content"><input type="text" class="text" name="name" value="{{ old('name') }}" autocomplete="off"></div>
                            </div>
                            <!-- エラーメッセージ -->
                            @if($errors->has('name'))<div class="errorMessage">{{ $errors->first('name') }}</div>@endif
                            <!-- 紹介メッセージ -->
                            <div class="multiText">
                                <div class="name">紹 介 メ ッ セ ー ジ（※必須）</div>
                                <div class="content"><textarea name="text" class="text">{{ old('text') }}</textarea></div>
                            </div>
                            <!-- エラーメッセージ -->
                            @if($errors->has('text'))<div class="errorMessage">{{ $errors->first('text') }}</div>@endif
                            <!-- 写真追加 -->
                            <div class="picture">
                                <div class="name">ＰＩＣＴＵＲＥ</div>
                                <div class="content"><img class="preview" id="preview"></div>
                                <div class="buttonSection">
                                    <div class="pictButton" id="pictureSelect">添付</div>
                                    <input type="file" class="NONE" accept="img/*,.jpg,.jpeg,.png,.gif,.bmp" name="pict" id="pictureButton">
                                </div>
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
                <div id="nextButtonA" class="setButton">Create</div>
                <div id="modalOut" class="backButton">Back</div>
            </div>
        </div>
    </div>

@endsection
