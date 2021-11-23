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
    <form action = "report.php" method = "post">
    <label for = "report">Reports</label>
    <select name = "report">
        <?php while($report = mysqli_fetch_array($results,MYSQLI_ASSOC)): ?>
            <option value="<?php echo $report["report_id"]; ?>">
                <?php echo $report["report_name"]; ?>
            </option>
        <?php endwhile; ?>
    <input type = "submit" name = "submit" value = "View Report">
    </form>
  </div>

