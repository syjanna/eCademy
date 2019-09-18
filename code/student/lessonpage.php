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
  <?php
  $selectedlesson = $_SESSION['selectedlesson'];
  $query = "SELECT lessonxml, quizxml, name FROM lessons WHERE lesson_id = '$selectedlesson'";
  $result = mysqli_query($database, $query);

  while ($row = $result->fetch_array()) {
    $lessoncontent = $row['lessonxml'];
    $quizcontent = $row['quizxml'];
    $lessonname = $row['name'];
  }
  echo "<h1>$lessonname</h1>";

  $newxml = parseLesson($lessoncontent);
  echo ("<div id='showlesson'>$newxml</div><br><br>");


  echo "<h2 class='subtitle'>Quiz</h2>";
  $newquizxml = parseQuiz($quizcontent);
  $jsonquizdata = json_encode($newquizxml);
  echo("<div id='quizPreview' class='xmlcontent'><script>parseQuizjs($jsonquizdata);</script></div>
    <button id='submit' onclick='show_score();'>Submit</button>
    <br><br>
    <div id='results'></div>");
  ?>
</body>

</html>
