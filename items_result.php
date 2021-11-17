<?php
//Check whether the session has been started,
//then add header to page.
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once 'includes/dbh.inc.php';
require_once "includes/header.php";


//Require both the item name and date lost
if(isset($_POST["submit"])) {
  $item_name = $_POST["item_name"];
  $category = $_POST["category"];
  $item_value = $_POST["item_value"];
  $date_lost = $_POST["date_lost"];
  $user_id = $_SESSION["user_id"];
  }
//Make sure that the search field isnt left empty
if (empty($item_name) && !isset($_POST["showall"])) {
  header("location: items.php?error=emptyfield");
  exit();
}

//Constructing SQL statement
 if (isset($_POST["showall"])) {
  $sql = 'SELECT * FROM `items` INNER JOIN category ON category.category_id = items.category_id';
 }
 else {
 $sql = 'SELECT * FROM `items` INNER JOIN category ON category.category_id = items.category_id WHERE `item_name` LIKE "' . $item_name . '" ';

 if (!empty($category)) {
  $sql .= "AND items.`category_id` = " . $category . " ";
 }

 if (!empty($item_value)) {
  $sql .= "AND `item_value` = " . $item_value . " ";
 }

 if (!empty($date_lost)) {
  $sql .= 'AND `date_lost` = "' . $date_lost . '" ';
 }
$sql .= "AND is_archived = 0 AND is_found = 0";
}
?>

<link rel="stylesheet" href ="css/table.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<h2>Search Results</h2>
<table id="fairtable">
  <tr>
    <td class = "column-header">Item ID </td>
    <td class = "column-header">Item Name</td>
    <td class = "column-header">Date Lost</td>
    <td class = "column-header">Item Value</td>
    <td class = "column-header">Category Name</td>
  </tr>

    <?php 
        $results = mysqli_query($conn,$sql);
        while($rowitem = mysqli_fetch_array($results,MYSQLI_ASSOC)) {
        echo "<tr>";
            echo "<td>" . $rowitem['item_id'] . "</td>";
            echo "<td>" . $rowitem['item_name'] . "</td>";
            echo "<td>" . $rowitem['date_lost'] . "</td>";
            echo "<td>" . $rowitem['item_value'] . "</td>";
            echo "<td>" . $rowitem['category_name'] . "</td>";
            echo "</tr>";
            }
    ?>
</table>