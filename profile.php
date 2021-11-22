<link rel="stylesheet" href ="css/table.css">
<link rel="stylesheet" href ="css/form-style.css">
<?php
 include_once 'includes/header.php';
 include_once 'includes/login-check.php';
 include_once 'includes/dbh.inc.php';

 echo "<h2> Welcome back " . $_SESSION['user_first_name'] . "</h2>";

 $user_id = $_SESSION['user_id'];
?>
 <h3>Items you've lost</h3>
 <table id="fairtable">
    <tr>
        <td class = "column-header">Item ID </td>
        <td class = "column-header">Item Name</td>
        <td class = "column-header">Date Lost</td>
        <td class = "column-header">Item Value</td>
        <td class = "column-header">Category Name</td>
    </tr>

    <?php 
        $basesql = "SELECT items.`item_id`,items.`item_name`,items.`date_lost`,items.`item_value`,category.`category_name` 
                        FROM items 
                            INNER JOIN category ON category.category_id = items.category_id
                        WHERE items.user_id = " . $user_id;
        $sql = $basesql . " AND `status_id` = 1";
        $lost = mysqli_query($conn,$sql);


        while($rowitem = mysqli_fetch_array($lost,MYSQLI_ASSOC)) {
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

<h3>Items you've found</h3>
<table>
    <tr>
        <td class = "column-header">Item ID </td>
        <td class = "column-header">Item Name</td>
        <td class = "column-header">Date Lost</td>
        <td class = "column-header">Item Value</td>
        <td class = "column-header">Category Name</td>
    </tr>
    <?php
        $sql = $basesql . " AND `status_id` = 2";
        $found = mysqli_query($conn,$sql);


        while($rowitem = mysqli_fetch_array($found,MYSQLI_ASSOC)) {
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
    <form action = "edit.php" method = "post">
    <label for = "item">My Items</label>
    <select name = "item">
        <?php while($category = mysqli_fetch_array($all_items,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $category["item_id"]; ?>">
                <?php echo $category['item_id'] . ' | ' . $category["item_name"]; ?>
            </option>
        <?php endwhile; ?>
    <input type = "submit" name = "submit" value = "Edit">
    </form>
  </div>


