<?php
/* Signup Functions */


function emptyInputSignup($firstname,$lastname,$email,$mobilenumber,$password,$passwordrepeat) {
	$result;

	if (empty($firstname) || empty($lastname) || empty($email) || empty($mobilenumber) || empty($password) || empty($passwordrepeat)) {
		$result = true;
	} 

	else {
		$result = false;
	}

	return $result;
}


function invalidEmail($email) {
	$result;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
	} 

	else {
		$result = false;
	}

	return $result;
}


function passwordMatch($password,$passwordrepeat) {
	$result;
	if($password !== $passwordrepeat) {
		$result = true;
	}

	else {
		$result = false;
	}

	return $result;
}


function emailExists($conn,$email) {
	$sql = "SELECT * FROM users WHERE user_email = ?;";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt,$sql)) {
		header("location: ../signup.php?error=statementfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt,"s",$email);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}

	else {
		$result = false;
		return $result;
	}

	mysqli_stmt_close($stmt);
}


function validateMobileNumber($mobilenumber) {
	$charactersToReplace = array("-","(",")"," ");
	$mobilenumber = str_replace($charactersToReplace,"",$mobilenumber);
	echo $mobilenumber;

	if(strlen($mobilenumber) !== 10) {
		if(strlen($mobilenumber) !== 11) {
			//header("location: ../signup.php?error=phonelengthinvalid");
			exit();
		}
	}

	if (!is_numeric($mobilenumber)) {
		header("location: ../signup.php?error=phonecontainsletters");
		exit();
	}
	return $mobilenumber;
}


function createuser($conn, $firstname, $lastname, $email, $mobilenumber, $password) {
	$sql = "INSERT INTO users (user_first_name,user_last_name,user_email,user_mobile,user_password) VALUES (?,?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../signup.php?error=statementfailedd");
		exit();
	}

	$hashedpassword = password_hash($password,PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt,"sssss",$firstname,$lastname,$email,$mobilenumber,$hashedpassword);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../signup.php?error=none");
	exit();
}

/* Login Functions */

function emptyInputLogin($email,$password) {
	$result;

	if (empty($email) || empty($password)) {
		$result = true;
	} 

	else {
		$result = false;
	}
	return $result;
}


function loginUser($conn,$email,$password) {
	$emailexists = emailExists($conn,$email);

	if ($emailexists === false) {
		header("location: ../login.php?error=emailexists");
		exit();
	}

	$passwordhashed = $emailexists["user_password"];
	$checkPassword = password_verify($password,$passwordhashed);

	if ($checkPassword === false) {
		header("location: ../login.php?error=passwordincorrect");
		exit();
	}
	else if ($checkPassword === true) {
		session_start();
		$_SESSION["user_id"] = $emailexists["user_id"];
		$_SESSION["user_email"] = $emailexists["user_email"];
		$_SESSION["user_first_name"] = $emailexists["user_first_name"];
		$_SESSION["is_admin"] = $emailexists["is_admin"];
		header("location: ../profile.php");
		exit();
	}
}

// Upload Functions
function dateCheck($date_lost) {
	exit();
}



function createItem($conn,$item_name,$category,$item_value,$date_lost,$user_id) {
	$sql = "INSERT INTO items (item_name,date_lost,category_id,item_value,user_id) VALUES (?,?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../upload.php?error=statementfailed");
		exit();
	}


	mysqli_stmt_bind_param($stmt,"sssss",$item_name,$date_lost,$category,$item_value,$user_id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../upload.php?error=none");
	exit();
}
// Profile Functions

function archiveItem($conn,$action,$item) {

	$sql = "UPDATE `items` SET `is_" . $action . "` = '1' WHERE `items`.`item_id` = $item";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt,$sql)) {
		header("location: ../profile.php?error=statementfailed");
		exit();
	}

	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	if ($action === "found") {
		$date_found = date("y-m-d");
		$sql = "UPDATE `items` SET `date_found` = '" . $date_found . "' WHERE `items`.`item_id` = '" . $item ."'";
		echo $sql;
		echo "<br>";
		echo "Item:" . $item . "<br>";
		echo "Date Found " . $date_found;
		$stmt = mysqli_stmt_init($conn);

		if (!mysqli_stmt_prepare($stmt,$sql)) {
			header("location: ../profile.php?error=statementfailed");
			exit();
		}	

		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	header("location: ../profile.php?error=none");
	exit();
}

function editItem($conn,$item_name,$category,$item_value,$date_lost,$item_id,$action) {

	$archived = 0;

	if ($action === "found") {
		$sql = "UPDATE `items` SET item_name = ?, date_lost = ?, category_id = ?, item_value = ?, is_archived = ?  WHERE `item_id` = ?";
	}

	elseif ($action === "archive") {
		$sql = "UPDATE `items` SET item_name = ?, date_lost = ?, category_id = ?, item_value = ?, is_found = ?  WHERE `item_id` = ?";
	}

	else {
		$sql = "UPDATE `items` SET item_name = ?, date_lost = ?, category_id = ?, item_value = ? WHERE `item_id` = ?";
	}

	echo "Item Name " . $item_name . "<br>";
	echo "Date Lost " . $date_lost . "<br>";
	echo "Category ID " . $category . "<br>";
	echo "Item Value " . $item_value . "<br>";
	echo "Item ID: " . $item_id . "<br>";
	echo "SQL Script ". $sql;
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../edit.php?error=statementfailed");
		exit();
	}
	if ($action === "found" || $action === "archive") {
		mysqli_stmt_bind_param($stmt,"ssssis",$item_name,$date_lost,$category,$item_value,$archived,$item_id);
	}

	else {
		mysqli_stmt_bind_param($stmt,"sssss",$item_name,$date_lost,$category,$item_value,$item_id);		
	}
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../profile.php?error=none");
	exit();

}
// Search Functions