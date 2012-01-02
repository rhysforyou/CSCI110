<?php

function signed_in() {
    echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <h1>Home</h1>
    <p>Welcome to the Nonspecific University subject management system.</p>
    
    <h2>Tasks</h2>
    <ul>
      <li><a href="#">List all subjects</a></li>
      <li><a href="./create_subject">Create new subject tables</a></li>
      <li><a href="./sign_out">Sign Out</a></li>
    </ul>
    
    <h2>Search</h2>
    <form method="GET" action="./manage_subject.php">
      <input type="text" name="code" placeholder="Subject code" style="display: inline" />
      <input type="submit" value="Manage Subject" style="display: inline" />
    </form>
  </section>
</body>
</html>
HERE;
}

function signed_out() {
    echo <<<HERE
<!DOCTYPE html>
<html>
<head>
  <title>Access Restricted</title>
  
  <link rel="stylesheet" href="./stylesheets/site.css" />
</head>
<body>
  <header>
    <img src="./images/crest.png" class="logo" />
    <h1>Nonspecific University</h1>
  </header>
  <section id="content">
    <h1>Access Restricted</h1>
    <p>You must be authorised to view this page. If you're a lecturer pleas <a href="./sign_in">Sign In</a>. If you don't yet have an account, <a href="./sign_up">Sign Up</a> for one.</p>
  </section>
</body>
</html>
HERE;
}

session_start();

if ($_SESSION["user"]) {
  signed_in();
} else {
  signed_out();
}

?>