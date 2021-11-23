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
  $item_type = $_POST["item_type"];
  $location = $_POST["location"];

  if ($item_type == "lost") {
    //Location is set to unknown & item_type set to lost
    $location = 6;
    $item_type = 1;
  } 

  else {
    //Location is set to unknown & item_type set to found
    $item_type = 2;
  }


	require_once '../includes/dbh.inc.php';
	require_once '../includes/functions.inc.php';

  createItem($conn,$item_name,$category,$item_value,$date_lost,$user_id,$item_type,$location);
}

else {
  header("location: ../upload.php");
  exit();
}