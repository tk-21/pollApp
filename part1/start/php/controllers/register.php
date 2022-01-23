<?php

namespace controller\register;

use lib\Auth;

function get()
{
    require_once SOURCE_BASE . 'views/register.php';
}

function post()
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');
    $nickname = get_param('nickname', '');

    if (Auth::regist($id, $pwd, $nickname)) {
        echo '登録成功';
    } else {
        echo '登録失敗';
    }
}
