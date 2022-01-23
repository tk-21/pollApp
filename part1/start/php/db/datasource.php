<?php

namespace db;

use PDO;

class DataSource
{

    private $conn;
    private $sqlResult;
    // クラス内でなんらかのキーを使う場合は、静的プロパティとして定数を用意する
    public const CLS = 'cls';

    public function __construct($host = 'localhost', $port = '8889', $dbName = 'pollapp', $username = 'test_user', $password = 'pwd')
    {

        $dsn = "mysql:host={$host};port={$port};dbname={$dbName};";
        $this->conn = new PDO($dsn, $username, $password);
        //デフォルトのFETCH_MODEをFETCH_ASSOCに設定
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // 例外が発生したときに、PDOExceptionの例外を投げてくれるようにする
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // DBのプリペアードステートメントの機能を使うようにし、PDOの機能は使わないようにする設定↓
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function select($sql = "", $params = [], $type = '', $cls = '')
    {
        // 厳格に型を指定したいときはbindValueを使う
        $stmt = $this->executeSql($sql, $params);
        // typeがclsで渡ってきたら、フェッチモードをFETCH_CLASSに、それ以外の場合はFETCH_ASSOCにする
        if ($type === static::CLS) {
            // FETCH_CLASSを使うと、指定したクラスのプロパティにカラムの値を代入できる。一致するプロパティが存在しない場合は、そのプロパティが作成される。
            return $stmt->fetchAll(PDO::FETCH_CLASS, $cls);
        } else {
            // 上でデフォルトモードを連想配列に設定しているので改めてPDO::FETCH_ASSOC記述しなくてもよい
            return $stmt->fetchAll();
        }
    }

    // 更新系はこのメソッドを使う
    public function execute($sql = "", $params = [])
    {
        $this->executeSql($sql, $params);
        // PDOのexecuteと戻り値を同じにするため、$this->sqlResultを返す
        return  $this->sqlResult;
    }

    public function selectOne($sql = "", $params = [], $type = '', $cls = '')
    {
        $result = $this->select($sql, $params, $type, $cls);
        // 1行だけ取ってきたいので、$resultの0番目を返す
        // countで空の配列ではないことを確認する
        return count($result) > 0 ? $result[0] : false;
    }

    public function begin()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollback()
    {
        $this->conn->rollback();
    }

    private function executeSql($sql, $params)
    {
        // $sqlで渡ってきたsqlを渡してprepareを実行
        $stmt = $this->conn->prepare($sql);
        // $paramsで渡ってきた配列を渡して実行し、$sqlResultに格納
        $this->sqlResult = $stmt->execute($params);
        // ステートメントを返す
        return $stmt;
    }
}
