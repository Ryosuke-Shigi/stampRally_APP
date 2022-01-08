
const { indexOf } = require("lodash");

$(function () {
    //モーダルウィンドウを開く
    $('#modalIn').on('click', function () {
        $('#modalWindow').fadeIn();
        return false;
    });
    //モーダルウィンドウを閉じる
    $('#modalOut').on('click', function () {
        //$('#pointname').val("");
        $('#modalWindow').fadeOut();
        return false;
    });
    //進行ボタンは複数あります 各それぞれのBladeで行き先管理
    //次へ進行するボタン
    $('#nextButtonA').on('click', function () {
        $('#nextActionA').submit();
    });
    //次へ進行するボタン
    $('#nextButtonB').on('click', function () {
        $('#nextActionB').submit();
    });
    //次へ進行するボタン
    $('#nextButtonC').on('click', function () {
        $('#nextActionC').submit();
    });

    //前へ戻るボタン
    $('#backButton').on('click', function () {
        $('#backAction').submit();
    });
    //画像ファイル選択アクション
    $('#pictureSelect').on('click',function (){
        if($('#pictureButton').val() != ""){
            $('#preview').attr("src","");
            //アップロードした画像をクリア
            $('#pictureButton').val("");
            $('#pictureSelect').html("添付");
        }else{
            $('#pictureButton').click();
        }
    });
    //画像プレビュー
    $('#pictureButton').on('change',function(e){
            let render = new FileReader();
            //一時ファイルをプレビューへ
            //一時ファイルを呼び出し
            render.onload = function(e){
                    //プレビュー画像表示
                    $('#preview').attr("src",e.target.result);
                    //プレビュータイトルの項目を入れる
                    $('#preview').attr("title",e.target.name);
            };
            //読込処理（ここが終わればonloadが発火する）
            render.readAsDataURL(e.target.files[0]);
            $('#pictureSelect').html("削除");
    });


    //ルート選択画面
    //複数ある同名IDからクリックイベントより、<input type="hidden" の id $route_nameに
    //data-route_nameで指定されている値をいれてサブミットさせる
    $('.rallySelectSection').on('click',function(){
        $('#selectroute_code').val($(this).data('route_code'));
        $('#nextActionA').submit();
    });

});
