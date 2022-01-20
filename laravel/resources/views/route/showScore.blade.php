@extends('layouts.root')

<!--タイトル-->
@section('title')
スコア表示
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/showScore.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!--コンテンツ部分-->
@section('contents')

    <!-- マップ表示　座標選択画面 -->
    <div class="wrapper">
        <!-- 地図部分 -->
        <div class="mainContainer">
            <div class="title">ScoreBoard</div>
            <!--スコア列挙　送られてきたデータ分作成する-->
            <div class="routeSector">
                @foreach ($table as $temp)
                    <div class = "itemSection">
                        <div class="title">{{ $temp->route_name }}</div>
                        <div class="name">{{ $temp->name }}</div>
                        <div class="time">{{ $temp->compleated_at }}</div>
                    </div>
                @endforeach

            </div>
        </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            <div id="modalIn" class="NONE"></div>
            <div id="backButton" class="backButton">Back</div>
        </div>
    </div>

    <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="{{ route('selectScore') }}" enctype="multipart/form-data">
        @csrf
    </form>

@endsection
