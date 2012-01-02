<?php

header("Content-type: text/json");

$faculty = $_GET["faculty"];
$subjects = array();

$mysqli = new mysqli('localhost', 'rpowell', 'floopthepig', 'ajax_subjects');
$query = $mysqli->prepare("SELECT * FROM ErehwonSubjects WHERE faculty=?");
$query->bind_param('s', $faculty);
$query->bind_result($subject_code, $faculty, $name, $lecturer, $description);
$query->execute();

$error = $mysqli->error;
if ($error) {
  echo $error;
}

while($query->fetch()) {
  $subjects[] = array(
    "code" => $subject_code,
    "title" => $name,
    "lecturer" => $lecturer,
    "description" => $description
  );
}

echo json_encode($subjects);

?>