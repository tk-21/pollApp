<?php
require_once 'config.php';

require_once SOURCE_BASE . 'models/user.model.php';
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/user.query.php';

session_start();

// 部品を共通化する
require_once SOURCE_BASE . 'partials/header.php';

// 動的にコントローラーを呼び出す
// $_SERVER['REQUEST_URI']で渡ってきたURLから、BASE_CONTEXT_PATHに一致する文字列を空文字で置き換える
$rpath = str_replace(BASE_CONTEXT_PATH, '', CURRENT_URI);

// リクエストメソッドを小文字に変換して取得
$method = strtolower($_SERVER['REQUEST_METHOD']);

route($rpath, $method);


function route($rpath, $method) //渡ってきたパスによって呼び出すコントローラーを変える
{
    // 何もなかったらhomeを入れる
    if ($rpath === '') {
        $rpath = 'home';
    }

    $targetFile = SOURCE_BASE . "controllers/{$rpath}.php";

    if (!file_exists($targetFile)) {
        require_once SOURCE_BASE . 'views/404.php';
        return;
        // returnを書くことで、これ以降のコードは見る必要がないということを伝えることができる
    }

    require_once $targetFile;

    // パスとメソッドによって関数を呼び分ける
    $fn = "\\controller\\{$rpath}\\{$method}";

    // 文字列で定義したものであっても、関数が見つかれば、末尾に()をつけることによって実行できる
    $fn();
}


// パスとコントローラーの紐付け
// if ($_SERVER['REQUEST_URI'] === '/poll/part1/start/login') {
//     require_once SOURCE_BASE . 'controllers/login.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/poll/part1/start/register') {
//     require_once SOURCE_BASE . 'controllers/register.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/poll/part1/start/') {
//     require_once SOURCE_BASE . 'controllers/home.php';
// }


require_once SOURCE_BASE . 'partials/footer.php';
