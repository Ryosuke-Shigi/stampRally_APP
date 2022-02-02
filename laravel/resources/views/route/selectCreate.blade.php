@extends('layouts.root')

<!--タイトル-->
@section('title')
RallyEdit
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/selectCreate.css') }}" rel="stylesheet">
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
                    <div class="titleSection"><div class="title">EDITOR</div></div>
                    <div class="configSection">
                        <div class="itemSection">
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionA" action="{{ route('selectDeleteRoutes') }}" enctype="multipart/form-data">
                                        <div id="nextButtonA" class="setButton">Delete</div>
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">コース削除</div>
                                </div>
                            </div>
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionD" action="{{ route('selectNowTravel') }}" enctype="multipart/form-data">
                                        <div id="nextButtonD" class="setButton">TripNow</div>
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">旅をしながら<br>作成</div>
                                </div>
                            </div>
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionB" action="{{ route('createRoute') }}" enctype="multipart/form-data">
                                        <div id="nextButtonB" class="setButton">Create</div>
                                    </form>
                                </div>
                                <div class="textSector">
                                    <div class="text">一気に<br>作成</div>
                                </div>
                            </div>
                            <div class="itemSector">
                                <div class="buttonSector">
                                    <form method="GET" id="nextActionC" action="{{ route('selectMode') }}" enctype="multipart/form-data">
                                        <div id="nextButtonC" class="setButton">ＢＡＣＫ</div>
                                    </form>
                                </div>
{{--                                 <div class="textSector">
                                    <div class="text">モード選択へ</div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
