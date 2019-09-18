<?php
$servername = "localhost";
$username = "iw3htp";
$password = "password";

//carry over username from login to know which user is logged in
$uname = $_SESSION["uname"];

// create and connect to mysql server
if ( !( $database = mysqli_connect($servername, $username, $password)))
  die ("Could not connect to server");
// connecting to ecademy database
if ( !(mysqli_select_db( $database, "ecademydb")) )
  die ("Error connecting to the ecademydb database");

if (isset($_POST['registercourse'])) {
  $coursetoregister = $_POST['courseselect'];
  $query = "INSERT INTO registration (course_id, student) VALUES ('$coursetoregister', '$uname')";
  mysqli_query($database, $query);
}

if (isset($_POST['coursenavigation'])){
  $selectedcourse = $_POST['coursenavigation'];
  $_SESSION['selectedcourse'] = $selectedcourse;
  $query = "SELECT instructor FROM courses WHERE course_id='$selectedcourse';";
  $result = mysqli_query($database, $query);

  while ($row = $result->fetch_array()) {
    $_SESSION['instructor'] = $row['instructor'];
  }
}

if (isset($_POST['unitselection'])) {
  $selectedunit = $_POST['unitselection'];
  $_SESSION['selectedunit'] = $selectedunit;
}

if (isset($_POST['lessonselection'])) {
  $selectedlesson = $_POST['lessonselection'];
  $_SESSION['selectedlesson'] = $selectedlesson;
}

?>
