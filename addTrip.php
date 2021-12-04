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
        $pdo = new PDO(DSN, USERNAME, PASSWORD, OPTIONS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->GETMessage());
    }

    $uid = isset($_GET['uid']) ? $_GET['uid'] : null;
    // $tripid = isset($_GET['tripid']) ? $_GET['tripid'] : null;
    $start = isset($_GET['start']) ? $_GET['start'] : null;
    $goal = isset($_GET['goal']) ? $_GET['goal'] : null;
    $time = isset($_GET['time']) ? $_GET['time'] : null;

    $target_trip = null;
    $trips = [];
    $exist = false;

    // 旅一覧を取得して $trips 配列に保存
    $sql = "SELECT * FROM `trip-table`";
      $stmt = $pdo -> prepare($sql);
      $stmt->execute();
      foreach ($stmt as $row) {
          $trips[] = [
                  'trip_id' => $row['trip_id'],
                  'member' => $row['member'],
                  'time' => $row['time']
              ];
      }
      
    // 取得してきた $trips の中に，$uidを持つユーザがいるか/日付が同じか調べる
    foreach ($trips as $t) {
        if (strpos($t['member'], $uid)!==false) {
            if (strpos($t['time'], date('Y-m-d'))!==false) {
                $exist = true;
                $target_trip = $t;
                break;
            }
        }
    }

    // いたらその情報をアップデートして返す
    if ($exist) {
        if ($start!=null) {
            $sql = "UPDATE `trip-table` SET `startStation`=?,`goalStation`=?,`goalTime`=? WHERE `trip_id` = ?";
            $stmt = $pdo -> prepare($sql);
            $stmt->bindParam(1, $start);
            $stmt->bindParam(2, $goal);
            $stmt->bindParam(3, $time);
            $stmt->bindParam(4, $target_trip["trip_id"]);
            $stmt->execute();
        }
        echo json_encode($target_trip);
    }
    // いなかったら追加してから返す
    else {
        $sql = "INSERT INTO `trip-table`( `title`, `time`, `distance`, `member`, `startStation`, `goalStation`, `goalTime`) VALUES('', NOW(), 0,?,'','','')";
        $stmt = $pdo -> prepare($sql);
        $stmt->bindParam(1, $uid);
        $stmt->execute();
        $id = $pdo -> lastInsertId();

        $sql = "SELECT * FROM `trip-table` WHERE `trip_id` = ?";
        $stmt = $pdo -> prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        foreach ($stmt as $row) {
            $result[] = [
              'trip_id' => $row['trip_id']
          ];
        }
        echo json_encode($result[0]);
    }
