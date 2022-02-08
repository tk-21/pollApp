<?php

namespace controller\topic\archive;

use db\TopicQuery;
use lib\Auth;
use model\UserModel;

function get()
{

    // もしログインせずにこのページにアクセスしようとした場合はログインページにリダイレクトする
    Auth::requireLogin();

    // まずセッションからユーザー情報の入ったオブジェクトを取ってくる
    $user = UserModel::getSession();

    // ユーザーに紐付く記事を取得してくる
    $topics = TopicQuery::fetchByUserId($user);

    // viewにあるメソッドを呼んでリストを表示する
    \view\topic\archive\index($topics);
    echo '<pre>', print_r($topics), '</pre>';
}
