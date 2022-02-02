@extends('layouts.root')

<!--タイトル-->
@section('title')
Score選択
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/selectScore.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">Select Score</div></div>
                    <div class="configSection">
                        <div class="itemSection">
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionA" action="{{ route('showScore') }}">
                                        <div id="nextButtonA" class="setButton">MINE</div>
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">攻略したスコアを<br>表示します</div>
                                </div>
                            </div>
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionB" action="{{ route('selectRouteScore') }}">
                                        <div id="nextButtonB" class="setButton">Course</div>
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">各コースのスコアを<br>表示します</div>
                                </div>
                            </div>
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionD" action="{{ route('searchRoutes') }}">
                                        <div id="nextButtonD" class="setButton">ＢＡＣＫ</div>
                                    </form>
                                </div>
{{--                                 <div class="textSector">
                                    <div class="text">トップ画面へ</div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
