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
  $trip_id = isset($_GET['tripid']) ? $_GET['tripid'] : null;
  $spot_id = isset($_GET['spotid']) ? $_GET['spotid'] : null;
  $hazure = isset($_GET['hazure']) ? $_GET['hazure'] : null;

  $sql = "INSERT INTO `history-table`(`trip_id`, `spot_id`, `user_id`, `date`, `hazure`) VALUES (?,?,?,NOW(),?)";
  $stmt = $pdo -> prepare($sql);
  $stmt->bindParam(1, $trip_id);
  $stmt->bindParam(2, $spot_id);
  $stmt->bindParam(3, $uid);
  $stmt->bindParam(4, $hazure);
  $stmt->execute();
