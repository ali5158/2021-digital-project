<link rel="stylesheet" href ="css/table.css">
<link rel="stylesheet" href ="css/form-style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php 
 include_once 'includes/header.php';
 include_once 'includes/dbh.inc.php';
 include_once 'includes/login-check.php';

 $sql = "SELECT * FROM `category` ORDER BY `category`.`category_name` ASC;";
 $all_categories = mysqli_query($conn,$sql);
?>

<h2>Search for an item</h2>
<div class = "item-search-form">
 <form action= "search_result.php" method= "post">

	<div class= "inputlabel">
   		<label for = "search">*Item name</label>
    	<input type = "text" name = "item_name" placeholder = "Search">
    </div>

  <div class = "inputlabel">
    <label for = "item">*Category</label>
    <select name = "category">
        <?php while($category = mysqli_fetch_array($all_categories,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $category["category_id"]; ?>">
                <?php echo $category["category_name"]; ?>
            </option>
        <?php endwhile; ?>
    </select>
  </div>

  <div class="inputlabel">
    <label for = "operatortype">Value</label>
    <br>
    <select name = "operatortype" id = "w20">
            <option value="=">=</option>
            <option value="<"><</option>
            <option value=">">></option>
            </option>
    </select>
    <input type = "text" name= "item_value" placeholder= "Item Value" id = "w60">
  </div>


  <div class = "inputlabel">
    <label for = "date_lost">Date Lost</label>
    <input type = "date" name = "date_lost">
  </div>

  <input type = "submit" name = "submit" value = "Search">
 </form>
 <h4> * Indicates required field </h4>
</div>

<?php
if (isset($_GET["error"])) {

    if ($_GET["error"] == "emptyinput") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Fill search term field" . "</div>";
    }
    if ($_GET["error"] == "dateinvalid") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Date lost is greater than todays date" . "</div>";
    }
}
?>