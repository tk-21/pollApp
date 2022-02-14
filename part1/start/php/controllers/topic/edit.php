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

    // セッションからデータを取ってきて変数に格納する。セッション上のデータは削除する
    // 必ずデータを取得した時点で、データを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
    $topic = TopicModel::getSessionAndFlush();

    // データが取れてくれば、その値を画面表示し、処理を終了
    if (!empty($topic)) {
        \view\topic\edit\index($topic, true);
        return;
    }

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
    \view\topic\edit\index($fetchedTopic, true);
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

    // trueの場合は、メッセージを出してarchiveに移動
    if ($is_success) {
        Msg::push(Msg::INFO, 'トピックの更新に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'トピックの更新に失敗しました。');

        // 登録に失敗した場合、入力した内容をセッションに保存する
        TopicModel::setSession($topic);

        // falseの場合は、メッセージを出して元の画面に戻す
        // このときに再びgetメソッドが呼ばれる
        redirect(GO_REFERER);
    }
}
