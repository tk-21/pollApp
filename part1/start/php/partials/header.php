<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>みんなのアンケート</title>
    <!-- <link rel="stylesheet" href="<?php echo BASE_CSS_PATH ?>sample.css"> -->
</head>

<body>

    <?php

    use lib\Auth;
    use lib\Msg;

    Msg::flush();

    if (Auth::isLogin()) {
        echo 'ログイン中です。';
    } else {
        echo 'ログインしていません。';
    }
    ?>
