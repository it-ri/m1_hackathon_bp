<?php
header('Access-Control-Allow-Origin: *');
//MySQLにログインするユーザーとパスワードを設定
define("USERNAME", "nakamura-lab");
define("PASSWORD", "n1k2m3r4fms");
//mysql:host=localhost; dbname=ito_db; charset=utf8', "nakamura-lab","n1k2m3r4fms"
try{

//データベースに接続する情報の指定
$dbh = new PDO("mysql:host=localhost; dbname=m1_5th; charset=utf8", "nakamura-lab","n1k2m3r4fms");

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 静的プレースホルダを指定
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//実行したいSQL文を記述 SELECT * FROM `history-table` WHERE `trip_id`=1
$stmt = $dbh->prepare("SELECT * FROM `history-table` WHERE `trip_id`= '". $_GET["trip_id"]."'");

$stmt->setFetchMode(PDO::FETCH_ASSOC);

$stmt->execute();

$rows = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
$rows[]=$row;
}

//接続成功ならjson形式で吐き出します
echo $json = json_encode($rows);

} catch(PDOException $e){

//一応失敗時のメッセージを記入
echo "失敗時のメッセージ（なくていもいい）"+$dbh;
echo $e->getMessage();
}

$dbh = null;

?>