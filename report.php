<link rel="stylesheet" href ="css/table.css">
<link rel="stylesheet" href ="css/form-style.css">

<?php
require_once 'includes/header.php';
require_once 'includes/login-check.php';
require_once 'includes/dbh.inc.php';

if (isset($_POST["submit"])) {
	$report_id = $_POST["report"];
}

if ($report_id == 3) {
  echo "<h2>Users with most lost items</h2>";
  $sql = "SELECT `items`.`user_id`,`users`.`user_first_name`,`users`.`user_last_name`,COUNT(`items`.`user_id`) AS 'items_lost'
  		  FROM `items`
		    INNER JOIN users ON `items`.`user_id` = `users`.`user_id`
		  WHERE `items`.`status_id` = 1
		  GROUP BY `items`.`user_id`
		  HAVING COUNT(`items`.`user_id`) > 0
		  ORDER BY `items_lost` DESC";

$x = mysqli_query($conn,$sql);

echo '<table>';
  echo '<tr>';
    echo '<td class = "column-header">User ID</td>';
    echo '<td class = "column-header">First Name</td>';
    echo '<td class = "column-header">Last Name</td>';
    echo '<td class = "column-header">Items Lost</td>';
  echo '</tr>';
while($rowitem = mysqli_fetch_array($x,MYSQLI_ASSOC)) {
  echo "<tr>";
    echo "<td>" . $rowitem['user_id'] . "</td>";
    echo "<td>" . $rowitem['user_first_name'] . "</td>";
    echo "<td>" . $rowitem['user_last_name'] . "</td>";
    echo "<td>" . $rowitem['items_lost'] . "</td>";
  echo "</tr>";
}
echo "</table>";
}

else if ($report_id == 4) {
  echo "<h2>Locations where item lost</h2>";
	$sql = "SELECT `location`.`location_name`,COUNT(`items`.`location_id`) AS 'location_lost'
  		  FROM `items`
		    INNER JOIN `location` ON `items`.`location_id` = `location`.`location_id`
        WHERE `location`.`location_name` != 'lost'
		  GROUP BY `items`.`location_id`
		  HAVING COUNT(`items`.`location_id`) > 0
          ORDER BY `location_lost` DESC";

  $y = mysqli_query($conn,$sql);

  echo '<table>';
  echo '<tr>';
    echo '<td class = "column-header">Location Name</td>';
    echo '<td class = "column-header">Location Lost</td>';
  echo '</tr>';
  while($rowitem = mysqli_fetch_array($y,MYSQLI_ASSOC)) {
  echo "<tr>";
    echo "<td>" . $rowitem['location_name'] . "</td>";
    echo "<td>" . $rowitem['location_lost'] . "</td>";
  echo "</tr>";
}
echo "</table>";
}

else if ($report_id == 5) {
	echo "<h2>Days found items were missing for</h2>";
  $sql = "SELECT `item_name`,DATEDIFF(`date_found`, `date_lost`) AS 'Days'
          FROM `items`
          WHERE `status_id` = 3;";

  $z = mysqli_query($conn,$sql);

  echo '<table>';
  echo  '<tr>';
    echo '<td class = "column-header">Item Name</td>';
    echo '<td class = "column-header">Days Lost</td>';
  echo '</tr>';
  while($rowitem = mysqli_fetch_array($z,MYSQLI_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $rowitem['item_name'] . "</td>";
    echo "<td>" . $rowitem['Days'] . "</td>";
    echo "</tr>";
}
echo "</table>";
}
?>