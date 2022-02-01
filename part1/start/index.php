<?php

use lib\Msg;

require_once 'config.php';

// Library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';
require_once SOURCE_BASE . 'libs/router.php';

// model
require_once SOURCE_BASE . 'models/abstract.model.php';
require_once SOURCE_BASE . 'models/user.model.php';

// Message
require_once SOURCE_BASE . 'libs/message.php';

// DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/user.query.php';

use function lib\route;

session_start();

try {
    // 部品を共通化する
    require_once SOURCE_BASE . 'partials/header.php';

    // 動的にコントローラーを呼び出す
    // $_SERVER['REQUEST_URI']で渡ってきたURLから、BASE_CONTEXT_PATHに一致する文字列を空文字で置き換える
    $rpath = str_replace(BASE_CONTEXT_PATH, '', CURRENT_URI);

    // リクエストメソッドを小文字に変換して取得
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    route($rpath, $method);

    require_once SOURCE_BASE . 'partials/footer.php';
} catch (Throwable $e) {
    // 処理を止める
    die('<h1>何かがすごくおかしいようです。</h1>');
}




// リクエストをまたいでエラーが発生したかどうかというのを処理する場合はセッションを使って値を保持する必要がある
