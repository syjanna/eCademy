<?php
session_start();
include "server.php";

if ($_SESSION["uname"] == ""){
  header('location: ../shared/forbidden.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../shared/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<title>Create course</title>
</head>


<body>
	<div id="logo">
		<a href="index.php"><img src="../img/logo.png"/></a>
	</div>

  <h1>Create a new course</h1>
  <form method="post" action="createcourse.php">
    <label>Course subject</label> <br>
      <select name="course_subject" required>
        <option value="ART">Art (ART)</option>
        <option value="ECON">Economics (ECON)</option>
        <option value="COMPSCI">Computer science (COMPSCI)</option>
        <option value="LIFESCI">Life sciences (LIFESCI)</option>
        <option value="MATH">Math (MATH)</option>
      </select></br>
    <label>Course name</label> <br><input name="course_name" type="text" required></input><br>
    <button type="submit" name="addcourse"> Add course</button>

  </form>
  Click <a href="index.php">here</a> to go back.
</body>
</html>
