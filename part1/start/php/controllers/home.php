<?php

namespace controller\home;

use db\TopicQuery;

// getでリクエストが来た場合
function get()
{

    $topics = TopicQuery::fetchPublishedTopics();
    // 投稿を表示する
    \view\home\index($topics);
}
