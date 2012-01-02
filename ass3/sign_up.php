<?php

include_once("database.php");

function display_form() {
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <form method="POST">
      <legend>Sign Up</legend>
      
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

function sign_up() {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $encrypted_password = md5($password);
  
  $valid_char_pattern = '/^\w{4,16}$/';
  
  if (!preg_match($valid_char_pattern, $username)) {
    handle_error("Invalid characters used in username");
    return;
  }
  
  $mysqli = db_connect();
  
  $query = $mysqli->prepare("INSERT INTO lecturers VALUES (?, ?)");
  $query->bind_param('ss', $username, $encrypted_password);
  $query->execute();
  
  $error = $query->error;
  
  if (empty($error)) { # No error, success
    echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Successfully Signed Up</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <h1>Signed Up</h1>
    <p>You have signed up successfully</p>
  </section>
</body>
</html>
HERE;
  } else { // Error
    handle_error($error);
  }
}

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
  display_form();
} else if ($method == "POST") {
  sign_up();
}

?>