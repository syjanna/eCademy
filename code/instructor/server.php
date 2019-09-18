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

if (isset($_POST['addcourse'])) {
  $addcoursesubject = mysqli_real_escape_string($database, $_POST['course_subject']);
  $addcoursename = mysqli_real_escape_string($database, $_POST['course_name']);
  $check_query = "SELECT * FROM courses WHERE subject='$addcoursesubject' AND name='$addcoursename'";
  $check_result = mysqli_query($database, $check_query);
  $course_exists = mysqli_fetch_assoc($check_result);

  if ($course_exists) {
    echo("<script>alert('This course already exists.');</script>");

  } else {
    $query = "INSERT INTO courses (name, subject, instructor) VALUES ('$addcoursename', '$addcoursesubject', '$uname')";
    mysqli_query($database, $query);
    echo("<script>alert('Course has been created.');</script>");
  }
  header("Refresh:0");
}

if(isset($_POST['delcourse'])) {
  $course_id = $_POST['delcourse'];
  mysqli_query($database, "DELETE FROM courses WHERE course_id='$course_id'");

}

if(isset($_POST['editcourse'])) {
  $course_id = $_POST['editcourse'];
  $_SESSION['editcourseid'] = $course_id;
}


if(isset($_POST['changecoursename'])) {
  $new_name = mysqli_real_escape_string($database,$_POST['changecoursename']);
  $course_id = $_SESSION['editcourseid'];
  $query = "UPDATE courses SET name='$new_name' WHERE course_id='$course_id'";
  mysqli_query($database, $query);
}

if(isset($_POST['addunit'])){
  $addunitname = mysqli_real_escape_string($database, $_POST['addunit_name']);
  $course_id = $_SESSION['editcourseid'];
  $query = "INSERT INTO units (name, course_id) VALUES ('$addunitname', '$course_id')";
  mysqli_query($database, $query);
  echo("<script>alert('Unit has been created.');</script>");
  header("Refresh:0");
  exit;
}

if(isset($_POST['delunit'])){
  $delunit = $_POST['delunit'];
  $course_id = $_SESSION['editcourseid'];
  $query = "DELETE FROM units WHERE unit_id='$delunit' AND course_id='$course_id'";
  mysqli_query($database, $query);
}

if(isset($_POST['editunit'])) {
  $unit_id = $_POST['editunit'];
  $_SESSION['editunitid'] = $unit_id;
}

if(isset($_POST['addlesson'])){
  $addlessonname = mysqli_real_escape_string($database,$_POST['addlesson_name']);
  $course_id = $_SESSION['editcourseid'];
  $unit_id = $_SESSION['editunitid'];
  $query = "INSERT INTO lessons (name, course_id, unit_id) VALUES ('$addlessonname', '$course_id', '$unit_id')";
  mysqli_query($database, $query);
  $query = "INSERT INTO quizzes (course_id, unit_id) VALUES ('$course_id', '$unit_id')";
  mysqli_query($database, $query);
  echo("<script>alert('Lesson has been created.');</script>");
  header("Refresh:0");
}

if(isset($_POST['dellesson'])){
  $dellesson = $_POST['dellesson'];
  $course_id = $_SESSION['editcourseid'];
  $query = "DELETE FROM lessons WHERE lesson_id='$dellesson'";
  mysqli_query($database, $query);
  $query = "DELETE FROM quizzes WHERE quiz_id='$dellesson'";
  mysqli_query($database, $query);
}

if(isset($_POST['editlesson'])){
  $lesson_id = $_POST['editlesson'];
  $_SESSION['editlessonid'] = $_POST['editlesson'];
}

if(isset($_POST['savelesson'])){
  $lessonxml = $_POST['savelesson'];
  $lessonxml = mysqli_real_escape_string($database,$lessonxml);
  $lessonid = $_SESSION['editlessonid'];
  $query = "UPDATE lessons SET lessonxml='$lessonxml' WHERE lesson_id='$lessonid'";

  mysqli_query($database, $query);
}

if(isset($_POST['savequiz'])) {
  $quizxml = $_POST['savequiz'];
  $quizxml = mysqli_real_escape_string($database,$quizxml);
  $lessonid = $_SESSION['editlessonid'];
  $query = "UPDATE lessons SET quizxml='$quizxml' WHERE lesson_id='$lessonid'";

  mysqli_query($database, $query);
}
?>
