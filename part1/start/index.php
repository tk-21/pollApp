<?php
require_once 'config.php';

// 部品を共通化する
require_once 'partials/header.php';

if ($_SERVER['REQUEST_URI'] === '/poll/part1/start/login') {
    require_once 'views/login.php';
} elseif ($_SERVER['REQUEST_URI'] === '/poll/part1/start/register') {
    require_once 'views/register.php';
} elseif ($_SERVER['REQUEST_URI'] === '/poll/part1/start/') {
    require_once 'views/home.php';
}


require_once 'partials/footer.php';
