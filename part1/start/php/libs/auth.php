<?php
// 認証機能はこのファイルに書く

namespace lib;

use db\UserQuery;

class Auth
{
    public static function login($id, $pwd)
    {
        // 関数の実行結果を入れる値。ログインが成功したときはtrueを入れる
        $is_success = false;

        $user = UserQuery::fetchById($id);

        // idからユーザーが取れてきた場合、パスワードの確認（DBに登録されているパスワードとの照合）を行う
        if (!empty($user) && $user->del_flg !== 1) {

            // ログインに成功した場合、$is_successにtrueを入れる
            if (password_verify($pwd, $user->pwd)) {
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


    public static function regist($id, $pwd, $nickname)
    {
        // 処理が成功したかどうかのフラグ。初期値はfalse。ログインが成功したときはtrueを入れる
        $is_success = false;

        // まずは同じユーザーが存在するかどうかの確認。idでユーザーが取れてくるかどうか
        $exist_user = UserQuery::fetchById($id);
        if (!empty($exist_user)) {
            echo 'すでにユーザーが存在します。';
            return false;
        }

        $is_success = UserQuery::insert($id, $pwd, $nickname);

        return $is_success;
    }
}
