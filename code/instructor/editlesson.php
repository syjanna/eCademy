<?php
session_start();
include "server.php";
include "../shared/parser.php";

if ($_SESSION["uname"] == ""){
  header('location: ../shared/forbidden.php');
}


if (isset($_POST['submitfile'])) {
  $filename = $_POST['filename'];
  $check_query = "SELECT * from FILES where uname='$uname' and filename='$filename'";
  $check_result = mysqli_query($database, $check_query);
  $file_exists = mysqli_fetch_assoc($check_result);


  if ($file_exists) {
    die("A file with this name already exists. Please choose a different file name. ");
  }

  if ($_FILES['file']['size'] < 500000){

    $file = addslashes(file_get_contents($_FILES['file']['tmp_name']));
    $result = mysqli_query($database, "INSERT INTO files (filename, file, uname) VALUES ('$filename','$file','$uname')");
    if (!$result) {
      die("database query failed when uploading file - file size may exceed 1mb ");
    }
    header('location: editlesson.php');
  }else {
    die("File size exceeds 1MB!");
  }
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../shared/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="../shared/quiz.js" type="text/javascript"></script>
  <script src="instructor.js" type="text/javascript"></script>
	<title>Edit lesson</title>
</head>


<body>
	<div id="logo">
		<a href="index.php"><img src="../img/logo.png"/></a>
	</div>
  <center>
  <?php
  $lesson_id = $_SESSION['editlessonid'];
  $query = "SELECT name FROM lessons WHERE lesson_id = '$lesson_id'";
	$result = mysqli_query($database, $query);

  while ($row = $result->fetch_array()) {
    $_SESSION['editlessonname'] = $row['name'];
  }
  echo("<h1>Editing lesson '" . $_SESSION['editlessonname'] . "'</h1>");
  ?>

	<div id="container">
    Click <a href='editunit.php'>here</a> to return to the lessons manager page.
    If you are unfamiliar with how to use our EML (educational markup language), click <a href='emlguide.html'>here</a> for a guide.
		<h2 class="subtitle"> Lesson content </h2>
      <?php
      $lesson_id = $_SESSION['editlessonid'];
      $query = "SELECT lessonxml, quizxml FROM lessons WHERE lesson_id = '$lesson_id'";
    	$result = mysqli_query($database, $query);

      while ($row = $result->fetch_array()) {
        $lessoncontent = $row['lessonxml'];
        $quizcontent = $row['quizxml'];
      }
      echo("<textarea class='xmlcontent' id='lessonxml'>$lessoncontent</textarea><br>
          You may upload images here (png only, max size of 1MB):
          <form method='POST' action='editlesson.php' enctype='multipart/form-data'>
            <input name='filename' type='text' placeholder='image name' required>
            <input name='file' accept='image/png' type='file' required>
            <input value='Submit file' type='submit' name='submitfile'>
          </form><br>
          <input class='txt_btn' id='savelessonbtn' type='submit' value='Save lesson'/>
            <br><br>");

      $newxml = parseLesson($lessoncontent);
      echo ("<button type= 'submit' onclick='toggleText(\"lessonPreview\")'>Preview lesson</button>");
      echo ("<div id='lessonPreview' class='xmlcontent' style='display:none;'>$newxml</div><br><br>");

      echo("Images you have uploaded:<br>");

      $userimgs = mysqli_query($database, "SELECT * FROM files WHERE uname='$uname';");
      echo("<div id='userImages'>");
        while ($row = $userimgs->fetch_array()) {
          echo $row['filename'].':<br> <img class="resize" src="data:image/jpeg;base64,'.base64_encode($row['file']).'"/><br>';
        }
      echo("</div><br><br>
        <h2 class='subtitle'> Quiz content </h2>");


      $newquizxml = parseQuiz($quizcontent);
      $jsonquizdata = json_encode($newquizxml);
      echo("<textarea class='xmlcontent' id='quizxml'>$quizcontent</textarea><br>
          <input id='savequizbtn' class='txt_btn' type='submit' value='Save quiz'/>
          <br><br>
          <button type='submit' onclick='toggleText(\"quizPreview\")'>Preview quiz</button>
          <div id='quizPreview' class='xmlcontent' style='display:none;'><script>parseQuizjs($jsonquizdata);</script>
            <button id='submit' onclick='show_score();'>Submit</button>
            <br><br>
            <div id='results'></div>
          </div>");
      ?>
  </div>
  <br/>



</body>
  <script src="instructor.js" type="text/javascript"></script>
</html>
