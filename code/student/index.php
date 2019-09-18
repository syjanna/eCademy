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
	<title>Student homepage</title>
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
				$query = "SELECT courses.subject,courses.course_id,courses.name FROM registration INNER JOIN courses ON courses.course_id = registration.course_id WHERE student='$uname';";
				$result = mysqli_query($database, $query);

        while ($row = $result->fetch_array()) {
          echo "<li id=" . $row['course_id'] . ">" . $row['subject'] . $row['course_id'] . ": " . $row['name'];
          echo " <input class='course_btn' type='submit' value='Go to course page'/>";
          echo "</li><br/>";
        }
			echo "</ol>";

			if (mysqli_num_rows($result) == 0){
				echo "You don't currently have any courses! Click the following button to register for a new course:<br>";
			}
			?>
			<button id="register_course" class="txt_btn"> Register for a new course </button>
		</div>
	</div>





  </center>
	<script src="student.js" type="text/javascript"></script>
</body>

</html>
