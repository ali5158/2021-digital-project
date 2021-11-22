<?php

 if (isset($_POST["submit"])) {
 	$firstname = $_POST["firstname"];
 	$lastname = $_POST["lastname"];
 	$email = $_POST["email"];
 	$mobilenumber = $_POST["mobilenumber"];
 	$password = $_POST["password"];
 	$passwordrepeat = $_POST["passwordrepeat"];

 	require_once 'dbh.inc.php';
 	require_once 'functions.inc.php';
 }

 if (emptyInputSignup($firstname,$lastname,$email,$mobilenumber,$password,$passwordrepeat !== false)) {
    header("location: ../signup.php?error=emptyinput");
    exit();
 }

 if (invalidEmail($email) !== false) {
    header("location: ../signup.php?error=invalidemail");
    exit();
 }

 if (passwordMatch($password,$passwordrepeat) !== false) {
    header("location: ../signup.php?error=passwordsdontmatch");
    exit();
 }

 if (emailExists($conn,$email) !== false) {
    header("location: ../signup.php?error=emailexists");
    exit();
 }

 $mobilenumber = validateMobileNumber($mobilenumber);

 createUser($conn,$firstname,$lastname,$email,$mobilenumber,$password);
