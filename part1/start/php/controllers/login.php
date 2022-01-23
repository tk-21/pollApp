<?php

// 呼び出す関数を切り替えることによって表示する画面を制御することができる
// 関数名が重複しそうな場合には、namespaceを指定する

namespace controller\login;

use db\UserQuery;

function get()
{
    require_once SOURCE_BASE . 'views/login.php';
}

function login($id, $pwd)
{
    // 関数の実行結果を入れる値。ログインが成功したときはtrueを入れる
    $is_success = false;

    $user = UserQuery::fetchById($id);

    // idからユーザーが取れてきた場合、パスワードの確認（DBに登録されているパスワードとの照合）を行う
    if (!empty($user) && $user->del_flg !== 1) {
        $result = password_verify($pwd, $user->pwd);

        // ログインに成功した場合、$is_successにtrueを入れる
        if ($result) {
            $is_success = true;
            // セッションにもユーザーの情報を入れておく
            // クラスから生成したオブジェクトもセッションに格納することができる
            $_SESSION['user'] = $user;
        } else {
            echo 'パスワードが一致しません。';
        }
    } else {
        echo 'ユーザーがみつかりません。';
    }

    return $is_success;
}

function post()
{
    // 値が飛んでこなかった場合には空文字を設定する
    // null合体演算子
    // 非nullのときは第一オペランドの$_POST['id']を返し、nullのときは第二オペランドの空文字を返す
    // 値が設定されているか確認して、設定されていなければ何らかの値を代入したいときに使う
    $id = $_POST['id'] ?? '';
    $pwd = $_POST['pwd'] ?? '';


    $result = login($id, $pwd);

    if ($result) {
        echo '認証成功';
    } else {
        echo '認証失敗';
    }
}
