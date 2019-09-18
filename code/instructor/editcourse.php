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
	<title>Edit course</title>
</head>


<body>
	<div id="logo">
		<a href="index.php"><img src="../img/logo.png"/></a>
	</div>
  <center>
  <?php
  $course_id = $_SESSION['editcourseid'];
  $query = "SELECT name, subject FROM courses WHERE course_id = '$course_id'";
	$result = mysqli_query($database, $query);

  while ($row = $result->fetch_array()) {
    $_SESSION['editcoursesubject'] = $row['subject'];
    $_SESSION['editcoursename'] = $row['name'];
  }

  echo("<h1>Editing " . $_SESSION['editcoursesubject'] . $_SESSION['editcourseid'] . ": " . $_SESSION['editcoursename'] . "</h1>");
  ?>

  <form method="post" action="editcourse.php">
    <br><input id="new_course_name" type="text" value="<?php echo($_SESSION['editcoursename']); ?>"></input>
    <button type="submit" id="changecoursename"> Change course name </button>
  </form>

	<div id="container">
		<h2 class="subtitle"> Units </h2>

		<div id="user_bookmarks">
			<?php
			  echo "<ol>";
        $course_id = $_SESSION['editcourseid'];
				$query = "SELECT unit_id,name FROM units WHERE course_id='$course_id'";
				$result = mysqli_query($database, $query);

        if (mysqli_num_rows($result) == 0){
          echo "This course currently has no units.";
        } else {
          while ($row = $result->fetch_array()) {
            echo "<li id=" . $row['unit_id'] . ">" . $row['name'];
            echo "<input class='edit_unit_btn' type='submit' value='edit'/>";
            echo "<input class='del_unit_btn' type='submit' value='delete'/>";
            echo "</li><br/>";
          }
        }
			  echo "</ol>";


			?>

    </div>

  </div>

  <div id="add_section">
    Add a new unit to this course here.
    <form method="post" action="editcourse.php">
      Unit name: <input type="text" name="addunit_name" id="addunit" required></input><button type="submit" name="addunit">Add unit</button>
    </form>
  </div>
  Click <a href="index.php">here</a> to go back.
</center>
<script src="instructor.js" type="text/javascript"></script>
</body>
</html>
