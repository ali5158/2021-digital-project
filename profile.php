<link rel="stylesheet" href ="css/table.css">
<link rel="stylesheet" href ="css/form-style.css">
<?php
 include_once 'includes/header.php';
 include_once 'includes/login-check.php';
 include_once 'includes/dbh.inc.php';

 echo "<h2> Welcome back " . $_SESSION['user_first_name'] . "</h2>";

 $user_id = $_SESSION['user_id'];
?>
 <h3>Your Lost Items:</h2>
 <table id="fairtable">
    <tr>
        <td class = "column-header">Item ID </td>
        <td class = "column-header">Item Name</td>
        <td class = "column-header">Date Lost</td>
        <td class = "column-header">Item Value</td>
        <td class = "column-header">Category Name</td>
    </tr>

    <?php 
        $sql = "SELECT items.`item_id`,items.`item_name`,items.`date_lost`,items.`item_value`,category.`category_name` FROM items INNER JOIN category ON category.category_id = items.category_id WHERE items.user_id = " . $user_id;
        $all_items = mysqli_query($conn,$sql);

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

<h2>Edit an item</h2>

  <div class = "inputlabel">
    <form action = "includes/profile.inc.php" method = "post">
    <label for = "item">My Items</label>
    <select name = "item">
        <?php while($category = mysqli_fetch_array($all_items,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $category["item_id"]; ?>">
                <?php echo $category['item_id'] . ' | ' . $category["item_name"]; ?>
            </option>
        <?php endwhile; ?>
    </select>
    <input type = "submit" name = "delete" value = "Mark as found">
    </form>
  </div>

