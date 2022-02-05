<?php

namespace partials;

use lib\Auth;
use lib\Msg;

// 関数の形式にして、引数を渡せるようにしておく
function header()
{
?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>みんなのアンケート</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="//fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo BASE_CSS_PATH; ?>style.css">
    </head>

    <body>
        <div id="container">
            <header class="container my-2">
                <nav class="row align-items-center py-2">
                    <a href="<?php the_url('/'); ?>" class="col-md d-flex align-items-center mb-3 mb-md-0">
                        <img width="50" class="mr-2" src="<?php echo BASE_IMAGE_PATH; ?>logo.svg" alt="みんなのアンケート　サイトロゴ">
                        <span class="h2 font-weight-bold mb-0">みんなのアンケート</span>
                    </a>
                    <div class="col-md-auto">
                        <?php if (true) : ?>
                            <a href="<?php the_url('register'); ?>" class="btn btn-primary mr-2">登録</a>
                            <a href="<?php the_url('login'); ?>">ログイン</a>
                        <?php else : ?>
                            <!-- ログインしているとき -->
                        <?php endif; ?>
                    </div>
                </nav>
            </header>
            <main class="container py-3">

            <?php
            // ここで$_SESSION['_msg']にセットされた配列の値をループで表示している
            Msg::flush();

            if (Auth::isLogin()) {
                echo 'ログイン中です。';
            } else {
                echo 'ログインしていません。';
            }
        }
            ?>
