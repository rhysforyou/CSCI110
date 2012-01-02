<?php

include_once('shared.php');

$id = $_GET["id"];
$tag = $_POST["tag"];
$mysqli = db_connect();

$query = $mysqli->prepare("INSERT INTO tags VALUES (null, ?, ?)");
$query->bind_param('sd', $tag, $id);
$query->execute();

header("Location: ./showPicture?id=$id")

?>