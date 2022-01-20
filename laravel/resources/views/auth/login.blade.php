@extends('layouts.root')

<!--タイトル-->
@section('title')
Route Search
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">ログイン</div></div>
                    <div class="configSection">
                        <form method="POST" id="nextActionA" action="{{ route('login') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- ユーザID -->
                            <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">User_ID</div>
                                    <input id="user_id" type="user_id" class="keyword" name="user_id" placeholder="UserID" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- パスワード -->
                            <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">PassWord</div>
                                    <input id="password" type="password" class="keyword" name="password" placeholder="パスワード"  required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- ログインボタン -->
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <div id="nextButtonA" class="setButton">LogIN</div>
                                </div>
                                <div class="buttonSector">
                                    <div id="nextButtonB" class="setButton">SignUP</div>
                                </div>
                                <div class="buttonSector">
                                    <div id="backButton" class="setButton">Back</div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
    </div>
    <!--新規登録用-->
    <form method="GET" id="nextActionB" action="{{ route('register') }}"></form>

    <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="/"></form>

@endsection
