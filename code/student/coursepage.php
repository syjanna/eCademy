<?php
session_start();
include "server.php";
include "../shared/parser.php";

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
  <script src="../shared/quiz.js" type="text/javascript"></script>
  <script src="student.js" type="text/javascript"></script>
	<title>Course page</title>
</head>


<body>
	<div id="logo">
		<a href="index.php"><img src="../img/logo.png"/></a>
	</div>
  <center>
  <div id="courseArea">
  <?php
  $course_id = $_SESSION['selectedcourse'];
  $query = "SELECT subject, course_id, name FROM courses WHERE course_id = '$course_id'";
	$result = mysqli_query($database, $query);
  $units = array();

  while ($row = $result->fetch_array()) {
    echo("<h1 class='title'>".$row['subject'].$row['course_id'].": ".$row['name']."</h1>");

  }

  $query = "SELECT unit_id, name from units where course_id='$course_id'";
  $result = mysqli_query($database, $query);

  while ($row = $result->fetch_array()){
    array_push($units, array($row['unit_id'] => $row['name']));

  }
  ?>
    <div id="tutArea">
      <p>
        Welcome! Select a unit from the sidebar to get started.
      </p>
    </div>


  </div>
  <div class="sidenav">
    <b> U n i t s </b> <br><br>
    <?php
      foreach ($units as $u){
        foreach ($u as $u_id => $u_name) {
          echo("<label onclick='unit_select(".$u_id.")' id=".$u_id.">".$u_name."</label>");
        }
      }
    ?>

  </div>
  <br/>



</body>
</html>
