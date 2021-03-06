<?php
// 現在のURI（ドメイン以下のパス）を取得
define('CURRENT_URI', $_SERVER['REQUEST_URI']);

// 正規表現でstartかendまでを取得
if (preg_match("/(.+(start|end))/i", CURRENT_URI, $match)) {
    define('BASE_CONTEXT_PATH', $match[0] . '/');
}
define('BASE_IMAGE_PATH', BASE_CONTEXT_PATH . 'images/');
define('BASE_JS_PATH', BASE_CONTEXT_PATH . 'js/');
define('BASE_CSS_PATH', BASE_CONTEXT_PATH . 'css/');

// __DIR__は、このファイルがあるディレクトリのフルパスを返す
define('SOURCE_BASE', __DIR__ . '/php/');

define('GO_HOME', 'home');
define('GO_REFERER', 'referer');

// メッセージを開発環境では出して、本番環境では出さない
// 開発環境はtrue,本番環境はfalseとすることで、開発のときのみ表示したいメッセージを制御することができる
define('DEBUG', false);
