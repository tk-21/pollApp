<?php

namespace controller\topic\edit;

use lib\Auth;
use model\TopicModel;
use model\UserModel;

function get()
{
    // ログインしているかどうか確認（管理画面なのでログインは必須）
    Auth::requireLogin();

    // TopicModelのインスタンスを作成
    $topic = new TopicModel;

    // GETから取得したtopic_idをオブジェクトに格納
    $topic->id = get_param('topic_id', null, false);

    // セッションに格納されているユーザー情報のオブジェクトを取ってくる
    $user = UserModel::getSession();

    // ログイン中のユーザーが記事を編集できるかどうかのチェックする
    // userモデルに紐づくtopic->idであれば許可する
    Auth::requirePermission($topic->id, $user);
}
