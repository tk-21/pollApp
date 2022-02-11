<?php

namespace view\topic\detail;

// トピックとコメントが渡ってくる
function index($topic, $comments)
{
    // ここでトピックを１件表示
    // トップページから呼ばれるわけではないので、第２引数はfalse（詳細ページへのリンクは付けない）
    \partials\topic_header_item($topic, false);

    // 以下でトピックに紐付くコメントを表示する
?>

    <ul class="list-unstyled">
        <?php foreach ($comments as $comment) : ?>
            <?php
            // agreeが１のときは賛成、０のときは反対を返す
            $agree_label = $comment->agree ? '賛成' : '反対';
            // 賛成か反対かによって色を変える
            $agree_cls = $comment->agree ? 'badge-success' : 'badge-danger';
            ?>

            <li class="bg-white shadow-sm mb-3 rounded p-3">
                <h2 class="h4 mb-2">
                    <span class="badge mr-1 align-bottom <?php echo $agree_cls; ?>"><?php echo $agree_label; ?></span>
                    <span><?php echo $comment->body; ?></span>
                </h2>
                <span>Commented by <?php echo $comment->nickname; ?></span>
            </li>
        <?php endforeach; ?>
    </ul>

<?php
}
?>
