<?php

include_once("database.php");

function display_form() {
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Sign In</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <form method="POST">
      <legend>Sign In</legend>
      
      <label for="username">User Name</label>
      <input type="text" name="username" id="username" />
      
      <label form="password">Password</label>
      <input type="password" name="password" id="password" />
      
      <input type="submit">
    </form>
  </section>
</body>
</html>
HERE;
}

function sign_in() {
  $username = $_POST["username"];
  $password = $_POST["password"];
  
  if (empty($username) || empty($password)) {
    handle_error("You must enter both a name and password");
  }
  
  $encrypted_password = md5($password);
  
  $mysqli = db_connect();
  $query = $mysqli->prepare("SELECT count(*) FROM lecturers WHERE username=? AND encrypted_password=?");
  $error = $mysqli->error;
  
  if (!empty($error)) {
    handle_error($error);
    exit;
  }
  
  $query->bind_param('ss', $username, $encrypted_password);
  $query->execute();
  $query->bind_result($count);
  
  if ($query->fetch() && $count == 1) { // Successful login
    session_start();
    $_SESSION["user"] = $username;
    echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Signed In</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <h1>Signed In</h1>
    
    <p>You have been signed in as <em>$username</em>.</p>
  </section>
</body>
</html>
HERE;
  } else {
    handle_error("Bad username or password");
  }
}


$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
  display_form();
} else if ($method == "POST") {
  sign_in();
}

?>