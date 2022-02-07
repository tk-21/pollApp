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
            // ここはstaticのメソッドを使う
            // バリデーションがどれか一つでもfalseで返ってきたら
            if (
                !(UserModel::validateId($id)
                    * UserModel::validatePwd($pwd))
            ) {
                // 呼び出し元のregister.phpにfalseを返して登録失敗になる
                return false;
            }

            // 関数の実行結果を入れる値。ログインが成功したときはtrueを入れる
            $is_success = false;

            // DBに接続する前にバリデーションは終わらせておく
            $user = UserQuery::fetchById($id);

            // idからユーザーが取れてきた場合、パスワードの確認（DBに登録されているパスワードとの照合）を行う
            if (!empty($user) && $user->del_flg !== 1) {

                // ログインに成功した場合、$is_successにtrueを入れる
                if (password_verify($pwd, $user->pwd)) {
                    $is_success = true;
                    // セッションにもユーザーの情報を入れておく
                    // クラスから生成したユーザー情報の入ったオブジェクトをセッションに格納
                    UserModel::setSession($user);
                } else {
                    Msg::push(Msg::ERROR, 'パスワードが一致しません。');
                }
            } else {
                Msg::push(Msg::ERROR, 'ユーザーがみつかりません。');
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
            // DBに接続する前に必ずチェックは終わらせておく
            // バリデーションがどれか一つでもfalseで返ってきたら
            if (
                // ()の中が０の場合にはtrueになり、if文の中が実行される
                // trueまたはfalseを返すメソッドを*の演算子でつなげると、１または０に変換される。これらをすべて掛け合わせたときに結果が０であれば、どれかのチェックがfalseで返ってきたことになる
                !($user->isValidId()
                    * $user->isValidPwd()
                    * $user->isValidNickname())
            ) {
                // 呼び出し元のregister.phpにfalseを返して登録失敗になる
                return false;
            }

            // 処理が成功したかどうかのフラグ。初期値はfalse。ログインが成功したときはtrueを入れる
            $is_success = false;

            // まずは同じユーザーが存在するかどうかの確認。idでユーザーが取れてくるかどうか
            $exist_user = UserQuery::fetchById($user->id);
            if (!empty($exist_user)) {
                Msg::push(Msg::ERROR, 'すでにユーザーが存在します。');
                return false;
            }

            // 登録が成功すれば$is_successにtrueが入る
            $is_success = UserQuery::insert($user);

            if ($is_success) {
                // UserModelのsetSessionにuserオブジェクトを渡してセッションに情報をセットする
                // スーパーグローバルには何らかの共通したメソッドからアクセスするようにする
                UserModel::setSession($user);
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

    // ログアウトするメソッド
    public static function logout()
    {
        try {
            // ユーザープロパティのセッション情報が削除される
            UserModel::clearSession();
        } catch (Throwable $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
            // 例外が発生した時点でfalseを返す
            return false;
        }

        // 例外が発生しなかったらtrueを返す
        return true;
    }

    // ログインを促すメソッド
    public static function requireLogin()
    {
        // もしログインしていない場合、メッセージを追加してログイン画面へリダイレクトさせる
        if (!static::isLogin()) {
            Msg::push(Msg::ERROR, 'ログインしてください。');
            redirect('login');
        }
    }
}
