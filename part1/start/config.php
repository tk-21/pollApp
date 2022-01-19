<?php
$uri = $_SERVER['REQUEST_URI'];
// 正規表現でstartかendまでを取得
if (preg_match("/(.+(start|end))/i", $uri, $match)) {
    define('BASE_CONTEXT_PATH', $match[0] . '/');
}
define('BASE_IMAGE_PATH', BASE_CONTEXT_PATH . 'images/');
define('BASE_JS_PATH', BASE_CONTEXT_PATH . 'js/');
define('BASE_CSS_PATH', BASE_CONTEXT_PATH . 'css/');
