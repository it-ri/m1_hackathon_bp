<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
  header('Content-Type: application/json; charset=utf-8');

  define("DSN", "mysql:host=localhost;dbname=m1_5th");
  define("USERNAME", "nakamura-lab");
  define("PASSWORD", "n1k2m3r4fms");
  define("OPTIONS", [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4']);


    try {
        $pdo = new PDO(DSN, USERNAME, PASSWORD , OPTIONS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->GETMessage());
    }

    $uid = isset($_GET['uid']) ? $_GET['uid'] : null;
    $trip_id = isset($_GET['tripid']) ? $_GET['tripid'] : null;

    $m = [];
      
    $sql = "SELECT `member` FROM `trip-table` WHERE `trip_id` = ?";
    $stmt = $pdo -> prepare($sql);
    $stmt->bindParam(1, $trip_id);
    $stmt->execute();
    $m = $stmt->fetch();

    // メンバーに$uidが入ってなければ追加
        if (strpos($m['member'],$uid)===false) {
            $addMember = $m['member'].",".$uid;

            $sql = "UPDATE `trip-table` SET `member`=? WHERE `trip_id` = ?";
                $stmt = $pdo -> prepare($sql);
                $stmt->bindParam(1, $addMember);
                $stmt->bindParam(2, $trip_id);
                $stmt->execute();

                echo($trip_id."のメンバーになりました");
        }else{
            echo("もうメンバーになっています");
        }
      
  

