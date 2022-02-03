<?php

// 呼び出す関数を切り替えることによって表示する画面を制御することができる
// 関数名が重複しそうな場合には、namespaceを指定する

namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;

function get()
{
    require_once SOURCE_BASE . 'views/login.php';
}

function post()
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    // POSTで渡ってきたIDとパスワードでログインに成功した場合、
    if (Auth::login($id, $pwd)) {
        // 登録されたユーザーオブジェクトの情報を取ってくる
        $user = UserModel::getSession();
        // オブジェクトに格納されている情報を使って、セッションのINFOにメッセージを入れる
        Msg::push(Msg::INFO, "{$user->nickname}さん、ようこそ。");
        // パスが空だったらトップページに移動
        redirect(GO_HOME);
    } else {
        // Auth::loginによって何がエラーかというのはpushされるので、ここでエラーメッセージは出さなくてよい

        // refererは一つ前のリクエストのパスを表す
        // 認証が失敗したときは、一つ前のリクエスト（GETメソッドでのログインページへのパス）に戻る
        redirect(GO_REFERER);
    }
}
