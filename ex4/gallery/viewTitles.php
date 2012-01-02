<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Picture Gallery</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <h1>Images by Title</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
      </tr>
    </thead>
    <tbody>
      <?php
        include_once('shared.php');

        $mysqli = db_connect();
        $query = $mysqli->prepare("SELECT id, title FROM photos");
        $query->execute();
        $query->bind_result($id, $title);

        while ($query->fetch()) {
          echo <<<HTML
          <tr>
            <td><a href="./showPicture.php?id=$id">$id</a></td>
            <td>$title</td>
          </tr>
HTML;
        }
      ?>
    </tbody>
  </table>
</body>
</html>