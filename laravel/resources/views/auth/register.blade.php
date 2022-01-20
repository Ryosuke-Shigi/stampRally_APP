@extends('layouts.root')

<!--タイトル-->
@section('title')
Route Search
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">新規登録</div></div>
                    <div class="configSection">
                        <form method="POST" id="nextActionA" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- ユーザID -->
                            <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">User_ID</div>
                                    <input id="user_id" type="text" class="keyword" name="user_id" placeholder="UserID" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email-Adress -->
                            <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">Email</div>
                                    <input id="email" type="email" class="keyword" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- password -->
                            <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">PassWord</div>
                                    <input id="password" type="password" class="keyword" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- confirm password パスワード再確認 -->
                            <div class="itemSector">
                                <div class="textSector">
                                    <div class="text">もう一度パスワード</div>
                                    <input id="password-confirm" type="password" class="keyword" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class = "buttonContainer">
                        <div class="buttonSector">
                            <div id="nextButtonA" class="setButton">SignUP</div>
                        </div>
                        <div class="buttonSector">
                            <div id="backButton" class="setButton">Back</div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!--新規登録用-->
    <form method="GET" id="nextActionB" action="{{ route('register') }}"></form>

    <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="{{ route('login') }}"></form>

@endsection
