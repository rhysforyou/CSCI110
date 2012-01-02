<?php

function handle_error($error) {
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
</head>
<body>
  <h1>Oh No</h1>
  <p>There was an error with your request: <em>$error</em></p>
</body>
</html>
HERE;
}

function db_connect() {
  global $mysqli;
  $mysqli = new mysqli('localhost', 'rpowell', 'floopthepig', 'picture_gallery');

  if (mysqli_connect_errno()) {
    handle_error(mysqli_connect_error());
    exit();
  }

  return $mysqli;
}

?>