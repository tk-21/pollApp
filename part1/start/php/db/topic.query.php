<?php

namespace db;

use db\DataSource;
use model\TopicModel;

class TopicQuery
{
    // 引数でユーザーのオブジェクトが渡ってくる
    // ユーザーのIDに紐付く記事を取得するメソッド
    public static function fetchByUserId($user)
    {
        // idのフォーマットが正しくない場合は処理を終了させる
        if (!$user->isValidId()) {
            return false;
        }
        // idが問題なければクエリを発行
        $db = new DataSource;
        // プリペアードステートメントを使うのでidはパラメータにしておく
        // delete_flgが１のものは取得しないようにして、論理的に無効なレコードは取得しないようにする
        $sql = 'SELECT * FROM pollapp.topics WHERE user_id = :id and del_flg != 1;';
        // 第2引数のパラメータに、引数で渡ってきた文字列を入れる
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // ここはselectメソッドなので複数行取れてくる
        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, TopicModel::class);

        // 結果が取れてくればresultを返す
        return $result;
    }


    // public static function insert($user)
    // {
    //     $db = new DataSource;
    //     $sql = 'insert into users(id, pwd, nickname) values(:id, :pwd, :nickname)';

    //     // パスワードはハッシュ化を行っておく
    //     $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

    //     // 登録に成功すれば、trueが返される
    //     return $db->execute($sql, [
    //         ':id' => $user->id,
    //         ':pwd' => $user->pwd,
    //         ':nickname' => $user->nickname
    //     ]);
    // }
}
