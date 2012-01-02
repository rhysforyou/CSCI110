<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Subjects by Faculty</title>

  <link href="style.css" rel="stylesheet" type="text/css">
  <link href="themes/blue/style.css" rel="stylesheet" type="text/css">
  <script src="jquery.js" type="text/javascript"></script>
  <script src="jquery.tablesorter.js" type="text/javascript"></script>
  <script src="getSubjects.js" type="text/javascript"></script>
</head>
<body>

  <h1>Subjects by Faculty</h1>

  <select id="faculty" onchange="getSubjects()">
    <?php

    $mysqli = new mysqli('localhost', 'rpowell', 'floopthepig', 'ajax_subjects');
    $query = $mysqli->prepare("SELECT DISTINCT faculty FROM ErehwonSubjects");
    $query->bind_result($faculty);
    $query->execute();

    $error = $mysqli->error;
    if ($error) {
      echo $error;
    }

    while ($query->fetch()) {
      echo "<option>" . $faculty . "</option>";
    }

     ?>
  </select>

<table id="subject_list" class="tablesorter">
  <thead>
    <tr>
      <th>Code</th>
      <th>Title</th>
      <th>Lecturer</th>
      <th>Description</th>
    <tr>
  </thead>
  <tbody>
  </tbody>
</table>
</body>
</html>