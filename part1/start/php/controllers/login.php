<?php

// 呼び出す関数を切り替えることによって表示する画面を制御することができる
// 関数名が重複しそうな場合には、namespaceを指定する

namespace controller\login;

use lib\Auth;
use lib\Msg;

function get()
{
    require_once SOURCE_BASE . 'views/login.php';
}

function post()
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    if (Auth::login($id, $pwd)) {
        // ログインに成功したらセッションのINFOにメッセージを入れる
        Msg::push(Msg::INFO, '認証成功');
        // パスが空だったらトップページに移動
        redirect(GO_HOME);
    } else {
        // ログインに失敗したらセッションのERRORにメッセージを入れる
        Msg::push(Msg::ERROR, '認証失敗');
        // refererは一つ前のリクエストのパスを表す
        // 認証が失敗したときは、一つ前のリクエスト（GETメソッドでのログインページへのパス）に戻る
        redirect(GO_REFERER);
    }
}
