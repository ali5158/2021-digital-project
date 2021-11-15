<?php

if(isset($_POST["submit"])) {

	$item_name = $_POST["item_name"];
	$category = $_POST["category"];
	$item_value = $_POST["item_value"];
	$date_lost = $_POST["date_lost"];

	//echo $item_name . '<br>';
	//echo $category . '<br>';
	//echo $item_value . '<br>';
	//echo $date_lost . '<br>';
	//exit();


	require_once 'dbh.inc.php';
	require_once 'functions.inc.php';

	createItem($conn,$item_name,$category,$item_value,$date_lost);

}
else {
	header("location: ../upload.php");
	exit();
}