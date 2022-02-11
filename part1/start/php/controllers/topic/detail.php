<?php

namespace controller\topic\detail;

use db\CommentQuery;
use db\TopicQuery;
use lib\Msg;
use model\TopicModel;

function get()
{
    $topic = new TopicModel;
    // $_GET['topic_id']から値を取ってくる
    // getから値を取るときは第３引数をfalseにしておく
    $topic->id = get_param('topic_id', null, false);

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに該当するトピックを１件取ってくる
    $fetchedTopic = TopicQuery::fetchById($topic);

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに紐付くコメントを取ってくる
    $comments = CommentQuery::fetchByTopicId($topic);

    // トピックが取れてこなかった場合は４０４ページにリダイレクト
    if (!$fetchedTopic) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }

    // トピックが取れてきた場合、viewのdetailのindexにtopicオブジェクトとcommentsオブジェクトを渡して実行
    \view\topic\detail\index($fetchedTopic, $comments);
}
