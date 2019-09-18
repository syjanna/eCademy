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
	<title>Instructor homepage</title>
</head>

<body>
	<div id="logo">
		<a href="index.php"><img src="../img/logo.png"/></a>
	</div>
  <br>
  <center>
  <?php echo "Welcome to your homepage, " . $uname . "!";  ?><br/><br/>

  <button id="logout" class="txt_btn">Log out</button>


	<div id="container">
		<h2 class="subtitle"> Your current courses </h2>

		<div id="user_bookmarks">

			<?php
			echo "<ol>";
				$query = "SELECT subject,course_id,name FROM courses WHERE instructor='$uname'";
				$result = mysqli_query($database, $query);

        while ($row = $result->fetch_array()) {
          echo "<li id=" . $row['course_id'] . ">" . $row['subject'] . $row['course_id'] . ": " . $row['name'];
          echo "<input class='edit_btn' type='submit' value='edit'/>";
          echo "<input class='del_btn' type='submit' value='delete'/>";
          echo "</li><br/>";
        }
			echo "</ol>";

			if (mysqli_num_rows($result) == 0){
				echo "You don't currently have any courses! Click the following button to create a new course:";
			}
			?>
			<button id="create_course" class="txt_btn"> Create a new course </button>
		</div>
	</div>





  </center>
	<script src="instructor.js" type="text/javascript"></script>
</body>

</html>
