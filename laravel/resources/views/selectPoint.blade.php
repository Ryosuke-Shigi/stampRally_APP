@extends('layouts.root')

<!--タイトル-->
@section('title')
Create Point
@endsection

<!--追加メタ情報-->
@section('meta')
<link href="{{ asset('css/initstyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectPoint.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/maps.js') }}" defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyBMKajpItMT-Hy-YgCTAvSO13Eefz2OVnY&callback=initMap" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!--コンテンツ部分-->
@section('contents')

    <div class="wrapper">
        <div class="mapContainer">
            <div class="map" id="map"></div>
        </div>
        <div class = "buttonContainer">
            <div id="modalIn" class="setButton">SET</div>
            <div id="backButton" class="backButton">Back</div>
        </div>
    </div>


    <!--モーダルウィンドウ　スタート詳細設定画面-->
    <div id="modalWindow" class="modalWindow">
        <div class="modalwrapper">
            <div class="configContainer">
                <div class="sectorA">
                    <div class="titleSection"><div class="title">ポイント詳細を設定してください</div></div>
                    <div class="configSection">
                        <!-- 緯度経度 -->
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="nowTime" id="nowTime">
                    </div>
                </div>
            </div>
            <div class="buttonContainer">
                <div id="nextButton" class="setButton">Save</div>
                <div id="modalOut" class="backButton">Back</div>
            </div>
        </div>
    </div>

    <!-- 戻るボタンクリック時に使用 戻る時点で作成していたスタートのテーブルデータを削除する 戻る処理でテーブルデータのIDを指定する -->
    <form method="post" enctype="multipart/form-data" id="backAction" action="reSelectStart">
        @csrf
        <!--スタートテーブルのIDを指定-->
        <input type="hidden" value="">
    </form>

@endsection
