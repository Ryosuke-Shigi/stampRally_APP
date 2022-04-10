@extends('layouts.root')

<!--タイトル-->
@section('title')
StamP-RALLY
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


{{--                 <div class="title">Stam<span class="P">P</span></div>
                <div class="title">RALLY</div> --}}
                <div class="sectorA">

                    <!-- <span class="sample21">すたん</span> -->
                    <span class="sample21">す</span>
                    <span class="sample21">た</span>
                    <span class="sample21">ん</span>

                    <span class="sample22">Ｐ</span>
                </div>
                <div class="sectorB">
{{--                     <span class="sample21">らり～</span>
 --}}
                    <span class="sample21">ら</span>
                    <span class="sample21">り</span>
                    <span class="sample21">～</span>

                </div>

                <!--実験CSS-->
{{--                 <div class="sectorA">
                    <span class="objectRotateA">◆</span>
                </div> --}}


           </div>

        </div>
        <!-- ボタン部分 -->
        <div class = "buttonContainer">
            @auth
                <div id="nextButtonA" class="setButton">START</div>
                <div id="nextButtonB" class="backButton">LogOut</div>
            @else
                <div id="nextButtonC" class="setButton">LogIN</div>
                <div id="nextButtonD" class="backButton">SignUP</div>
            @endauth
        </div>
    </div>

    <!--buttonaction 他に影響しないように外へ-->
    <form method="GET" id="nextActionA" action="{{ route('selectMode') }}" ></form>
    <form method="POST" id="nextActionB" action="{{ route('logout') }}" >@csrf</form>
    <form method="GET" id="nextActionC" action="{{ route('login') }}" ></form>
    <form method="GET" id="nextActionD" action="{{ route('register') }}"></form>

{{--     <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="" enctype="multipart/form-data">
        @csrf
    </form> --}}

@endsection
