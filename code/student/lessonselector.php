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
</head>



<body>
  Select a lesson below. <br><br>
  <?php
  $unit_id = $_SESSION['selectedunit'];
  $query = "SELECT lesson_id, name FROM lessons WHERE unit_id = '$unit_id'";
	$result = mysqli_query($database, $query);

  while ($row = $result->fetch_array()) {
    echo("<label>".$row['name']."</label> ");
    echo("<input onclick='lesson_select(".$row['lesson_id'].")' id=".$row['lesson_id']." type='submit' value='Select'/> <br>");
  }
  ?>
</body>

</html>
