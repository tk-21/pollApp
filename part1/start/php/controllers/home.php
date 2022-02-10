<?php
namespace controller\home;

use db\TopicQuery;

// getでリクエストが来た場合
function get() {

    $topics = TopicQuery::fetchPublishedTopics();
    \view\home\index($topics);
}
