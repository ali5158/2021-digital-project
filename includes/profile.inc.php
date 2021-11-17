<?php
if (session_status() == PHP_SESSION_NONE) {
  	session_start();
}

if(isset($_POST["submit"])) {

	$item = $_POST["item"];
	$action = $_POST["action"];

	require_once 'dbh.inc.php';
	require_once 'functions.inc.php';
	if ($action === "edit") {
		header("location: ../edit.php?item_id=" . $item);
	}

	else {
		editItem($conn,$action,$item);
	}

}
else {
	header("location: ../profile.php?error=statementtfailed");
	exit();
}