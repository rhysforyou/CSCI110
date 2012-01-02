<?php

function handle_error($error) {
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <h1>Oh No</h1>
  <p>There was an error with your request: <em>$error</em></p>
</body>
</html>
HERE;
}

function db_connect() {
  global $mysqli;
  $mysqli = new mysqli('localhost', 'rpowell', 'floopthepig', 'subject_management');
  
  if (mysqli_connect_errno()) {
    handle_error(mysqli_connect_error());
    exit();
  }
  
  return $mysqli;
}

?>