<?php

include_once('database.php');

session_start();

function upload_marks() {
  $error = $_FILES["marks"]["erro"];
  
  if ($error != UPLOAD_ERR_OK) {
    handle_error("Failed to upload marks data");
    exit();
  }
  
  $filename = $_FILES["marks"]["tmp_name"];
  
  $lines = file($filename);
  
  for ($i = 0; $i < count($lines); $i++) {
    $line = explode(" ", $lines[$i]);
    
    $student = $line[0];
    $mark = (double)$line[1];
    $task = $_POST["task_id"];
    $subject = $_GET["code"];
    
    $mysqli = db_connect();
    
    $query = $mysqli->prepare("INSERT INTO marks VALUES (?, ?, ?, ?)");
    $query->bind_param('dsss', $mark, $task, $student, $subject);    
    $query->execute();
    $mysqli->close();
  }
}

function display_form() {
  $subject = $_GET["code"];

  $mysqli = db_connect();
  $query = $mysqli->prepare("SELECT * FROM tasks WHERE subject=?");
  $query->bind_param('s', $subject);
  $query->execute();
  $query->bind_result($task_id, $task_subject, $task_name, $task_mark);

  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Upload Marks</title>
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
      <p>Upload a file with marks for $subject</p>
      <input type="file" name="marks" accept="text/plain" />
      <label for="task_id">Task</label>
      <select name="task_id" id="task_id" />
HERE;
  
  while ($query->fetch()) {
    echo "<option>$task_id</option>\n";
  }

  echo <<<HERE
      </select>
      <input type="submit" />
    </form>
  </section>
</body>
</html>
HERE;
}

$user = $_SESSION["user"];
$code = $_GET["code"];

if (!$user) {
  handle_error("You must be logged in to do that");
  exit();
}

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
  display_form();
} else if ($method == "POST") {
  upload_marks();
}

?>