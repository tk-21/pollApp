<?php

namespace model;

use lib\Msg;

// データベースから取ってきたユーザー情報を格納するモデル
class UserModel extends AbstractModel
{
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_user';

    // IDのバリデーション
    public static function validateId($val)
    {
        // レスポンス
        $res = true;

        // 空文字が渡ってきた場合に注意文を表示する
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'ユーザーIDを入力してください。');
            // バリデートが失敗した場合にマークしておく
            $res = false;
        } else {
            // 文字列の長さが11文字以上だったら
            if (strlen($val) > 10) {
                Msg::push(Msg::ERROR, 'ユーザーIDは10桁以下で入力してください。');
                $res = false;
            }

            // 小文字か大文字の半角英字もしくは数字にマッチしない場合
            if (!is_alnum($val)) {
                Msg::push(Msg::ERROR, 'ユーザーIDは半角英数字で入力してください。');
                $res = false;
            }
        }
        // エラーに引っかかった場合はfalseが返る
        return $res;
    }

    // インスタンスメソッドとしてはこのメソッドを使う
    public function isValidId()
    {
        return static::validateId($this->id);
    }


    // パスワードのバリデーション
    public static function validatePwd($val)
    {
        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'パスワードを入力してください。');
            $res = false;
        } else {

            // 半角のみを数えるときはstrlenでOK
            if (strlen($val) < 4) {

                Msg::push(Msg::ERROR, 'パスワードは４桁以上で入力してください。');
                $res = false;
            }

            if (!is_alnum($val)) {

                Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください。');
                $res = false;
            }
        }

        return $res;
    }

    // インスタンスメソッドとしてはこのメソッドを使う
    public function isValidPwd()
    {
        return static::validatePwd($this->pwd);
    }


    // ニックネームのバリデーション
    public static function validateNickname($val)
    {

        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'ニックネームを入力してください。');
            $res = false;
        } else {

            // mb_strlenは半角でも全角でも文字数カウント分だけ返してくれるので、日本語をチェックするときはこの関数を使う
            if (mb_strlen($val) > 10) {

                Msg::push(Msg::ERROR, 'ニックネームは１０桁以下で入力してください。');
                $res = false;
            }
        }

        return $res;
    }

    // インスタンスメソッドとしてはこのメソッドを使う
    public function isValidNickname()
    {
        return static::validateNickname($this->nickname);
    }
}
