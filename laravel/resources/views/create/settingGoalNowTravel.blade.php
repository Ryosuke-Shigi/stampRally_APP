@extends('layouts.root')

<!--タイトル-->
@section('title')
CREATE [G O A L]
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/settingGoalNowTravel.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">@if($errors->has('text')){{ $errors->first('text') }}@else 旅を締めくくりましょう。@endif</div></div>
                    <div class="configSection">
                    <form method="POST" id="nextActionA" action="{{ route('makeGoalNowTravel',['route_code'=>$route_code]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="itemSection">
                            <!-- 紹介メッセージ -->
                            <div class="multiText">
                                <div class="name">コメント（※必須）</div>
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
            <!--選択ボタン領域-->
            <div class="buttonContainer">
                <div id="nextButtonA" class="setButton">完了</div>
            </div>
    </div>

@endsection
