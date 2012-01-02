<?php
include_once('shared.php');

function render_form() {
  echo <<<HTML
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Picture Gallery</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <h1>Log In</h1>

  <form method="post">
    <div class="input">
      <label for="username">Username</label>
      <input name="username" type="text">
    </div>
    <div class="input">
      <label for="password">Password</label>
      <input name="password" type="password">
    </div>

    <input type="submit" value="Log In">
  </form>
</body>
</html>
HTML;
}

function login_user() {
  session_start();

  $username = $_POST["username"];
  $password = $_POST["password"];
  $encrypted_password = md5($password);

  $mysqli = db_connect();
  $query = $mysqli->prepare("SELECT count(*) FROM users WHERE username=? AND encrypted_password=?");
  $query->bind_param('ss', $username, $encrypted_password);
  $query->execute();
  $query->bind_result($count);

  if($query->fetch() && $count == 1) {
    $_SESSION["user"] = $username;
    header("Location: ./");
  } else {
    handle_error("Invalid username or password: $encrypted_password");
  }
}

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "GET") {
  render_form();
} else {
  login_user();
}

?>