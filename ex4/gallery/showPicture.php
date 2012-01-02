<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Picture Gallery</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php

  include_once('shared.php');

  $id = $_GET["id"];

  $mysqli = db_connect();
  $query = $mysqli->prepare("SELECT title, comment FROM photos WHERE id=?");
  $query->bind_param('d', $id);
  $query->execute();
  $query->bind_result($title, $comment);
  $query->fetch();
  $error = $query->error;

  if ($error) {
    handle_error($error);
  }

  echo <<<HTML
    <h1>$title</h1>

    <img src="imageFromMySQL.php?id=$id" />

    <p id="comment">$comment</p>
HTML;

  ?>

  <h2>Tags</h2>
  <ul>
  <?php

  $mysqli = db_connect();
  $query = $mysqli->prepare("SELECT tag FROM tags WHERE photo_id=?");
  $query->bind_param('d', $id);
  $query->execute();
  $query->bind_result($tag);
  while ($query->fetch()) {
    echo "<li>" . $tag . "</li>";
  }

  ?>
  </ul>

  <h2>Add a Tag</h2>
  <form action="./addTag.php?id=<?php echo $id ?>" method="post">
    <div class="input">
      <label for="tag">Tag</label>
      <input name="tag" type="text">
    </div>
    <p><input type="submit" value="Next"></p>
  </form>
</body>
</html>