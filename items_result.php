<?php
//Check whether the session has been started,
//then add header to page.
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include_once "includes/header.php";

//Require both the item name and date lost
if(isset($_POST["submit"])) {
  $item_name = $_POST["item_name"];
  $category = $_POST["category"];
  $item_value = $_POST["item_value"];
  $date_lost = $_POST["date_lost"];
  $user_id = $_SESSION["user_id"];
}
//Make sure that the search field isnt left empty
if (empty($item_name)) {
  header("location: items.php?error=emptyfield");
  exit();
}
//Connect to database


//Inital SQL statement, will add on to 
//it depending on if statements ahead

 $sql = "SELECT * FROM `items` WHERE `item_name` LIKE " . $item_name . " ";

 if (!empty($category)) {
  $sql .= "AND `category` = " . $category . " ";
 }

 if (!empty($item_value)) {
  $sql .= "AND `item_value` = " . $item_value . " ";
 }

 if (!empty($date_lost)) {
  $sql .= "AND `date_lost` = " . $date_lost . " ";
 }
$sql .= ";";
echo $sql;
?>


