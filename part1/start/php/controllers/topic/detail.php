<?php

namespace controller\topic\detail;

use db\CommentQuery;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;

function get()
{
    $topic = new TopicModel;
    // $_GET['topic_id']から値を取ってくる
    // getから値を取るときは第３引数をfalseにしておく
    $topic->id = get_param('topic_id', null, false);

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに該当する記事を１件取ってくる
    $topic = TopicQuery::fetchById($topic);

    // 引数で渡したtopicのidに紐付くコメントを取ってくる
    $comments = CommentQuery::fetchByTopicId($topic);

    // topicの値が取れてこなかった場合
    if (!$topic) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }

    // topicが取れてきた場合、viewのdetailのindexにtopicオブジェクトとcommentsオブジェクトを渡す
    \view\topic\detail\index($topic, $comments);
}
