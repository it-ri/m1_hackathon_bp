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

    $trip_id = isset($_GET['tripid']) ? $_GET['tripid'] : null;

    $members = [];
    $url = [];
    $photoURL ="";
      
    $sql = "SELECT `member` FROM `trip-table` WHERE `trip_id` = ?";
    $stmt = $pdo -> prepare($sql);
    $stmt->bindParam(1, $trip_id);
    $stmt->execute();
    $member = $stmt->fetch();

    $members = explode(",", $member['member']);

foreach ($members as $m) {
    $sql = "SELECT `photoURL` FROM `user-table` WHERE `user_id` = ?";
    $stmt = $pdo -> prepare($sql);
    $stmt->bindParam(1, $m);
    $stmt->execute();
    $url = $stmt->fetch();

    // $photoURL = '"'.$url['photoURL'].'",'.$photoURL;
    $photoURL = $photoURL.$url['photoURL'].',';
}
$photoURL = rtrim($photoURL, ',');
echo($photoURL);
