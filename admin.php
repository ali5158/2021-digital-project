<?php
include_once "includes/header.php";
include_once "includes/dbh.inc.php";

$sql = "SELECT * FROM reports";
$results = mysqli_query($conn,$sql);
?>
<link rel="stylesheet" href ="css/table.css">
<link rel="stylesheet" href ="css/form-style.css">
<h2>Admin Page</h2>

  <div class = "inputlabel">
    <form action = "edit.php" method = "post">
    <label for = "item">Reports</label>
    <select name = "item">
        <?php while($category = mysqli_fetch_array($results,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $category["item_id"]; ?>">
                <?php echo $category['item_id'] . ' | ' . $category["item_name"]; ?>
            </option>
        <?php endwhile; ?>
    <input type = "submit" name = "submit" value = "View Report">
    </form>
  </div>

