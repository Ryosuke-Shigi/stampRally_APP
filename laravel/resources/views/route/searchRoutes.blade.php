@extends('layouts.root')

<!--タイトル-->
@section('title')
Route Search
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/searchRoutes.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">ＧＡＭＥＳ</div></div>
                    <div class="configSection">

                        <div class="itemSection">
{{--                             <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">全てのラリー</div>
                                </div>
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionA" action="{{ route('selectRoute') }}" enctype="multipart/form-data">
                                        <div id="nextButtonA" class="setButton">ＡＬＬ</div>
                                    </form>
                                </div>
                            </div> --}}

                            <div class="itemSector">
                                <form method="GET" id="nextActionC" action="{{ route('selectRoute') }}" enctype="multipart/form-data">
                                    <div class="textSector">
                                    <!-- REQUESTに keyword を入れて転送　向こうで判断して別のものを表示します -->
                                    <div class="text">ラリー検索</div>
                                        <input type="text" class="keyword" name="keyword" placeholder="キー検索も可">
                                    </div>
                                    <div class="buttonSector">
                                        <div id="nextButtonC" class="setButtonA">検　索</div>
                                    </div>
                                </form>
                            </div>

                            <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">現在進行中<br>参加しているラリー</div>
                                </div>
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionB" action="{{ route('progressRoutes') }}" enctype="multipart/form-data">
                                        <div id="nextButtonB" class="setButtonB">進行中</div>
                                    </form>
                                </div>
                            </div>

                            <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">攻略したラリーを<br>表示します</div>
                                </div>
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionE" action="{{ route('selectScore') }}">
                                        <div id="nextButtonE" class="setButtonC">SCORE</div>
                                    </form>
                                </div>
                            </div>


                            <div class="itemSector">
{{--                                 <div class="textSector">
                                    <div class="text">モード選択へ</div>
                                </div> --}}
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionD" action="{{ route('selectMode') }}" enctype="multipart/form-data">
                                        <div id="nextButtonD" class="backButton">ＢＡＣＫ</div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
