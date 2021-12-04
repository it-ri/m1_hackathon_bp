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


    $name = isset($_GET['name']) ? $_GET['name'] : null;
    $uid = isset($_GET['uid']) ? $_GET['uid'] : null;
    $photoURL = isset($_GET['photoURL']) ? $_GET['photoURL'] : null;


    $target_user = null;
    $users = [];
    $exist = false;

    // ユーザ一覧を取得して $users 配列に保存
    $sql = "SELECT * FROM `user-table`";
      $stmt = $pdo -> prepare($sql);
      $stmt->bindParam(1, $title);
      $stmt->execute();
      foreach ($stmt as $row) {
              $users[] = [
                      'id'   => $row['id'],
                      'name' => $row['user_name'],
                      'uid' => $row['user_id'],
                      'photoURL' => $row['photoURL']
              ];
      }
      
    // 取得してきた $users の中に，$uidを持つユーザがいるか調べる
    foreach ($users as $u) {
      if ($u['uid']===$uid) {
        $exist = true;
        $target_user = $u;
        break;
      }
    }

    // いたらその情報を返す
    if ($exist) {
      echo json_encode($target_user);
    }
    // いなかったら追加してから返す
    else {

      $sql = "INSERT INTO `user-table`(`user_id`, `user_name`, `photoURL`) VALUES(?, ?, ?)";
        $stmt = $pdo -> prepare($sql);
        $stmt->bindParam(1, $uid);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $photoURL);
        $stmt->execute();
        $id = $pdo -> lastInsertId();

      $sql = "SELECT * FROM `user-table` WHERE `id` = ?";
        $stmt = $pdo -> prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        foreach ($stmt as $row) {
          $result[] = [
              'id' => $row['id'],
              'uid' => $row['user_id'],
              'name' => $row['user_name'],
              'photoURL' => $row['photoURL']
          ];
        }
      echo json_encode($result[0]);

    }
 ?>