<?php

namespace db;

use db\DataSource;
use model\UserModel;

class UserQuery
{
    public static function fetchById($id)
    {
        $db = new DataSource;
        // プリペアードステートメントを使うのでidはパラメータにしておく
        $sql = 'SELECT * FROM users WHERE id = :id;';
        // 第2引数にパラメータに、引数で渡ってきた文字列を入れる
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でUserModelまでのパスを取得して、そのクラスを使うように指定
        $result = $db->selectOne($sql, [
            ':id' => $id
        ], DataSource::CLS, UserModel::class);

        return $result;
    }


    public static function insert($user)
    {
        $db = new DataSource;
        $sql = 'insert into users(id, pwd, nickname) values(:id, :pwd, :nickname)';

        // パスワードはハッシュ化を行っておく
        $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':id' => $user->id,
            ':pwd' => $user->pwd,
            ':nickname' => $user->nickname
        ]);
    }
}
