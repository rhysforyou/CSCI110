<?php

include_once('./database.php');

session_start();

if (!$_SESSION["user"]) {
  handle_error("You must be signed in to manage subjects");
  exit();
}

$code = $_GET["code"];
$mysqli = db_connect();

$query = $mysqli->prepare("SELECT * FROM subjects WHERE  lecturer=?");
$query->bind_param('s', $_SESSION["user"]);
$query->execute();

$query->bind_result($code, $title, $content, $objectives, $lecturer);

if ($query->fetch()) {
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>$code: $title</title>
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <h1>$code: $title</h1>
    <ul>
      <li><a href="./view_subject.php?code=$code">View subject details</a></li>
      <li><a href="./add_students?code=$code">Add students</a></li>
      <li><a href="./define_assessments?code=$code">Define assessment tasks</a></li>
      <li><a href="./upload_marks?code=$code">Upload marks</a></li>
      <li><a href="#">View class marks</a></li>
      <li><a href="#">View histograms</a></li>
      
      <li><a href="./log_out">Log out</a></li>
    </ul>
    
    <a href="./">Back to Home</a>
  </section>
</body>
</html>
HERE;
} else {
  handle_error("Subject not found");
}

?>