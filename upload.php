<?php include_once 'includes/header.php' ?>

<h2>Upload an Item</h2>
<h4>Please fill all fields</h4>
<link rel="stylesheet" href ="css/form-style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class ="upload-form">
 <form action="includes/upload.inc.php" method="post">

  <div class="inputlabel">
   <label for = "itemname">Item Name</label>
   <input type = "text" name= "itemname" placeholder= "Item Name">
  </div>

  <div class="inputlabel">
   <label for = "itemvalue">Description</label>
   <input type = "text" name= "itemvalue" placeholder= "Item Description">
  </div>

  <div class="inputlabel">
   <label for = "itemvalue">Value</label>
   <input type = "text" name= "itemvalue" placeholder= "Item Value">
  </div>

  <div class = "inputlabel">
  	<label for = "datelost">Date Lost</label>
  	<input type = "date" value="<?php  date_default_timezone_set("pacific/auckland"); echo date("Y-m-d");?>" name ="datelost">
  </div>

  <input type = "submit" name = "submit" value = "Upload">
</form>

</div>