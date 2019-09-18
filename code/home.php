<?php
	include "db/dbsetup.php";

	global $database;
	if (isset($_SESSION['uname'])){
		$uname = $_SESSION['uname'];
		$query = "SELECT acc_type FROM users WHERE uname='$uname'";
    $result = mysqli_query($database, $query);
		while ($row = $result->fetch_array()) {
			if ($row['acc_type'] == "instructor"){
        header('location: ./instructor/index.php');
      } else {
        header('location: ./student/index.php');
      }
		}

	}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../shared/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>eCademy homepage</title>
</head>


<body>
	<div id="logo">
		<img src="img/logo.png"/>
	</div>
	<br><br>

	<div id="content">

		<center>
		<p> Welcome to eCademy! Please login to access your account. </p>

		<div id="messages">
			<?php
				if (count($messages) > 0){
					foreach ($messages as $e) {
						echo "<b>".$e."</br></b>";
					}
				}
			?>
		</div><br>

		<div id="login_form">
			<form action="home.php" method="post">
				<h2 class="subtitle"> Login </h2>
				<label>Username:</label> <br><input name="uname_log" type="text" required></input><br>
				<label>Password:</label> <br><input name="pswd_log" type="password" required></input><br>
        <label>Are you an instructor or a student?</label><br><input type="radio" name="acc_type_log" value="instructor" required>Instructor</input><input type="radio" name="acc_type_log" value="student">Student</input> <br><br>
				<button class="txt_btn" type="submit" name="login">Login</button><br><br>
				Don't have an account? <a href="register.php">Sign up</a>
			</form>
		</div>
	</center>
	</div>
	<br><br>

</body>
</html>
