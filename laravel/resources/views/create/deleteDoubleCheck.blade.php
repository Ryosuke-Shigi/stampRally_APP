@extends('layouts.root')

<!--タイトル-->
@section('title')
ポイントを追加しますか？
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/deleteDoubleCheck.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">本当に削除しますか？</div></div>
                    <div class="configSection">

                        <div class="itemSection">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionA" action="{{ route('deleteRoute') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div id="nextButtonA" class="setButton">削　除</div>
                                        <input type="hidden" name="route_code" value={{ $route_code }}>
                                    </form>
                                </div>
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionB" action="{{ route('selectDeleteRoutes') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div id="nextButtonB" class="backButton">やめる</div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
