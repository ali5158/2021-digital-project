<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION["useremail"])) {
	header("location: login.php?error=notloggedin");
	exit();
}

?>