<?php

namespace controller\topic\edit;

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

    // GETリクエストから取得したtopic_idをモデルに格納
    $topic->id = get_param('topic_id', null, false);

    // セッションに格納されているユーザー情報のオブジェクトを取ってくる
    $user = UserModel::getSession();

    // ログイン中のユーザーが記事を編集できるかどうかのチェックする
    // userモデルに紐づくtopic->idであれば許可する
    Auth::requirePermission($topic->id, $user);

    // idが格納された$topicを渡してそのトピックを取ってくる
    $fetchedTopic = TopicQuery::fetchById($topic);

    // トピックを渡してviewのindexを表示
    \view\topic\edit\index($fetchedTopic);
}


function post()
{
    // ログインしているかどうか確認（管理画面なのでログインは必須）
    Auth::requireLogin();

    // TopicModelのインスタンスを作成
    $topic = new TopicModel;

    // POSTで渡ってきた値をモデルに格納
    $topic->id = get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = get_param('published', null);

    // セッションに格納されているユーザー情報のオブジェクトを取ってくる
    $user = UserModel::getSession();

    // ログイン中のユーザーが記事を編集できるかどうかのチェックする
    // userモデルに紐づくtopic->idであれば許可する
    Auth::requirePermission($topic->id, $user);

    // 更新処理
    try {
        // 更新が成功すればtrue,失敗すればfalseが返ってくる
        $is_success = TopicQuery::update($topic);
    } catch (Throwable $e) {
        // エラー内容を出力する
        Msg::push(Msg::ERROR, $e->getMessage());
        $is_success = false;
    }

    // 更新に成功すれば、メッセージを出す
    if ($is_success) {
        Msg::push(Msg::INFO, 'トピックの更新に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'トピックの更新に失敗しました。');
        // 元の画面に戻す
        redirect(GO_REFERER);
    }
}
