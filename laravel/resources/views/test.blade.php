@extends('layouts.root')

<!--タイトル-->
@section('title')
ラリークリア！
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/showGoal.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!--コンテンツ部分-->
@section('contents')

    <!-- マップ表示　座標選択画面 -->
    <div class="wrapper">
        <!-- 地図部分 -->
        <div class="mainContainer">
            <div class="mainKind">クリア！おめでとうございます！</div>
            <div class="configContainer">
                <div class="sectorA">
{{--                     @if($table->pict != NULL)
                    <div class="picture">
                        <div class="content">
                            <img src = {{ "https://ada-stamprally.s3.ap-northeast-3.amazonaws.com/"./* $table->pict */ }} class="preview">
                        </div>
                    </div>
                    @endif
 --}}                    <div class="multiText">
                        <div class="name">クリアメッセージ</div>
                        <div class="content">
                            <textarea name="text" id="text" class="text" readonly>test</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            <div id="modalIn" class="setButton">次へ</div>
        </div>

    </div>


    <!--BackAction 他に影響しないように外へ-->
    <form method="POST" id="backAction" action="" enctype="multipart/form-data">
        @csrf
        <!-- ルートを一度削除するため、route_codeを送る -->
    </form>


    <!--モーダルウィンドウ ポイント設定画面-->
    <div id="modalWindow" class="modalWindow">
        <div class="modalwrapper">
            <!-- 詳細設定部分 -->
            <div class="configContainer">
                <div class="sectorA">
                    <form method="POST" id="nextActionA" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="singleText">
                            <div class="name">名前をいれてください</div>
                            <div class="content">
                                <input type="text" name="name" class="text">
                            </div>
                        </div>
                        <div class="singleText">
                            <div class="name">コメント</div>
                            <div class="content">
                                <input type="text" name="text" class="text">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!--モーダルウィンドウ　ボタン部分-->
            <div class="buttonContainer">
                <div id="nextButtonA" class="setButton">完了</div>
                <div id="modalOut" class="backButton">Back</div>
            </div>
        </div>
    </div>

@endsection
