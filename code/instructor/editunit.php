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
	<title>Edit unit</title>
</head>


<body>
	<div id="logo">
		<a href="index.php"><img src="../img/logo.png"/></a>
	</div>
  <center>
  <?php
  $unit_id = $_SESSION['editunitid'];
  $query = "SELECT name FROM units WHERE unit_id = '$unit_id'";
	$result = mysqli_query($database, $query);

  while ($row = $result->fetch_array()) {
    $_SESSION['editunitname'] = $row['name'];
  }

  echo("<h1>Editing " . $_SESSION['editunitname'] . "</h1>");
  ?>

	<div id="container">
		<h2 class="subtitle"> Lessons </h2>

		<div id="user_bookmarks">
			<?php
			  echo "<ol>";
        $unit_id = $_SESSION['editunitid'];
				$query = "SELECT lesson_id,name FROM lessons WHERE unit_id='$unit_id'";
				$result = mysqli_query($database, $query);

        if (mysqli_num_rows($result) == 0){
          echo "This course currently has no lessons.";
        } else {
          while ($row = $result->fetch_array()) {
            echo "<li id=" . $row['lesson_id'] . ">" . $row['name'];
            echo "<input class='edit_lesson_btn' type='submit' value='edit'/>";
            echo "<input class='del_lesson_btn' type='submit' value='delete'/>";
            echo "</li><br/>";
          }
        }
			  echo "</ol>";


			?>

    </div>

  </div>

  <div id="add_section">
    Add a new lesson to this course here.
    <form method="post" action="editunit.php">
      Lesson name: <input type="text" name="addlesson_name" id="addlesson" required></input><button type="submit" name="addlesson">Add lesson</button>
    </form>
  </div>
  Click <a href="editcourse.php">here</a> to go back.
</center>
<script src="instructor.js" type="text/javascript"></script>
</body>
</html>
