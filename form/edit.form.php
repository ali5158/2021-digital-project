<?php
if (session_status() == PHP_SESSION_NONE) {
  	session_start();
}

if(isset($_POST["submit"])) {

	$item_name = $_POST["item_name"];
	$category = $_POST["category"];
	$item_value = $_POST["item_value"];
	$date_lost = $_POST["date_lost"];
	$item_id = $_POST["item_id"];
	$status = $_POST["status"];
	$location_id = $_POST["location_id"];

	require_once '../includes/dbh.inc.php';
	require_once '../includes/functions.inc.php';


	editItem($conn,$item_name,$category,$item_value,$date_lost,$item_id,$status,$location_id);

}
else {
	header("location: ../profile.php");
	exit();
}