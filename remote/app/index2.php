<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>DB接続サンプル</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
      div {
        margin-top: 10px;
      }
      .container-fluid {
        margin-right: auto;
        margin-left: auto;
        max-width: 400px;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <h2>DB接続サンプル</h2>
<?php
// #######################################################################
// テスト用サンプル
// ・デフォルトのエンコーディング(UTF-8)の確認
// ・日本語データの登録、取得
// #######################################################################

$host = 'localhost';
$db   = 'my_database';
$user = 'my_user';
$pass = 'my_password';

$dsn = "mysql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // SQL作成
    $sql = 'CREATE TABLE IF NOT EXISTS user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(20)
    )';

    // SQL実行
    $res = $pdo->query($sql);
} catch (PDOException $e) {
    echo 'DB connect error<br />';
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

try {
    $pdo->beginTransaction();

    // データ削除
    $pdo->exec('DELETE FROM user');

    // データ追加
    $stmt = $pdo->prepare("INSERT INTO user (name) VALUES (?)");
    foreach (['太郎','花子','一郎','次郎'] as $name)
    {
        $stmt->execute([$name]);
    }

    $pdo->commit();

    // データ表示
    $sql = 'SELECT * FROM user ORDER BY id';
    $stmt = $pdo->query($sql);

    echo '<table class="table">';
    echo '<tr><th>No</th><th>名前</th></tr>';
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo '<tr><td>' . $result['id'] . '</td><td>' . $result['name'] . '</td></tr>';
    }
    echo '</table>';

    echo 'Date: ' . date('Y年m月d日 H時i分s秒') . '<br />';
} catch (PDOException $e){
    if ($pdo->inTransaction()) $pdo->rollback();
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>
    </div>
  </body>
</html>
