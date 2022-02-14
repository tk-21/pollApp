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

    // セッションからデータを取ってきて変数に格納する。セッション上のデータは削除する
    $topic = TopicModel::getSessionAndFlush();

    // データが取れてこなかった場合、TopicModelで初期化を行う
    if (empty($topic)) {
        $topic = new TopicModel;
        $topic->id = -1;
        $topic->title = '';
        $topic->published = 1;
    }

    // データが取れてくれば、そのまま画面表示する
    // トピックを渡してviewのindexを表示
    \view\topic\edit\index($topic, false);
}


function post()
{
    // ツールなどでもリクエストは投げれるので、必ずPOSTでもログインしているかどうか確認する
    Auth::requireLogin();

    // TopicModelのインスタンスを作成
    $topic = new TopicModel;

    // POSTで渡ってきた（フォームで飛んできた）値をトピックモデルに格納
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

    // trueの場合は、メッセージを出してarchiveに移動
    if ($is_success) {
        Msg::push(Msg::INFO, 'トピックの登録に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'トピックの登録に失敗しました。');

        // 登録に失敗した場合、入力した内容をセッションに保存する
        TopicModel::setSession($topic);

        // falseの場合は、メッセージを出して元の画面に戻す
        // このときに再びgetメソッドが呼ばれる
        redirect(GO_REFERER);
    }
}
