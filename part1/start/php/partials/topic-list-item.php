<?php

namespace partials;

// この関数が呼ばれると中のHTMLが出力されるようになる
// 引数でtopicというオブジェクトが渡ってくる
function topic_list_item($topic)
{
?>
    <li class="topic row bg-white shadow-sm mb-3 rounded p-3">
        <div class="col-md d-flex align-items-center">
            <h2 class="mb-2 mb-md-0">
                <span class="badge badge-primary mr-1 align-bottom">公開</span>
                <a class="text-body" href="">犬も歩けば棒に当たりますか？</a>
            </h2>
        </div>
        <div class="col-auto mx-auto">
            <div class="text-center row">
                <div class="view col-auto min-w-100">
                    <div class="h1 mb-0">26</div>
                    <div class="mb-0">Views</div>
                </div>
                <div class="likes-green col-auto min-w-100">
                    <div class="h1 mb-0">3</div>
                    <div class="mb-0">賛成</div>
                </div>
                <div class="dislikes-red col-auto min-w-100">
                    <div class="h1 mb-0">2</div>
                    <div class="mb-0">反対</div>
                </div>
            </div>
        </div>
    </li>

<?php
}
