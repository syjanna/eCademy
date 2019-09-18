<?php
session_start();
$servername = "localhost";
$username = "iw3htp";
$password = "password";
$eduCode = "ilovetolearn";
//initialize variables
$uname_reg = "";
$pswd_reg = "";
$pswd2_reg = "";
$acc_type_reg = "student";
$uname_log = "";
$pswd_log = "";
$acc_type_log = "student";
$messages = []; // messages to show to the user

// create and connect to mysql server
if ( !( $database = mysqli_connect($servername, $username, $password)))
  die ("Could not connect to server");

// connecting to ecademy database
if ( !(mysqli_select_db( $database, "ecademydb")))
  die ("Error connecting to the ecademy database");

// Register
if (isset($_POST['registration'])) {
  $uname = mysqli_real_escape_string($database, $_POST['uname_reg']);
  $pswd = mysqli_real_escape_string($database, $_POST['pswd_reg']);
  $pswd2 = mysqli_real_escape_string($database, $_POST['pswd2_reg']);

  // check database to ensure the same username does not exist in the system.
  $uname_check_q = "SELECT * FROM users WHERE uname='$uname'";
  $result = mysqli_query($database, $uname_check_q);
  $uname_exists = mysqli_fetch_assoc($result);

  //validate form
  if ($pswd != $pswd2) {
    array_push($messages, "Passwords must match.");
  }
  if ($uname_exists) {
    array_push($messages, "Username already exists.");
  }
  if (isset($_POST['is_instructor'])) {
    if (!verifyEduCode(mysqli_real_escape_string($database, $_POST['edu_code']))){
      array_push($messages, "Education code is incorrect.");
    }
  }

  // check password and username requirements
  // password must be at least 8 characters, and have at least one letter and one number
  // username must be at least 4 characters
  if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $pswd)){
    array_push($messages, "Password must be at least 8 characters and contain at least 1 letter and 1 number.");
  }
  if (strlen($uname) < 4) {
    array_push($messages, "Username must be at least 4 characters.");
  }

  if (count($messages) == 0) {
    $pswd = md5($pswd); // encrypt password
    $query = "INSERT INTO users (uname, password, acc_type) VALUES ('$uname', '$pswd', '$acc_type_reg')";
    mysqli_query($database, $query);
    array_push($messages, "You are now registered for an account. Your username is $uname");
  }
}


// Login
if (isset($_POST['login'])){
  $uname = mysqli_real_escape_string($database, $_POST['uname_log']);
  $pswd = mysqli_real_escape_string($database, $_POST['pswd_log']);
  $acc_type = mysqli_real_escape_string($database, $_POST['acc_type_log']);
  $query = "SELECT * FROM users WHERE uname='$uname'";
  $result = mysqli_query($database, $query);
  if (mysqli_num_rows($result) == 0) {
    array_push($messages, "User does not exist.");
  } else {
    $pswd = md5($pswd);
    $query = "SELECT * FROM users WHERE uname='$uname' AND password='$pswd' AND acc_type='$acc_type'";
    $result = mysqli_query($database, $query);
    if (mysqli_num_rows($result) == 1) {
      $_SESSION['uname'] = $uname; // if the login was successful, set session uname to that username so we know this user is logged in
      if ($acc_type == "instructor"){
        header('location: instructor/index.php');
        $_SESSION['instructor'] = $uname;
      } else {
        header('location: student/index.php');
      }
    } else {
      array_push($messages, "Wrong username or password.");
    }
  }
}

// helper functions
function verifyEduCode($code) {
  if ($code == $GLOBALS['eduCode']){
    $GLOBALS['acc_type_reg'] = "instructor";
    return True;
  } else {
    return False;
  }
}
