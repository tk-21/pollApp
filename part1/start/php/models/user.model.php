<?php

namespace model;

// データベースから取ってきたユーザー情報を格納するモデル
class UserModel extends AbstractModel {
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_user';
}
