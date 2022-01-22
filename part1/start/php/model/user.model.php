<?php

namespace model;

// データベースから取ってきたユーザー情報を格納するモデル
class UserModel {
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flag;
    

}
?>
