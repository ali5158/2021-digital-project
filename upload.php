<?php 

include_once 'includes/header.php';
include_once 'includes/login-check.php';
include 'includes/dbh.inc.php';
?>

<h2>Upload an Item</h2>
<h4>Please fill all fields</h4>
<link rel="stylesheet" href ="css/form-style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class ="upload-form">
 <form action="includes/upload.inc.php" method="post">

  <div class="inputlabel">
   <label for = "itemname">Item Name</label>
   <input type = "text" name= "item_name" placeholder= "Item Name">
  </div>

  <div class = "inputlabel">
    <label for = "category">Category</label>
    <select name = "category">
        <?php 
        $sql = "SELECT * FROM `category` ";
        $all_categories = mysqli_query($conn,$sql);
        while($category = mysqli_fetch_array($all_categories,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $category["category_id"]; ?>">
                <?php echo $category["category_name"]; ?>
            </option>
        <?php endwhile; ?>
    </select>
  </div>

  <div class="inputlabel">
    <label for = "itemvalue" class = "w30">Value</label>
    <select name = "category" class = "w20">
            <option value="<"><</option>
            <option value="=">=</option>
            <option value=">">></option>
            </option>
    </select>
    <input type = "text" name= "item_value" placeholder= "Item Value" class = "w40">
  </div>

  <div class = "inputlabel">
  	<label for = "date_lost">Date Lost</label>
  	<input type = "date" value="<?php  date_default_timezone_set("pacific/auckland"); echo date("d-m-y"); ?>" name ="date_lost">
  </div>

  <div class = "inputlabel">
    <label for = "location">Location</label>
    <select name = "location">
    <?php
    $sql = "SELECT * FROM `location` ";
    $all_locations = mysqli_query($conn,$sql);
    while($location = mysqli_fetch_array($all_locations,MYSQLI_ASSOC)): ?>
        <option value="<?php echo $location["location_id"]; ?>">
            <?php echo $location["location_name"]; ?>
        </option>
    <?php endwhile; ?>
    </select>
  </div>

  <input type = "submit" name = "submit" value = "Upload">
</form>

<?php 
if (isset($_GET["error"])) {

    if ($_GET["error"] == "emptyinput") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Fill all input fields" . "</div>";
    }

    else if ($_GET["error"] == "none") {
        echo "<div class='isa_success'>" . "<i class='fa fa-check'></i>Item successfully posted" . "</div>";
    }
}
?>
