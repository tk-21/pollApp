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
            \partials\topic_list_item($topic);
        }
        ?>
    </ul>

<?php
}
