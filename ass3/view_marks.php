<?php

include_once('database.php');

session_start();

$mysqli = db_connect();

$subject_query = $mysqli->prepare("SELECT * FROM subjects WHERE code=?");
$subject_query->bind_param('s', $_GET["code"]);
$subject_query->execute();
$subject_query->bind_result($subject_code, $subject_title, $subject_content, $subject_objectives, $subject_lecturer);
$subject_query->fetch();

echo($subject_query->error);

echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>$subject_code: $subject_title</title>
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <h1>$subject_code: $subject_title</h1>
    <table>
      <tr>
        <th>Student ID</th>
        <th>Tutorial</th>
HERE;

$subject_query->close();

$tasks_query = $mysqli->prepare("SELECT * FROM tasks WHERE subject=?");
$tasks_query->bind_param('s', $_GET["code"]);
$tasks_query->execute();
$tasks_query->bind_result($task_id, $task_subject, $task_name, $task_mark);


$task_ids = array();

while ($tasks_query->fetch()) {
  echo "<th>$task_id / $task_mark</th>";
  $task_ids[] = $task_id;
}

$tasks_query->close();

echo <<<HERE
<th>Total Mark</th>
</tr>
HERE;

$students_query = $mysqli->prepare("SELECT * FROM students WHERE subject=?");
$students_query->bind_param('s', $_GET["code"]);
$students_query->execute();
$students_query->bind_result($student_id, $student_password, $student_tutorial, $student_subject);
$students_query->store_result();

while ($students_query->fetch()) {
  echo <<<HERE
  <tr>
    <td>$student_id</td>
    <td>$student_tutorial</td>
HERE;
  
  $total = 0;
  $i = 0;
  $curent_task = $task_ids[$i];
  
  $marks_query = $mysqli->prepare("SELECT * FROM marks WHERE student=? AND subject=? AND task=?");
  $marks_query->bind_param('sss', $student_id, $subject_code, $curent_task);
  $marks_query->execute();
  $marks_query->bind_result($mark_mark, $mark_task, $mark_student, $mark_subject);
  $marks_query->fetch();
  
  
  while ($i < count($task_ids)) {
    if (!$mark_mark) {
      $mark = 0;
    } else {
      $mark = $mark_mark;
    }
    
    $total += $mark;
    
    echo "<td>$mark</td>";
    $i++;
    $curent_task = $task_ids[$i];
    $marks_query->execute();
    $marks_query->bind_result($mark_mark, $mark_task, $mark_student, $mark_subject);
    $marks_query->fetch();
  }
  
  echo <<<HERE
  <td>$total</td>
  </tr>
HERE;
}

echo <<<HERE
</table>
</section>
</body>
</html>
HERE;

?>