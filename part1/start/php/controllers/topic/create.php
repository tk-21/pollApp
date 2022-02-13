<?php

namespace controller\topic\create;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get()
{
    // ログインしているかどうか確認（管理画面なのでログインは必須）
    Auth::requireLogin();

    // TopicModelのインスタンスを作成
    $topic = new TopicModel;
    $topic->id = -1;
    $topic->title = '';
    $topic->published = 1;

    // トピックを渡してviewのindexを表示
    \view\topic\edit\index($topic, false);
}


function post()
{
    // ツールなどでもリクエストは投げれるので、必ずPOSTでもログインしているかどうか確認する
    Auth::requireLogin();

    // TopicModelのインスタンスを作成
    $topic = new TopicModel;

    // POSTで渡ってきた値をモデルに格納
    $topic->id = get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = get_param('published', null);

    // 更新処理
    try {
        // セッションに格納されているユーザー情報のオブジェクトを取ってくる
        $user = UserModel::getSession();

        // insertメソッドにトピックモデルとユーザーモデルを渡す
        // 更新が成功すればtrue,失敗すればfalseが返ってくる
        $is_success = TopicQuery::insert($topic, $user);
    } catch (Throwable $e) {
        // エラー内容を出力する
        Msg::push(Msg::ERROR, $e->getMessage());
        $is_success = false;
    }

    // 登録に成功すれば、メッセージを出す
    if ($is_success) {
        Msg::push(Msg::INFO, 'トピックの登録に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'トピックの登録に失敗しました。');
        // 元の画面に戻す
        redirect(GO_REFERER);
    }
}
