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
  <h1>Add a Picture</h1>

  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10737418240" />
    <div class="input">
      <label for="title">Title</label>
      <input name="title" size=80 type="text">
    </div>
    <div class="input">
      <label for="comment">Comment</label>
      <textarea name="comment" rows=10 cols=58></textarea>
    </div>
    <div class="input">
      <label for="image">Image</label>
      <input type="file" name="image" accept="image/jpg" />
    </div>
    <div class="input">
      <label for="tags">Tags</label>
      <input name="tags" size=80 type="text">
    </div>

    <input type="submit" value="Upload Picture">
  </form>
</body>
</html>
HTML;
}

function upload_picture() {
  $error = $_FILES["image"]["error"];
  if ($error != UPLOAD_ERR_OK) {
    handle_error($error);
    exit;
  }

  $filename = $_FILES["image"]["tmp_name"];
  $title = $_POST["title"];
  $comment = $_POST["comment"];

  if (empty($title) || empty($comment)) {
    handle_error("You must give both a title and comment");
    exit;
  }

  $numbytes = filesize($filename);
  $handle = fopen($filename, 'r');

  if (!$handle) {
    handle_error("Unable to open image");
    exit;
  }

  $imagedata = addslashes(fread($handle, $numbytes));

  if (!$imagedata) {
    handle_error("Unable to read image");
    exit;
  }

  fclose($handle);

  $mysqli = db_connect();

  $query = "INSERT INTO photos VALUES (null, '$title', '$comment', '$imagedata')";
  $mysqli->query($query);
  $error = $mysqli->error;

  if ($error) {
    handle_error($error);
    exit;
  }

  $result = $mysqli->query("SELECT LAST_INSERT_ID()");
  $row = $result->fetch_row();
  $id = $row[0];

  $taglist = $_POST["tags"];
  $tags = explode(",", $taglist);

  $query = $mysqli->prepare("INSERT INTO tags VALUES (null, ?, ?)");
  foreach ($tags as $tag) {
    $tag = trim($tag);
    $query->bind_param('ss', $tag, $id);
    $query->execute();
  }

  header("Location: ./showPicture.php?id=$id");
}

session_start();

$user = $_SESSION["user"];

if (!$user) {
  header("Location: ./login.php");
}

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "GET") {
  render_form();
} else {
  upload_picture();
}

?>