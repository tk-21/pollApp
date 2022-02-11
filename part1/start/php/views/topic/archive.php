<?php

namespace view\topic\archive;

// 引数でtopicの配列が渡ってくる
function index($topics)
{
?>
    <h1 class="h2 mb-3">過去の投稿</h1>
    <ul class="container">
        <?php
        // 一つずつの投稿がtopic_list_itemに渡って、リストが形成される
        foreach ($topics as $topic) {
            // idをキーにしてtopicの編集画面に飛ぶようにする
            // get_urlメソッドでフルパスを作成
            // このURLを引数として渡す
            $url = get_url('topic/edit?topic_id=' . $topic->id);
            // 第３引数をtrueにすることで、公開非公開のラベルが表示される
            \partials\topic_list_item($topic, $url, true);
        }
        ?>
    </ul>

<?php
}
