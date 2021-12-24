@extends('layouts.root')

<!--タイトル-->
@section('title')
CREATE [start]
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/initstyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectStart.css') }}" rel="stylesheet">
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
            <div id="modalIn" class="setButton">登録</div>
            <div id="backButton" class="backButton">戻る</div>
        </div>
    </div>


    <!--モーダルウィンドウ　スタート詳細設定画面-->
    <div id="modalWindow" class="modalWindow">
        <div class="modalwrapper">
            <div class="configContainer">
                container
            </div>
            <div class="buttonContainer">
                <div id="nextButton" class="setButton">Next</div>
                <div id="modalOut" class="backButton">Back</div>
            </div>
        </div>
    </div>



@endsection
