<?php 
  include_once 'includes/header.php';
  include_once 'includes/login-check.php';
  include 'includes/dbh.inc.php';
  //Get item_id from the URL
  $item_id = $_POST["item"];

  //SQL and Query for item_id passed in through URL
  $sql = "SELECT * FROM `items` WHERE `item_id` = " . $item_id;
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $category = $row["category_id"];
  $location = $row["location_id"];

  //SQL and Query for the category dropdown box
  $sql = "SELECT * FROM `category` ";
  $all_categories = mysqli_query($conn,$sql);
?>
<link rel="stylesheet" href ="css/form-style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<h2>Edit an Item</h2>
<h4>Please fill all fields</h4>

<form action="form/edit.form.php" method="post">
  <input type = "hidden" name = "item_id" value = "<?php echo $item_id; ?>">

  <div class="inputlabel">
    <label for = "itemname">Item Name</label>
    <input type = "text" name= "item_name" placeholder= "Item Name" value = "<?php echo $row["item_name"]; ?>">
  </div>

  <div class = "inputlabel">
    <label for = "category">Category</label>
    <select name = "category">
      <option value = "">Select...</option>
      <?php while($category = mysqli_fetch_array($all_categories,MYSQLI_ASSOC)):?>
        <option value="<?php echo $category['category_id']; ?>">
          <?php echo $category["category_name"]; ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class= "inputlabel">
   <label for = "itemvalue">Value</label>
   <input type = "text" name= "item_value" placeholder= "Item Value" value = "<?php echo $row['item_value']; ?>">
  </div>

  <div class = "inputlabel">
  	<label for = "date_lost">Date Lost</label>
  	<input type = "date" value="<?php echo $row['date_lost']; ?>" name = "date_lost">
  </div>

  <div class = "inputlabel">
    <label for = "status">Action</label>
    <select name = "status">
        <option value = "">Select...</option>
        <?php 
        $sql = "SELECT * FROM `status` WHERE is_active = 1;";
        $all_status = mysqli_query($conn,$sql);

        while($status = mysqli_fetch_array($all_status,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $status['status_id']; ?>">
                <?php echo $status["status_name"]; ?>
            </option>
        <?php endwhile; ?>
    </select>
  </div>

  <div class = "inputlabel">
    <label for = "location_id">Location</label>
    <select name = "location_id">
        <option value = "">Select...</option>
        <?php 
        $sql = "SELECT * FROM `location` WHERE is_active = 1;";
        $all_locations = mysqli_query($conn,$sql);

        while($location = mysqli_fetch_array($all_locations,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $location['location_id']; ?>">
                <?php echo $location["location_name"]; ?>
            </option>
        <?php endwhile; ?>
    </select>
  </div>

  <input type = "submit" name = "submit" value = "Confirm">
</form>