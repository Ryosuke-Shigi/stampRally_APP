@extends('layouts.root')

<!--タイトル-->
@section('title')
チェックポイント一覧
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
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
                <div class="title">Stam <div class="P">P</div></div>
                <div class="title">ＲＡＬＬＹ</div>
           </div>

        </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            @auth
                <div id="nextButtonA" class="setButton">START</div>
                <div id="nextButtonB" class="setButton">LOGOUT</div>
            @else
                <div id="nextButtonC" class="setButton">LOG IN</div>
                <div id="nextButtonD" class="setButton">新規登録</div>
            @endauth
        </div>
    </div>

    <!--buttonaction 他に影響しないように外へ-->
    <form method="GET" id="nextActionA" action="{{-- {{ route('') }} --}}" ></form>
    <form method="POST" id="nextActionB" action="{{ route('logout') }}" >@csrf</form>
    <form method="GET" id="nextActionC" action="{{ route('login') }}" ></form>
    <form method="GET" id="nextActionD" action="{{ route('register') }}"></form>

{{--     <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="" enctype="multipart/form-data">
        @csrf
    </form> --}}

@endsection
