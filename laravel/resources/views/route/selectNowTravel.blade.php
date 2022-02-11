@extends('layouts.root')

<!--タイトル-->
@section('title')
now Travel
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/selectNowTravel.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">{{ $route_name }}：作成中</div></div>
                    <div class="configSection">
                        <div class="itemSection">
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionA" action="{{ route('selectPointNowTravel') }}">
                                        <div id="nextButtonA" class="setButtonA">@if($pointNum>0) 作 成 @else 追 加 @endif</div>
                                        <input type="hidden" name="route_code" value="{{ $route_code }}">
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">ポイント{{ $pointNum+1 }}つ目作成</div>
                                </div>
                            </div>
                            <!--ポイントが一つでもあれば表示される-->
                            @if($pointNum > 0)
                                <div class="itemSector">
                                    <div class="buttonSector">
                                        <form method="GET" id="nextActionB" action="{{ route('settingGoalNowTravel',['route_code'=>$route_code]) }}">
                                            <div id="nextButtonB" class="setButtonB">完 了</div>
                                        </form>
                                    </div>
                                    <div class="textSector">
                                        <div class="text">ラリー作成完了</div>
                                    </div>
                                </div>
                            @endif


                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionC" action="{{ route('resetNowTravel') }}">
                                        <div id="nextButtonC" class="setButtonC">Reset</div>
                                        <!--ルートコードを送って削除する-->
                                        <input type="hidden" name="route_code" value="{{ $route_code }}">
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">最初からやり直します</div>
                                </div>
                            </div>

                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionD" action="{{ route('selectCreate') }}">
                                        <div id="nextButtonD" class="backButton">Back</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
