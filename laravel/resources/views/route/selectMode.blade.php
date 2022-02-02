@extends('layouts.root')

<!--タイトル-->
@section('title')
Game or Create
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/selectMode.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!--コンテンツ部分-->
@section('contents')

    <!-- マップ表示　座標選択画面 -->
    <div class="wrapper">
            <!-- 詳細設定部分 -->
            <div class="configContainer">
                <div class="sectorA">
                    <div class="titleSection"><div class="title">Mode Select</div></div>
                    <div class="configSection">
                        <div class="itemSection">
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionA" action="{{ route('searchRoutes') }}">
                                        <div id="nextButtonA" class="setButton">ＰＬＡＹ</div>
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">スタンプラリーを<br>開始します</div>
                                </div>
                            </div>
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionB" action="{{ route('selectCreate') }}">
                                        <div id="nextButtonB" class="setButton">ＥＤＩＴ</div>
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">ラリーコースを<br>作成します</div>
                                </div>
                            </div>
{{--                             <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionC" action="{{ route('selectScore') }}">
                                        <div id="nextButtonC" class="setButton">ＳＣＯＲＥ</div>
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">攻略したラリーを<br>表示します</div>
                                </div>
                            </div> --}}
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionD" action="/">
                                        <div id="nextButtonD" class="backButton">ＨＯＭＥ</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
