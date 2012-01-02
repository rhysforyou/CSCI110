<?php

include_once('./database.php');

session_start();

if (!$_SESSION["user"]) {
  handle_error("You must be signed in to manage subjects");
  exit();
}

$code = $_GET["code"];
$mysqli = db_connect();

$query = $mysqli->prepare("SELECT * FROM subjects WHERE lecturer=?");
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
    
    <h2>Subject Content</h2>
    <p>$content</p>
    
    <h2>Subject Objectives</h2>
    <p>$objectives</p>
    
    <h2>Enrolled Students</h2>
    <ul class="students">
HERE;
    
    $mysqli->close();
    $mysqli = db_connect();
    
    $student_query = $mysqli->prepare("SELECT * FROM students WHERE subject=? ORDER BY id ASC");
    
    $err = $mysqli->error;
    if ($err) {
      echo($err);
    }
    
    $student_query->bind_param('s', $code);
    $student_query->bind_result($id, $password, $tutorial, $subject);
    $student_query->execute();
    
    while ($student_query->fetch()) {
      echo "<li>" . $id . "</li>";
    }
    
    echo <<<HERE
    </ul>
    <a href="./manage_subject.php?code=$code">Back to Subject</a>
  </section>
</body>
</html>
HERE;
} else {
  handle_error("Subject not found");
}

?>