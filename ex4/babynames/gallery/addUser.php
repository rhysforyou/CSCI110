<?php 

$mysqli;

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
  <h2>Sign Up</h2>
  
  <form method="post">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    
    <label for="table_name">Table Name</label>
    <input type="text" name="table_name" id="table_name">
    
    <input type="submit">
  </form>
</body>
</html>
HERE;
}

function handle_create()
{
  global $mysqli;

  $username = $_POST["username"];
  $password = $_POST["password"];
  $table_name = $_POST["table_name"];
  
  if (empty($username) || empty($password) || empty($table_name)) {
    display_form();
    return;
  }
  
  $valid_characters_pattern = '/^[A-Za-z0-9 -\.]{4,16}$/';
  if (!preg_match($valid_characters_pattern, $username)) {
    bad_data("Username is too long or contains invalid characters");
    exit();
  }
  if (!preg_match($valid_characters_pattern, $table_name)) {
    bad_data("Table name is too long or contains invalid characters");
    exit();
  }
  
  connect_to_db();
  
  $encrypted_password = md5($password);
  $query = $mysqli->prepare("INSERT INTO users VALUES (?, ?, ?)");
  $query->bind_param('sss', $username, $encrypted_password, $table_name);
  $query->execute();
  
  $error = $query->error;
  
  if (empty($error)) { # No error, success
    echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>User Added | Photo Gallery</title>
</head>
<body>
  <h1>New User Added</h1>
  <p>A record has been created for user $username, associated with table $table_name</p>
</body>
</html>
HERE;
  } else { // Error
      echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Error | Photo Gallery</title>
</head>
<body>
  <h1>Oh No</h1>
  <p>There was a database error: <em>$error</em></p>
</body>
</html>
HERE;
  }
  
  $query->close();
}

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

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
  display_form();
} else if ($method == "POST") {
  handle_create();
}

?>

