<?php

namespace view\home;

// 引数でトピックの配列が渡ってくる
function index($topics)
{
    // 配列の先頭だけ切り出す
    // $topicsの配列の一番最初だけ$topicに入り、残りのものは$topicsに格納される
    $topic = array_shift($topics);

    // 一番最初の値だけtopic_header_itemで表示し、残りはtopic_list_itemで表示するようにしている
    \partials\topic_header_item($topic);
?>

    <ul class="container">
        <?php
        // 一つずつの投稿がtopic_list_itemに渡って、リストが形成される
        foreach ($topics as $topic) {
            // idをキーにしてtopicの編集画面に飛ぶようにする
            // このURLを引数として渡す
            $url = get_url('topic/edit?topic_id=' . $topic->id);
            \partials\topic_list_item($topic, $url);
        }
        ?>
    </ul>

<?php
}
?>
