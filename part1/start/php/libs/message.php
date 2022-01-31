<?php

namespace lib;

use model\AbstractModel;

class Msg extends AbstractModel
{
    protected static $SESSION_NAME = '_msg';

    // 表示するメッセージの種類によってタイプを分けておく
    public const ERROR = 'error';
    public const INFO = 'info';
    public const DEBUG = 'debug';

    // セッションにメッセージを詰めるためのメソッド
    public static function push($type, $msg)
    {
        // getSessionで配列がとれてこなかったら、セッション上に配列を初期化する
        if (!is_array(static::getSession())) {
            static::init();
        }

        // 初期化された配列を代入
        $msgs = static::getSession();
        // 配列の種類に合わせてメッセージを格納
        $msgs[$type][] = $msg;
        // メッセージを格納した配列を$_SESSION['_msg']にセット
        static::setSession($msgs);
    }

    // メッセージを表示するためのメソッド
    public static function flush()
    {
        // とれてこなかったら空の配列を代入
        $msgs_with_type = static::getSessionAndFlush() ?? [];

        foreach ($msgs_with_type as $type => $msgs) {
            // $typeにデバッグが回ってきたとき、falseだったら次のループにステップする
            if ($type === static::DEBUG && !DEBUG) {
                continue;
            }
            foreach ($msgs as $msg) {
                echo "<div>{$type}:{$msg}</div>";
            }
        }
    }

    // セッションを初期化するメソッド
    private static function init()
    {
        // セッションの初期値として保存される
        static::setSession([
            static::ERROR => [],
            static::INFO => [],
            static::DEBUG => []
        ]);
    }
}
