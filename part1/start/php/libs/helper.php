<?php
// 共通で使う処理はこのファイルに書いていく


// 初期化処理を関数として定義する
// $_POSTや$_GETなどのスーパーグローバル変数はアクセスできるところを限定してやる。いたるところでアクセスできるようにしてしまうと修正が大変だから
function get_param($key, $default_val, $is_post = true)
{
    // $is_postのデフォルト値はtrueなので、省略されたときは$_POSTが代入される
    $array = $is_post ? $_POST : $_GET;
    // 値が飛んでこなかった場合には$default_valを設定する
    // null合体演算子
    // 非nullのときは第一オペランドを返し、nullのときは第二オペランドを返す
    // 値が設定されているか確認して、設定されていなければ何らかの値を代入したいときに使う
    return $array[$key] ?? $default_val;
}

// 渡ってきた値が含まれるURLに遷移させるメソッド
function redirect($path)
{
    if ($path === GO_HOME) {
        $path = get_url('');
    } elseif ($path === GO_REFERER) {
        $path = $_SERVER['HTTP_REFERER'];
    } else {
        $path = get_url($path);
    }

    header("Location: {$path}");
    die();
}

// get_urlで取得したURLを画面表示するメソッド
function the_url($path)
{
    echo get_url($path);
}

// 渡ってきた値をstartまでのパスの後ろにつなげてURLを返すメソッド
function get_url($path)
{
    // 両端にスラッシュが含まれていればトリミングする
    return BASE_CONTEXT_PATH . trim($path, '/');
}

// 小文字か大文字の半角英字もしくは数字にマッチするかどうかを判定するメソッド
function is_alnum($val)
{
    return preg_match("/^[a-zA-Z0-9]+$/", $val);
}
