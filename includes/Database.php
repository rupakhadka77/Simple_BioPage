<?php
$dsn = 'mysql:dbname=finalproject;host=127.0.0.1;port=3306';
$user = 'root';
$password = '';

try {
  $ConnectingDB = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
  echo "Connection Failed: ".$e->getMessage();
}
 ?>
