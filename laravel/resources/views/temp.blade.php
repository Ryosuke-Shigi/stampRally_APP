@extends('layouts.root')

<!--タイトル-->
@section('title')
チェックポイント一覧
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/test.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!--コンテンツ部分-->
@section('contents')

    <!-- マップ表示　座標選択画面 -->
    <div class="wrapper">
        <!-- 地図部分 -->
        <div class="mainContainer">
{{--             <div class="title">はじめるルートを選択してください</div>
 --}}

            <div class="mainSector">
{{--                 @foreach ($table as $temp)
                    <div class = "rallySelectSection" data-route_code={{ $temp->route_code }}>
                        <div class="title">{{ $temp->route_name }}</div>
                        <div class="message">{{ $temp->text }}</div>
                        @if($temp->pict != NULL)
                            <img src = {{ "https://ada-stamprally.s3.ap-northeast-3.amazonaws.com/".$temp->pict }} class="picture">
                        @else
                            <div class="picture">NO IMAGE</div>
                        @endif
                    </div>
                @endforeach
 --}}            </div>

        </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            @auth
                <div id="nextButtonA" class="setButton">START</div>
            @else
                <div id="nextButtonB" class="setButton">新規登録</div>
                <div id="nextButtonC" class="setButton">ログイン</div>
            @endauth
        </div>
    </div>

    <!--buttonaction 他に影響しないように外へ-->
    <form method="GET" id="nextActionA" action="{{ route('checkPoint') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="route_code" id="selectroute_code">
    </form>
    <form method="GET" id="nextActionB" action="{{ route('checkPoint') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="route_code" id="selectroute_code">
    </form>
    <form method="GET" id="nextActionC" action="{{ route('checkPoint') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="route_code" id="selectroute_code">
    </form>


{{--     <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="" enctype="multipart/form-data">
        @csrf
    </form> --}}

@endsection
