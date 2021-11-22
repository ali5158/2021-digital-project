<?php
//Include functions that are needed
require_once 'includes/dbh.inc.php';
require_once "includes/header.php";
require_once "includes/functions.inc.php";

//Check to see if session variables have been started
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

//Require both the item name and date lost
if(isset($_POST["submit"])) {
  $item_name = $_POST["item_name"];
  $category = $_POST["category"];
  $item_value = $_POST["item_value"];
  $date_lost = $_POST["date_lost"];
  $user_id = $_SESSION["user_id"];
}

// Make sure that the search field isnt left empty
// unless the showall box has been ticked.
if (empty($item_name) && !isset($_POST["showall"])) {
  header("location: items.php?error=emptyfield");
  exit();
}

// Initial SQL statement
$sql = 'SELECT * FROM `items` INNER JOIN category ON category.category_id = items.category_id WHERE `item_name` LIKE "%'  . $item_name . '%" AND items.category_id = " . $category . " ';


// These if statements add onto the initial SQL statement
// to construct a unique one based on what the user inputs.

 if (!empty($item_value)) {
  //Find out what type of operator was used in the value field
  $value_operator = "";
  validateValue($item_value,$value_operator);
  $sql .= "AND `item_value` " . $value_operator . $item_value . " ";
 }

 if (!empty($date_lost)) {
  $sql .= 'AND `date_lost` = "' . $date_lost . '" ';
 }
//Adds flags to make sure that the item is currently 'lost'
$sql .= "AND is_archived = 0 AND is_found = 0";

//Changes SQL statement to return all items from the items database
 if (isset($_POST["showall"])) {
  $sql = 'SELECT * FROM `items` INNER JOIN category ON category.category_id = items.category_id';
 }


?>

<link rel="stylesheet" href ="css/table.css">
<link rel="stylesheet" href ="css/form-style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<h2>Search Results</h2>
<table>
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
<?php
  if ($_SESSION["is_admin"] !== 1) {
    $sql .= " AND user_id = " . $user_id . ";";
  }
  $items = mysqli_query($conn,$sql);
  $users = mysqli_query($conn,$sql);
?>

<h2>Edit an item</h2>
  <div class = "inputlabel">
    <form action = "edit.php" method = "post">
    <label for = "item">My Items</label>
    <select name = "item">
        <?php while($category = mysqli_fetch_array($items,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $category["item_id"]; ?>">
                <?php echo $category['item_id'] . ' | ' . $category['item_name']; ?>
            </option>
        <?php endwhile; ?>
    <input type = "submit" name = "submit" value = "Edit">
    </form>
  </div>


<h2>Contact a user</h2>
<div class = "inputlabel">
  <form action = "contact.php" method = "post">
    <label for = "user">Items</label>
    <select name = "user">
        <?php while($category = mysqli_fetch_array($users,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $category["user_id"]; ?>">
                <?php echo $category['item_id'] . ' | ' . $category['item_name']; ?>
            </option>
        <?php endwhile; ?>
    <input type = "submit" name = "submit" value = "Contact">
  </form>
</div>

