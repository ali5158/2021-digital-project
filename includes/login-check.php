<?php

session_start();

if (!isset($_SESSION["useremail"])) {
	header("location: login.php?error=notloggedin");
	exit();
}

?>