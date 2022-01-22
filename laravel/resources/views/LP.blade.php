@extends('layouts.root')

<!--タイトル-->
@section('title')
StamP-RALLY LP
@endsection

<!--追加メタ情報-->
@section('meta')
    <link href="{{ asset('css/LP.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!--コンテンツ部分-->
@section('contents')

    <div class="wrapper">

        <!-- 紹介ページ１ about stamprally-->

        <div class="pageContainer">
            <div class="pageSector">
                <div class="line"><div class="textp1">ABOUT 『 StampRally 』</div></div>
                <div class="s-contents">
                    <div class="d-content"><img class='pict' src="{{ asset('/images/1-topmap.jpg') }}"></div>
                    <div class="d-content">
                        <div class="textp1">
                            スタンプラリーのコースを<br>
                            作成・遊ぶ事ができる<br>
                            ＷＥＢアプリです。
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 紹介ページ２ できること-->

        <div class="pageContainer">
            <div class="pageSector">
                <div class="line"><div class="textp1">-- できること --</div></div>
                <div class="s-contents">
                    <div class="d-content">
                        <div class="textp2">
                            『 P l a y 』<br>
                            　自分や人が作ったコースで<br>
                            　遊べます。<br>
                            『 E D I T 』<br>
                            　新しくコースを作成することが<br>
                            　できます。<br>
                            『 S C O R E 』<br>
                            　攻略したラリーを<br>
                            　確認することができます。<br>
                        </div>
                    </div>
                    <div class="d-content"><img class='pict' src="{{ asset('/images/2-select.jpg') }}"></div>
                </div>
            </div>
        </div>


        <!-- 紹介ページ３ あそびかた-->

        <div class="pageContainer">
            <div class="pageSector">
                <div class="line"><div class="textp1">-- あそびかた１ --</div></div>
                <div class="s-contents">
                    <div class="d-content"><img class='pict' src="{{ asset('/images/3-play.jpg') }}"></div>
                    <div class="d-content">
                        <div class="textp3">
                            「PLAY」からルートを<br>
                            　検索・選択してスタート<br>
                            <br>
                            　各地にある「P」に<br>
                            　50ｍ以内に近づいて<br>
                            <br>
                            　「Ｐ」をクリック<br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 紹介ページ４ あそびかた-->

        <div class="pageContainer">
            <div class="pageSector">
                <div class="line"><div class="textp1">-- あそびかた２ --</div></div>
                <div class="s-contents">
                    <div class="d-content"><img class='pict' src="{{ asset('/images/4-play.jpg') }}"></div>
                    <div class="d-content">
                        <div class="textp3">
                            全てのポイントをチェックすれば<br>
                            ゲームクリアです。<br>
                            <br>
                            ゴール後メッセージを受け取って<br>
                            <br>
                            名前とコメントを残してください。<br>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- 紹介ページ５ つくりかた-->

        <div class="pageContainer">
            <div class="pageSector">
                <div class="line"><div class="textp1">-- つくりかた１ --</div></div>
                <div class="s-contents">
                    <div class="d-content">
                        <div class="textp4">
                            「EDIT」からルートが<br>
                            　作成できます<br>
                            <br>
                            　コース名を決めてから<br>
                            　説明をつけてください<br>
                            　画像も添付できます<br>
                        </div>
                    </div>
                    <div class="d-content"><img class='pict' src="{{ asset('/images/5-create.jpg') }}"></div>
                </div>
            </div>
        </div>


        <!-- 紹介ページ７ つくりかた-->

        <div class="pageContainer">
            <div class="pageSector">
                <div class="line"><div class="textp1">-- つくりかた２ --</div></div>
                <div class="s-contents">
                    <div class="d-content">
                        <div class="textp4">
                            各ポイントを設置します<br>
                            <br>
                            数に制限はありません<br>
                            <br>
                            それぞれに紹介文と画像が<br>
                            <br>
                            添付できます。
                        </div>
                    </div>
                    <div class="d-content"><img class='pict' src="{{ asset('/images/6-create.jpg') }}"></div>
                </div>
            </div>
        </div>


        <!-- 紹介ページ８ つくりかた-->

        <div class="pageContainer">
            <div class="pageSector">
                <div class="line"><div class="textp1">-- つくりかた３ --</div></div>
                <div class="s-contents">
                    <div class="d-content">
                        <div class="textp4">
                            最後にクリアコメントをつけて<br>
                            完成です。<br>
                            <br>
                            こちらにも画像を<br>
                            添付できます
                        </div>
                    </div>
                    <div class="d-content"><img class='pict' src="{{ asset('/images/7-create.jpg') }}"></div>
                </div>
            </div>
        </div>


        <!-- 紹介ページ９ 最後に-->

        <div class="pageContainer">
            <div class="pageSector">
                <div class="line"><div class="textp1">-- 以上になります --</div></div>
                <div class="s-contents">
                    <div class="d-content">
                        <div class="textp5">
                            一度、簡単なラリーを作成して<br>
                            体験してみてください。
                        </div>
                    </div>
                    <div class="d-content">
                        <!-- 紹介終了 -->
                        <div class = "buttonContainer">
                                <div id="nextButtonA" class="setButton">体験する</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>

    <!--buttonaction 他に影響しないように外へ-->
    <form method="GET" id="nextActionA" action="/" ></form>

{{--     <!--BackAction 他に影響しないように外へ-->
    <form method="GET" id="backAction" action="" enctype="multipart/form-data">
        @csrf
    </form> --}}

@endsection