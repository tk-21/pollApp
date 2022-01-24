<?php

namespace model;

// 先頭にabstractをつけることによって継承しないと使えないようにする
abstract class AbstractModel
{
    // セッションに情報を格納するメソッド
    public static function setSession($val)
    {
    }
}
