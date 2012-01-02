<?php

include_once('database.php');

session_start();

function random_string($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $size = strlen( $chars );
    $str = '';
    
    for( $i = 0; $i < $length; $i++ ) {
    	$str .= $chars[ rand( 0, $size - 1 ) ];
    }
    
    return $str;
}

function add_students() {
  $error = $_FILES["student_list"]["erro"];
  
  if ($error != UPLOAD_ERR_OK) {
    handle_error("Failed to upload student data");
    exit();
  }
  
  $filename = $_FILES["student_list"]["tmp_name"];
  $handle = fopen($filename, "r");
  $numbytes = filesize($filename);
  
  if (!$handle) {
    handle_error("Failed to upload student data");
    exit();
  }
  
  $subject = $_GET["code"];
  
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Students Added</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <table>
    <tr>
      <th>Student Id</th>
      <th>Password</th>
    </tr>
HERE;
  
  while (!feof($handle)) {
    $login = fread($handle, 5);
    fread($handle, 1);
    $tute = fread($handle, 1);
    fread($handle, 1);
    $password = random_string(8);
    
    if (!feof($handle)) {
      $mysqli = db_connect();
      $query = $mysqli->prepare("INSERT INTO students VALUES (?, ?, ?, ?)");
      $query->bind_param('ssss', $login, $password, $tute, $subject);
      $query->execute();
      
      echo "<tr>";
      echo "<td>" . $login . "</td>";
      echo "<td>" . $password . "</td>";
      echo "</tr>";
    }
  }
  
  echo <<<HERE
    </table>
  </section
</body>
</html>
HERE;
}

function display_form() {
    echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Add Students</title>
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
      <p>Upload a file with student IDs and lab allocations for $code</p>
      <input type="file" name="student_list" accept="text/plain" />
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
  add_students();
}

?>