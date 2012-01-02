<?php 

include_once("database.php");

function display_form() {
echo <<<HERE
  <!DOCTYPE html>
<html>
<head>
  <title>Define Assessment Tasks</title>
  <link rel="stylesheet" href="./stylesheets/site.css">
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo">
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <h1>Define Assessment Tasks</h1>
    <form name="task" id="task_defintion">
      <legend>Task Definition</legend>
      <table style="text-align: left">
        <tr>
          <th>Task Id</th>
          <th>Task Name</th>
          <th>Mark</th>
        </tr>
        <tr>
          <td><input type="text" name="id" id="id" /></td>
          <td><input type="text" name="name" id="name" /></td>
          <td><input type="text" name="mark" id="mark" /></td>
        </tr>
      </table>
      
      <input type="submit" value="Add Task">
    </form>
    
    <form name="task_list" id="tasks_list" method="post">
      <textarea readonly="readonly" name="tasks" rows="20" id="tasks"></textarea>
      <input type="submit" value="Define Tasks" />
      <input type="button" value="Reset" id="reset_button" />
    </form>
  </section>
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script>
    $("#task_defintion").submit(function(e){
      e.preventDefault()

      var id = $("#id").attr('value')
      var name = $("#name").attr('value')
      var mark = $("#mark").attr('value')
      
      var tasks = $("#tasks")
      
      var new_task = id + "|" + name + "|" + mark + "\\n";
      
      tasks.html(tasks.html() + new_task)
    });
    
    $("#tasks_list").submit(function(e) {
      var tasks = $("#tasks").html().replace(/^\s+|\s+$/g, "").split("\\n")
      var sum = 0
      
      for (task in tasks)
        sum += parseInt(tasks[task].split("|")[2])
        
      if (sum != 100) {
        alert("Marks must add up to 100")
        e.preventDefault()
      }
    });
    
    $("#reset_button").click(function(e) {
      $("#tasks").html("");
    });
  </script>
</body>
</html>
HERE;
}

function define_assessments() {
  $subject = $_GET["code"];
  $tasks = explode("\n", trim($_POST["tasks"]));
  $mysqli = db_connect();
    
  $query = $mysqli->prepare("INSERT INTO tasks VALUES (?, ?, ?, ?)");
  
  $err = $mysqli->error;
  
  if ($err) {
    handle_error($err);
    exit();
  }
  
  for ($i = 0; $i < count($tasks); $i++) {
    $task = explode("|", $tasks[$i]);
    $id = $task[0];
    $name = $task[1];
    $mark = (int)$task[2];
  
    $query->bind_param('sssd', $id, $subject, $name, $mark);
    $query->execute();
    
    $err = $query->error;
    
    if ($err) {
      handle_error($err);
      exit();
    }
  }
  
  $query->close();
}

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
  display_form();
} else if ($method == "POST") {
  define_assessments();
}

?>