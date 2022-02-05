<?php

namespace controller\logout;

// libの中のAuthクラスをインポートしてくる
use lib\Auth;
use lib\Msg;

// getでリクエストが来た場合
function get()
{
    // logoutメソッドでtrueが返ってきたらメッセージを格納する
    if (Auth::logout()) {
        Msg::push(Msg::INFO, 'ログアウトが成功しました。');
    } else {
        Msg::push(Msg::ERROR, 'ログアウトが失敗しました。');
    }

    redirect(GO_HOME);
}
