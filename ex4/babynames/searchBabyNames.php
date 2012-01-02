<!DOCTYPE html>

<?php
$matching_names = array();

function invalid_data() {
  echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Invalid Data</title>
</head>
<body>
  <h1>Invalid Data</h1>
  <p>Oops, perhaps you visited this page directly without first filling out <a href="./">the form</a>?</p>
</body>
</html>
HERE;
  die();
}

function connect_to_mysql() {
  $mysql = new mysqli('localhost', 'rpowell', 'floopthepig', 'test');

  if (mysqli_connect_errno()) {
    $error = mysqli_connect_error();
    die($error);
  }

  return $mysql;
}

function perform_search($db, $gender, $letter) {
  global $matching_names;
  $name = "";

  $query = $db->prepare("SELECT name FROM babynames WHERE gender=? AND name LIKE ?");
  $query->bind_param('ss', $gender, $letter);
  $query->execute();
  $query->bind_result($name);

  while ($query->fetch()) {
    $matching_names[] = $name;
  }

  $query->close();
}

$gender = $_POST["gender"];
$letter = $_POST["letter"];

// Gender must be boy or girl
if ($gender != "boy" && $gender != "girl") {
  invalid_data();
}

// Must be a single, upper case letter
$letter_pattern = '/^[A-Z]$/';
if (!preg_match($letter_pattern, $letter)) {
  invalid_data();
}

$letter = $letter . "%";

$db = connect_to_mysql();
perform_search($db, $gender, $letter);
$db->close();

?>

<html>
<head>
  <title>Baby Names</title>
  <style>
    body {
      font-family: 'Helvetica Neue' ,Helvetica, Arial, sans-serif;
      font-size: 16px;
      line-height: 24px;
      width: 400px;
      padding: 20px;
      margin: auto;
      margin-top: 40px;
    }

    h1 {
      font-weight: 100;
    }
  </style>
</head>
<body>
  <h1>Baby Names</h1>
  <?php if (count($matching_names) == 0) : ?>
  <p>Sorry, we were unable to find a name that meets your requirements</p>
  <?php else : ?>
  <p>The following names might suit:</p>
  <uL>
    <?php foreach ($matching_names as $name) echo("<li>" . $name . "</li>"); ?>
  </ul>
  <?php endif; ?>
</body>
</html>