<?php
//これ多分使わないけど一応

if (!isset($_GET['user_id'])) {
    header('Location: https://topページに戻す/');
    exit();
}
$user_id = $_GET['user_id'];

if (!isset($_GET['user_name'])) {
    header('Location: https://‘前のページに戻す');
    exit();
}
$u_name = $_GET['user_name'];


//最初の設定
$dsn = "mysql:host=localhost; dbname=m1_5th; charset=utf8";
$username = "nakamura-lab";
$password = "n1k2m3r4fms";

//接続確認
try {
    $dbh = new PDO($dsn, $username, $password);

    //登録する
    $sql = "INSERT INTO `user-table` (user_id, user_name) VALUES (?, ?)";
    $stmt = $dbh->prepare($sql); //SQL文の設定

    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $u_name, PDO::PARAM_STR);

    $stmt->execute(); //SQLの実行
} catch (PDOException $e) {
    $msg = $e->getMessage();
} finally {
    // DB接続を閉じる
    $pdo = null;
    // 後で追加
    //header('Location: https://‘前のページに戻す');
    //exit();
}
