<?php

include_once("./database.php");

function display_form() {
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Create Subject</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css"/>
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  
  <section id="content">
    <form method="POST">
      <legend>Create Subject</legend>
      
      <label for="subject_code">Subject Code</label>
      <input type="text" name="subject_code" id="subject_code" />
      
      <label for="title">Title</label>
      <input type="text" name="title" id="title" />
      
      <label for="content">Content</label>
      <textarea name="content" id="content" rows="5">
      </textarea>
      
      <label for="objectives">Objectives</label>
      <textarea name="objectives" id="objectives" rows="5">
      </textarea>
      
      <input type="submit" value="Create Subject" />
    </form>
  </section>
</body>
</html>
HERE;
}

function create_subject() {
    $code = $_POST["subject_code"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $objectives = $_POST["objectives"];
    $lecturer = $_SESSION["user"];
    
    $mysqli = db_connect();
    $query = $mysqli->prepare("INSERT INTO subjects VALUES (?, ?, ?, ?, ?)");
    $query->bind_param('sssss', $code, $title, $content, $objectives, $lecturer);
    $query->execute();
    
    $error = $query->error;
    
    if (empty($error)) { # Everything's fine here
      echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Subject Created</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <h1>Subject Created</h1>
    <p>Added $code: $title to the list of subject.</p>
  </section>
</body>
</html>
HERE;
    }
}

$method = $_SERVER["REQUEST_METHOD"];

session_start();

if (!$_SESSION["user"]) {
  handle_error("You must be logged in to do that");
}

if ($method == "GET") {
  display_form();
} else if ($method == "POST") {
  create_subject();
}

?>