<?php
	include "db/dbsetup.php";
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../shared/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<title>Registration</title>
</head>

<body>
	<div id="logo">
		<img src="img/logo.png"/>
	</div>
	<br>
  <center>
  <p>Fill in your details to start learning with eCademy today.<br>
	Note: If you are an instructor, check the checkbox and enter the education code.</p>

	<div id="messages">
		<?php
			if (count($messages) > 0){
				foreach ($messages as $e) {
					echo "<b>".$e."</br></b>";
				}
			}
		?>
	</div><br>

	<div id="login_form" style="height: 420px;">
	  <form method="post" action="register.php">
			<h2 class="subtitle"> Register </h2>
	    <label>Username</label> <br><input name="uname_reg" type="text" required></input><br>
	    <label>Password</label> <br><input name="pswd_reg" type="password" required></input><br>
	    <label>Confirm password</label> <br><input name="pswd2_reg" type="password" required></input><br><br>
      <input type="checkbox" name="is_instructor" value="checked"><label>I confirm that I am registering as an instructor.</label><br><input name="edu_code" type="password" placeholder="education code"></input><br><br>
	    <button name="registration" class="txt_btn" type="submit">Register now!</button><br><br>
			Already a member? <a href="home.php">Login</a>
	  </form>
	</div>
  </center><br>


</body>
</html>
