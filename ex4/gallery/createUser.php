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
  <h1>Create User</h1>

  <form method="post">
    <div class="input">
      <label for="username">Username</label>
      <input name="username" type="text">
    </div>
    <div class="input">
      <label for="password">Password</label>
      <input name="password" type="password">
    </div>

    <input type="submit" value="Sign Up">
  </form>
</body>
</html>
HTML;
}

function create_user() {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $encrypted_password = md5($password);

  $mysqli = db_connect();
  $query = $mysqli->prepare("INSERT INTO users VALUES (?, ?)");
  $query->bind_param('ss', $username, $encrypted_password);
  $query->execute();
  $error = $query->error;

  if ($error) {
    handle_error($error);
  } else {
    header("Location: ./");
  }
}

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "GET") {
  render_form();
} else {
  create_user();
}

?>