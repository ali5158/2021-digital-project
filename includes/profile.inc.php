<?php
if (session_status() == PHP_SESSION_NONE) {
  	session_start();
}

if(isset($_POST["submit"])) {

	$item = $_POST["item"];
	$action = $_POST["action"];

	require_once 'dbh.inc.php';
	require_once 'functions.inc.php';
	if ($action === "edit") {
		echo "<form action='../edit.php' method='post'>";
		echo "<input type = 'hidden' name = 'item_id' value = '<?php echo $item_id; ?>'>";
		echo "</form>";
	}

	else {
		editItem($conn,$action,$item);
	}

}
else {
	header("location: ../profile.php?error=statementtfailed");
	exit();
}