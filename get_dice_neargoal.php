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

if(isset($_GET["station"])){
    $stmt=$dbh -> prepare("(SELECT * FROM `spot-table` WHERE `nearest_station` LIKE '".$_GET["station"]."' LIMIT 1 ) UNION (SELECT * FROM `spot-table` WHERE `nearest_station` NOT LIKE '".$_GET["staiton"]."' AND `tag`=1 LIMIT 5)`");
    if($_GET["gohan"]==0){
        //実行したいSQL文を記述 select * from `spot-table` order by UUID() LIMIT 6
            $stmt = $dbh->prepare("(SELECT * FROM `spot-table` WHERE `nearest_station` LIKE '".$_GET["station"]."' AND `tag`=1 LIMIT 1 ) UNION (SELECT * FROM `spot-table` WHERE `nearest_station` NOT LIKE '".$_GET["station"]."' AND `tag`=1 LIMIT 5)`");
        }else {
            $stmt = $dbh->prepare("(SELECT * FROM `spot-table` WHERE `nearest_station` LIKE '".$_GET["station"]."' AND `tag`!=1 LIMIT 1 ) UNION (SELECT * FROM `spot-table` WHERE `nearest_station` NOT LIKE '".$_GET["station"]."' AND `tag`!=1 LIMIT 5)`");
        }
}else{
    if($_GET["gohan"]==0){
        //実行したいSQL文を記述 select * from `spot-table` order by UUID() LIMIT 6
            $stmt = $dbh->prepare("select * from `spot-table` WHERE `tag`!=1 order by UUID() LIMIT 6");
        }else {
            $stmt = $dbh->prepare("select * from `spot-table` WHERE `tag`=1 order by UUID() LIMIT 6");
        }        

}
//(SELECT * FROM `spot-table` WHERE `nearest_station` LIKE "市ヶ谷" LIMIT 1 ) UNION (SELECT * FROM `spot-table` WHERE `nearest_station` NOT LIKE "市ヶ谷" AND `tag`=1 LIMIT 5)
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
echo "失敗時のメッセージ（なくていもいい）"+"select * from `spot-table` order by UUID() LIMIT 6";
echo $e->getMessage();
}

$dbh = null;

?>