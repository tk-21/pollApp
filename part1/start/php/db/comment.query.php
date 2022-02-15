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
        if (!$topic->isValidId()) {
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


    public static function insert($comment)
    {
        // 値のチェック
        // DBに接続する前に必ずチェックは終わらせておく
        // バリデーションがどれか一つでもfalseで返ってきたら、呼び出し元にfalseを返して登録失敗になる
        if (
            // ()の中が０の場合にはtrueになり、if文の中が実行される
            // trueまたはfalseを返すメソッドを*の演算子でつなげると、１または０に変換される。これらをすべて掛け合わせたときに結果が０であれば、どれかのチェックがfalseで返ってきたことになる
            !($comment->isValidTopicId()
                * $comment->isValidBody()
                * $comment->isValidAgree())
        ) {
            return false;
        }

        $db = new DataSource;

        $sql = '
        insert into comments
            (topic_id, agree, body, user_id)
        values
            (:topic_id, :agree, :body, :user_id)
        ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':topic_id' => $comment->topic_id,
            ':agree' => $comment->agree,
            ':body' => $comment->body,
            ':user_id' => $comment->user_id
        ]);
    }
}
