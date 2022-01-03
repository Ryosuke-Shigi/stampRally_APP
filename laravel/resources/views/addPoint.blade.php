@extends('layouts.root')

<!--タイトル-->
@section('title')
CREATE [G O A L]
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/addPoint.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">ポイントを追加しますか？</div></div>
                    <div class="configSection">

                        <div class="itemSection">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionA" action="{{ route('selectPoint',['route_code'=>$route_code,'route_name'=>$route_name,'point_no'=>$point_no]) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div id="nextButtonA" class="setButton">追　加</div>
                                    </form>
                                </div>
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionB" action="{{ route('settingGoal',['route_code'=>$route_code,'route_name'=>$route_name]) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div id="nextButtonB" class="setButton">完　了</div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
