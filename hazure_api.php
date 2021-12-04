<?php
//はずれの登録をするよ

if (!isset($_GET['user_id'])) {
    header('Location: https://topページに戻す/');
    exit();
}
$user_id = $_GET['user_id'];

if (!isset($_GET['title'])) {
    header('Location: https://‘前のページに戻す');
    exit();
}
$title = $_GET['title'];
$place = $_GET['place'];


//最初の設定
$dsn = "mysql:host=localhost; dbname=m1_5th; charset=utf8";
$username = "nakamura-lab";
$password = "n1k2m3r4fms";

//接続確認
try {
    $dbh = new PDO($dsn, $username, $password);

    //登録する
    $sql = "INSERT INTO `hazure-table` (title, user_id, place) VALUES (?, ?, ?)";
    $stmt = $dbh->prepare($sql); //SQL文の設定

    $stmt->bindValue(1, $title, PDO::PARAM_STR);
    $stmt->bindValue(2, $user_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $place, PDO::PARAM_STR);

    $stmt->execute(); //SQLの実行
} catch (PDOException $e) {
    $msg = $e->getMessage();
} finally {
    // DB接続を閉じる
    $pdo = null;
    //後で追加
    //header('Location: https://‘前のページに戻す');
    //exit();

}
