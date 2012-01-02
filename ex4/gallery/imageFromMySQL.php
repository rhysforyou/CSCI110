<?php

include_once('shared.php');

$id = $_GET["id"];

$mysqli = db_connect();
$query = "SELECT image FROM photos WHERE id=$id";
$result = $mysqli->query($query);
$error = $mysqli->error;

if ($error) {
  handle_error($error);
  exit;
}

$row = $result->fetch_array(MYSQLI_NUM);
$bytes = $row[0];

header("Content-Type: image/jpg");
echo $bytes;

?>