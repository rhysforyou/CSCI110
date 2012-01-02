<?php

$mysqli;

function bad_data($message)
{
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Error | Photo Gallery</title>
</head>
<body>
  <h1>Oh No</h1>
  <p>There was an error with your input: <em>$message</em></p>
</body>
</html>
HERE;
}

function connect_to_db()
{
  global $mysqli;
  $mysqli = new mysqli('localhost', 'rpowell', 'floopthepig', 'picy');
  
  if (mysqli_connect_errno()) {
    $problem = mysqli_connect_error();
    bad_data($problem);
    exit();
  }
}

function display_form()
{
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Sign Up | Photo Gallery</title>
  <style>
    body {
      font-family: Helvetica, Arial, sans-serif;
    }
    input {
      display: block;
      margin-bottom: 1em;
    }
  </style>
</head>
<body>
  <h1>Photo Gallery</h1>
  <hr />
  <h2>Sign In</h2>
  
  <form method="post">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    
    <input type="submit">
  </form>
</body>
</html>
HERE;
}

function handle_login() {
  global $mysqli;
  
  $username = $_POST["username"];
  $password = $_POST["password"];
  
  if (empty($username) || empty($password)) {
    display_form();
    return;
  }
  
  $encrypted_password = md5($password);
  
  connect_to_db();
  $query = $mysqli->prepare("SELECT count(*) FROM users WHERE username=? AND encrypted_password=? AND table_name='picys'");
  $error = $mysqli->error;
  
  if (!empty($error)) {
    bad_data($error);
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
  <title>Logged In | Photo Gallery</title>
</head>
<body>
  <h1>Welcome $username</h1>
  <p>You have been logged in successfully.</p>
</body>
</html>
HERE;
  } else {
    bad_data("Bad username or password");
  }
}

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
  display_form();
} else {
  handle_login();
}

?>