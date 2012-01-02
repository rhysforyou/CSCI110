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
  <h1>Search Tags</h1>

  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10737418240" />
    <div class="input">
      <label for="tag">Tag</label>
      <input name="tag" type="text">
    </div>
    <input type="submit" value="Search">
  </form>
</body>
</html>
HTML;
}

function search_tags() {
  $tag = $_POST["tag"];
  $mysqli = db_connect();
  $results = array();

  $query = $mysqli->prepare("SELECT photo_id FROM tags WHERE tag=?");
  $query->bind_param('s', $tag);
  $query->execute();
  $query->bind_result($photo_id);

  while ($query->fetch()) {
    $results[] = $photo_id;
  }

  echo <<<HTML
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title>Picture Gallery</title>
    <link href="style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <h1>Results</h1>

    <ul>
HTML;

  $query = $mysqli->prepare("SELECT title FROM photos WHERE id=?");
  foreach ($results as $id) {
    $query->bind_param('d', $id);
    $query->execute();
    $query->bind_result($title);
    $query->fetch();
    echo "<li><a href='./showPicture.php?id=$id'>$title</a></li>";
  }

  echo <<<HTML
</ul>
</body>
</html>
HTML;
}

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "GET") {
  render_form();
} else {
  search_tags();
}

?>