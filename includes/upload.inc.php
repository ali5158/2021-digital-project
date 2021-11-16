<?php
if (session_status() == PHP_SESSION_NONE) {
  	session_start();
}

if(isset($_POST["submit"])) {

	$item_name = $_POST["item_name"];
	$category = $_POST["category"];
	$item_value = $_POST["item_value"];
	$date_lost = $_POST["date_lost"];
	$user_id = $_SESSION["user_id"];

	require_once 'dbh.inc.php';
	require_once 'functions.inc.php';


	createItem($conn,$item_name,$category,$item_value,$date_lost,$user_id);

}
else {
	header("location: ../upload.php");
	exit();
}