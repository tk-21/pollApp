<?php

// 呼び出す関数を切り替えることによって表示する画面を制御することができる
// 関数名が重複しそうな場合には、namespaceを指定する

namespace controller\login;

function get() {
    require_once SOURCE_BASE . 'views/login.php';
}

function post() {
    echo 'post methodを受け取りました';
}
