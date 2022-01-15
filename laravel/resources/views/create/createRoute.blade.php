@extends('layouts.root')

<!--タイトル-->
@section('title')
スタンプラリー作成画面
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/createRoute.css') }}" rel="stylesheet">
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
                <div class="titleSection"><div class="title">スタンプラリーを作成します</div></div>
                <div class="configSection">
                <form method="POST" id="nextActionA" action="{{ route('makeRoute') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="itemSection">
                        <!-- 名前 -->
                        <div class="singleText">
                            <div class="name">コース名（※必須）</div>
                            <div class="content"><input type="text" name="name" class="text">{{ old('name') }}</div>
                        </div>
                        <!-- エラーメッセージ -->
                        @if($errors->has('name'))<div class="errorMessage">{{ $errors->first('name') }}</div>@endif

                        <!-- 検索用キーワード -->
                        <div class="singleText">
                            <div class="name">検索用キーワード</div>
                            <div class="content"><input type="text" name="keyword" class="text">{{ old('keyword') }}</div>
                        </div>

                        <!-- 紹介メッセージ -->
                        <div class="multiText">
                            <div class="name">どんなコースですか？（※必須）</div>
                            <div class="content"><textarea name="text" class="text">{{ old('text') }}</textarea></div>
                        </div>
                        <!-- エラーメッセージ -->
                        @if($errors->has('text'))<div class="errorMessage">{{ $errors->first('text') }}</div>@endif


                        <!-- 写真追加 -->
                        <div class="picture">
                            <div class="name">画像もあれば</div>
                            <div class="content"><img class="preview" id="preview"></div>
                            <div class="buttonSection">
                                <div class="pictButton" id="pictureSelect">添付</div>
                                <input type="file" class="NONE" accept="img/*,.jpg,.jpeg,.png,.gif,.bmp" name="pict" id="pictureButton">
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            <div id="nextButtonA" class="setButton">SET</div>
            <div id="backButton" class="backButton">Back</div>
        </div>
    </div>
    <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action={{ route('selectCreate') }}></form>

@endsection
