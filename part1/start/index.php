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
require_once SOURCE_BASE . 'models/topic.model.php';
require_once SOURCE_BASE . 'models/comment.model.php';

// Message
require_once SOURCE_BASE . 'libs/message.php';

// DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/user.query.php';
require_once SOURCE_BASE . 'db/topic.query.php';
require_once SOURCE_BASE . 'db/comment.query.php';

// partials
require_once SOURCE_BASE . 'partials/topic-list-item.php';
require_once SOURCE_BASE . 'partials/topic-header-item.php';
require_once SOURCE_BASE . 'partials/header.php';
require_once SOURCE_BASE . 'partials/footer.php';

// View
require_once SOURCE_BASE . 'views/home.php';
require_once SOURCE_BASE . 'views/login.php';
require_once SOURCE_BASE . 'views/register.php';
require_once SOURCE_BASE . 'views/topic/archive.php';
require_once SOURCE_BASE . 'views/topic/detail.php';

// controllerのファイルはrouter.php内で自動的に読み込まれるので、ここに記述する必要はない

use function lib\route;

session_start();

try {
    // ヘッダーとフッターを共通化して読み込み
    \partials\header();

    // 動的にコントローラーを呼び出す処理

    // $_SERVER['REQUEST_URI']で渡ってきたURLを分ける
    $url = parse_url(CURRENT_URI);

    // $url['path']でパスの部分だけ取ってきたURLから、BASE_CONTEXT_PATHに一致する文字列（start/までのURL）を空文字で置き換える
    $rpath = str_replace(BASE_CONTEXT_PATH, '', $url['path']);

    // リクエストメソッドを小文字に変換して取得
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    // 渡すパスによって呼び出すコントローラーが変わる
    // getかpostかによって実行されるメソッドが変わる
    route($rpath, $method);

    \partials\footer();
} catch (Throwable $e) {
    // 処理を止める
    die('<h1>何かがすごくおかしいようです。</h1>');
}




// リクエストをまたいでエラーが発生したかどうかというのを処理する場合はセッションを使って値を保持する必要がある
