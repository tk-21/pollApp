<?php

namespace partials;

// この関数が呼ばれると中のHTMLが出力されるようになる
// 引数でtopicというオブジェクトが渡ってくる
// 編集画面に遷移させるためのURLも引数として渡ってくる
function topic_list_item($topic, $title_url, $with_status)
{
    // publishedが１のときは公開、０のときは非公開
    $published_label = $topic->published ? '公開' : '非公開';
    // ラベルの色を切り替える
    $published_cls = $topic->published ? 'badge-primary' : 'badge-danger';
?>
    <li class="topic row bg-white shadow-sm mb-3 rounded p-3">
        <div class="col-md d-flex align-items-center">
            <h2 class="mb-2 mb-md-0">

                <?php if ($with_status) : //$with_statusがtrueの場合、ラベルを表示する 
                ?>
                    <span class="badge mr-1 align-bottom <?php echo $published_cls; ?>"><?php echo $published_label; ?></span>
                <?php endif; ?>

                <a class="text-body" href="<?php echo $title_url; ?>"><?php echo $topic->title; ?></a>
            </h2>
        </div>
        <div class="col-auto mx-auto">
            <div class="text-center row">
                <div class="view col-auto min-w-100">
                    <div class="h1 mb-0"><?php echo $topic->views; ?></div>
                    <div class="mb-0">Views</div>
                </div>
                <div class="likes-green col-auto min-w-100">
                    <div class="h1 mb-0"><?php echo $topic->likes; ?></div>
                    <div class="mb-0">賛成</div>
                </div>
                <div class="dislikes-red col-auto min-w-100">
                    <div class="h1 mb-0"><?php echo $topic->dislikes; ?></div>
                    <div class="mb-0">反対</div>
                </div>
            </div>
        </div>
    </li>

<?php
}
