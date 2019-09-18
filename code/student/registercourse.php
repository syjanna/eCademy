<?php
session_start();
include "server.php";

if ($_SESSION["uname"] == ""){
  header('location: forbidden.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../shared/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<title>Course registration</title>
</head>


<body>
	<div id="logo">
		<a href="index.php"><img src="../img/logo.png"/></a>
	</div>

  <h1>Register for a new course</h1>
  <form id="courses" method="post" action="registercourse.php">
  <?php
    $query = "SELECT distinct courses.name, courses.course_id, courses.subject FROM courses where course_id not in (select distinct course_id from registration where student='$uname');";
  	$result = mysqli_query($database, $query);

    if ($result){
      while ($row = $result->fetch_array()) {
        echo("<input type='radio' name='courseselect' value=".$row['course_id'].">");
        echo($row['subject'] . $row['course_id'] .": " . $row['name'] . "<br>");
      }
    }
    echo("<br><input value='Register for course' type='submit' name='registercourse'>");
  ?>
  </form>
  <br>
  Click <a href="index.php">here</a> to go back.
</body>
</html>
