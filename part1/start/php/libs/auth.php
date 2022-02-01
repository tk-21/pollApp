<?php
// 認証機能はこのファイルに書く

namespace lib;

use db\UserQuery;
use model\UserModel;
use Throwable;

class Auth
{
    public static function login($id, $pwd)
    {
        try {
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
                    UserModel::setSession($user);
                } else {
                    echo 'パスワードが一致しません。';
                }
            } else {
                echo 'ユーザーがみつかりません。';
            }
        } catch (Throwable $e) {
            // 例外が発生した場合はfalseになるようにしておく
            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ログイン処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        }

        return $is_success;
    }


    // POSTで送られてきた値が入ったUserオブジェクト($user)が引数で渡ってくる
    public static function regist($user)
    {
        try {
            // 処理が成功したかどうかのフラグ。初期値はfalse。ログインが成功したときはtrueを入れる
            $is_success = false;

            // まずは同じユーザーが存在するかどうかの確認。idでユーザーが取れてくるかどうか
            $exist_user = UserQuery::fetchById($user->id);
            if (!empty($exist_user)) {
                echo 'すでにユーザーが存在します。';
                return false;
            }

            // 登録が成功すれば$is_successにtrueが入る
            $is_success = UserQuery::insert($user);

            if ($is_success) {
                // setSessionにuserオブジェクトを渡す
                // スーパーグローバルには何らかの共通したメソッドからアクセスするようにする
                UserModel::setSession($user);
                // $_SESSION['user'] = $user;
            }
        } catch (Throwable $e) {
            // 例外が発生した場合はfalseになるようにしておく
            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ユーザー登録でエラーが発生しました。少し時間をおいてから再度お試しください。');
        }

        return $is_success;
    }


    // ログインしているかどうかを判定する
    public static function isLogin()
    {
        try {
            $user = UserModel::getSession();
        } catch (Throwable $e) {
            // ユーザー認証に関わるので、例外が発生した場合はユーザーをログアウトさせる
            UserModel::clearSession();
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'エラーが発生しました。再度ログインを行ってください。');
            // 例外が発生した時点でfalseを返す
            return false;
        }

        if (isset($user)) {
            return true;
        } else {
            return false;
        }
    }
}
