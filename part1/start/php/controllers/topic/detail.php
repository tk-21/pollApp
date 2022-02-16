<?php

namespace controller\topic\detail;

use Throwable;
use db\CommentQuery;
use db\DataSource;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\CommentModel;
use model\TopicModel;
use model\UserModel;

function get()
{
    $topic = new TopicModel;

    // $_GET['topic_id']から値を取ってくる
    // getから値を取るときは第３引数をfalseにしておく
    $topic->id = get_param('topic_id', null, false);

    // このメソッドを実行することでDBのviewsに１を足す
    TopicQuery::incrementViewCount($topic);

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに該当するトピックを１件取ってくる
    $fetchedTopic = TopicQuery::fetchById($topic);

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに紐付くコメントを取ってくる
    $comments = CommentQuery::fetchByTopicId($topic);

    // トピックが取れてこなかった場合、またはpublishedの値がfalseの場合（０の場合）は４０４ページにリダイレクト
    if (empty($fetchedTopic) || !$fetchedTopic->published) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }

    // トピックが取れてきた場合、viewのdetailのindexにtopicオブジェクトとcommentsオブジェクトを渡して実行
    \view\topic\detail\index($fetchedTopic, $comments);
}

// コメントをフォームから送信するメソッド
function post()
{
    // ログインしていないとフォームが出てこないので、ますログインを要求する
    Auth::requireLogin();

    // コメントモデルの初期化
    $comment = new CommentModel;

    // postで飛んできた値を格納する
    $comment->topic_id = get_param('topic_id', null);
    $comment->agree = get_param('agree', null);
    $comment->body = get_param('body', null);

    // ユーザー情報を取得する
    $user = UserModel::getSession();

    // user_idをコメントのuser_idに入れる
    $comment->user_id = $user->id;

    try {
        // ２つのテーブルに更新を投げるのでトランザクションを使用する
        // DB接続
        $db = new DataSource;
        $db->begin();

        // コメントのオブジェクトを渡して実行
        $is_success = TopicQuery::incrementLikesOrDislikes($comment);

        // 賛成反対のインクリメントが成功して、かつコメント入力がされていれば、インサートのクエリを実行する
        if ($is_success && !empty($comment->body)) {
            $is_success = CommentQuery::insert($comment);
        }
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        $is_success = false;
    } finally {
        // 成功した場合はコミットを行い、それ以外の場合はロールバックで切り戻しを行う
        // finallyブロックで行うことによって、不整合なデータが登録されるのを防ぐ
        if ($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, 'コメントの登録に成功しました。');
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, 'コメントの登録に失敗しました。');
        }
    }

    // 処理が終了したら画面を移動させる
    redirect('topic/detail?topic_id=' . $comment->topic_id);
}
