<?php

namespace db;

use db\DataSource;
use model\CommentModel;

class CommentQuery
{
    // controllerのdetail.phpで呼び出している
    public static function fetchByTopicId($topic)
    {
        // 渡ってきたトピックオブジェクトのidが正しいか確認
        if(!$topic->isValidId()) {
            return false;
        }

        $db = new DataSource;

        // commentsテーブルとusersテーブルをinner joinで内部結合している
        $sql = '
        select c.*, u.nickname FROM comments c
        inner join users u
        on c.user_id  = u.id
        WHERE c.topic_id = :id
        AND c.body != ""
        AND c.del_flg != 1
        AND u.del_flg != 1
        ORDER BY c.id DESC
        ';
        // 第2引数のパラメータは指定しないので、空の配列を渡す
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // ここはselectメソッドなので複数行取れてくる
        // $resultにはオブジェクトの配列が格納される
        $result = $db->select($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, CommentModel::class);

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
