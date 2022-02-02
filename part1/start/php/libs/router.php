<?php

namespace lib;

use Error;
use Throwable;

// 渡ってきたパスによって呼び出すコントローラーを変えるメソッド
// index.php内でこのメソッドを呼び出す
function route($rpath, $method)
{
    // try catchは影響範囲の大きいところから書いていく
    try {
        // この記述を入れるとcatchの方に飛ぶ
        // throw new Error();

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
    } catch (Throwable $e) {
        // デバッグで何が起こったか確認できるようにする
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, '何かがおかしいようです。');
        // 404ページにとばす
        require_once SOURCE_BASE . 'views/404.php';
    }
}
