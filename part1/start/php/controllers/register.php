<?php

namespace controller\register;

// 別の名前空間にあるクラスをインポートする
use lib\Auth;
use model\UserModel;

function get()
{
    require_once SOURCE_BASE . 'views/register.php';
}

function post()
{
    $user = new UserModel;
    $user->id = get_param('id', '');
    $user->pwd = get_param('pwd', '');
    $user->nickname = get_param('nickname', '');

    // Userオブジェクトをregistに渡してあげる
    // 引数をある特定のモデルとすることで引数の記述を簡略化できる
    // 引数が多くなる場合もあるので、モデル自体を渡してやるとスッキリする
    if (Auth::regist($user)) {
        echo '登録成功';
    } else {
        echo '登録失敗';
    }
}
